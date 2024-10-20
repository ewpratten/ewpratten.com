---
title: ewconfig
description: The scripts and config files that keep me sane
---

`ewconfig` (short for "**ew**pratten's **config** files") is a carefully maintained collection of scripts and config files that keep <span class="gray">(a surprisingly large portion of)</span> my life running smoothly.

Like most sysadmins/developers, I found myself building up a little bundle of shell scripts that I would move around between machines to customize my shell environments. Back in ~2017 I decided to make an attempt at properly organizing these files, and thus the first generation of `ewconfig` was born.

In its current state, `ewconfig` is made up of three main components:

- **Config bundle:** Stores application configs
- **Script library:** A collection of Python & BASH scripts
- **Module system:** A dynamic module loader that lets me write private plugins

These components are all managed by a cross-platform installer script.
