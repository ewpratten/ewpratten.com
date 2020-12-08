---
layout: page
title:  "Notes from FRC: Autonomous point-to-point navigation"
description: "The tale of some very curvy math"
date:   2020-08-13 10:00:00 
tags: frc
excerpt: >-
    This post is a continuation on my "Notes from FRC" series. This time, 
    I cover an extremely simple, yet very effective way to get a 
    tank-drive robot from A to B autonomously.
redirect_from: 
 - /post/68dj2jl4/
 - /68dj2jl4/
uses:
 - katex
---

This post is a continuation on my "Notes from FRC" series. If you haven't already, I recommend reading my post on [Converting joystick data to tank-drive outputs](/blog/2020/08/03/joystick-to-voltage). Some concepts in this post were introduced there. Like last time, to see the production code behind this post, check [here](https://github.com/frc5024/lib5k/blob/ab90994b2a0c769abfdde9a834133725c3ce3a38/common_drive/src/main/java/io/github/frc5024/common_drive/DriveTrainBase.java) and [here](https://github.com/frc5024/lib5k/tree/master/purepursuit/src/main/java/io/github/frc5024/purepursuit/pathgen).

At *Raider Robotics*, most of my work has been spent on these three subjects:
 - Productivity infrastructure
 - Developing our low-level library
 - Writing the software that powers our past three robots' *DriveTrain*s

When I joined the team, we had just started to design effective autonomous locomotion code. Although functional, our ability to manuever robots around the FRC field autonomously was very limited, and with very low precision. It has since been my goal to build a powerful software framework for precisely estimating our robot's real-world position at all times, and for giving anyone the tools to easily call a method, and have the robot to drive from point *A* to *B*. My goal with this post is to outline how this system actually works. But first, I need to explain some core concepts:

**Poses**. At Raider Robotics, we use the following vector components to denote a robot's position and rotation on a 2D plane (the floor). We call this magic vector a *pose* :

$$
pose = \begin{bmatrix} x \\ y \\ \theta \end{bmatrix}
$$

With a robot sitting at $$\big[\begin{smallmatrix}0\\0\\0\end{smallmatrix}\big]$$, it would be facing positive in the $$x$$ axis.

**Localization**. When navigating the real world, the first challenge is: knowing where the robot is. At Raider Robotics, we use an [Unscented Kalman Filter](https://en.wikipedia.org/wiki/Kalman_filter#Unscented_Kalman_filter) (UKF) that fuses high-accuracy encoder and gyroscope data with medium-accuracy VI-SLAM data fed off our robot's computer vision system. Our encoders are attached to the robot's tank track motor output shafts, counting the distance traveled by each track. Although this sounds extremely complicated, this algorithm can be boiled down to a simple (and low-accuracy) equation that originated from marine navigation called [Dead Reckoning](https://en.wikipedia.org/wiki/Dead_reckoning):

$$
\Delta P = \begin{bmatrix}(\Delta L - \Delta R) \cdot \sin(\theta\cdot\frac{\pi}{180}) \\ (\Delta L - \Delta R) \cdot \cos(\theta\cdot\frac{\pi}{180}) \\ \Delta \theta \end{bmatrix}
$$

The result of this equation, $$\Delta P$$, is then accumulated over time, into the robot's *pose*. $$L$$ and $$R$$ are the distance readings from the *left* and *right* tank tracks.

With an understanding of the core concepts, lets say we have a tank-drive robot sitting at pose $$A$$, and we want to get it to pose $$B$$. 

$$
A = \begin{bmatrix}0\\0\\0\end{bmatrix}
$$

$$
B = \begin{bmatrix}0\\1\\90\end{bmatrix}
$$

This raises an interesting problem. Our *goal pose* is directly to the left of our *current pose*, and tanks cannot strafe (travel in the $$y$$ axis without turning). Luckily, to solve this problem we just need to know our error from the goal pose as a distance ($$\Delta d$$), and a heading ($$\Delta\theta$$):

$$
\Delta d = \sqrt{\Delta x^2 + \Delta y^2}
$$

$$
\Delta\theta = \arctan(\Delta y, \Delta x) \cdot \frac{180}{\pi}
$$

Notice how a polar coordinate containing these values: $$\big[\begin{smallmatrix}\Delta d \\ \Delta\theta\end{smallmatrix}\big]$$ is very similar to our joystick input vector from the [previous post](/blog/2020/08/03/joystick-to-voltage): $$\big[\begin{smallmatrix}T\\S\end{smallmatrix}\big]$$. Converting our positional error into a polar coordinate makes the process of navigating to any point very simple. All we need to do is take the [Hadamard product](https://en.wikipedia.org/wiki/Hadamard_product_(matrices)) of the coordinate matrix with a gain matrix to make small adjustments to the output based on the physical characteristics of your robot, like the amount of voltage required to overcome static friction. This is a very simple P-gain controller.

$$
input = \begin{bmatrix}\Delta d \\ \Delta\theta\end{bmatrix}\circ\begin{bmatrix}K_t \\ K_s \end{bmatrix}
$$

This new input vector can now be fed directly into the code from the previous post, and as long as the $$K_t$$ and $$K_s$$ gains are tuned correctly, your robot will smoothly and efficiently navigate from pose $$A$$ to pose $$B$$ automatically.

There are a few tweaks that can be made to this method that will further smooth out the robot's movement. Firstly, we can multiply $$\Delta d$$ by a restricted version of $$\Delta\theta$$. This will cause the robot to slow down any time it is too far off course. While it is slower, turns can be made faster, and more efficiently. This cuts down on the amount of time needed to face the goal pose in the first place. We can calculate this gain, $$m$$, as:

$$
m = \big(-1 * \frac{\min(abs(\Delta\theta), 90)}{90}\big) + 1
$$

$$m$$ is now a scalar that falls in $$-1 \leq m \leq 1$$. Our calculation to determine a new "input" vector is now as follows:

$$
input = \begin{bmatrix}\Delta d \\ \Delta\theta\end{bmatrix}\circ\begin{bmatrix}K_t \\ K_s \end{bmatrix} \circ \begin{bmatrix}m \\ 1 \end{bmatrix}
$$

For even more controllability, Raider Robotics passes $$\Delta d$$ through a [PD](https://en.wikipedia.org/wiki/PID_controller#Selective_use_of_control_terms) controller, and $$\Delta\theta$$ through a [PI](https://en.wikipedia.org/wiki/PID_controller#PI_controller) controller before converting them to motor values... and that is it! With just a couple formulæ, we have a fully functional autonomous point-to-point locomotion system. 

For a real-world example of this method in use, check out 5024's robot (bottom right) and 1114's robot (bottom left). Both teams were running nearly the same implementation. We were both running autonomously for the first 15 seconds of the game:

<iframe width="1280" height="720" src="https://www.youtube.com/embed/5Q39LIVcXSQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

---

I hope someone will some day find this post helpful. Most papers about this topic went way over my head in 10th grade, or were over-complicated for the task. If you would like me to go further in depth on this topic, [contact me](/about/) and let me know. I will gladly help explain things, or write a new post further expanding on a topic.