---
title: My work at Raider Robotics
---

# My work at Raider Robotics

I was a member of [Raider Robotics](https://raiderrobotics.org) (a competitive robotics team) from 2017 through 2021.

During my time on the team, I was the lead software developer. This role involved devising and giving lessons on embedded programming to other students, creating high-level system designs, coordinating a team of other developers, and writing code (*lots* of code).

Alongside my software development responsibilities, I also worked very closely with the mechanical team to design and implement complex physical systems to high standards.

## Personal specializations

Outside of the general work that comes with building high-performance machines, I found interest in a few specific areas:

### Computer vision

I built three OpenCV-based vision systems for the team, each drastically improving upon the last.

The first two were based on hand-tuned color, shape, and edge detection algorithms. These systems were used to detect position deltas of game elements and scoring targets.

By obtaining real-time position deltas in robot-space, I was able to build path planning and following algorithms that allowed robots to autonomously navigate the world based on vision data.

#### My first ever attempt at vision-based path following

<div style="max-width:200px;margin:auto;">
    <video controls style="width:100%">
        <source src="/videos/robotics/5024/vision_v1.mp4"  type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

#### A different robot using computer vision to validate the position of a target

<div style="max-width:200px;margin:auto;">
    <video controls style="width:100%">
        <source src="/videos/robotics/5024/vision_v2.mp4"  type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

#### Using VISLAM to navigate to a point in space

<div style="max-width:500px;margin:auto;">
    <video controls style="width:100%">
        <source src="/videos/robotics/5024/vision_v3.mp4"  type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

### Robot Locomotion

I also developed a deep fascination of robot locomotion. I spent a great deal of time learning about the physics involved in making things move, and a greater amount of time learning how to make them move to where I wanted them to be.

Some systems I developed as a result of my learnings were:

- Predictive anti-tip software (used an array of sensors to predict when robots were likely to tip over, and automatically correct for it)
- [VISLAM](https://en.wikipedia.org/wiki/Simultaneous_localization_and_mapping)-based spacial navigation (as seen above)
- A robot simulator that was used to sanity-check software changes before deployment

## Robots I've worked on

The following are robots I've worked on at Raider Robotics:

- [Darth Raider](/robotics/5024/darth-raider)
- [HATCHField](https://github.com/frc5024/deepspace)
- [MiniBot](https://github.com/frc5024/uBase)
- [Q*bert](https://github.com/frc5024/powerup) ([offseason re-write](https://github.com/frc5024/PowerUp-Offseason))

## Lib5K

My final large project at Raider Robotics was [Lib5K](https://github.com/frc5024/lib5k), a software library that was designed to make everything I learned over my time at Raider Robotics available to and easy to use for future students.