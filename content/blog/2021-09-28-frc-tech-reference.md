---
layout: page
title:  "An overview of the tech on a complex FRC robot"
description: "Reference material for my friends"
date:   2021-09-28
written: 2021-09-28
tags: reference
---

This document is aimed at a small handful of people, but published publicly as reference material for anyone that needs it. All contents are highly specific to the FRC robotics electrical and programming environments.

## Table of Contents

- [Table of Contents](#table-of-contents)
- [Types of devices](#types-of-devices)
  - [On-robot computers](#on-robot-computers)
  - [Microcontrollers](#microcontrollers)
  - [Peripherals](#peripherals)
- [*"The list of blinky things"*](#the-list-of-blinky-things)
- [OpenMesh Radios](#openmesh-radios)
- [Datasheets](#datasheets)
- [Reference Material](#reference-material)

## Types of devices

There are three types of devices found on an FRC robot:

- Computers
- Microcontrollers
- Peripherals

### On-robot computers

The main computer on-robot is of course the roboRIO. The roboRIO is a standard [Real-Time Linux](https://www.linuxfoundation.org/blog/intro-to-real-time-linux-for-embedded-developers/) device running a custom Kernel, built on [Busybox](https://en.wikipedia.org/wiki/BusyBox). The main system users are `admin` (the administrative user with full system write access), and `lvuser` (this user is the one that executes the robot program).

If you SSH into the roboRIO (`ssh admin@10.TE.AM.2`), and navigate to `/home/lvuser/`, you will find the robot program (probably a `.jar`), along with the `deploy` folder, and a script that starts it all. You can stick anything in this script and it will run when the roboRIO boots.

Other on-robot computers include the Limelight (which is just a [Raspberry Pi Compute Module v3](https://www.raspberrypi.org/products/compute-module-3-plus/)), the router (although you can't really run custom code on it), and any Raspberry Pis that might be used.

### Microcontrollers

Aside from the obvious, Arduinos, other on-board microcontrollers include any CTRE devices or "smart" REV devices. Each speed controller and control module is running some pre-compiled firmware on its own. Some of these devices (like the Talon SRX and the Spark Max) allow us to push custom code to them at runtime (like an off-board control loop) over the CAN bus. The NavX is also a microcontroller, communicating over Serial-over-MXP.

### Peripherals

Things like AD Gyroscopes, buttons, rangefinders, color sensors, etc. are all dumb peripherals. These behave exactly like any device you would connect to an Arduino.

## *"The list of blinky things"*

The *list of blinky things* is a list I came up with years ago for quickly answering the question of "what does that blinking light mean?".

- CTR Electronics
  - [Power Distribution Panel](https://www.ctr-electronics.com/downloads/pdf/PDP%20User's%20Guide.pdf#%5B%7B%22num%22%3A60%2C%22gen%22%3A0%7D%2C%7B%22name%22%3A%22XYZ%22%7D%2C69%2C696%2C0%5D) (2015-2022?)
  - [Voltage Regulation Module](https://www.ctr-electronics.com/VRM%20User's%20Guide.pdf#%5B%7B%22num%22%3A28%2C%22gen%22%3A0%7D%2C%7B%22name%22%3A%22XYZ%22%7D%2C69%2C696%2C0%5D)
  - [Pneumatic Control Module](https://www.ctr-electronics.com/downloads/pdf/PCM%20User's%20Guide.pdf#%5B%7B%22num%22%3A51%2C%22gen%22%3A0%7D%2C%7B%22name%22%3A%22XYZ%22%7D%2C69%2C720%2C0%5D) (multiple pages)
  - [Talon SRX](http://www.ctr-electronics.com/Talon%20SRX%20User's%20Guide.pdf#%5B%7B%22num%22%3A93%2C%22gen%22%3A0%7D%2C%7B%22name%22%3A%22XYZ%22%7D%2C33%2C705%2C0%5D)
  - [Victor SPX](http://www.ctr-electronics.com/downloads/pdf/Victor%20SPX%20User's%20Guide.pdf#page=11&zoom=auto,-207,705)
- Rev Robotics
  - [Spark Max](https://docs.revrobotics.com/sparkmax/status-led)
  - [Spark](https://www.revrobotics.com/content/docs/REV-11-1200-UM.pdf#page=14&zoom=auto,2,756)
- National Instruments
  - [roboRIO](https://www.ni.com/pdf/manuals/374474a.pdf#G45855) (multiple pages)


## OpenMesh Radios

The current fleet of robots are using OpenMesh radios for 2.4GHz and 5GHz communication. 

These radios come in two models (found on the bottom of the radio). First is the `OM5P-AN` and the second is the `OM5P-AC`. The `AC` variant is the newer (and faster) model. It is also more locked down. You can flash OpenWRT to the `AN` model and use it as a practice field router (which I have done before).

These are consumer routers designed for home use! They are **not** in any way good at robotics applications. You will want to follow [this guide](https://docs.wpilib.org/en/stable/docs/networking/networking-introduction/om5p-ac-radio-modification.html) to protect your routers before putting them on the field.

For information on flashing routers, see [here](https://docs.wpilib.org/en/stable/docs/zero-to-robot/step-3/radio-programming.html#programming-your-radio). Routers from Israeli teams will be incompatible with any north american tech, so they need to be reflashed to match our regulations.

## Datasheets

| Manufacturer         | Model                     | Datasheet                                                                                                                    |
|----------------------|---------------------------|------------------------------------------------------------------------------------------------------------------------------|
| OpenMesh             | OM5P-AC                   | [PDF](https://www.openmesh.com/resource-downloads/OM-Series-Datasheet.pdf)                                                   |
| CTR Electronics      | Power Distribution Panel  | [PDF](https://www.ctr-electronics.com/downloads/pdf/PDP%20User's%20Guide.pdf)                                                |
| CTR Electronics      | Voltage Regulation Module | [PDF](https://www.ctr-electronics.com/VRM%20User's%20Guide.pdf)                                                              |
| CTR Electronics      | Pneumatic Control Module  | [PDF](https://www.ctr-electronics.com/downloads/pdf/PCM%20User's%20Guide.pdf)                                                |
| CTR Electronics      | Talon SRX                 | [PDF](https://www.ctr-electronics.com/Talon%20SRX%20User's%20Guide.pdf)                                                      |
| CTR Electronics      | Victor SPX                | [PDF](https://www.ctr-electronics.com/downloads/pdf/Victor%20SPX%20User's%20Guide.pdf)                                       |
| Rev Robotics         | Spark Max                 | [HTML](https://docs.revrobotics.com/sparkmax/status-led)                                                                     |
| Rev Robotics         | Spark                     | [PDF](https://www.revrobotics.com/content/docs/REV-11-1200-UM.pdf)                                                           |
| National Instruments | roboRIO                   | [PDF](https://www.ni.com/pdf/manuals/374474a.pdf)                                                                            |
| Kauai Labs           | NavX-MXP                  | [PDF](https://pdocs.kauailabs.com/navx-mxp/wp-content/uploads/2020/09/navx2-mxp_robotics_navigation_sensor_user_guide-8.pdf) |

More devices can be found in [this list](https://docs.wpilib.org/en/stable/docs/controls-overviews/control-system-hardware.html).

## Reference Material

- [The CAN Bus and Protocol](https://en.wikipedia.org/wiki/CAN_bus)
- [The SPI Communication Standard](https://en.wikipedia.org/wiki/Serial_Peripheral_Interface) used by many peripherals
- [Pulse Width Modulation](https://en.wikipedia.org/wiki/Pulse-width_modulation) (used by some speed controllers and encoders)
- [Rotary Encoders](https://en.wikipedia.org/wiki/Rotary_encoder) (keep in mind, we almost exclusively use **Hall Effect + Quadrature + Incremental** encoders)