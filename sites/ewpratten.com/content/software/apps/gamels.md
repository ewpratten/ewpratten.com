---
title: gamels
description: ls with the power of the Steam API
---

`gamels` will list all files in a directory in the style of `ls -la`, but will also show the name of any Steam game found in the listing. This utility was made to help me explore the filesystem of the Steam Deck.

This works by querying the Steam API to resolve the appids back in to something useful for us humans.

![](/images/software/apps/gamels/screenshot.png)

Rust users can install this tool with `cargo install gamels`. The source code and builds are available on [GitHub](https://github.com/ewpratten/gamels).
