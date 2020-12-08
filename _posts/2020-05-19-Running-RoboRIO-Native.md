---
layout: page
title:  "Running RoboRIO firmware inside Docker"
description: "Containerized native ARMv7l emulation in 20 minutes"
date:   2020-05-19 13:00:00 
tags: frc roborio emulation
redirect_from: 
 - /post/5d3nd9s4/
 - /5d3nd9s4/
---

It has now been 11 weeks since the last time I have had access to a [RoboRIO](https://www.ni.com/en-ca/support/model.roborio.html) to use for debugging code, and there are limits to my simulation software. So, I really only have one choice: *emulate my entire robot*.

My goal is to eventually have every bit of hardware on [5024](https://www.thebluealliance.com/team/5024)'s [Darth Raider](https://cs.5024.ca/webdocs/docs/robots/darthRaider) emulated, and running on my docker swarm. Conveniently, everything uses (mostly) the same CPU architecture. In this post, I will go over how to build a RoboRIO docker container.

## Host system requirements

This process requires a host computer with:
 - An x86_64 CPU
 - A decent amount of RAM
 - [Ubuntu 18.04](https://mirrors.lug.mtu.edu/ubuntu-releases/18.04/) or later
 - [Docker CE](https://docs.docker.com/engine/install/debian/) installed
 - [docker-compose](https://docs.docker.com/compose/install/) installed

## Getting a system image

This is the hardest step. To get a RoboRIO docker container running, you will need:
 - A copy of the latest RoboRIO firmware package
 - A copy of `libfakearmv7l.so` ([download](https://github.com/robotpy/fakearmv7l/releases/download/v1/libfakearmv7l.so))

### RoboRIO Firmware

To acquire a copy of the latest RoboRIO Firmware package, you will need to install the [FRC Game Tools](https://www.ni.com/en-ca/support/downloads/drivers/download.frc-game-tools.html) on a **Windows** machine (not wine).

After installing the toolsuite, and activating it with your FRC team's activation key (provided in Kit of Parts), you can grab the latest `FRC_roboRIO_XXXX_vXX.zip` file from the installation directory of the *FRC Imaging Tool* (This will vary depending on how, and where the Game Tools are installed).

After unzipping this file, you will find another ZIP file, and a LabVIEW FPGA file. Unzip the ZIP, and look for a file called `systemimage.tar.gz`. This is the RoboRIO system image. Copy it to your Ubuntu computer.

## Bootstrapping

The bootstrap process is made up of a few parts:

 1. Enabling support for ARM-based docker containers
 2. Converting the RoboRIO system image to a Docker base image
 3. Building a Dockerfile with hacked auth

### Enabling Docker-ARM support

Since the RoboRIO system image and libraries are compiled to run on ARMv7l hardware, they will refuse to run on an x86_64 system. This is where [QEMU]() comes in to play. We can use QEMU as an emulation layer between out docker containers and our CPU. To get QEMU set up, we must first install support for ARM->x86 emulation by running:

```sh
sudo apt install qemu binfmt-support qemu-user-static -y
```

Once QEMU has been installed, we must run the registration scripts with:

```sh
docker run --rm --privileged multiarch/qemu-user-static --reset -p yes
```

### Converting the system image to a Docker base

We have a system image filesystem, but need Docker to view it as a Docker image. 

#### Using my pre-built image

Feel free to skip the following step, and just use my [pre-built](https://hub.docker.com/r/ewpratten/roborio) RoboRIO base image. It is already set up with hacked auth, and is (at the time of writing) based on firmware version `2020_v10`.

To use it, replace `roborio:latest` with `ewpratten/roborio:2020_v10` in the `docker-compose.yml` config below.

#### Building your own image

Make a folder, and put both the system image, and `libfakearmv7l.so` files in it. This will be your "working directory". Now, import the system image into docker with:

```sh
docker import ./systemimage.tar.gz roborio:tmp
```

This will build a docker base image out of the system image, and name it `roborio:tmp`. You can use this on it's own, but if you want to deploy code to the container with [GradleRIO](https://github.com/wpilibsuite/GradleRIO), or SSH into the container, you will need to strip the NI Auth.

### Stripping National Instruments Auth

By default, the RoboRIO system image comes fairly locked down. To fix this, we can "extend" our imported docker image with some configuration to allow us to remove some unknown passwords.

In the working directory, we must first create a file called `common_auth`. This will store our modified authentication configuration. Add the following to the file:

```
#
# /etc/pam.d/common-auth - authentication settings common to all services
#
# This file is included from other service-specific PAM config files,
# and should contain a list of the authentication modules that define
# the central authentication scheme for use on the system
# (e.g., /etc/shadow, LDAP, Kerberos, etc.).  The default is to use the
# traditional Unix authentication mechanisms.

# ~~~ This file is modified for use with Docker ~~~ 

# here are the per-package modules (the "Primary" block)
# auth	[success=2 auth_err=1 default=ignore]	pam_niauth.so nullok
# auth	[success=1 default=ignore]	pam_unix.so nullok
# here's the fallback if no module succeeds
# auth	requisite			pam_deny.so
# prime the stack with a positive return value if there isn't one already;
# this avoids us returning an error just because nothing sets a success code
# since the modules above will each just jump around
auth	required			pam_permit.so
# and here are more per-package modules (the "Additional" block)

```

Now, we must create a `Dockerfile` in the same directory with the following contents:

```
FROM roborio:tmp

# Fixes issues with the original RoboRIO image
RUN mkdir -p /var/volatile/tmp && \
    mkdir -p /var/volatile/cache && \
    mkdir -p /var/volatile/log && \
    mkdir -p /var/run/sshd

RUN opkg update && \
    opkg install binutils-symlinks gcc-symlinks g++-symlinks libgcc-s-dev make libstdc++-dev

# Overwrite auth
COPY system/common_auth /etc/pam.d/common-auth
RUN useradd admin -ou 0 -g 0 -s /bin/bash -m
RUN usermod -aG sudo admin

# Fixes for WPILib
RUN mkdir -p /usr/local/frc/third-party/lib
RUN chmod 777 /usr/local/frc/third-party/lib

# This forces uname to report armv7l
COPY system/libfakearmv7l.so /usr/local/lib/libfakearmv7l.so
RUN chmod +x /usr/local/lib/libfakearmv7l.so && \
    mkdir -p /home/admin/.ssh && \ 
    echo "LD_PRELOAD=/usr/local/lib/libfakearmv7l.so" >> /home/admin/.ssh/environment && \
    echo "PermitUserEnvironment yes" >> /etc/ssh/sshd_config && \
    echo "PasswordAuthentication no">> /etc/ssh/sshd_config

# Put the CPU into 32bit mode, and start an SSH server
ENTRYPOINT ["setarch", "linux32", "&&", "/usr/sbin/sshd", "-D" ]
```

This file will cause the container to:
 - Install needed tools
 - Configure an "admin" user with full permissions
 - Set r/w permissions for all FRC libraries
 - Overwrite the system architecture with a custom string to allow programs like `pip` to run properly
 - Enables password-less SSH login
 - Sets the CPU to 32bit mode

We can now build the final image with these commands:

```sh
docker build -f ./Dockerfile -t roborio:local .
docker rmi roborio:tmp
docker tag roborio:local roborio:latest
```

## Running the RoboRIO container locally

We can now use `docker-compose` to start a fake robot network locally, and run our RoboRIO container. First, we need to make a `docker-compose.yml` file. In this file, add:

```yml
version: "3"

services:

  roborio:
    image: roborio:latest # Change this to "ewpratten/roborio:2020_v10" if using my pre-built image
    networks:
      robo_net:
        ipv4_address: 10.50.24.2

networks:
    robo_net:
        ipam:
            driver: default
            config:
                - subnet: 10.50.24.0/24
```

We can now start the RoboRIO container by running

```sh
docker-compose up
```

You should now be able to SSH into the RoboRIO container with:

```sh
ssh admin@10.50.24.2
```

Or even deploy code to the container! (Just make sure to set your FRC team number to `5024`)