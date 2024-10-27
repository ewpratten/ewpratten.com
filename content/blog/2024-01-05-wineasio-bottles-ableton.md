---
title: WineASIO, Bottles, and Ableton
description: How to run Ableton in a bottle with minimal latency
date: 2024-01-05
draft: false
extra:
  auto_center_images: true
  excerpt: A post showing the process of installing WineASIO into a bottle
aliases:
  - /blog/wineasio-bottles-ableton
---

Ableton was not built to run inside Wine. Yet, I've been doing it anyways for the past 6-ish years with reasonable success anyways.

Over those years, my one complaint about the setup is latency. No matter what I tweaked, I couldn't get audio input/monitoring to behave as well as it does on a supported operating system.

Generally, when you encounter audio latency issues on Windows, the go-to solution is Steinberg's *Audio Stream Input/Output* (ASIO) API. Its effectively a direct pipe between software and your sound card, bypassing the Windows audio stack entirely. Could there be such a thing for Wine?

## WineASIO

Well, you read the title of this post, so I kinda already gave the answer to that question away.

[WineASIO](https://github.com/wineasio/wineasio) is a project that implements the ASIO API inside Wine, and pipes the audio to the Jack Audio Connection Kit (JACK) on the host system instead of a physical sound card.

While you could just follow the instructions in the WineASIO project README and skip over the rest of this post, the WineASIO project is mainly designed to work with a standard Wine install and JACK running on the host system. Being a Fedora user, I have neither of these things.

I instead use [Bottles](https://usebottles.com/) to manage multiple wineprefixes (*wineprefixi?*) and [PipeWire](https://www.pipewire.org/) to manage audio on my system. So, I had to do a bit of extra work to get WineASIO working.

### Compiling

Compiling WineASIO is quite simple. Firstly, grab the dependencies (the Wine and JACK headers):

```sh
sudo dnf install pipewire-jack-audio-connection-kit-devel wine-devel
```

Then, clone the WineASIO repo and compile it:

```sh
# Clone the repo
cd /tmp
git clone https://github.com/wineasio/wineasio
cd wineasio
git submodule update --init --recursive

# Compile
make 64
```

This will produce a pair of libraries in `./build64`. Copy them to Wine's library directories:

```sh
sudo cp ./build64/wineasio.dll /usr/lib64/wine/x86_64-windows/
sudo cp ./build64/wineasio.dll.so /usr/lib64/wine/x86_64-unix/
```

### Installing into a Bottle

Firstly, you need to know your bottle's `WINEPREFIX`. You can find this by taking the output of the command `bottles-cli info bottles-path` and appending the name of your bottle to it. For example, my Ableton installation looks like this:

```sh
# echo $(bottles-cli info bottles-path)/Ableton-11-Suite
/home/ewpratten/.local/share/bottles/bottles/Ableton-11-Suite
```

With this path, set your `WINEPREFIX` environment variable, and run the WineASIO registration script:

```sh
export WINEPREFIX= ... # Your path here
/tmp/wineasio/wineasio-register
```

Finally, copy the built libraries into your bottle:

```sh
cp /tmp/wineasio/build64/wineasio.dll.so $WINEPREFIX/drive_c/windows/system32/wineasio.dll
cp /tmp/wineasio/build64/wineasio.dll.so $WINEPREFIX/drive_c/windows/system/wineasio.dll
```

## Using WineASIO

Now that WineASIO is installed, Ableton will automatically detect it and list it in your audio drivers list. Simply select it, and you're good to go. (You even get [Ableton Link](https://www.ableton.com/en/link/) support when using WineASIO!)

I personally have [a script](https://git.ewpratten.com/ewconfig/tree/scripts/ableton-linux) that handles this whole process for me automatically.

*Oh, ya. Happy New Year btw.*
