---
title: Network
extra:
    enable_gh_markdown: true
---

<p></p>

# My Network

[![BGP.tools](https://img.shields.io/badge/-bgp.tools-blue)](https://bgp.tools/as/398057)
[![PeeringDB](https://img.shields.io/badge/-PeeringDB-yellowgreen)](https://www.peeringdb.com/asn/398057)

I operate [Autonomous System](https://en.wikipedia.org/wiki/Autonomous_system_(Internet)) **398057**. This network is designed to be a playground for my experiments and research, while at the same time providing internet access to my servers and devices in a fast and reliable manner.

<!-- [![Map of network routers](/images/network/net_map_cropped.svg)](/images/network/net_map.svg) -->

<!-- ## Configuration & Architecture

Currently, the network operates with a partial routing table and is configured to act as an overlay transit provider for my downstream peers. The only routes known internally are those to peers and their customers. 

This choice has a few reasons behind it:

- Only accepting my peers routes forces me to peer with as many ASes as I can, and develop good relations with other network operators.
- Providing transit to select peers allows me to experiment with the technical implications that come with such a service. I ensure that each of these peers has a backup upstream, allowing me to tinker with lesser repercussions.

I generally aim to deploy routers with roughly 512MB of RAM, a single core, and 5-20GB of disk space. This additional limitation helps me learn to keep my router configs lean and efficient. -->

## What is the network actually *doing*?

Currently, AS398057 is:

- Providing IPv6 transit to various clients
- Running a private [tunnel brokerage](https://en.wikipedia.org/wiki/Tunnel_broker) service
- Running an experiment to analyze the uses of [anycasted](https://en.wikipedia.org/wiki/Anycast) amateur radio services.
- Hosting [APRS](https://en.wikipedia.org/wiki/Automatic_Packet_Reporting_System) IGates and [EchoLink](https://en.wikipedia.org/wiki/EchoLink) Proxies

## Peering

AS398057 has an **open** peering policy and is willing to peer with networks which meet one of the following criteria:

- The network is connected to an IXP in common with AS398057
- The network is able to directly cross-connect to an AS398057 router
- The network is willing to peer over a tunnel

..and agrees to the following:

- Only send routes from your own network and/or your customers unless otherwise agreed upon
- Only announce address space which you are authorized to announce
- Only send traffic destined to the routes AS398057 announces to you

To request a peering arrangement, please contact me via email at [`peering@ewpratten.com`](mailto:peering@ewpratten.com), on discord at `ewpratten#9114`, or through a common IXP's peering portal.

### Additional peering information

- Routing policy may be found via WHOIS. ([`whois -h whois.radb.net AS398057`](https://www.radb.net/query?keywords=AS398057))
- I will generally announce [`AS-EWP`](https://www.radb.net/query?keywords=AS-EWP) to peers by default

### BGP communities

| Lage Community   | Description                   |
|------------------|-------------------------------|
| `398057,100,1`   | Nexthop is an AMPRNet gateway |
| `398057,100,2`   | Nexthop is an DN42 gateway    |
| `398057,200,0`   | Learned from homelab          |
| `398057,200,1`   | Learned from preferred peer   |
| `398057,200,2`   | Learned from fallback peer    |
| `398057,666,666` | Magic has happened            |

<hr>

<div style="text-align:center;display:flex;justify-content:space-evenly;align-items:center;flex-wrap:wrap;">
<img src="//ipv6.he.net/certification/create_badge.php?pass_name=ewpratten&amp;badge=1" style="border: 0; width: 128px; height: 128px" alt="IPv6 Certification Badge for ewpratten"></img>
<a href="https://www.arin.net/"><img src="/images/network/arin.png" alt="ARIN Member" width="256px"></img></a>
<a href="https://www.ampr.org/"><img src="/images/network/44-logo.png" alt="AMPRNet Operator" width="128px"></img></a>
</div>

<br><br>