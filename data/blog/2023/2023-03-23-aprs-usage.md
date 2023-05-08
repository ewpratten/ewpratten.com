---
layout: page
title: "What are people actually doing with APRS?" 
description: "An analysis of worldwide APRS data"
date: 2023-03-23
tags: radio
draft: true
extra:
  auto_center_images: true
  excerpt: "This post looks in to what radio operators are actually doing with the APRS network"
---

Sometimes I wonder how many people really use the amateur radio services I hear about.

In particular, I quite enjoy working with the [Automated Packet Reporting System](https://en.wikipedia.org/wiki/Automatic_Packet_Reporting_System) (APRS), but have a few observations:

- The standard feels like a bit of a mess. Many features don't seem to actually be used IRL
- APRS can do world-wide radio-based text messaging, yet nobody ever responds to my messages
- Support seems non-existent
  - "APRS capable radios" seem to only implement subsets of the standard (usually RX or Tx only)
  - Web services built around the APRS ecosystem are largely closed-source with no plans to allow community contribution
  - Most parsing libraries are half-baked and abandoned (I am guilty of doing this with my own..)

So. Its time for a bit of a deep dive.

***What are people actually doing with APRS?***

## APRS vs. APRS-IS

Firstly, I want to know if anyone is actually using APRS proper. 

The APRS network is built in two halves: RF and Internet. Special devices called [IGates](http://www.aprs-is.net/IGating.aspx) exist on the network to bridge between the RF world and the Internet world, gating packets between the two. This allows an RF packet to take a path like:

![](/images/posts/aprs-usage/igate_graphic.svg)

The RF part of this path is generally referred to as "APRS", and the Internet part as "APRS-IS".

I spent a night collecting data from a node that has a full view of the traffic crossing the APRS network, and the results were... predictable.

![](/images/posts/aprs-usage/internet_vs_rf.png)

My thoughts on this visualization are as follows:

- The lack of good in-radio support for APRS makes it a bit of a challenge for the average user to use.
  - For most people, the best way to send an APRS packet is by using the [APRSDroid app](https://aprsdroid.org/) to generate and play the packet into their radio while holding PTT.
  - The only other alternative to a janky setup using an Android app is to use a dedicated [Terminal Node Controller](https://en.wikipedia.org/wiki/Terminal_node_controller) (TNC), which can be expensive. Many TNCs are also not compatible with modern radios and computers without extra adapters.
- The barrier to entry for APRS-IS is *super low*
  - All it takes is an HTTP POST request, and you have sent an APRS-IS packet to the world

## Traffic flow

The next thing I wanted to know was: where are the packets going?

The top 10 packet sources (RF and internet) are:

![](/images/posts/aprs-usage/top_10_sources.png)

And look! I'm in there :laughing:. My `VA3UJF-1` station that injects canadian passenger train telemetry into the APRS network sits at position #8. The [WINLINK](https://aprs.fi/info/a/Winlink) station takes first place though. This is another automated station for bridging [WinLink](https://winlink.org/) and APRS traffic.

How about the destinations?

![](/images/posts/aprs-usage/top_10_destinations.png)

Well thats interesting... None of these destinations are real callsigns. Instead, they are "APRS Software Version Numbers". The original APRS specification defines these as follows (more have been added over time):

![](/images/posts/aprs-usage/aprs_version_numbers.png)

These destination strings are used in scenarios where a station is broadcasting data, such as:

- Beacon packets
- Position reports
- Telemetry reports

...which leads me to another question. What percentage of packets are direction-less beacons?

![](/images/posts/aprs-usage/beacon_vs_non_beacon.png)

Is this different between RF and internet users?

<table>
    <tr>
        <td><img src="/images/posts/aprs-usage/beacon_vs_non_beacon_inet.png"></td>
        <td><img src="/images/posts/aprs-usage/beacon_vs_non_beacon_rf.png"></td>
    </tr>
</table>
<br>

Ok. So, lots of APRS traffic involves beacons. I guess that makes sense, although thats an awful lot of beacons coming from APRS-IS, which makes a little less sense.

The way I see the data, RF users are largely sending messages between each other, and occasionally beaconing their positions and telemetry. This seems to be the way APRS was intended to be used.

Internet users on the other hand seem to be just filling the network with data. Position reports don't make a ton of sense, but this traffic is probably a lot of people who (like me) use cron jobs to display their QTH and possibly local repeaters on the APRS maps. This is probably a bit less of the intended use of APRS.