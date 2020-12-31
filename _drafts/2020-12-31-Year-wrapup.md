---
layout: page
title:  "2020 Wrap-Up"
description: "I wrote a lot of code this year. This post looks back on it all"
date:   2020-12-31 10:00:00 
written: 2020-12-09
tags: writeup review projects
excerpt: >-
    2020 has been my most productive year so far in terms of software development. This post looks back at the year
redirect_from: 
 - /post/g494l5j3/
 - /g494l5j3/
---

*So, whats up with 2020?* For readers who do not know me personally, here is a quick overview:

 - I made over 6000 commits to over 300 open source projects
 - I passed both 300 and 400 GitHub repositories on my account (and am on track to pass 500 any second)
 - I lead software development at [Raider Robotics](https://github.com/frc5024) for my third year
 - I published my largest open source project
 - I got to do a summer internship at Toronto-based animation studio [Industrial Brothers](https://www.industrialbrothers.com/), working on pipeline software
 - This website now gets over 300 readers per month (wow!)

## Robotics

This year, I packed a lot of robotics work into a small amount of time. Starting in the first week of January, through the beginning of March, I worked with close to 100 other highschool students at *Raider Robotics* to develop our most successful robot of recent time: [Darth Raider](https://www.thebluealliance.com/team/5024/2020). 

<div class="center" markdown="1">
<iframe width="443" height="249" 
src="https://www.youtube.com/embed/iF-p-rTo8Xk" frameborder="0" 
allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
</iframe>

*The full source code and tooling for this robot is [public](https://github.com/frc5024/InfiniteRecharge)*
</div>

This robot brought us all the way to the finals of our only competition this year (before the world got shut down). It was only in the finals that we finally lost our winning streak (and strong #1 place) due to some questionable scoring and a broken component on one of our teammate's robots.

On the software side of this machine, [I pushed to switch the core development language over to Java](/blog/2019/06/24/languagehunt2), which went very well, and the team seems to be on track to stay with this new language and toolset for the forseeable future. This year, we pushed very hard towards our goal of letting software handle as much of the "hard work" of operation as possible. In previous years, our robots mainly acted as stupidly expensive RC cars with custom controls, but this year, we wanted to offload tasks prone to human error to computers. 

We were able to design a fully autonomous shooting system using high-speed computer vision, real-time path planning, and ball trajectory models to allow our operators to make the robot score game pieces by pressing and holding a single button. On top of this scoring system, *Darth Raider* featured fully autonomous and real-time-error-correcting spatial navigation, allowing us to input a list of goal coordinates for the robot to navigate to efficiently. The final large autonomously controlled system of this robot was known as the "hopper"; a long tunnel for storing and stacking balls. This system was 100% software controlled, and made use of an amazing predictive sorting system developed by @rsninja722 that would perfectly align balls as they were fed in to the robot. Below is a clip taken from semi-finals where we wrote an experimental system that allowed us to essentially use two completely separate robots as one, effectively doubling our gamepiece storage capacity from our max 4 balls to 7. (Big thanks to the [Falcons](https://www.thebluealliance.com/team/5032) for letting us subject them to this experiment.)

<div class="center" markdown="1">
![Two-robot autonomous scoring system](/assets/images/buddy-auto.gif)
</div>


For a few months after we finished competing, I went on to publish my largest open source project to date: [Lib5K](https://github.com/frc5024/Lib5k). 

> Lib5K is the software library that powers the Raider Robotics control system. It originally started as a summer project by @ewpratten back in the 2018 offseason. [...] Lib5K development really picked up during summer 2019, where the library (and all of Raider Robotics development) switched from C++ to Java Native. This switch also brought a lot of the core features to Lib5K, and the whole team got involved in development during the 2020 season. \[source: [Lib5K Wiki](https://cs.5024.ca/lib5k/)]

My goal with Lib5K was to design a way for myself to pass along my knowledge and learnings to future team members in an easy-to-digest way. According to internal team productivity metrics, I have made around 650,000 edits to this library, making it my most contributed-to project ever.

## Personal projects

During a rewrite of this website I did earlier this year, I implemented a new section on the homepage, where I list all of my major projects. This list is ever-growing, and generally a good place to see what I am working on.

<!-- This year, I have spent my time in the following development categories:

 - Libraries
 - CLI
 - Web
 - Pipeline -->

All the code I have written this year has lead to the need to build a plethora of common software libraries in my three main languages: Python, Java, and C/C++. Through the process of building these, I have picked up many new skills like: properly unit-testing software, [building reliable library distribution systems](/blog/2020/09/17/ultralight-writeup), and extensively documenting code.

In the web world, I have learned to work with [JamStack](https://jamstack.org/), and have deployed many serverless / lambda-powered web applications, mostly based on [Flask](https://github.com/pallets/flask) or [Jekyll](https://jekyllrb.com/). A list of my repositories that use these technologies can be found [here](https://github.com/search?l=&q=user%3AEwpratten+filename%3Anow.json&type=code). 

I have also picked up low-level programming for systems running on the [AVR Microprocessor architecture](https://en.wikipedia.org/wiki/AVR_microcontrollers). I have found AVR programming to be a fun and generally easy way to learn about very low-level computing: interrupts, timers, I/O, serial busses, memory management, etc. I also used this as an opportunity to learn how to use a powerful new build system developed by Google, called [*Bazel*](/categories?c=bazel). Many of my projects this year have been shifting over to build with *Bazel* as I really enjoy the build environment and tooling available. I have also used *Bazel* to build [my popular school note-taking system](/blog/2020/08/23/notetaking-with-latex).

A list of the over 200 personal projects I have worked on this year (including unfinished projects) can be found with [this query](https://github.com/search?l=&q=user%3AEwpratten+created%3A%22%3E+2020-01-01+%3C+2021-01-01%22&type=repositories).

## Finishing up

I'll end this post with a few things that did not get to be their own major section:

### My programming challenge

People who know me in real life know of a bit of a challenge I set for myself a while ago (although I don't actually try very hard to keep up). I have now gone a year without a break from programming any longer than three days (completely accidental), and two years without a break any longer than five days. (yes, this is the secret to how I have so many projects, I never stop writing code).

### This website

I have now experimented with three posting schedules for this website: monthly, bi-weekly, and weekly. Monthly posts were too spread-apart, and left this site feeling a little empty. I switched to weekly posting through the summer, which worked out great. Since school started again, I have moved to bi-weekly posts, writing each post a few weeks before publishing it (hover over the date of any post to see the date I wrote it). The bi-weekly system seems to be working very well, and I will likely stick to it until summer 2021, so enjoy more content fairly regularly (and remember to subscribe to my [RSS Feed](/feed.xml)).

