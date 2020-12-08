---
layout: page
title:  "My first mechanical keyboard: The Vortex Core"
description: "Just the right amount of obscure"
date:   2020-11-6 23:00:00 
written: 2020-09-28
tags: keyboards workflow
excerpt: >-
    I recently purchased my first mechanical keyboard, and decided to go "all in" with a 40% layout.
redirect_from: 
 - /post/XlPl0k24/
 - /XlPl0k24/
---

About a month ago, I decided to buy myself a mechanical keyboard. I have always been a huge fan of membrane / laptop keyboards. My current laptop (the Lenovo T480) has a very nice feel to its keyboard, and my previous laptop (the Acer R11) had the best keyboard I have ever used. The switch to mechanical wasn't my first choice, although I was open to trying something new, so didn't see it as a negative. Ever since adding another monitor to my setup, I haven't had enough room on my desk to fit a keyboard. This generally is not a problem since I mainly use my laptop, but I occasionally need to use my desktop for rendering work, which requires a separate keyboard.

I began to look for keyboards that could fit in the little space in front of my laptop, and stumbled across [a video](https://www.youtube.com/watch?v=ofXOu7zK9IY) from one of my favorite YouTube creators, [Wolfgang](https://www.youtube.com/c/WolfgangsChannel/featured) on the [Niu Mini](https://kbdfans.com/products/niu-mini-40-diy-kit), which is a 40% keyboard (meaning it has 40% of the keys of a full size layout). The heavy use of keybindings to get work done on such a small keyboard interested me a lot, and I almost picked up a Niu Mini for myself, although ended up not getting it because I decided I wasn't quite ready to learn how to type on an [ortholinear](https://blog.roastpotatoes.co/review/2015/09/20/ortholinear-experience-atomic/) layout, while needing to learn keybindings at the same time.

Instead of the Niu Mini, I ended up getting myself the cheaper [Vortex Core](https://mechanicalkeyboards.com/shop/index.php?l=product_detail&p=3550). The core, made by the same company that produces the well-known [POK3R](https://mechanicalkeyboards.com/shop/index.php?l=product_detail&p=3527), is a programmable 40% with a staggered layout.

## Overall build

The Vortex Core is built very nicely, I chose mine with the [Cherry MX Brown](https://www.cherrymx.de/en/mx-original/mx-brown.html) switches, since I dislike overly clicky keyboards, and I have had no problems with noise. The keys also feel very nice, and are effortless to type with. Interestingly, my keyboard shipped with an extra "Windows" key in place of a function key, which on a keyboard that makes heavy use of function keys, was a bit annoying. Not a huge deal though, since I just know what the key does, and I don't spend much time looking at the keycaps anyways.

That being said, since the keyboard has so many shortcuts and combinations to get things done, I really like the fact that the core comes with color-coded keycaps that tell you what they do.

The keyboard's baseplate is made of aluminum, and is CNC-cut, so it both looks and feels very nice. For a keyboard that I can wrap my (admittedly large) hand around, it is fairly heavy too (I seem to remember the FedEx shipment coming in at around 3lbs). In this case, heavy is not at all a bad thing. The weight of this keyboard makes it feel... expensive. Also, it never feels like the board is sliding away when I'm typing.

![The keyboard](/assets/images/core.jpg)

One downside though, in terms of connectivity, the keyboard unfortunately uses USB micro connector instead of the newer (and nicer) USB type C connector. As someone who connects his life with USB-C, I am not the biggest fan of this choice, but at least I had a right-angle USB-micro cable lying around that I can use with it. Alongside the USB-micro connection, removing the backplate will reveal a [JTAG](https://en.wikipedia.org/wiki/JTAG) connector that allows you to flash custom firmware to the keyboard if you want. @ChaoticEnigma has forked the popular [QMK](https://github.com/qmk/qmk_firmware) keyboard firmware as [`qmk_pok3r`](https://github.com/pok3r-custom/qmk_pok3r), and added support for many Vortex boards including the Core, if you are looking to load something more custom.

## Keybindings

I have been talking non-stop about this keyboard's keybindings. So, *what's up with that?*

Keybindings are very common on 40% keyboards, since many keys you have probably grown to love simply are not on the keyboard anymore. No <kbd>F</kbd> keys, no number keys, no arrow keys, no symbols, and no quotations either. For this quick overview, I will explain this for a Vortex Core keyboard *without* any custom programming.

Let's say you wanted to type the number `5`. On the core, this is done by pressing <kbd>fn1</kbd>+<kbd>F</kbd> (there are three function keys on the core. <kbd>fn</kbd>, <kbd>fn1</kbd>, and <kbd>pn</kbd>). While this might be a bit confusing at first, it is a fairly simple system to learn, and the color-coded keycap markings make the learning process super easy.


## Programming

There are three main things I wanted to do immediately after getting my core:

 - Remap <kbd>Caps Lock</kbd> to <kbd>Tab</kbd>
 - Switch the <kbd>Win</kbd> and <kbd>Alt</kbd> keys to match the layout of my Thinkpad
 - Remap the arrow keys to [vim keys](https://hea-www.harvard.edu/~fine/Tech/vi.html)

The first could be done simply by performing a firmware upgrade to the latest version for the core. Setting custom keybindings on the other hand, requires switching the core's firmware to the `MPC` version. 

This process unfortunately requires access to a computer that runs Windows (or VirtualBox). On windows, the setup process is really quite easy. You go to [this link](http://www.vortexgear.tw/db/upload/webdata4/6vortex_201861271445393.exe), which will download the firmware upgrade tool. Running the tool, and plugging in the keyboard will provide you with some options.

![Vortex Core firmware upgrade tool](/assets/images/core-mpc-tool.png)

The "bin group" selection provides two options. Selecting `Core by MPC` will flash the re-programmable firmware to the keyboard, and the other option will restore the keyboard to factory firmware.

Vortex provides a programming tool, but I am not a huge fan of it. I plan to write a Java app that can program the keyboard (and load saved profiles from it), but for now, I am using a great tool made by @tsfreddie called [Much Programming Core](https://tsfreddie.github.io/much-programming-core/). This tool allows you to configure keybindings and remap keys through his website, and there are easy-to-follow instructions on how to download the correct file, and flash your keyboard.

![Much Programming Core website](/assets/images/core-mpc-webapp.png)

Speaking of flashing the board, with the MPC firmware, the process for loading custom keybindings (which works on any OS) is really easy and simple. Just unplug the keyboard, then plug it back in while holding <kbd>fn</kbd>+<kbd>D</kbd>. This will cause the keyboard to mount as a USB drive, and you can drop configuration files on to it.

## Do I recommend it?

Well, that depends. If you are the type of person to customize everything for maximum efficiency, go for it! The Vortex Core is a very nice keyboard with more configurability than I can wrap my head around (even if you need a third party tool to do so). If you just want something simple, stick to a 60% keyboard. The lack of numbers on the core drives many people crazy.

For programmers: you basically need to remap your keys. Most common keys (brackets, quotes, operators, ...) are hidden behind one or two function keys, and the learning curve might hurt for the first week or so.

