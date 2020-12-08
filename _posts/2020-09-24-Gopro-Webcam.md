---
layout: page
title:  "My workflow: video conference edition"
description: "Turning some spare filmmaking equipment into a high-quality video conference setup"
date:   2020-09-24 15:30:00 
written: 2020-09-13
tags: video cameras workflow
excerpt: >-
    As my courses have moved mostly online, I have looked to improve 
    my live video setup. This post covers how I stream sharp HD video 
    at home, and some interesting quirks of the setup.
redirect_from: 
 - /post/XcaM04o4/
 - /XcaM04o4/
---

It has been quite some fun writing about my workflows for various day-to-day things on this blog recently, and since I have been getting a lot of positive feedback from my last few workflow-related posts, I am planning to continue writing them.

As my courses and work have moved mostly online, I have looked to improve my home setup. This started out with investing in another monitor to be dedicated to displaying server and network status info for my recent summer internship at [Industrial Brothers](https://industrialbrothers.com/). After that, I started looking in to purchasing a high-end condenser microphone and another audio interface to drive it, but quickly discovered that Lenovo did such a good job on the internal mic in my [ThinkPad T480](https://www.lenovo.com/ca/en/laptops/thinkpad/thinkpad-t-series/ThinkPad-T480/p/22TP2TT4800) that it is hard to buy a better microphone without spending a large chunk of money.

So, I can keep video conferences on their own screen, while still doing work on the other two, plus I have a pretty good mic. There is only one thing left to upgrade. The webcam!

I went searching for something decent, and immediately encountered a large issue. Everyone is sold out of webcams. That's fair, there is a massive market for them right now, and not many companies actively producing new products. This lead me to a secondary option, one that I was planning to do quite a while ago when I ran a joint gaming YouTube channel with a friend in elementary school. 

Commonly, professional videographers will actually use a spare DSLR or point&shoot camera with a video output as their webcam. When I had originally looked in to doing this, I was turned off by the insane prices of capture cards. At the time, I was only familiar with large tech brands, and seeing a mid-tier capture card for $500 wasn't exactly 12-year-old-me-friendly.

More recently, I have gotten in to searching through eBay for generally Chinese manufacturing facilities selling unbranded products in bulk directly. Since these products are basically coming straight off an assembly line, and not going through any other company, they end up being ridiculously cheap! *(I recommend looking for Arduinos this way. You can usually acquire them in batches at $1.15 per board)*

During one of my searches, I stumbled across a few sellers selling batches of generic / un-branded capture cards. Clearly designed to be resold with custom branding. You can pick one of these up for only $15! The one I have can do 1080p/60 and 2.7k/30 (disclaimer: these are the only resolutions I have tried. It can probably handle other sizes). 

Another nice thing about the card I got, since it isn't made by some company that requires special software to run their products (cough, Elgato, cough) the device was plug&play compatible with my Ubuntu laptop!

## Alright. Enough about cheap capture cards, and on to my setup.

For the actual camera, I opted for the *GoPro Hero 5 Black edition* that has been sitting on my desk unused for the past year. Unfortunately, this camera is no longer sold by GoPro. If you are looking to replicate this setup, I can strongly recommend picking up the [Hero 7 Black edition](https://gopro.com/en/us/shop/cameras/hero7-black/CHDHX-701-master.html), which is the most recent GoPro camera to support live HDMI video without needing a bunch of accessories.

Speaking of HDMI video, I also picked up a Micro HDMI to HDMI cable to connect from the camera's output to the capture card. [This one here](https://www.ebay.ca/itm/Micro-HDMI-to-HDMI-Cable-Supports-Ethernet-3D-1080P-Audio-Return-3-6-10-15FT/193637232780?hash=item2d15adb08c:g:KDMAAOSwNGNfRdnR) should do the trick, and is only $8.

For mounting, I went with a [Jolby GorillaPod](https://joby.com/global/gorillapod/), but let's be honest. These are GoPros. There is no shortage of mounting solutions for them. You could do a first-person-view conference call if you really wanted. (New project idea..?)

## Software Setup

The software setup process is quite simple, and fairly painless. First, near the end of every GoPro's settings menu is a mode selector for how HDMI output should behave. Setting this to `live` will cause the camera to output exactly what it sees, without any status icons or timestamps, to the capture card.

On the computer end, these cheap capture cards identify themselves as webcams. So there isn't really much setup needed. That being said, many people I know like to send their capture card output into [Open Broadcaster Software](https://obsproject.com/), process the feed, then export it as a [virtual webcam](https://obsproject.com/forum/resources/obs-virtualcam.949/).

## Some neat things to try

Experimenting with my camera's many video cropping / scaling modes has been quite fun. I have discovered that keeping the camera in `linear` mode is good for general usage and presenting, and switching to `superwide` is great if I need to physically demonstrate or show something.

I recently remembered that GoPros also have [voice commands](https://www.captureguide.com/gopro-voice-commands/). I have been using this to switch between `timelapse`, `video`, and `photo` modes, where I have saved a video preset in each. This is a very cheaty way to change my camera settings on the fly without needing to use the GoPro app on my phone. Here is what each of these modes is set to do on my camera:

| Mode      | Action                                                                                            |
|-----------|---------------------------------------------------------------------------------------------------|
| timelapse | Narrow view, zoomed in on my face. This looks like a normal laptop webcam                         |
| video     | Linear view. Very crisp, and auto-lowlight handling enabled. This looks like I'm using a DSLR     |
| photo     | Superview. Zoomed all the way out, at full resolution. It's so wide, you can see whats on my desk |