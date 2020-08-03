---
layout: page
title:  "Notes from FRC: Autonomous point-to-point navigation"
description: "The tale of some very curvy math"
date:   2020-08-03 10:00:00 
categories: frc
redirect_from: 
 - /post/68dj2jl4/
 - /68dj2jl4/
---

This post is a continuation on my "Notes from FRC" series. If you haven't already, I recommend reading my post on [Converting joystick data to tank-drive outputs](/blog/2020/08/03/drivetrain-navigation). Some concepts in this post were introduced there. Like last time, to see the production code behind this post, check [here](https://github.com/frc5024/lib5k/blob/ab90994b2a0c769abfdde9a834133725c3ce3a38/common_drive/src/main/java/io/github/frc5024/common_drive/DriveTrainBase.java) and [here](https://github.com/frc5024/lib5k/tree/master/purepursuit/src/main/java/io/github/frc5024/purepursuit/pathgen).

At *Raider Robotics*, most of my work has been spent on these three subjects:
 - Productivity infrastructure
 - Developing our low-level library
 - Writing the software that powers our past three robots' *DriveTrain*s

When I joined the team, we had just started to design effective autonomous locomotion code. Although functional, our ability to manurer robots around the FRC field autonomously was very limited, and with very low precision. It has since been my goal to build a powerful software framework for precisely estimating our robot's real-world position at all times, and for giving anyone the tools to easily call a method, and have the robot to drive from point *A* to *B*. My goal with this post is to outline how this system actually works. But first, I need to explain some core concepts:

**Coordinate System**. At Raider Robotics, we use the following vector components to denote a robot's position and rotation on a 2D plane (the floor). We call this magic vector a *pose* :

$$
pose = \begin{bmatrix} x \\ y \\ \theta \end{bmatrix}
$$

**Localization**. When navigating the real world, the first challenge is: knowing where the robot is. At Raider Robotics, we use an [Unscented Kalman Filter](https://en.wikipedia.org/wiki/Kalman_filter#Unscented_Kalman_filter) (UKF) that fuses high-accuracy encoder and gyroscope data with medium-accuracy VI-SLAM data fed off our robot's computer vision system. Our encoders are attached to the robot's tank track motor output shafts, counting the distance traveled by each track. Although this sounds extremely complicated, this algorithm can be boiled down to a simple (and low-accuracy) equation that originated from marine navigation called [Dead Reckoning](https://en.wikipedia.org/wiki/Dead_reckoning):

$$
\Delta P = \begin{bmatrix}(\Delta L - \Delta R) \cdot \sin(\theta\cdot\frac{\pi}{180}) \\ (\Delta L - \Delta R) \cdot \cos(\theta\cdot\frac{\pi}{180}) \\ \Delta \theta \end{bmatrix}
$$

The result of this equation, $$\Delta P$$, is then accumulated over time, into the robot's *pose*. $$L$$ and $$R$$ are the distance readings from the *left* and *right* tank tracks.

