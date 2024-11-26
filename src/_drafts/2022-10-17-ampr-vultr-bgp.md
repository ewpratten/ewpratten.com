---
layout: default
title: Announcing your AMPRNet prefix to Vultr with BGP
description: That how-to guide everyone keeps asking me to make
date: 2022-10-17
tags:
- amprnet
- networking
- bgp
draft: true
extra:
  auto_center_images: true
  excerpt: A tutorial for AMPRNet operators who are BGP announcing their first prefix
    to Vultr
aliases:
- /blog/ampr-vultr-bgp
---

Since I briefly [waved my hands over this topic](@/blog/2021-11-14-amprnet-bgp.md) last year, I have gotten many emails and DMs from fellow amateur radio operators asking for help announcing their own `/24`s to the world. 

This post is aimed at existing operators of AMPRNet who wish to BGP announce a `/24` or larger of IPv4 space from a Virtual Private Server (VPS). The VPS provider I have chosen for this process is [Vultr](https://www.vultr.com/?ref=8932365), since they are highly recommended in the AMPRNet community and have free BGP sessions for their machines upon request.

> AMPRNet [...] is used in amateur radio for packet radio and digital communications between computer networks managed by amateur radio operators.
> <br>\[source: [Wikipedia](https://en.wikipedia.org/wiki/AMPRNet)]

## Recap: Getting your IP prefix

You *should* already be familiar with this process if you are reading this post. If not, here is a very quick recap of how to request an AMPRNet BGP prefix.

Firstly, you must be a licensed [amateur radio](https://en.wikipedia.org/wiki/Amateur_radio) operator, and have an account on the [AMPRNet portal](https://portal.ampr.org/).

Once logged in, head to `Networks > 44.0.0.0/8`, and request a `/24` netmask. If you need more addresses, you can also request a *smaller* number than this, but you must have good reason. Be sure to also check the `Direct (BGP)` box.

![A screenshot of the prefix request page](/images/posts/ampr-vultr-bgp/request-page.png)

After filing the application, a member of the ARDC will review your request, and should follow up with more questions and information for you. Once its all done, you have yourself at least 255 IPv4 addresses for radio use for the next couple years (yes, you have to occasionally renew your prefix).

## Do you need an ASN?

*Probably not*, but it's handy to have one for future expansion. Feel free to skip this if you already have an Autonomous System Number (ASN).

> An autonomous system is a collection of connected Internet Protocol routing prefixes under the control of one or more network operators on behalf of a single administrative entity or domain, that presents a common and clearly defined routing policy to the Internet.
> <br>\[source: [Wikipedia](https://en.wikipedia.org/wiki/Autonomous_system_(Internet))]

Nearly every other provider that allows BGP sessions will require you to have an ASN, but Vultr lets you use a private number if you stay [single homed](https://www.datapacket.com/blog/multihomed-network-vs-single-homed-network) with them.

Some benefits come with going through the extra work of obtaining an ASN:

- Ability to freely jump between IP transit providers
- Ability to announce your IPs from multiple locations at once
- Ability to directly peer with other networks
- *Clout* :laughing:

If you would like to get your own ASN, you have a few possible routes to take:

- Get a european ASN from [August Internet](https://august.tw/) (a highly regarded RIPE [LIR](https://en.wikipedia.org/wiki/Regional_Internet_registry#Local_Internet_registry))
  - You also get a free `/48` of IPv6 space included with this
  - You must show that your network has some presence in the RIPE region
  - Local Internet Registries have fairly tight control over their customers, so you will generally need to ask August to do administrative things for you
- Shell out a bit of extra money and register your own ASN with [ARIN](https://www.arin.net/)
  - You must have a registered company in the ARIN region (Sole Proprietorships are fine)
  - Costs more, but gives you full freedom over your ASN and resources without a managing LIR

I personally went the second route with my own ASN ([398057](https://bgp.tools/as/398057)) because I did not like having the future of my network tied to an LIR's ability to stay in business, and was willing to pay a bit extra for such freedom.

## Bringing up a VPS

Alright. Prerequisites out of the way, its time to set up a router for your IP space.

With a Vultr account created, head to the [deploy page](https://my.vultr.com/deploy/?ref=8932365) and start configuring your server. My personal recommendation for a server that is only routing packets and not hosting any content is as follows:

- Cloud Compute, Regular Performance
- Whichever region is closest to you
- Debian 11 (x64)
- The $5/month plan is plenty
- No backups
- IPv6 *enabled*

Once your server is up and running, head to `Products > Network > BGP` in the Vultr control panel, and request BGP to be set up for your account. You'll have to provide the LOA you got from ARDC in your prefix application process.

At this point, you should get the option to choose between full routing tables and the default route. If you are single-homed, choose default route. If you have your own ASN, you should be able to decide for yourself weather you need full tables or not (I'm trusting you on this one :wink:).

While you are getting stuff ready, I recommend logging in to the server, possibly setting up [Fail2Ban](https://www.fail2ban.org/wiki/index.php/Main_Page), and installing the following packages:

```bash
apt install bird2 mtr tcpdump
```

At this point, just wait until Vultr gets your BGP session set up.

## Announcing your space



## Verify everything is working
