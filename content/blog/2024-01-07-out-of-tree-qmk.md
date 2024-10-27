---
title: Building QMK Keyboard Firmware Out of Tree
description: Side-stepping the QMK monorepo for my own sanity
date: 2024-01-07
draft: false
extra:
  auto_center_images: true
aliases:
  - /blog/out-of-tree-qmk
---

Like many builders and users of custom mechanical keyboards, I make heavy use of the [QMK](https://qmk.fm) keyboard firmware project. It provides functions for doing everything you'd expect a keyboard to be able to do, and is the de-facto standard for [AVR](https://en.wikipedia.org/wiki/AVR_microcontrollers)-based custom keyboards.

For anyone unfamilliar with QMK, it is a *huge* monorepo containing:

- The QMK firmware code itself
- A handful of vendored dependencies
- A custom build system
- A tree of per-user firmware configurations for various keyboards

This means that cloning the QMK Git repository will also pull in everyone's custom keyboard configurations (even though there is very little chance you'll ever use them).

While I am generally a fan on working in monorepos, I'm not a huge fan of including user-specific code in the main source tree (for this project at least). Additionally, the work required to keep up with the intended flow of the QMK project is a bit much for me considering that I have more important things to spend my time on (like, actually using my keyboard).

## Working Out of Tree

To completely side-step the fork-edit-PR cycle of the main QMK project, I've been experimenting with working out of tree.

This means that my personal firmware source files live in an external repository, and I have a script that:

1. Fetches a fresh copy of the QMK source code
2. Loads the dependencies
3. Copies my modifications on-top of the QMK source tree
4. Builds the firmware
5. Handles flashing the firmware to my keyboards (one of them has some weird extra steps)

### My process

My keyboard source code is organized by board:

![File tree](/images/posts/out-of-tree-qmk/file-tree.png)

The contents of these files are exactly like a normal QMK keymap.

When it comes time to build the firmware, my script will directly copy each keymap into the QMK source tree, correctly modifying file paths to match that of the main repository.

```text
keyboards/qmk/keymaps/<keyboard> -> keyboards/<keyboard>/keymaps/ewpratten
```

Then, it simply passes the build arguments to the QMK buildsystem.

## Closing thoughts

This post turned into more of a show-and-tell than my usual walkthrough format.

Have questions, comments, or want to learn more about my build script? Please [send me an email](/contact).