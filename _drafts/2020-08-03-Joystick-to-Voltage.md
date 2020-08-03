---
layout: page
title:  "Notes from FRC: Converting joystick data to tank-drive outputs"
description: "..and making a tank-based robot's movements look natural"
date:   2020-08-03 09:07:00 
categories: frc
redirect_from: 
 - /post/6j49kjl4/
 - /6j49kjl4/
---

I am starting a new little series here called "Notes from FRC". The idea is that I am going to write about what I have learned over the past three years of working (almost daily) with robots, and hopefully someone in the future will find them useful.

Today's topic is quite simple, yet almost nobody has written anything about it. One of the very first problems presented to you when working with an FRC robot is: *"I have a robot, and I have a controller.. How do I make this thing move?"*. When I first started as a software developer at *Raider Robotics*, I decided to do some Googling, as I was sure someone would have at least written about this from the video-game industry.. Nope.

Let's lay out the problem. We have an application that needs to run some motors from a joystick input. Periodically, we are fed a vector of joystick data, `[T, R]`, where `[-1, -1] <= [T, R] <= [1, 1]`. `T` denotes our *throttle* input, and `R` denotes something we at Raider Robotics call *"rotation"*. As you will see later on, rotation is not quite the correct word, but none of us can come up with anything better. Some teams, who use a steering wheel as input instead of a joystick, call this number *wheel*, which makes sense in their context.