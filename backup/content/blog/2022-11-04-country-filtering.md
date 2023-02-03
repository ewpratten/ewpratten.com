---
layout: page
title: "Crudely geo-filtering internet routes" 
description: "How I make routers drop traffic for certain countries"
date: 2022-11-04
tags: network
draft: true
extra:
  auto_center_images: true
  excerpt: 
---

Sometimes I find the need to filter internet traffic traversing my networks based on country of origin. Commonly, I find that dropping certain countries (*cough Russia*) decreases the amount of scans and attacks I see to nearly zero. Sometimes its also nice to ignore routes that pass through countries with heavy surveillance policies too.

In my network, I personally have two types of geographic filters:

- Blacklist: Do not accept any traffic to or from a country
- Depreference: Try to pick routes that do not pass through a country

In order to implement any of this, I first needed a way to quantify which country originates a particular route being learned by an edge router. There are many ways to do this, generally following the rule that *more accuracy = much more effort*.

While working on this system for myself, I came up with a few possible ways to programmatically determine a route's country of origin:

- Parse the route's [geofeed](https://datatracker.ietf.org/doc/html/rfc9092) file
  - **Pro:** If the geofeed is implemented correctly, this is highly accurate
  - **Con:** This requires the prefix to have a covering geofeed in the first place
  - **Con:** Its really easy for a network to lie in their geofeed
- Assume that [autonomous systems](https://en.wikipedia.org/wiki/Autonomous_system_(Internet)) operate in the country they are registered
  - **Pro:** Very easy to obtain the country of origin for an AS
  - **Con:** Global anycast exists
  - **Con:** Hobbynets like to lie about their country of operation
- Infer geographical information from [BGP communities](https://www.rfc-editor.org/rfc/rfc1997)
  - **Pro:** If done right, this is very accurate
  - **Pro:** Sounds awesome, would be good talk material
  - **Con:** Documenting communities used by transit providers is a lot of work
  - **Con:** Not all transit providers use communities
  - **Con:** My upstreams like stripping communities from their routes sometimes

After pondering my options, I ended up choosing to just filter on the country of origin attached to each AS number's records. This is very easy to obtain, and leaves room for me to do something fancy in the future now that I have the rest of the system in place too.

## Getting a list of ASNs registered to a country

If I were to update this filter regularly, I would try pulling [WHOIS](https://en.wikipedia.org/wiki/WHOIS) database dumps, parsing through the data, and creating a lookup table for this purpose.

However, I really don't need to instantly catch networks as they are registered, and feel perfectly fine updating this filter every few months. Thus, the easy route.

