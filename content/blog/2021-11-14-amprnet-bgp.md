---
layout: page
title: 'Adventures in BGP: routing my own public IPv4 address space'
description: A college student, playing with the "big boys"
date: 2021-11-14
tags:
- reference
- amprnet
- bgp
- networking
extra:
  excerpt: This post covers the process I went through to publicly route my own /24
    block of IP addresses with low-cost hardware.
aliases:
- /blog/amprnet-bgp
---

Your first, and possibly only question is likely: *"what?"*, and I forgive you for asking such a thing. As probably any reader of my posts knows very well, IPv4 address blocks are practically impossible to get, and more than impossible to get for personal use. To quickly clear things up, my address block is *not* for personal use, but in comparison to the majority of the internet's existing address block owners, I am basically a single person holding on to a `/24` subnet for dear life while the giants of large internet corporations are eating up everything around me.

Ok, ok, I'm sure you are here for actual technical talk, and not a history lesson, so here we go.

## How do you even get IPv4 space? 

These days, the minimum [BGP](https://en.wikipedia.org/wiki/Border_Gateway_Protocol)-routable IPv4 block is a `/24` subnet, coming in at 255 addresses. One of these blocks auctions for prices starting around 15 thousand dollars USD. I'd say that's slightly unachievable for a college student like me, but when I come to think about it, that's still about the same as a year of tuition and housing, so... :eyes:

Alright, enough getting side-tracked. I'd rather pay $0 for some IP space if possible, and luckily for me, it is! I am a licensed [Amateur Radio operator](https://en.wikipedia.org/wiki/Amateur_radio), and through this, I get to make use of a few cool license-restricted services run by and for other operators. One of such services is [AMPRNet](https://en.wikipedia.org/wiki/AMPRNet), a `/8` subnet of public IP space specifically assigned for Amateur Radio Digital Communications back in 1981, and self-administered by radio amateurs. The governing body of this subnet is the [Amateur Radio Digital Communications](https://www.ampr.org/) (ARDC) foundation. Through their web portal, with a manually-verified account, any amateur can request subnets or single addresses under the `44.0.0.0/8` subnet.

There are, of course, restrictions to this which I will not cover in full here. The main restriction to keep in mind is: AMPRNet address space *must* be used for amateur-radio-related uses only, and generally must better the radio community in some way.

The primary justification for my allocation is that a large chunk of my addresses are being used to provide [Echolink](https://secure.echolink.org/) proxies that allow users behind firewalls to interact with the Echolink network. Other uses of my address space involve exposing software-defined radios to the internet, and repeater linking.

<h2>RIP <em class="gray">(my free time)</em></h2>

The most common way users of AMPRNet route their allocated IP addresses to and from the public internet is via the [RIP](https://en.wikipedia.org/wiki/Routing_Information_Protocol) protocol. RIP is one of the oldest routing protocols, and has the main downside of not being particularly scalable, as well as not being the preferred routing protocol for the internet for a long time.

The choice of RIP (specifically RIPv2) is not exactly surprising for a network as old as AMPRNet, but not exactly what I was looking for. With the conventional RIP setup used by almost all AMPRNet hosts, gateway servers are set up to subscribe to RIP broadcasts sent by the AMPRNet-Internet gateway (`amprgw.ucsd.edu`), located at the UCSD [San Diego Supercomputer Center](https://en.wikipedia.org/wiki/San_Diego_Supercomputer_Center).

I tried setting up RIPv2-based routing on my gateway to start. I was allocated the `44.63.7.32/29` address block to test this out with, and followed the guides on the [AMPRNet Wiki](https://wiki.ampr.org/wiki/Main_Page), along with [KB9MWR's documentation](https://www.qsl.net/kb9mwr/wapr/tcpip/) on the subject. I ran into *many* roadblocks through this method that absorbed many weekends of my life. The common issue between all of these roadblocks is lack of, or plain incorrect documentation. The AMPRNet Wiki seems to have an issue of minimal review. Many guides are lacking details and have spelling issues in important places.

Through piecing together broken and incomplete documentation, along with emails from the AMPRNet mailing list, I eventually got my gateway to route between my hosts and other hosts under the `44/8` IP space, but never managed to get the public internet to see my hosts.

As a quick aside, before setting up RIP routing, I had my gateway connected to the highly experimental [AMPRNet VPN](https://wiki.ampr.org/wiki/AMPRNet_VPN) service run by [OH7LZB](https://www.qrz.com/db/OHX/OH7LZB). This service allows all clients to access both AMPRNet and the internet, but does not route back to clients, and all clients are given dynamic IP addresses. Not optimal for any of the uses I outlined at the end of the last section.

## There is a better way

The AMPRNet documentation rather strongly tells users **not** to try routing their allocated IP space via the ubiquitous Border Gateway Protocol (BGP), and provides many solid reasons why. Of course, I took this as a bit of a challenge, and simply *did it anyways*. 

Well, ok, it was not quite as simple as saying "no" and clicking a button, but this big scary piece of dark magic that is BGP was surprisingly easy to work with in the end. I had heard of BGP before from many great blog posts by [*Ben Cox*](https://benjojo.co.uk/) but I had never had the reason, time, or resources to even come close to touching it. After all, at the time of first learning about routing protocols, I was just a 9th grader.

I didn't want to dive in to BGP blind and on my own, since I had read many horror stories of what can go wrong when you mess up your routes <span class="gray"><em>cough Facebook cough</em></span>, so I began looking for help. I stumbled across [2M0LOB](https://lobi.to/)'s AMPRNet allocation, and sent an email asking for advice before hopping in the project. Thanks to 2M0LOB for some great pointers that got me started, and for teaching me about [DN42](https://dn42.eu/Home), a great resource for smoke-checking your BGP routing setups before throwing them into the real world.

## A second attempt

In the world of internet routing, you generally need four things:

- A block of IP addresses of size `/24` or larger
- An [autonomous system number](https://en.wikipedia.org/wiki/Autonomous_system_(Internet)) (ASN)
- A gateway server
- Peers to announce your routes to

### Requesting an IP allocation

My existing AMPRNet allocation was a `/29` block which, due to [CIDR Notation](https://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing#CIDR_notation) being clever, is *smaller* than a `/24`. Thus, I had to request a larger IP block for myself. The process for requesting a BGP-routable `/24` from ARDC is a bit different than the standard allocation request process. Firstly, all BGP allocations must be requested under [`44.31.0.0/16`](https://portal.ampr.org/networks.php?a=region&id=162), which is the "BGP Allocations" segment of `44/8`. These BGP allocations fall under the `Direct` allocation type that the AMPRNet Wiki warns you *not* to use.

After filling out the usual allocation application, I was contacted by [G1FEF](https://g1fef.co.uk/), the IT Director of ARDC, with an extra document to fill out, then I was handed an Letter Of Authorization (LOA) and was ready to go!

### (Not) becoming an Autonomous System

> An autonomous system (AS) is a collection of connected Internet Protocol (IP) routing prefixes under the control of one or more network operators \[[Wikipedia](https://en.wikipedia.org/wiki/Autonomous_system_(Internet))\]

The idea behind becoming an Autonomous System is that you and your IP allocations are registered in a public coordinated database. These "databases" are managed by [Regional Internet Registries](https://en.wikipedia.org/wiki/Regional_Internet_registry) (RIRs), and in my case as a Canadian, specifically the [American Registry for Internet Numbers](https://en.wikipedia.org/wiki/American_Registry_for_Internet_Numbers) (ARIN). 

This is where I ran into a *slight* roadblock. Registering an Autonomous System under ARIN requires a membership, costing $250USD annually for a `/24`, along with the requirement that all entities assigned an ASN must be registered organizations. I don't have my own company, nor do I want to pay a large yearly fee for a side-project. 

I decided *not* to register myself an Autonomous System.

### Killing three birds with one stone

Bailing out on the second of four critical steps isn't a great start, but having done my research beforehand, I had a fallback plan. A friendly "little" company called [Vultr](https://www.vultr.com/) has a crazy good deal package that covers all three remaining requirements and more! Vultr provides:

- Virtual Private Server hosting
- The ability for clients to bring their own IP space for free
- Private ASNs
- Free BGP peering

This means, for only $5USD per month (yes, $5) I get a gateway server, a private ASN, multiple BGP peers, and the added upside of their Canadian datacenter being literally 40km from where I live. My college is on the same internet exchange as my brand new gateway server, and they have a 10-gig fiber link running between them, so the latency for me to use this thing is insanely tiny.

## Bringing it all together

Now equipped with everything I needed to route my `/24` IP space, I was left with one last step: *actually doing it*. Back on the [Facebook BGP](https://engineering.fb.com/2021/10/05/networking-traffic/outage-details/) issues, I really didn't want to screw this part up, so I once again went looking for help. Luckily after asking around my college, I was introduced to [Felix Carapaica](https://www.linkedin.com/in/felixgustavocarapaica/), Sheridan's resident BGP expert.

My goal for this new network of mine was to have a single gateway server that exposes a [Wireguard](https://www.wireguard.com/) server, where each VPN client is assigned a *public* static IP address. Felix was very helpful and provided me with instructions on simulating my entire networking setup in [GNS3](https://www.gns3.com/). Once I was satisfied with my test environment, I proceeded to replicate everything in real life on the gateway server, and it worked first try! Seriously. I know that never happens, but :man_shrugging:

For anyone curious on what BGP routing on a Vultr VPS involves, check out [Vultr's Documentation](https://www.vultr.com/docs/configuring-bgp-on-vultr) on the matter.

## Thanks

Well, thats it! I am now the proud owner of a `/24` block of public IPv4 address space, and am happily using it for all kinds of radio projects. It is unbelievably convenient to be able to use public addresses even for testing, just because I have them!
<!-- 
Wanting to see a real-life service using this IP space? Good news! If you are reading this article on `va3zza.com`, you are currently being served by `44.31.62.3`, one of my brand new addresses!

I also set up a bunch of monitoring software, so I can generate cool traffic and usage graphs like this:

<img src="http://mrtg.router.va3zza.com/localhost_wg0-day.png" width="100%" alt="Subnet Traffic Graph">

Check out more info about the gateway itself [here](http://router.va3zza.com/). -->

Once again, I'd like to thank Ben, 2M0LOB, G1FEF, and Felix for helping me through this process, and helping me get hands-on experience learning about a piece of critical internet infrastructure technology the very few other college students get to touch beyond a simulator.
