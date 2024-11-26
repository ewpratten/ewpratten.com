---
layout: default
title: I performed a button swap on my mouse
description: This had better not be my gateway drug into custom mice
date: 2023-05-01
tags:
- random
- hardware
draft: false
extra:
  auto_center_images: true
  excerpt: Some photos and notes on how I swapped the middle button on my mouse
  discuss:
    reddit: https://www.reddit.com/r/ewpratten/comments/1356u1t/i_performed_a_button_swap_on_my_mouse/
    hacker_news: https://news.ycombinator.com/item?id=35781662
aliases:
- /blog/mouse-button-swap
---

Recently, my mouse (a [Logitech M310](https://www.logitech.com/en-us/products/mice/m310-wireless-mouse.910-001917.html)) has been starting to give out on me, which I suppose is to be expected considering how much use my peripherals get, but is nevertheless annoying, considering that the failing component was the middle button, which I use a lot.

Instead of just heading out to Walmart and buying another mouse, I decided to try repairing this one with some spare parts I had lying around.

## The guts

Disassembling the mouse was nice and easy. Simply pop off the battery cover, remove the battery, and unscrew two screws. The top just pops off, revealing one of the simplest circuit boards I've seen in a while.

<div style="display:flex;flex-wrap:wrap;">
<img src="/images/posts/mouse-button-swap/PXL_20230501_193330518.jpg" style="max-width:210px;"></img>
<img src="/images/posts/mouse-button-swap/PXL_20230501_193336150.jpg" style="max-width:250px;"></img>
</div>

<br>

Located in the middle of the circuit is the momentary switch for the middle button. Conveniently the standard size you'd expect to find in a breadboard kit.

<img src="/images/posts/mouse-button-swap/PXL_20230501_234325200.jpg"></img>

## The swap

All that remained to do was to de-solder the old switch, and solder in a new one (which I conveniently have a few of in a bin by my desk).

Below is an image of the underside of the stock middle button, a very easy solder job.

<img src="/images/posts/mouse-button-swap/PXL_20230501_234350942.jpg"></img>

## The results

After de-soldering the existing button, and replacing it with a spare, I was left with a mouse circuit that looked no different than when I started.

<img src="/images/posts/mouse-button-swap/PXL_20230502_000502685.jpg"></img>

After re-assembling the mouse, I am proud to say that the button click now registers 100% of the time (unlike the ~40% when I started).

The only issue I have encountered is that my choice of replacement button is a little stiff, requiring slightly more activation force than before. I have a feeling that it will wear down over time. If not, I might just hit it with a little bit of lubricant.
