---
layout: post
title:  "I want to build a satellite"
description: "For under $100"
date:   2019-09-19 21:13:00
categories: idea
redirect_from: 
 - /post/e9gb3490/
 - /e9gb3490/
---

I like learning and trying new things. Most recently, I have been working with radios, and have obtained a licence to operate some [RPAs](https://en.wikipedia.org/wiki/Unmanned_aerial_vehicle). So, obviously the next step is *space*, right? As I am entering this with near 0 experience, I'm going to start simple. 

## Design
My first satellite project (named [Spike](https://github.com/Ewpratten/Spike)) is designed to do the following:
 - Be deployed in [LEO](https://en.wikipedia.org/wiki/Low_Earth_orbit) by a [cubesat launcher](https://en.wikipedia.org/wiki/CubeSat#Launch_and_deployment)
 - Be solar powered
   - 24/7 data is not required, so the device may go dark
   - I may look into an on-board [LCB](https://en.wikipedia.org/wiki/Solid-state_battery) for night operation
 - Record temperature, and light levels
 - Stream data down to earth 
 - Burn up in the atmosphere 

I am currently working with the following parts to build a grounded test device. 
 - [Arduino pro mini](https://www.ebay.com/itm/New-Pro-Micro-ATmega32U4-5V-16MHz-Replace-ATmega328-Arduino-Pro-Mini-/221891843710)
 - [315mhz transmitter](https://www.sparkfun.com/products/10535) (This will be replaced)
 - [A photocell](https://www.sparkfun.com/products/9088)
 - [A TMP102 sensor](https://www.sparkfun.com/products/13314)

My goal for the grounded test device is for it to survive ~14 weeks of un-attended operation, and some temperature tests.

## Current progress
Currently, My testing setup consists of the following components that I had lying around:
 - Arduino pro mini
 - Photocell
 - [lm35 sensor](http://www.ti.com/product/LM35)
 - Buzzer (To emulate a radio)

![Current Test Board](/assets/images/satv1.jpg)

The board has been "transmitting" telemetry data for over a week now, and is operating as expected.

## Project on hold
I am currently waiting for [SparkFun](https://www.sparkfun.com/) to send me some new components to work with.. A new post will come eventually.
