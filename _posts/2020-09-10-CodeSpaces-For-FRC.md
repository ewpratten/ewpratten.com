---
layout: page
title:  "Integrating GitHub Codespaces with FRC"
description: "Robotics software development in your browser"
date:   2020-09-10 9:30:00 
tags: github codespaces
excerpt: >-
    I was recently accepted into the GitHub Codespaces beta test program
    and decided to try it out on the largest open source project I am 
    currently involved with. 
redirect_from: 
 - /post/2jdk02s4/
 - /2jdk02s4/
---

I was recently accepted into the [GitHub Codespaces](https://github.com/features/codespaces) beta test program. After reading through the documentation, I wanted to find a good use for this new tool, and decided to try it out on the largest open source project I am currently involved with. At *Raider Robotics* (@frc5024), we maintain a fairly large robotics software library called [Lib5K](https://github.com/frc5024/lib5k). The goal of this library is to provide an easy-to-use framework for new programmers to use when writing control systems code. As this library has become more complex, we have recently forked it into its own GitHub repository, and completely reworked our dependency system to match that of any other large OSS project. I figured that setting this repository up to use Codespaces might make it easier for other developers at Raider Robotics to make small changes to the library without needing to pull in the nearly 5GB of dependencies needed just to compile the codebase.

I am quite impressed at how easy it is to set up a Codespace environment. All you need to do is, load a pre-made docker image, and write some JSON to configure the environment. I decided to write a custom Dockerfile that extends the [`mcr.microsoft.com/vscode/devcontainers/base:ubuntu`](https://hub.docker.com/_/microsoft-vscode-devcontainers) base image. 

```dockerfile
FROM mcr.microsoft.com/vscode/devcontainers/base:ubuntu

RUN apt update -y
RUN apt install sudo -y

# Install needed packages
RUN sudo apt install -y python3 python3-pip
RUN sudo apt install -y curl wget
RUN sudo apt install -y zip unzip

# Install sdkman
RUN curl -s "https://get.sdkman.io?rcupdate=true" | bash

# Install java
RUN bash -c "source /root/.sdkman/bin/sdkman-init.sh && sdk install java 11.0.8-open"

# Install gradle
RUN bash -c "source /root/.sdkman/bin/sdkman-init.sh && sdk install gradle"

RUN echo "source /root/.sdkman/bin/sdkman-init.sh" >> /root/.bashrc

# Install WPILib
RUN wget https://github.com/wpilibsuite/allwpilib/releases/download/v2020.3.2/WPILib_Linux-2020.3.2.tar.gz -O wpilib.tar.gz
RUN mkdir -p /root/wpilib/2020
RUN tar -zxvf wpilib.tar.gz -C /root/wpilib/2020
```

All that is being done in this container is:

 - Installing Python
 - Installing [sdkman](https://sdkman.io)
 - Installing OpenJDK 11
 - Installing Gradle
 - Installing [WPILib](https://github.com/wpilibsuite/allwpilib/)

In the world of FRC development, almost all codebases depend on a library and toolset called WPILib. The tar file that is downloaded contains a copy of the library, all JNI libraries depended on by WPILib itself, some extra tooling, and a custom JVM built specifically to run on the [NI RoboRIO](https://www.ni.com/en-ca/support/model.roborio.html).

With this docker container, all we need to do is tell GitHub how to set up a Codespace for the repo. This is done by placing a file in `.devcontainer/devcontainer.json`:

```js
// .devcontainer/devcontainer.json
{
    // Name of the environment
    "name":"General FRC Development",

    // Set the Docker image to use
    // I will explain this below
    "image":"ewpratten/frc_devcontainer:2020.3.2",

    // Set any default VSCode settings here
    "settings": {
        "terminal.integrated.shell.linux":"/bin/bash"
    },

    // Tell VSCode where to find the workspace directory
    "workspaceMount": "source=${localWorkspaceFolder},target=/root/workspace,type=bind,consistency=cached",
    "workspaceFolder": "/root/workspace",

    // Allow the host and container docker daemons to communicate
    "mounts": [ "source=/var/run/docker.sock,target=/var/run/docker-host.sock,type=bind" ],

    // Any extensions you want can go here
    "extensions": [
        // Needed extensions for using WPILib
        "redhat.java",
        "ms-vscode.cpptools",
        "vscjava.vscode-java-pack",

        // The WPILib extension itself
        "wpilibsuite.vscode-wpilib"
    ]
}
```

Notice the line `"image":"ewpratten/frc_devcontainer:2020.3.2",`. This is telling VSCode and Codespaces to pull a docker image from my docker hub account. Instead of making Codespaces build a docker image for itself when it loads, I have pre-built the image, and published it [here](https://hub.docker.com/r/ewpratten/frc_devcontainer). The reason for this is quite simple. Codespaces will flat out crash if it tries to build my dockerfile due to WPILib just being too big.

With a minimal amount of work, I got everything needed to develop and test FRC robotics code running in the browser via Codespaces.

![](/assets/images/codespaces-menu.png)

*Launching Codespaces from a GitHub repository*

![](/assets/images/codespaces-code.png)

*Editing code in the browser*


 <!-- - Pushing a container this large to dockerhub requires the daemon to be restarted with -->

<!-- sudo systemctl stop docker
sudo dockerd -s overlay --max-concurrent-uploads=1  -->
