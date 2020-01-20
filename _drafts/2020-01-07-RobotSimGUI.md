---
layout: post
title:  "Graphical drivebase simulation for FRC robots"
description: "Showcasing part of the frc5024 codebase"
date:   2020-01-07 22:13:00
categories: frc
redirect_from: 
 - /post/vcv4101s90/
 - /vcv4101s90/
---

The 2020 FRC season has kicked off, and the @frc5024 software team is already hard at work developing the software that will power this year's robot. Throughout the season, I'm hoping to showcase cool things we work on.

Today, I built a little tool to provide a graphical simulation of our robot's drivebase in 2D space. This post will outline how I did it.

## Robot simulation

As our code is developed with [WPILib](https://github.com/wpilibsuite/allwpilib), we make use of [HALSIM](https://github.com/wpilibsuite/allwpilib/tree/master/simulation/halsim_gui) to test out code before pushing to real hardware. This tool is great for checking for null pointer exceptions, and ensuring telemetry data is correctly pushed, but has some limitations. Mainly, we use a fair amount of un-supported hardware, and our own robotics library does not integrate with WPILib's "Sendable" system.

### Faking HAL device support

To give HALSIM support to our custom devices, we use WPILib's [SimDevice](https://github.com/wpilibsuite/allwpilib/blob/master/hal/src/main/java/edu/wpi/first/hal/SimDevice.java) wrapper. @PeterJohnson explained to me how to do this [in this thread](https://www.chiefdelphi.com/t/ctre-halsim/370106/2?u=ewpratten).

### Simulating sensors

For drivebase simulation, we need to simulate two devices. Our [encoders](https://www.usdigital.com/products/encoders/incremental/kit/E4T), and our [gyroscope](https://pdocs.kauailabs.com/navx-mxp/). Neither of these devices have HALSIM support, so I added my own [[1](https://github.com/frc5024/InfiniteRecharge/commit/837e9f571a03917c72b2df83d4e19650bab4ad66)] [[2](https://github.com/frc5024/InfiniteRecharge/commit/78c501a4bbaeee1d05e95a3c1ba07a897bc78a80)].

Now that the device I/O has been simulated, we need to simulate sensor readings.

#### Encoders

Encoder readings can be estimated, assuming we know these properties:

 - Current motor speed (percent output)
 - Max motor speed (RPM)
 - Encoder Pulses per Revolution
 - Gearing ratio between simulated motor and sensor

Inside a quickly-updating loop, I used this pseudocode to determine the reading for an encoder:
```java
double current_time = getSeconds();

double dt = current_time - last_time;
last_time = current_time;


double rpm = (getMotorSpeed() * max_rpm) / gearbox_ratio;
double revs = (rpm / 60.0) * dt; 

encoder_ticks += (revs * tpr);
```

#### Gyroscope

