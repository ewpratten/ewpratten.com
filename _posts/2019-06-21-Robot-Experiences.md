---
layout: post
title:  "What I have learned from 2 years of FRC programming"
description: "Robots are pretty cool"
date:   2019-06-21 15:14:00
categories: frc
---

Over the past two years (2018 / 2019), I have been a member of my school's [FRC](https://www.firstinspires.org/robotics/frc) team, [Raider Robotics](frc5024.github.io). Specifically, a programmer.

## My roles
In my first year, I joined the team as a programmer and had a fun time learning about embedded programming and development with hardware. Then, in my second year, I was promoted to programming co-lead along with [@slownie](https://github.com/slownie). I much preferred my second season because I had a better understanding of the technology I was working with, and we got to play with some cool tools throughout the season.

## What I have learned
Starting with our 2018 season, PowerUP. We learned early on that there is a practical limit to the number of programmers that 5024 can handle. That year, we had too many, and our situation was not helped by the fact that some members preferred scrolling through Instagram over writing code. This issue was almost entirely fixed by the introduction of a mandatory skill exam at the start of the season. Sam and I did not really care about the scores of the exam because, from reading the results, we could see who was actually motivated to join the team. Thanks to the test, we entered the season with seven excited programmers.

During the PowerUP season, I also learned the importance of student involvement. Most of the code from the season was written by mentors with the students just watching on a projecter. After talking with other team members, I learned that none of them through this was a good method of teaching, and many felt powerless. In the 2019 season, I completely reversed this. All students worked together on the codebase, and the mentors worked on other projects and provided input where needed.

### Version Control
During the 2018 season, code was shared around by USB. This lead to crazy conflicts, confusion over what was running on the robot, and general frustration during competitions. In 2019, I moved the team over to a [GitHub](https://github.com) organization account and sent an email to support to get us unlimited private repos (thanks GitHub!). For the team members that where not comfortable in the terminal, I set them up with [GitKracken PRO](https://www.gitkraken.com/) accounts, and they enjoyed using the program. The rest of us stuck with GIT cli, or various plugins for VSCode.

### Alpha test
I got our team on board with the 2019 toolchain alpha test the week it was released in order to get everyone used to the new tools before the season (and help find bugs for the WPILib team). The new buildsystem, Gradle, worked great and I could even run it on the chromebook I was using for development at the time! To further assist the team, I set up a CI pipeline for automatic testing and code reviews of Pull Requests, and a doxygen + GitHub pages CD pipeline for our new documentation webpage.

### Webdocs
A significant amount of my time was spent answering repetitive questions from the team. I enjoy helping people out, but explaining the same things over and over was starting to frustrate me. This was caused by a lack of documentation or bits of documentation spread over multiple websites. To solve this problem, I started the [Webdocs Page](https://frc5024.github.io/webdocs/#/). This website is designed to house a mix of team-specific notes, guides, low-level documentation, and documentation from all FRC vendors. This site was published after the season, so I will find out how usefull it really is during the 2020 season.

### Command base
"Command based programming is great. But..." is probably the best way to describe my suggested changes for 2020.

I have been learning from other teams, and from mentors about better ways to control our robot. During the offseason, I am playing with new ways to write robot code. Here are some of my changes:
 - Use a custom replacement for WPILib's [Subsystem](https://first.wpi.edu/FRC/roborio/release/docs/java/edu/wpi/first/wpilibj/command/Subsystem.html) that buffers it's inputs and outputs
   - This reduces load on our CAN and Ethernet networks
 - Offload all camera and vision work to a Raspberry PI
 - Every subsystem must push telemetry data to NetworkTables for easy debugging and detailed logs
 - Use a custom logging system that buffers writes to stdout. This reduces network strain

I am working on many other changes over on the [MiniBot](https://github.com/frc5024/MiniBot) codebase.

## My plans for 2020
I have been re-selected to be the sole lead of the 5024 programming team for 2020. Here are my goals:
 - Switch the team from C++ to Java 
   - Easier for prototyping
   - Better memory management for high-level programmers
   - Better documentation from vendors
   - It is taught in our school's compsci classes
 - Remove the skills exam in favour of weekly homework for the first 8 weeks
 - Provide writeups of lessons
 - Have mentors do "guest presentations"
 - Dedicate a day to robot driving lessons
 - Use a custom library with wrappers and tools built by me to provide easy interfaces for new programmers