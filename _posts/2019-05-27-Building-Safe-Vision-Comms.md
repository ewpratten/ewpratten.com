---
layout: post
title:  "Building a safe and easy system for sending computer vision data from a raspberry pi to a roborio"
date:   2019-05-27 09:22:00+0000
categories: frc
---

Computer vision on an FRC robot has some problems.
 - RoboRIO is not powerfull enough
 - NetworkTables is not fast enough
 - A TCP connection is great until you lose connection
 - mDNS discovery is not reliable on the field
 - UDP can skip frames

## Needs
These are the things I need to have.
 - Send data from any device
 - Recive data on RoboRIO at any time
 - Data rate faster than period time

## Wants
These are the things I would like to have.
 - Easy discovery
 - Threaded
 - Simple interface for new programmers
 - Fallback in case of UDP issues
 - FMS network firewall compliant

I am currently working on a protocol for solving this problem, nad will post an update here once it has been tested. Feel free to let me know your thoughts and ideas.