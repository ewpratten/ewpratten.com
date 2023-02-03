---
title: "Projects: Kobo Ereader Hacking"
---

I got myself into the weird world of hacking ereaders a while back. Most Kobo products are just poorly secured Linux machines. These projects abuse various aspects of the firmware upgrade process to load custom code onto my ereader.

## Kobo Rust Library

![](https://img.shields.io/badge/Language-Rust-green)

`kobo-rs` is a minimal Rust library for interacting with modified Kobo e-readers. This is designed for use in applications running on the Kobo, not over the network.

This is my current core Kobo library used in various other (mostly private) projects.

View on: [GitHub](https://github.com/Ewpratten/kobo-rs)


## Kobo Tweaks

![](https://img.shields.io/badge/Language-Starlark-green)
![](https://img.shields.io/badge/-archived-orange)

This project contains some of my earlier Kobo tweaks and tools, and was used as my initial bootstrapping environment for later work.

View on: [GitHub](https://github.com/Ewpratten/kobo-tweaks)


## KoboSSH

![](https://img.shields.io/badge/Language-Bash-green)

The KoboSSH project contains the tools needed to compile [dropbear](https://matt.ucc.asn.au/dropbear/dropbear.html) for the `arm-kobo-linux-gnueabihf` system (all recent Kobo products). This binary is used for root shell access on Kobo devices which, in my case, is used to deploy and debug software on e-readers.

View on: [GitHub](https://github.com/Ewpratten/KoboSSH)


## KoLib

![](https://img.shields.io/badge/Language-C++-green)
![](https://img.shields.io/badge/-archived-orange)

KoLib is a modern C++ library to assist in development of software targeting Kobo products. This project was superseded by my Kobo Rust library.

View on: [GitHub](https://github.com/Ewpratten/kolib)