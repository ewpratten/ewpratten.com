---
layout: page
title: "I built my own private telephone network" 
description: "Nobody makes phone calls anymore"
date:   2022-02-14
tags: project pbx
draft: true
extra:
  uses_katex: false
  auto_center_images: true
---

Over the past few months, I have built my own [internet backbone router](/blog/amprnet-bgp) (and an [internet exchange](https://ffixp.net)). So logically, the next step is to branch off into telephony... *right?*

Eh, even if I never get any practical use out of any of this in the end, at least its content for the blog.

## A simplistic introduction to telephone networking

This is all coming from someone that has very little experience with the telephony world, but I *have* managed to make all my gear work, so this can't go too badly.

As far as I have ever been concerned, the telephone network looks as follows:

![The magical phone network](/images/posts/personal-pbx/magic_phones.png)

But in reality, it looks a little more like the internet (I guess that makes sense, since dialup was a thing).

![The magical phone network, with more phones](/images/posts/personal-pbx/phone_internet.png)

The *Dark Magic* still exists, and I am still not entirely sure whats going on there. Presumably some kind of routing protocols exists to handle country codes and such, but I have had no need (yet) to explore this further.

Continuing on with terminology, **Phones** are simply endpoints. Such endpoints could be cellphones, VOIP clients, automated answering machines, etc. **Carriers** are the same as the internet world. Big companies that own switching gear and phone number blocks they charge you to connect up to. 

Finally, **PBX**es. A [Private Branch eXchange](https://en.wikipedia.org/wiki/Business_telephone_system#Private_branch_exchange) (PBX) combines the concepts of routers and [NATs](https://en.wikipedia.org/wiki/Network_address_translation) in the telephony world. A PBX can be hardware-controlled, or software-defined through something like [Asterisk](https://en.wikipedia.org/wiki/Asterisk_(PBX)).

I have personally used Asterisk a fair bit due to its heavy use in the Amateur Radio world as the backbone for repeater interconnections. More on this in a bit.

## The goals for this project



