---
layout: page
title: "An analysis of personal ASNs in the wild" 
description: "You can get a surprising amount of info from bulk whois"
date: 2022-10-02
tags: website network
draft: false
extra:
  uses_katex: false
  auto_center_images: true
  excerpt: A look at the usage of personal ASNs based on freely available data
---

As a [network operator](/network), I keep a fairly close eye on what my peers are up to. This is mainly to make sure nobody is doing something *too* stupid near my network, but also just out of curiosity. Its nice to know what other people are up to, both as a sanity check on my own network, and as a view into new things I could try out.

I was recently inspired by [Hurricane Electric](https://he.net/)'s webpage that provides [statistics on IPv6 adoption](https://bgp.he.net/ipv6-progress-report.cgi) to create a website to display info about personal [Autonomous System Numbers](https://en.wikipedia.org/wiki/Autonomous_system_(Internet)). This site both caught my interest due to being a pretty raw plain-text website (can you tell, I like simple webpages?), and due to containing a ton of interesting information.

As a little side project, I decided to take my turn at scraping the internet for various bits of data relating to the usages of personal ASNs out in the wild. This post will cover some of my findings. The data that follows *will* be out of date eventually. All of this was recorded in late september 2022.

## Where are personal ASes used?

To get a pretty good sense of personal ASN usage, I looked to the [Regional Internet Registries](https://en.wikipedia.org/wiki/Regional_Internet_registry) that are in charge of handing out numbers to new networks.

![Pie chart of personal ASN registration by RIR](/images/posts/personal-ases/rirs.png)

Unsurprisingly, the vast majority (~750) of personal ASNs are registered under [RIPE NCC](https://ripe.net), the (mainly) European RIR.

RIPE has a fairly lax model allowing anyone with presence in their region to request an ASN and IP space through one of their many [Local Internet Registries](https://www.ripe.net/participate/member-support/list-of-members). I personally hold a RIPE ASN which has become my testing ground for things before I deploy them in production.

Thanks to data available from the [RIPE Database](https://apps.db.ripe.net/db-web-ui/query), I was actually able to break down these ASNs further to get a sense of the most preferred LIRs. The following are the top 10 LIRs that have issued personal ASNs:

| Local Registry                                                | Count |
|---------------------------------------------------------------|:-----:|
| [Securebit AG](https://www.peeringdb.com/net/18724)           |  60   |
| [Openfactory GmbH](https://www.peeringdb.com/net/7194)        |  53   |
| [SnapServ](https://www.peeringdb.com/net/9285)                |  45   |
| [Servperso Systems](https://www.peeringdb.com/net/21009)      |  43   |
| [August Internet](https://www.peeringdb.com/net/28226)        |  29   |
| [Inferno Communications](https://www.peeringdb.com/net/21470) |  20   |
| [iFog GmbH](https://www.peeringdb.com/net/22819)              |  17   |
| [Kirino Networks](https://www.peeringdb.com/net/19561)        |  17   |
| [Elektronik Boecker](https://www.peeringdb.com/net/15980)     |  14   |
| [Bakker IT](https://www.peeringdb.com/net/21424)              |  14   |

## What are people announcing?

For starters, there are 185 personal ASNs that announce nothing. These are probably just abandoned and forgotten about. After that, I have measured some basic statistics on the remaining ASNs from global routing table data.

Winning the metal for most IPv4 address space announced, comes [AS15562](https://bgp.tools/as/15562), which is run by [Job Snijders](http://sobornost.net/~job/), announcing 263 /24s (67065 addresses). I occasionally see Job posting on the [NANOG](https://www.nanog.org/) mailing lists from his work at [Fastly](https://www.fastly.com/), so it comes as no surprise to me that he'd also have a pretty solid personal network running too. Job is also announcing the largest continuous block of IPv4 space, being a /17.

On the IPv6 side, [AS59645](https://bgp.tools/as/59645) (run by [Tobias Fiebig](https://doing-stupid-things.as59645.net/)) is announcing the most /48s (1048579). This works out to [`1.2676542e+30`](https://www.wolframalpha.com/input?i=1.2676542e%2B30) IPv6 addresses.

The largest continuous IPv6 block award is tied between 18 people. All of them announcing /29s to the DFZ.

The prefix with the most origins is `2a07:54c2:b00b::/48`. I am personally announcing this address space to help build the anycasted chaos that is:

[2a07:54c2:b00b:b00b:b00b:b00b:b00b:b00b](http://b00b.eu) (IPv6-only website)

Along with myself, there are currently 9 other ASNs announcing their own instances of this website. The version you see in your browser will be different depending on your geographical location or even ISP in the same building.

Finally, I have built the following chart to break down the adoption of IPv6 by personal ASNs:

![Chart of IPv6 adoption by personal ASNs](/images/posts/personal-ases/ip_stack.png)

## Want to see more?

All of this data comes from a cron job of mine. Check out the live data on my ASN stats website:

[as-stats.ewpratten.com](https://as-stats.ewpratten.com/) (see also: [archived version](https://web.archive.org/web/as-stats.ewpratten.com/))

To read more about my own network, see [my networking page](/network).
