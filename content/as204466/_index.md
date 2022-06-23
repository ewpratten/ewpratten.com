---
title: AS204466
description: "Autonomous System: Evan Warren Pratten"
extra:
    enable_gh_markdown: true
---

# AS204466

**AS204466** provides IPv6 connectivity to experimenters, as well as IPv4 connectivity to amateur radio operators.

<div style="text-align:center;">
<img style="max-width:400px;" src="https://bgp.tools/pathimg/204466-default" alt="Routing overview is currently unavailable for display">
</div>

<br>
You may find the following links useful:

- [bgp.tools](https://bgp.tools/as/204466)
- [PeeringDB](https://www.peeringdb.com/asn/204466)

## Network goals

- Focus on IPv6 adoption
- Maintain the lowest possible cost of operation
- <strong style="font-weight:bolder;">Learn new things</span>

## Peering

Looking to peer with the network? [Send me a message](/contact), and I'll work something out with you. Physical co-location is not a requirement, I do most of my work through WireGuard tunnels.

## Sub-networks

| Prefix                                                                | Announced at | Description                  |
|-----------------------------------------------------------------------|--------------|------------------------------|
| [`44.31.62.0/24`](https://bgp.tools/prefix/44.31.62.0/24)             | London, UK   | AMPRNet address block        |
| [`2a06:a005:d2b::/48`](https://bgp.tools/prefix/2a06:a005:d2b::/48)   | Toronto, CA  | North America - General use  |
| [`2a12:dd47:8040::/48`](https://bgp.tools/prefix/2a12:dd47:8040::/48) | London, UK   | General use & Infrastructure |
| [`2a06:a005:edf::/48`](https://bgp.tools/prefix/2a06:a005:edf::/48)   | N/A          | Anycast Prefix               |

### Anycast addresses

I am making use of anycast addresses to provide simple geographically routed endpoints for various services. The following are what I have set up so far:

- `2a06:a005:edf::1`: Best router
- `2a06:a005:edf::614c`: Best 6in4 tunnel

## Requests and employment opportunities

I enjoy working with backbone tech, and would love to work with you on a larger scale. Please [contact me](/contact) if your company is hiring, or for any other information related to AS204466.
