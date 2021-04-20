---
layout: page
title:  "Building a cheap APRS digipeater"
description: "How I set up my feature-packed APRS digipeater for under $100"
date:   2021-04-20 
written: 2021-04-20
tags: project raspberrypi hamradio aprs
excerpt: >-
    Using an extra radio and some spare parts, I set up an APRS/APRS-IS/APRStt digipeater. This post covers some of the details.
redirect_from: 
 - /post/eb0klDd9/
 - /eb0klDd9/
---

***WARNING:** To replicate this project, you **must** be the holder of an amateur radio license in your country*

I have an extra [Baofeng UV-5R](https://baofengtech.com/product/uv-5r/) lying around, and had no idea what to use it for. The original plan was to set up a UHF simplex repeater with internet linking capabilities, but that project was set back due to my lack of time to figure out how to set up the [Asterisk PBX](https://en.wikipedia.org/wiki/Asterisk_(PBX)).

After giving up on Asterisk, I was left without ideas once again. That is, until a few days ago when I remembered that the large [APRS](http://www.aprs.org/) network exists, and is fairly easy to experiment with. I have some past experience with APRS, specifically the [APRS-IS](http://www.aprs-is.net/) internet bridge. I have cron jobs running on a few of my computers that fetches their positions through [geo-ip](https://en.wikipedia.org/wiki/Internet_geolocation) and beacons this info (plus weather info if I feel like it) to the APRS network through APRS-IS. None of that setup has anything to do with radio though, so it feels like I'm not a *true APRS user*. 

A solution to both problems: set up a digipeater.

## What my radio is doing

To be specific, I am running much more than just a digipeater. This spare radio is also an APRS-IS [IGate](http://www.aprs-is.net/IGating.aspx), and an [APRStt](http://www.aprs.org/aprstt.html) bridge. The more important of these capabilities is APRStt.

APRStt is a standard originally designed for the [PSAT2](http://www.aprs.org/psat2.html) satellite, that allows radio operators with non-APRS-compatible radios to send beacons using DTMF sequences. The encoding standard for doing this is not exactly user friendly in my opinion, but it works.

Combining these radio capabilities with some basic knowledge of the [Maidenhead Locator System](https://en.wikipedia.org/wiki/Maidenhead_Locator_System) on my part allows me to go anywhere in the city with my HT and send beacons to the APRS network using DTMF. Pretty cool in my opinion.

## Setup Guide

The following is a mostly complete guide on replicating my digipeater setup. You will have to do some extra reading to understand the configuration system.

### Required hardware

To set up a digipeater, you need a controller, a radio, and some hardware to connect the two. All of the parts I use are found below (I did not choose the most cost-effective listings here):

 - [Raspberry Pi 3B+](https://www.ebay.com/itm/193345669838)
 - [Baofeng UB-5R](https://baofengtech.com/product/uv-5r/)
 - [USB sound card](https://www.ebay.com/itm/203355827559)
 - 2x [3.5mm audio cables](https://www.ebay.com/itm/402032141776)
 - [2.5mm Male to 3.5mm Female adaptor](https://www.ebay.com/itm/202853095248)
 - [Single-channel relay](https://www.ebay.com/itm/114771147582)
 - Some female-to-female jumper cables (see [here](https://www.ebay.com/itm/203350136236))
 - Solder and a soldering iron are also needed for cable modifications

### Compiling Dire Wolf

Compiling and setting up the control software, [Dire Wolf](https://github.com/wb2osz/direwolf), is pretty easy. The full guide on this process can be found [here](https://github.com/wb2osz/direwolf/blob/master/doc/Raspberry-Pi-APRS.pdf). I'll summarize below:

On a fresh install of [Raspbian](https://www.raspberrypi.org/software/operating-systems/#raspberry-pi-os-32-bit):

```sh
sudo apt update
sudo apt install cmake libasound2-dev libudev-dev git
cd ~
git clone https://github.com/wb2osz/direwolf
cd direwolf
mkdir build && cd build
cmake ..
make -j4
sudo make install
make install-conf
cd ~
```

You can now launch Dire Wolf by running `direwolf`. See the full guide for info on staring on boot.

### Building a PTT cable for the Baofeng UV-5R

Baofeng sells a proper [audio interface cable](https://baofengtech.com/product/aprs-k1/), which will make this process easier, but it is not really needed if you have some basic soldering skills.

The push-to-talk system on most Baofeng radios works by shorting the ground of the mic cable to the ground of the speaker cable. Interestingly, the USB audio interface listed above automatically does this (aka. PTT is always enabled when the cables are plugged in). My quick solution is to use some wire strippers to open up the 3.5mm cable used for the microphone input, and snipping the ground line. I then just stick the relay in series with this snipped cable, and can enable and disable ground by triggering the relay.

Plugging the relay into [pin `GPIO14`](https://www.bigmessowires.com/wp-content/uploads/2018/05/Raspberry-GPIO.jpg) of the Raspberry PI will let Dire Wolf have full control over the radio PTT.

### Configuration

The entire configuration process is outlined in the Dire Wolf [user manual](https://github.com/wb2osz/direwolf/blob/master/doc/User-Guide.pdf). Here are some additional notes:

 - Set `PTT GPIO 14` in the `CHANNEL 0` section to enable hardware PTT using the relay
 - Set `DTMF` in the `CHANNEL 0` section to enable APRStt
 - Uncomment the `DIGIPEAT` configuration to enable digipeating

## Need help?

If you happened to follow this guide and need more configuration help, [send me a message](/about).