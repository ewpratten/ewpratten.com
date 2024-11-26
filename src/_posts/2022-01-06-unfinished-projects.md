---
layout: default
title: Unfinished projects and failed ideas
description: A walkthrough of my private GitHub repos
date: 2022-01-06
tags: random
draft: false
extra:
  excerpt: My GitHub profile is a bit like an iceberg. At the time of writing, I have
    made nearly 8 and a half thousand commits to nearly a thousand repositories. This
    post covers the hidden failed projects.
aliases:
- /blog/unfinished-projects
---

My [GitHub profile](https://github.com/Ewpratten) is a bit like an iceberg. At the time of writing, I have made nearly 8 and a half thousand commits to nearly a thousand repositories. Since July 2018, I have made an effort to go no more than 3 consecutive days without writing code, and I have only broken that streak 6 times (each of those being a 4-day break).


![My 2021 commit history](/images/posts/unfinished-projects/commit_history.png)

I remember making myself a GitHub account back in 8th grade (August 16, 2016 to be exact). Ever since then, I have published *every single* personal project I have made to GitHub.

My goal at the time was simply to use GitHub as a free file storage platform for my little side-projects, but it ended up having two interesting side-effects:

- My profile is an accurate representation of my work, since it *is* my work. No filler or template projects needed!
- You can see my progression as a programmer by looking through my timeline.

Since I send potential employers directly to my GitHub profile, I have a few rules for how I manage the account. The important one for this post is:

> Only *finished* and *documented* projects are made public. (Some WIP projects may also be public for various reasons)

This means that while I currently have 476 *finished* personal projects (yes, I write a lot of code), I also have roughly the same number of unfinished projects that'll likely never see the light of day.


## Showcase

My goal for this post is to showcase some of the interesting failed ideas I have had in the past. Before I get to the whole list, here are a few recent projects of mine that are worth mentioning in their own section:

### A near success

This is a project that may actually be finished some day, considering how its nearly production ready.

In mid-late 2021, I was building a custom graphics pipeline for some friends. After finishing work on [**\[data::loss\]**](https://github.com/Ewpratten/ludum-dare-49), a group of us started prototyping various concepts for future games. Continuing off of this, [@demilurii](https://demilurii.art) and I began looking at integrating 3D layout and rigging tools into our 2D asset pipeline.

Thus, `strangle` was born. Strangle is a little tool that allows super easy project and asset management through various tools using Pixar's [USD](https://graphics.pixar.com/usd/release/index.html) as a data interchange format.

`strangle` can handle the [MagicaVoxel](https://ephtracy.github.io/), [Blender](https://www.blender.org/), [Maya 2022](https://www.autodesk.ca/en/products/maya/overview), and [Houdini](https://www.sidefx.com/) DCCs in a layering approach, where each DCC is used to add their specialty to an asset. This means that magica could be used for modeling, blender for texturing and shading, maya for layout, rigging and animation, and houdini for lighting and FX.

This whole pipeline works flawlessly, but the tooling was never released due to some less-than-ideal design choices in how the tools interface with each other across OSes.

### A public failure

I actually published one of my failed projects as reference material for other developers.

[https://github.com/ewpratten/animal-loader](https://github.com/ewpratten/animal-loader)

<br>

> `animal-loader` (A not-so-acronym for "A Native Mod Loader") is an experimental, unfinished project to allow the [@kleientertainment](https://github.com/kleientertainment/) games [Don't Starve](https://www.klei.com/games/dont-starve) and [Don't Starve Together](https://www.klei.com/games/dont-starve-together) to load native mods written in rust, and support WebAssembly plugins.

After starting work on this project, I learned that the game I was attempting to mod was never compiled with support for dynamic library loading through its LUA interface, so I was unable to continue without considerable effort.

### A little bit of IOT hacking

`mitechlib`, another unfinished project of mine, is a Rust library that allows me to programmatically interface with the laundry machines in the building I live in.

The only reason it exists is because I thought it would be funny to walk into a laundry room, and wash my clothes with a laptop connected to a washing machine.

## The list


With the power of APIs, I threw together a little GraphQL query to grab all my private repos:

```graphql
query { 
  viewer { 
    repositories (privacy: PRIVATE, first: 100, after: null) {
      edges {
        node {
          name
          description
        }
      }
      pageInfo {
        endCursor
      }
    }
  }
}
```

I then vetted the list a bit, and converted it to a web-ready format.

Here is the new and improved list of my project ideas that never saw the light of day:

- `CardStudio`
  - A tool for working with various RFID cards using Proxmark devices
- `proxmark-rs`
  - A Proxmark3 client library for Rust
- `render-test`
  - An experimental game that only uses ASCII art for rendering
- `ewpratten-commit-stats`
  - A private api for querying my GitHub ranking in Canada
- `dst-rpc`
  - Discord RPC (Rich Presence) support for @kleientertainment's Don't Starve Together (precursor to animal-loader)
- `blink-camera-api`
  - A partial API client for Amazon/Blink cameras
- `blink-client`
  - A simple client for Blink home security cameras
- `MultiAuth`
  - A development tool to allow a mix of premium and "offline mode" accounts to join a Minecraft server
- `multirss`
  - A minimalist RSS aggregator
- `dynmap-viewer`
  - A high-performance desktop client for Dynmap
- `wtf`
  - A utility for dumping large amounts of information about a host
- `microfetch`
  - An over-simplistic portable command-line system information tool
- `mitechlib`
  - A library for interacting with Mitech smart connected laundry machines
- `rc2d`
  - A 2D raycasting library for line-of-sight lighting in 2D games
- `MuchPerformance`
  - A minecraft performance modpack
- `tiny-osc`
  - Morse code practice ocillator built on the Atmel ATtiny85 platform
- `EmmetMob`
  - A minecraft mod that turns my friend into an entity
- `amprdns`
  - An alternate DNS service, only avalible to 44net hosts
- `betaroute`
  - A peer-to-peer routing tool
- `MiwuStickers`
  - A custom sticker pack
- `shoot-to-interact`
  - A game with one option: shoot
- `protocrypt`
  - An experimentation in XOR-ing data
- `tinylink`
  - An alternate repeater linking project
- `repeaterstack`
  - A full amateur radio simplex node / remote repeater
- `hamscan`
  - Frequency monitoring and web visualization based on `rtl_power`
- `strangle`
  - Experimental voxel art pipeline
- `vox2usd`
  - Convert from the Magica Voxel file format to Universal Scene Description
- `usd-tutorial-files`
  - Scripts from Pixar's USD tutorials
- `discolytica`
  - A tool for tracking discord data into an analytics database
- `ampr-minecraft`
  - Minecraft server for stress-testing an edge router
- `darkdns`
  - A standalone Docker-based DNS server that resolves lesser-recognized domains
- `r3_pipeline`
  - Video game and animation production pipeline (Used for **\[data::loss\]**)
- `egf`
  - Evan's Game Framework: Everything you need to build a 2D game
- `tyler`
  - A custom `tiled` map loader
- `sonr`
  - A voice chat control library built on Serenity and Songbird
- `discord-map`
  - Generates a graphviz map of all your Discord servers
- `ewc`
  - C-compatible core library for quick development shortcuts in various languages
- `cloth-toy`
  - 2D cloth simulation toy
- `morsencode`
  - Experimental data encoding algorithm based around morse code
- `kobodash`
  - A simple dashboard application for the Kobo Aura
- `gpu-avg`
  - Learning experiment for executing headless compute shaders
- `rtiod`
  - Ray-Tracing In One Day: A random project to fill my time
- `spac`
  - Abstract mathematical types for library interop with easy-to-use interfaces
- `vec-convert`
  - A translation layer between the many Rust vector types
- `open-echo-proxy`
  - An open-source echolink proxy server
- `discord-framework`
  - Easily build Discord bots by defining them using JSON data
- `tinygl-rs`
  - Rust bindings to tinygl
- `network-monitor`
  - A tool for logging network drops
- `fileshare`
  - Personal file-sharing service
- `disco`
  - Simple network discoverability service
- `zndfrm`
  - A procedural audio engine
- `egui-raylib-rs`
  - Raylib integration for egui
- `error-adaptor`
  - Utility macros for wrapping external error types in Rust
- `xplre`
  - XPLRE: A small 2d game
- `strands`
  - Basic and experimental physics toys
- `minecraft-wasmtime-experiment`
  - Experiment in loading plugins into Minecraft with Wasmtime
- `csrpc`
  - Crazy Simple RPC library
- `tiny-analytics`
  - Small and efficient analytics engine for my personal projects
- `ut`
  - Usage Tracking API
- `zzarl`
  - VA3ZZA Amateur Radio Logging software
- `kx2-rs`
  - Rust library for serial control of the Elecraft KX2/KX3 transceivers
- `kxsvc`
  - Local gRPC service for programmatic control of Elecraft KX2 and KX3 transceivers
- `nv`
  - An environment management tool
- `pathwarn`
  - A library for providing useful feedback about invalid paths passed to Rust applications
- `tvdsb-student-api-rs`
  - Rust API for interacting with Thames Valley District School Board student information
- `ludum-dare-48-rework`
  - A design rework of our Ludum Dare 48 game: Deep Breath
- `ewpose`
  - "ewpratten's positioning library"
- `vision-types`
  - Datatypes and utils related to computer vision targets
- `ampersand`
  - A build tool for Rust-based Android apps
- `gnn`
  - An experiment in building a generic neural network
- `pixyusb2-rs`
  - Rust bindings for `libpixyusb2`
- `mdviz`
  - Multi-dimensional graphing tool
- `lightpanel`
  - A tool for turning my computer monitors into configurable light sources for my room
- `improc`
  - Image processing and filtering in Rust
- `leapmotion-rs`
  - Rust bindings for the LeapMotion V2 API
- `wg-dash`
  - A dashboard for WireGuard servers
- `lmvn`
  - A small tool for managing local maven repositories
- `packtool`
  - A tool for managing Minecraft modpacks
- `breaktrack`
  - A simple crawler for broken URLS on a webpage
- `stratosphere-r6`
  - A tool for estimating Rainbow Six Siege match results
- `autojson`
  - Automatic JSON serialization and deserialization macros for Rust
- `ZZALOG`
  - VA3ZZA's Amateur Radio logging software
- `repeatermon`
  - A tool for monitoring repeater activity
- `lcx`
  - LaunchControlX: A custom macro pad
- `git-time`
  - Graph time spent on a Git project
- `spawn-server`
  - Experimental Minecraft server infrastructure
- `aprtwt`
  - APRS <-> Twitter bridge
- `raylib-tessellation`
  - A bridge between Lyon and Raylib, allowing easy GPU path tessellation
- `slyce`
  - An experiment in low-complexity game development
- `GameTK`
  - A game development and 3D rendering framework
- `raylib-imgui-rs`
  - Raylib + Dear ImGui. In Rust
- `cone-of-vision-demo`
  - A small app demonstrating cone-of-vision rendering in 2D
- `raylib-tweaks`
  - Some small tweaks and extensions on raylib to make it a little more Rust-friendly
- `bdl`
  - Small and fast HTTPS file downloader
- `burstfetch`
  - A very simple BitTorrent implementation
- `tinyos`
  - A tiny OS
- `nodelink`
  - Dockerized internet radio nodes
- `path3d`
  - A demonstration of 3D path solving
- `repeater-info`
  - Web-based amateur radio repeater information
- `avr-rust-utils`
  - Some utility functions for working with Rust AVR code
- `py-aprsfi-api`
  - An aprs.fi API client for Python
- `hambadges`
  - Embeddable badges for amatuer radio operators
- `ham-status`
  - An experimental dashboard for amatuer radio operators
- `logbook`
  - Clean and simple log-keeping program for amateur radio operators
- `propagation-app`
  - A simple android app for displaying HF and VHF propagation information
- `tws-bs-x-morse`
  - Platform-agnostic Rust driver for the TWS-BS series high-power wireless transmitter modules. This driver is specifically for sending data encoded as morse code
- `wxbcn`
  - A project to create a local area CW beacon providing temprature and light level informaiton
- `twentytwo`
  - A Minecraft server plugin that adds a new music disc type
- `rayray-demo`
  - 3D rendering 3D objects, ray-traced in 3D. An experiment
- `maven-edge`
  - Tools to deploy personal maven edge servers anywhere, any time
- `mathutils-rs`
  - Rust port of my MathUtils library
- `basic-control`
  - Basic systems and controllers for Python
- `control-rs`
  - Rust ports of various basic control loops and systems
- `mathutils-py`
  - Python port of MathUtils
- `bionic`
  - A robotics framework
- `glass-engine`
  - A dead simple 2d game engine build from past experience
- `update-notifier`
  - A small Java library to provide software update notifications to users
- `plugin-core`
  - Core API shared across my Spigot / PaperMC plugins
- `rq`
  - A scalable rendering pipeline
- `jarcon`
  - A lot of recon in a little bit of jar (A tool for hiding telemetry services in Java applications)
- `SDRInterface`
  - Web front-end for my WebSDR server
- `MapLink`
  - The missing link between Dynmap and your Minecraft client
- `hookback`
  - Remote monitoring for Java applications
- `ChatBridge`
  - Bridge Minecraft chat to a Discord channel
- `PlayerStats`
  - A Minecraft server plugin for tracking client-server activities
- `sdrexplorer`
  - A web tool for exploring WebSDR servers globally
- `tooltips`
  - Meta extensions to Java, allowing custom tooltips in source
- `VarStrings`
  - Non-constant String types for Java
- `LiteIO`
  - A lightweight HAL for systems I commonly use
- `openbandplan`
  - A web-viewer for ITU region 2 band plans
- `baremetal-avr`
  - C++ tools for working with AVR microprocessors
- `AutoBCN`
  - Simple CW beacon driver
- `repeaterbook2gqrx`
  - A tool for exporting a list of repeaters from RepeaterBook as a GQRX bookmark file
- `koctl`
  - A tool for interacting with Kobo hardware on-device
- `RayJava`
  - Raylib bindings to Java using cross-compiled JNI
- `rayconsole`
  - A graphical debug console for use in Java RayLib applications
- `codestyle.css`
  - CodeStyle is a small CSS+JS project I built to nicely style Kramdown code blocks
- `toy.social`
  - A personal learning project where I create a simple social platform for sharing text-based posts
- `nativetools`
  - My personal toolchain for developing code using the Java Native Interface
- `rules_teensy`
  - A collection of Bazel rules for the teensy microcontroller family
- `xlog`
  - Cross-platform PWA for logging radio contacts, and syncing between devices
- `open-london`
  - A simple API for querying data about the city of London Ontario
- `repeatermap`
  - An interactive map showing VHF and UHF amateur radio repeaters throuought the world
- `robolib`
  - A Python library containing various tools I developed during my time in highschool robotics
- `no-wurst-logo`
  - A small fabric mod to completely disable the Wurst client logo
- `quicksds`
  - A small Python library that extends dataclasses to allow packing and unpacking
- `REGEXResolver`
  - A small and simple asset resolver for the Pixar USD framework, based on REGEX rules
- `flashbg`
  - Flash BattleGrounds is a fast-paced multiplayer arena battle game
- `amongus_hooks`
  - A Python library for interacting with a local instance of Among Us on a Windows host
- `mobile_cv_passthrough`
  - An experimental Android app for running basic OpenCV video pipelines on-device
- `dynmap_heatmap`
  - A GUI tool to generate a real-time heatmap of the positions of Minecraft players via the Dynmap API
- `vscode-poetry`
  - Visual Studio Code extension for the Poetry build tool
- `quickxor`
  - A tool and file format for encoding and decoding data with an ASCII key
- `fastrender`
  - Quick, simple, and easy to use graphics
- `launchlib`
  - Interact with MIDI controllers
- `lp2joy`
  - Convert Novation Launchpad inputs to Joystick buttons
- `smtp-send`
  - A tool for sending email using direct SMTP connection
- `backblaze`
  - Rendering improvements for Minecraft
- `thirdparty-mod-docs`
  - Automatic Javadoc generation for other people's Minecraft mods
- `voxelmc-pipeline`
  - Sponge schematic -> VOX data processing pipeline
- `grafana-nt`
  - A Grafana datasource for NetworkTables servers
- `snapfinder`
  - A tool for scraping snapchat accounts out of instagram bios
- `randomart`
  - Generates SSH randomart from any file
- `mc-analytics`
  - A tool for analyzing Minecraft server logs
- `textual`
  - A web graphics engine based around visual story telling
- `offload`
  - Multi-host hardware interfaces with RPC-over-serial
- `combat-tracer`
  - Adds the "Tracing" enchantment to Minecraft, allowing the player to mark entities by hitting them
- `amongus-hacking`
  - Playing with the Among Us multiplayer protocol
- `remoduino`
  - A project to turn AVR-based Arduino devices into scriptable devices over UART
- `jekyll-wiki`
  - A small and lightweight jekyll wiki theme
- `coreserv`
  - Fast and easy minecraft server hosting inside a docker container
- `icebucket`
  - A small server-side plugin to allow players to add frost-walker to an iron bucket
- `playergraph`
  - Graph the vitals of every player on a Minecraft server in real time
- `mapcap`
  - A tool for taking "screenshots" of a minecraft map by hooking into dynmap
- `shift3`
  - A fast re-implementation of https://github.com/Ewpratten/shift
- `dynfolio`
  - Dynfolio is a web tool for displaying your Instagram profile as a photography portfolio
- `tinygc`
  - A small learning experiment in garbage collection
- `shotpredict`
  - ShotPredict is a software library for predicting the trajectory of objects launched through the air
- `backblast`
  - The UI/UX framework I use for web frontends when I don't want to do web work
- `obfuj`
  - A demonstration of visually obfuscating Java code
- `simple-sensor-fusion`
  - A small Java library and Android webapp for pose estimation of an FRC robot
- `SnapAbuse`
  - A script for quickly dealing with spam snapchat accounts to determine what they are trying to do.
- `fsession`
  - A simple library for sorting files based on the current session
- `sliding-arm-manipulation`
  - A project to design a system with a single jointed arm on a slider
- `tapatalk-api`
  - Interact with tapatalk via Python
- `bust_scripts`
  - Experimental bustabit betting scripts
- `celltrackd`
  - A tool for tracking people based on their network connectivity
- `vessl`
  - An experiment in isometric game development
- `statix`
  - Easily configurable and scriptable status bars
- `tvdsb-student-life`
  - The TVDSB Student Life app
- `rules_avr`
  - Bazel rules for build code using AVRC 
- `roborank`
  - A tool for ranking FRC teams
- `learning-drake`
  - Source code from my process of learning how to use DRAKE
- `driverstation`
  - A tool for transmitting X-Input data to robot controllers running FRCNetComm
- `ewvector`
  - Vectors, Quantities, and Sizes
- `yubiparse`
  - A simple library for parsing yubikey OTP strings
- `tictacsolve`
  - A program for deciding the optimal move in tac-tac-toe for any given board state
- `Rayzor2`
  - A faster implementation of the Rayzor rendering engine
- `libJames`
  - Query @rsninja722's life from inside Python
- `PathChaser`
  - An experiment in autonomous movement inside an urban environment
- `pixypose`
  - An experiment in pose estimation with computer vision
- `pysnapcode`
  - Python scripts for working with snapcodes
- `swarm`
  - A virtual experiment in swarm-based robotics
- `homebase`
  - A webapp for tracking meeting participants
- `GhostStat`
  - Share your Google Fit or Apple HealthKit stats in SnapChat
- `snapterm`
  - Share your terminal to SnapChat
- `containerFIRST`
  - An entire FRC software development toolsuite in a Docker container
- `pastefs`
  - A filesystem based around hosting your files in someone else's cloud
- `guikit`
  - Build simple GUI programs in Java (an extension of PicoEngine)

## Language statistics

Wow! You made it to the end of the list!

As a reward, here are some language statistics for the project list above. This does not include all languages, just the first few I queried from GitHub off the top of my head.

![Language stats](/images/posts/unfinished-projects/lang_stats.svg)
