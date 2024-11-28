---
layout: default
title: ewconfig
description: A collection of scripts that automate my life
---

Over the past {{ site.time | date: "%Y" | minus: 2017 }} years, I have been building an ever-growing collection of scripts and config files that follow me around to each computer I use. I call this collection "ewconfig" (**ew**pratten's **config** files).

The premise is pretty simple. I have a git repository that can be cloned onto any computer, and some shell scripts handle moving files around and symlinking things to override whatever the defaults were on the system.

The whole thing is built to run on as many platforms as possible, using only the best supported shell and coreutils commands. This means that the same config bundle serves me on Linux, MacOS, BSD, Windows, and WSL.

## Plugins

I have built a plug-in system that allows me to create private extensions for sensitive work-related tools. These plugins are stored in a separate repository (within company infrastructure), and are pulled in by my work machine during the setup process.

These plugin repos are specifically built in a way that allows them to be used stand-alone by my co-workers too!

This means that I have an easy way to share shell scripts around at work by just saying "Hey, check out the latest commit to my scripts repo!"
