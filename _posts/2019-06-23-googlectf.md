---
layout: page
title:  "I gave Google's CTF a short try and learned a thing or two"
description: "But exams got in the way and took all the fun"
date:   2019-06-23 22:04:00
tags: ctf
---

Honestly, I completely forgot that this was the weekend of Google's online [CTF Qualifications](https://g.co/ctf) for 2019 and was late, unprepared, busy, and did not have a team to work with.

## What is this event?
Google hosts a (yearly?) event where hackers from around the world team up and attempt a variety of tasks like: exploiting machines over a network, reversing firmware, pulling passwords from tcp packets, hacking crypto stuff (something I suck at), breaking compilers. and much more. Generally, this event and others like it are really fun.

## What I learned
Many questions I worked on involved extracting a key from a binary. I employed two vastly different tools for this job. First, a standard linux tool, `strings`. When passed a filename, it will extract and print all human-readable strings it can find to the terminal. The flag is usually in this dump. If not, I use the second tool. [Ghidra](https://www.nsa.gov/resources/everyone/ghidra/), an open-source reverse engineering tool designed by the NSA. I used this tool a fair amount during my quick attempt at GCTF.

## Will I do this again?
Yes! The CTF was very fun to try, and I will definitely give it a proper shot next time.