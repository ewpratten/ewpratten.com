---
layout: page
title:  "How I route my own public IPv4 address space"
description: "A college student, playing with the \"big boys\""
date:   2021-11-14
tags: reference
draft: true
---

Your first, and possibly only question is likely: *"what?"*, and I forgive you for asking such a thing. As probably any reader of my posts knows very well, IPv4 address blocks are practically impossible to get, and more than impossible to get for personal use. To quickly clear things up, my address block is *not* for personal use, but in comparison to the majority of the internet's existing address block owners, I am basically a single person holding on to a /24 subnet for dear life while the giants of large internet corporations are eating up everything around me.

Ok, ok, I'm sure you are here for actual technical talk, and not a history lesson, so here we go.

## How do you even get IPv4 space? 

These days, the minimum [BGP](https://en.wikipedia.org/wiki/Border_Gateway_Protocol)-routable IPv4 block is a /24 subnet, coming in at 255 addresses. One of these blocks auctions for prices starting around 15 thousand dollars USD. I'd say thats slightly unachievable for a college student like me, but when I come to think about it, that's still less than a year of tuition, so... :eyes:

Alright, enough getting side-tracked. I'd rather pay $0 for some IP space if possible, and luckily for me, it is! I am a licensed [Amateur Radio operator](https://en.wikipedia.org/wiki/Amateur_radio), and through this, I get to make use of a few cool license-restricted services run by and for other operators. One of such services is [AMPRNet](https://en.wikipedia.org/wiki/AMPRNet), a /8 subnet of public IP space specifically assigned for Amateur Radio Digital Communications back in 1981, and self-administered by radio amateurs. The governing body of this subnet is the [Amateur Radio Digital Communications](https://www.ampr.org/) (ARDC) foundation. Through their web portal, with a manually-verified account, any amateur can request subnets or single addresses under the `44.0.0.0/8` subnet.

There are, of course, restrictions to this which I will not cover in full here. The main restriction to keep in mind is: AMPRNet address space *must* be used for amateur-radio-related uses only, and generally must better the radio community in some way.

The primary justification for my allocation is that a large chunk of my addresses are being used to provide [Echolink](https://secure.echolink.org/) proxies that allow users behind firewalls to interact with the Echolink network. Other uses of my address space involve exposing software-defined radios to the internet, and repeater linking.

<h2>RIP <em class="gray">(my free time)</em></h2>
<!-- Mention the first OpenVPN setup -->

## There is a better way



<!-- 
 - Inexperience, jumping right in
 - Benjojo
 - Contacting people (Felix and other person)
 - 
 -->