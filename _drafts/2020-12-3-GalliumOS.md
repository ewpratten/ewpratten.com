---
layout: page
title:  "Upgrading my chromebook"
description: "The process of installing GalliumOS on an ACER R11"
date:   2020-12-3 09:00:00 
written: 2020-10-31
categories: project laptop hardware
excerpt: >-
    Performing some upgrades to my old laptop. This post outlines the setup process for installing GalliumOS
redirect_from: 
 - /post/gk3jEkd4/
 - /gk3jEkd4/
---

My previous development laptop was an [Acer R11](https://www.acer.com/ac/en/CA/content/series/acerchromebookr11) chromebook. I always ran it in [developer mode](https://chromium.googlesource.com/chromiumos/docs/+/master/developer_mode.md) with all the Linux packages I needed installed via [chromebrew](https://github.com/skycocker/chromebrew). This setup worked great except for GUI programs, as (at the time), the built-in [Wayland](https://en.wikipedia.org/wiki/Wayland_(display_server_protocol)) server on the chromebook was not exposed to the user in a meaningful way. I relied on an internal tool from Google called [sommelier](https://chromium.googlesource.com/chromiumos/platform2/+/HEAD/vm_tools/sommelier/) to translate X11 calls to the internal Wayland server. None of this was ideal, but with a lot of scripts and aliases, I made it work.

Recently, I decided to remove the locked-down ChromeOS all together, and set the laptop up with [GalliumOS](https://galliumos.org) so it can be used as a lightweight code-review machine with access to some useful tools like [VSCode](https://code.visualstudio.com/) and [GitKraken](https://www.gitkraken.com/). This whole process is actually fairly easy, and a good way to breathe new life in to an old chromebook. This guide will be R11-specific, but the process doesn't vary too wildly between models.

## Developer mode

A standard feature on chromebooks is "developer mode". This is a hidden boot mode that is designed to give [ChromiumOS](https://www.chromium.org/chromium-os) contributors and Google developers access to debug tools when testing new OS builds. Along with debug tools, this mode also exposes a Linux terminal with root access to the user via <kbd>Ctrl</kbd> + <kbd>Alt</kbd> + <kbd>-></kbd>. On an extremely locked down system like a chromebook, this terminal access exposes a lot of new capability. For this use case, we will only use it to modify the system bootloader.

To enable developer mode, simply press <kbd>Esc</kbd> + <kbd>Refresh</kbd> + <kbd>Power</kbd>, and let the chromebook reboot. Once the recovery screen pops up, press <kbd>Ctrl</kbd> + <kbd>D</kbd>, and the device is now in developer mode.

## Write protection

This step will void your device's warranty.

## Flashing a custom bootloader

### Setting fuses

## Installing GalliumOS

### Enabling verbose boot


<!--
https://imgur.com/a/GuyYz

https://medium.com/@simstems/how-i-got-the-acer-chromebook-r11-cb5-132t-to-run-parrot-security-os-without-crouton-d282a110060a

https://wiki.galliumos.org/Hardware_Compatibility

https://chromium.googlesource.com/chromiumos/platform/vboot/+/master/_vboot_reference/firmware/include/gbb_header.h
-->