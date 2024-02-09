---
title: Custom lighting for my bookshelf
description: For when Ikea is slightly too much effort
date: 2024-01-14
tags:
  - electronics
draft: false
extra:
  auto_center_images: true
aliases:
  - /blog/shelf-lights
---

Beside my desk, I have a bookshelf. While this *"book"shelf* barely contains any books, it is a key part of my hobby work as it contains all kinds of electronic components, a server, some networking gear, and my 3D printer.

![Office Layout](/images/posts/shelf-lights/office-layout.png)

A few years ago, I semi-permanently affixed a strip of PWM-controllable RGB LEDs around the frame of my desk to make it glow at night, and since then I've been looking for more things to LED-ify. Thus, the next logical step was to light up my bookshelf!

![The lights on my desk](/images/posts/shelf-lights/desk-lights.jpg)

<p style="text-align:center;"><em>Lights on my desk</em></p>

## The plan

My bookshelf is laid out as follows:

![Bookshelf Layout (side)](/images/posts/shelf-lights/shelf-layout-side.png)

I only wanted to light up the top row, since the bottom row has very little room for light to bounce around in, so after a few hours of tinkering, I settled on the following wiring layout (top-down view):

![Bookshelf Layout (top)](/images/posts/shelf-lights/shelf-layout-top.jpg)

***NOTE:** In both images, the purple lines represent the LED strips, and the red lines represent the wires connecting them.*

I opted to use some WS2812 LED strips, and a small Arduino to tie everything together software-wise.

Of course, in real life, the wiring looks a.. um.. appropriate amount of sketchy.

![A photo of the wiring](/images/posts/shelf-lights/shelf-lights-left.jpg)

<p style="text-align:center;"><em>A photo of the left-most section</em></p>

## A custom LED controller

The LED controller that came with my LED strips isn't awesome... mainly because it doesn't even power on :laughing:. So, equipped with an Arduino and a soldering iron, I set out to make my own.

The software isn't really important here, since its basically the [NeoPixel](https://github.com/adafruit/Adafruit_NeoPixel) example code, but I did opt to make my program function with one button.

I can tap the button to cycle through a few different preset colours, and I can also hold it for a few seconds to turn the whole thing on and off.

The controller itself is 100% function and 0% aesthetic, but that sums up most of my personal harware projects, so it fits right in.

![The controller](/images/posts/shelf-lights/led-controller.jpg)

## The results

So, how does it look?

Great actually!

![The lights on my bookshelf](/images/posts/shelf-lights/shelf-lights.jpg)

## A note from later me

Hi! It is currently February 2, 2024. I've recently re-written and open-sourced the software tha powers this shelf. Feel free to check it out [on GitHub](https://github.com/ewpratten/shelf-led-controller).
