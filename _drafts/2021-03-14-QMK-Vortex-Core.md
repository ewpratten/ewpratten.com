---
layout: page
title:  "How I flashed QMK to my Vortex Core"
description: "Open-source firmware on a closed-source keyboard"
date:   2021-03-14 13:00:00 
written: 2021-03-14
tags: project keyboards qmk firmware
excerpt: >-
    After having some issues with the factory firmware on my 40% keyboard, I decided to replace it with the widely used QMK firmware instead.
redirect_from: 
 - /post/gkedkd93/
 - /gkedkd93/
---

Last fall, I [purchased my first mechanical keyboard](/blog/2020/11/06/vortex-core), the [Vortex Core](https://mechanicalkeyboards.com/shop/index.php?l=product_detail&p=3550), and have been loving it ever since. Well, almost loving it. There are a few "quirks" of the keyboard that I wasn't super fond of, like: occasionally not sending `KEY_UP` commands back to the computer, or the badly documented and maintained system for building custom layouts.

In my previous post on this keyboard, I had mentioned @ChaoticEnigma's fork of [QMK](https://github.com/qmk/qmk_firmware) for the core. This custom firmware had been sitting on my mind for a while, and I finally decided to try it out on my keyboard. This post will cover the process of loading QMK on to a non-supported Vortex Core keyboard.

The following are all the steps required to complete this process. Make sure to **read them all before getting started**. As per usual when I am outlining ways to modify hardware, you might brick your keyboard doing this so: *be careful*.

 1. [Compiling the toolchain](#compiling-the-toolchain)
 2. [Compiling the firmware](#compiling-the-firmware)
 3. [Finding debugging hardware](#finding-debugging-hardware)
 4. [Connecting to the core's JTAG interface](#connecting-to-the-cores-jtag-interface)
 5. [Unlocking the keyboard](#unlocking-the-keyboard)
 6. [Flashing QMK](#flashing-qmk)

## Compiling the toolchain

Firstly, you'll need all the software tools required to interface with the keyboard. The following list contains GitHub links to everything needed (this is all for Linux of course):

 - [OpenOCD patched with HT32 support](https://github.com/ChaoticConundrum/openocd-ht32)
 - [Commandline interface tool](https://github.com/pok3r-custom/pok3rtool)
 - [Unlocked core firmware](https://github.com/pok3r-custom/pok3r_re_firmware)

### OpenOCD

What is [OpenOCD](http://openocd.org/)?

 > OpenOCD is a free-software tool mainly used for on-chip debugging, in-system. programming and boundary-scan testing. OpenOCD supports flashing and. debugging a wide variety of platforms such as: ARMv5 through latest ARMv8. [source: [Debian WIKI](https://wiki.debian.org/OpenOCD)]

OpenOCD is a standard tool / interface that allows you to use many different types of hardware debuggers interchangeably. It is a very useful project for tasks like this, where we will need to connect directly into an embedded chip via its debugging ports.

The link provided above for OpenOCD is actually a fork of the main project that specifically adds support for the [Holtek HT32F165x](https://www.keil.com/dd2/holtek/ht32f1655/) MCU (the chip that powers the keyboard).

After cloning the GitHub repo, the build process is fairly simple:

```sh
cd openocd-ht32

# Install the build dependencies
sudo apt install build-essential pkg-config libtool

# Configure the build system
./bootstrap

# These arguments may change depending on the hardware debugger you are using. I use the ST-LinkV2
# Check the official OpenOCD documentation for more information on this
./configure --enable-stlink --disable-werror

# Build
make 
sudo make install
```

### Pok3rtool

`pok3rtool` is the commandline interface tool designed specifically for interacting with the firmware on Vortex keyboards. It is fairly unstable, but I can confirm that all the commands used in this guide work just fine.

The build process for `pok3rtool` is a little different as it requires you to clone the GitHub repo, then create a new directly called `pok3rtool-build` **beside** the cloned repo. Aside from that quirk, the process for building `pok3rtool` is as follows:

```sh
cd pok3rtool

# Pull the git submodules
git submodule update --init --recursive

cd ../pok3rtool-build

# Build the tool
cmake ../pok3rtool
make
```

### Intermediary firmware

Part of the firmware upgrade process involves loading some intermediary firmware on to the keyboard. This is simply the stock Vortex Core firmware, but with the security bit disabled on the chip. This allows us to perform all further firmware upgrades over the keyboard's USB port instead of through JTAG.

Building this is as simple as cloning the repo, then running `make`.

## Compiling the firmware

When it comes to the final firmware, I have [my own fork](https://github.com/Ewpratten/qmk_core/) of @ChaoticEnigma's fork of QMK. You could use @ChaoticEnigma's fork, but I would recommend my own, since I am specifically maintaining it for the Vortex Core, and my fork has a few more features (like a proper layout for the core).

You have the option between four QMK keyboard layouts for the Vortex Core:

 - @ChaoticEnigma's `default`
   - A remake of the factory layout (missing a few function keys)
 - @ChaoticEnigma's `chaotic`
   - Presumably @ChaoticEnigma's personal layout. No idea what it does
 - `ewpratten`
   - My personal layout
 - `better_default`
   - My full remake of the factory layout

To build my QMK fork, run the following:

```sh
cd qmk_core

# Fetch everything needed to build QMK
make git-submodule

# Build the layout of your choosing
# For example, I use: make vortex/core:ewpratten
make vortex/core:<layout_name>
```

## Finding debugging hardware

As mentioned in the [OpenOCD](#openocd) section, I am using a clone of the [ST-Link/V2](https://www.st.com/en/development-tools/st-link-v2.html), which I picked up for a few dollars [from ebay](https://www.ebay.com/itm/ST-Link-V2-OpenOCD-On-Chip-Debugger-STM8-STM32-JTAG-SWIM-Linux-OSX-Arduino/254315946241?hash=item3b36696101:g:Uq0AAOSwYRJdQWxj). You can use any OpenOCD-supported debugger though.

The next section will assume you have an ST-Link when I talk about I/O pin names.

## Connecting to the core's JTAG interface

Its finally time to open up the keyboard. This is pretty simple, there are five screws hidden under the keycaps. Just remove the caps, and the screws.

On the bottom of the keyboard, you'll see a serial number. If this is **not** `CYKB175_V03 20160511`, stop right now, and do not proceed with this guide. This is the only model supported.

In between the `LED80` and `LED66` markings on the PCB (just below the serial number), you'll find an empty 5-pin header. For the sake of simplicity, I'll number them 1 to 5, where 1 is the pin closest to the serial number. Connect them to your hardware debugger as follows (this will require soldering, or small clips):

| Keyboard Pin | Debugger Pin |
| ------------ | ------------ |
| `1`          | **N/A**      |
| `2`          | `SWDIO`      |
| `3`          | `SWCLK`      |
| `4`          | `RST`        |
| `5`          | `GND`        |

## Unlocking the keyboard

With the keyboard JTAG interface wired up, plug in the keyboard's USB (to provide power), then after the keyboard has connected, plug in the hardware debugger.

Move to the directory you built OpenOCD in, then run the following:

```sh
cd tcl

# Connect to the keyboard
# The first -f flag of this command will vary depending on the hardware debugger you chose to use
../src/openocd -c 'set HT32_SRAM_SIZE 0x4000' -c 'set HT32_FLASH_SIZE 0x10000' -f ./interface/stlink-v2-1.cfg -f ./target/ht32f165x.cfg
```

This will spawn a telnet server on `localhost:4444`. Connect to that with `telnet 172.0.0.1 4444`, then run the following commands over telnet:

```sh
# REMINDER: We are now going to be modifying firmware on the keyboard. If you mess up, you may have just created an expensive brick

# We need to erase the existing firmware
ht32f165x mass_erase 0

# Now, we write the new firmware
# The '0' at the end of this command is very important
# This must be an absolute path to where ever you cloned the intermediary firmware
flash write_image /path/to/pok3r_re_firmware/disassemble/core/builtin_core/firmware_builtin_core.bin 0
```

The last command will take a solid five minutes, so go grab a snack and *don't bump anything*. There is no progress bar or anything, so enjoy the suspense.

Assuming all went well, you can run `exit` over telnet, then close OpenOCD. Unplug the hardware debugger and keyboard, then just plug the keyboard back in. It should function like it just came from the factory. If you forgot to unplug the debugger, the keyboard will not function.

You now have a firmware-unlocked Vortex Core.

## Flashing QMK

*Its time for the last step :tada:*

With the keyboard unlocked, you can technically load anything you want on to it, but lets stick with QMK. The following commands will do all the hard work for you:

```sh
# Go back to where you built pok3rtool
cd pok3rtool-build

# Make sure you can see the keyboard from pok3rtool
sudo ./pok3rtool list

# Flash the firmware
# "QMK_CORE_EW" can be whatever you want the version of your keyboard to display
# vortex_core_xxxx.bin will be different depending on the keyboard layout you chose to compile
sudo ./pok3rtool -t vortex-core flash QMK_CORE_EW /path/to/qmk_core/vortex_core_xxxx.bin
```

Any time you want to update QMK or change layouts, the above commands will be how to do it.

**NOTE:** sometimes, `pok3rtool` fails to put the keyboard in bootloader mode before flashing new firmware. If this happens, just run the following command before flashing (and you may need to repeat this process a few times to get `pok3rtool` to behave)

```sh
sudo ./pok3rtool -t vortex-core bootloader
```