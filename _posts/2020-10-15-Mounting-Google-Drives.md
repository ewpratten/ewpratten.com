---
layout: page
title:  "Mounting Google Drive accounts as network drives"
description: "Easy-to-use Google Drive integration for Linux using rclone"
date:   2020-10-15 10:00:00 
written: 2020-09-22
tags: linux workflow google
excerpt: >-
    I can never get the Google Drive webapp to load quickly when I need it 
    to. My solution: use some command-line magic to mount my drives directly 
    to my laptop's filesystem.
redirect_from: 
 - /post/XcaM0k24/
 - /XcaM0k24/
---

When sharing files, I use three main services. I use [Firefox Send](https://en.wikipedia.org/wiki/Firefox_Send) and [KeybaseFS](https://book.keybase.io/docs/files) to share one-off and large files with friends, and I use [Google Drive](https://drive.google.com) to store some personal files, and for everything school-related (I don't get a choice about this). For the first two services, sharing a file is as simple as calling [`ffsend`](https://github.com/timvisee/ffsend) or moving a local file into my kbfs mountpoint, and I am done. Google Drive, on the other hand, the process isn't as easy. While some Linux distributions have Google Drive integration out of the box (I miss daily-driving [ChromiumOS](https://www.chromium.org/chromium-os)), Linux users generally have to go to `drive.google.com`, and deal with the Google Drive webapp. Not sure if this is an "only me" problem, but whenever I need to quickly make a change to a document through the webapp, It decides to stop working.

I really like the Keybase approach of mounting remote storage as a "network drive" on my laptop, and wanted to do something similar for Google Drive. This is where a great tool called [`rclone`](https://rclone.org) comes in to play. Rclone is a very easy-to-use command-line application for working with cloud storage. I originally learned about it when I used to host this website on [DigitalOcean Spaces](https://www.digitalocean.com/products/spaces/) a few years ago. Out of the box, Rclone supports [many cloud providers](https://rclone.org/#providers), including Google Drive!

## Setting up Rclone for use with Google Drive

Now for the fun part, to get started with Rclone and Google Drive on your computer, you must first install Rclone. I am going to assume you are using a Linux-based operating system here, but with some slight tweaking, this works on BSD and Windows too!

```sh
# Install Rclone with the automated installer
curl https://rclone.org/install.sh | sudo bash
```

Once Rclone is installed, you need to hop on over to the [Google Cloud Developer Console](https://console.developers.google.com/), and create a new project. Under the *ENABLE APIS AND SERVICES* section, search for, and enable the `Google Drive API`. This will expose an API to your Google Drive, and let programs interact with the files (if setting up multiple accounts, you only need to enable the API on one of them). Click the *Credentials* tab in the left-side panel, then *Create credentials*. This will open a panel letting you set up access to your new API.

With the panel open, click *CONFIGURE CONSENT SCREEN*, *External*, then *CREATE*. Enter `rclone` as the application name, and save it. You now have set up one of those "sign in with Google" screens for yourself. Clicking the *Credentials* tab again will bring you to an area where you can generate the needed API keys for Rclone.

Click *+ CREATE CREDENTIALS* at the top of the panel, and select *OAuth client ID*. Set the application type to *Desktop app*, and finally, press *Create*. You will now be shown the needed info to link Rclone to your account(s).

<div class="center" markdown="1">
*Note: This API project is **not verified** by Google.*<br>
*This means that you will be greeted with a scary warning when logging in the first time. Just ignore it.*
</div>

Back in the terminal, we can run `rclone config` to set up a configuration for Google Drive. You will be prompted with many options. Use the following:
```sh
# > rclone config

# Create a new config
n) New remote

# Set a name
name> my_drive

# Choose a storage type
Storage> drive

# You will be asked for a client ID and secret. These are the strings we just generated
...

# Set the scope to allow Rclone access to your files
scope> 1

# Select the default option for everything until asked if you want to use "auto config"
# When asked, say yes
auto_config> y

# Set team drive to no
team_drive> n

# Verify the information, then say yes
ok> y
```

Almost done. You need to run `rclone ls my_drive:` (the colon is important). This will probably ask you to go to a link, and enable an API. Do so.

Your Google Drive can now be mounted by running the following (feel free to change the paths to whatever you want)

```
mkdir -p ~/google_drive
rclone mount my_drive: ~/google_drive --vfs-cache-mode writes
```

## Starting Rclone on boot

You probably don't want to run an `rclone` command every time you start your computer. This can be solved in one of two ways

### For i3wm users

On `i3wm`, just add the following line to `~/.config/i3/config`:

```sh
exec --no-startup-id rclone mount my_drive: /home/<user>/google_drive --vfs-cache-mode writes
```

*Make sure to replace `<user>` with your username.*

Keep in mind, `exec` commands are not run when reloading `i3` with <kbd>Mod</kbd>+<kbd>Shift</kbd>+<kbd>r</kbd>. You must log out (<kbd>Mod</kbd>+<kbd>Shift</kbd>+<kbd>e</kbd>), and back in again.

### For Ubuntu / Debian-based users

In pretty much any Debian-based system, you can edit `/etc/rc.local` (using `sudo`), and add the following line right before `exit 0`:

```sh
rclone mount my_drive: /home/<user>/google_drive --vfs-cache-mode writes
```

*Make sure to replace `<user>` with your username.*