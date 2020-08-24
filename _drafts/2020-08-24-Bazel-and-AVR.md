---
layout: page
title:  "Compiling AVR-C code with a modern build system"
description: "Bringing Bazel to 8-bit microcontrollers"
date:   2020-08-24 9:30:00 
categories: avr embedded bazel
redirect_from: 
 - /post/68dk02l4/
 - /68dk02l4/
---

When writing software for an Arduino, or any other [AVR]()-based device, there are generally three main options. You can use the [Arduino IDE]() with [arduino-cli](), which is in my opinion, a clunky system that is great for high levels of abstraction and teaching people how to program, but lacks any kind of easy customization I am interested in. If you are looking for something more advanced (and works in your favorite IDE), you might look at [PlatformIO](). Finally, you can just program without any Hardware Abstraction Library at all, and use [avr-libc]() along with [avr-gcc]() and [avrdude](). 

This final option is my favorite by far, as it both forces me to think about how the system I am building is actually working "behind the scenes", and lets me do everything exactly the way I want. Unfortunately, when working directly with the AVR system libraries, the only buildsystem / tool that is available (without a lot of extra work) is [Make](). As somebody who spends 90% of his time working with higher-level buildsystems like [Gradle]() and [Bazel](), I don't really like needing to deal with Makefiles, and manually handle dependency loading. This got me thinking. I have spent a lot of time working in Bazel, and cross-compiling for the armv7l platform via the [FRC Toolchain](https://launchpad.net/~wpilib/+archive/ubuntu/toolchain/). How hard can it be to add AVR Toolchain support to Bazel?

*The answer: Its pretty easy.*

