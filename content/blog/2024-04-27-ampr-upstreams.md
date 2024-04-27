---
title: Who are the upstreams for AMPRNet?
description: 
date: 2024-04-27
tags:
  - networking
draft: false
extra:
  auto_center_images: true
aliases:
  - /blog/ampr-upstreams
---

I happened to be poking through the [AMPRNet](https://ampr.org) gateway list today, and pretty much out of nowhere came up with the question: *I wonder what networks most commonly house AMPR gateways?*

So, in this short post, I shall set out to answer that question.

## A brief overview

Feel free to read about AMPRNet yourself online. There's lots of great information floating around.

For anyone looking for a TLDR before continuing, you can basically think of AMPRNet as an ad-hoc mesh of gateways that act as core routers for tiny slices of IP space. These gateways share routing information with each other and form a mixed-topology network that spans the globe.

## What gateways exist?

Firstly, in order to figure out what networks house gateways, I need to know what gateways exist.

AMPR operators have access to a little API that allows us to query for a list of all active gateways, so thats where I shall start.

If you happen to be following along at home, heres the commands I am using to get my list of gateway IPs:

```bash
AMPR_API_TOKEN="your-api-token-here"
http get https://portal.ampr.org/api/v1/encap/routes \
  "Authorization: Bearer $AMPR_API_TOKEN" \
  "Accept: application/json" \
  | jq ".encap[].gatewayIP" \
  | tr -d '"' \
  | sort \
  | uniq
```

This returns a nicely sorted list of approximately 650 unique gateways.

## Where are they?

Now that I have a list of IPs, I just put them into a file (`/tmp/ips` in my case) and asked the [BGP.tools API](https://bgp.tools/kb/api) for info about them.

```bash
echo "begin\n$(cat /tmp/ips)\nend" | nc bgp.tools 43 | tee /tmp/bgp-tools-result
```

This gives me a very long list of ASNs for each gateway, which I can then process.

Taking the `/tmp/bgp-tools-result` file that the previous command generated, I can now run the following command to get a list of unique ASNs:

```bash
cat /tmp/bgp-tools-result \
  | cut -d "|" -f 7 \
  | sort \
  | uniq -c \
  | sort -n -r
```

## The results

At the time of writing, here's the distribution of gateways by Autonomous System:

| Count | Autonomous System                                 |
|-------|---------------------------------------------------|
| 46    | Comcast Cable Communications, LLC                 |
| 25    | Charter Communications Inc                        |
| 23    | The Constant Company, LLC                         |
| 23    | AT&T Services, Inc.                               |
| 22    | Verizon Business                                  |
| 16    | Charter Communications                            |
| 15    | Akamai (Linode)                                   |
| 14    | Free SAS                                          |
| 11    | Amazon.com, Inc.                                  |
| 10    | Lumen (ex. Qwest)                                 |
| 10    | Cox Communications Inc.                           |
| 10    | Bell Canada                                       |
| 9     | Ote SA (Hellenic Telecommunications Organisation) |
| 9     | DigitalOcean LLC                                  |
| *249* | *Various Others*                                  |

<br>

**Note:** the *Various Others* row represents nearly 230 ASes that only host 1 gateway, and a smaller handful that host a few more.
