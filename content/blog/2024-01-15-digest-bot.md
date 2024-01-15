---
title: Digest Bot
description: My mornings start with a bit of reading
date: 2024-01-15
tags:
  - random
draft: false
extra:
  auto_center_images: true
aliases:
  - /blog/digest-bot
---

Each morning, shortly after I've woken up, I receive an email.

<pre style="border-left:2px solid gray;border-radius:0;max-width:100%;overflow-x:scroll;">
Subject: Your digest for Wednesday, January 03
From: Digest Bot &lt;redacted@redacted.com&gt;

Good morning, this is your daily digest for Wednesday January 03, 2024.

Daytime weather is expected to be cloudy. 30 percent chance of flurries
early this morning. Wind becoming southwest 20 km/h this morning. High
plus 3. UV index 1 or low.

The following new articles have been published recently:
>> Xe Iaso
   - New Year's Resolutions
     URL: https://xeiaso.net/videos/2023/new-years-resolutions/

>> John Graham-Cumming
   - Complete restoration of an IBM "Butterfly" ThinkPad 701c
     URL: http://blog.jgc.org/2023/12/restoration-of-ibm-thinkpad-701c.html
</pre>

Its an email I quite look forward to, sent by a trusty Cron job that's been running for the past few months.

## Why?

I spend a fair bit of time reading other people's blogs. Its where most of the ideas, and nearly 100% of the motivation for this one stem from.

My list of blogs to keep an eye on has grown quite a bit since I started this habit back in 2017. During that time, I've come up with a little list of comments about interacting with blogs via RSS feeds:

- All the RSS apps suck
  - They either have good sync, or a good UI. Never both
  - The best ones are either annoyingly expensive, or abandoned
- Managing a feed of posts to read is hard to get right
  - Some publishers (*cough, Cloudflare*) drown everyone else out
  - Few good readers nicely support tags/categories
- I want to read articles on all my devices, but don't want to maintain a central server
  - Also, Miniflux just randomly doesn't work sometimes

So, after many years of building half-baked custom readers, and trying everything available on the Play Store, I decided to take an entirely different approach to keeping up with my favorite blogs.

## How the Digest Bot works

Digest Bot is a Python script triggered by a Cron job every morning.

Once triggered, it downloads a copy of the RSS file for each blog I'm "following", and checks for new articles against an SQLite database of previously seen ones.

It then makes a quick query to [weather.gc.ca](https://weather.gc.ca) to get the weather for the day, constructs a plaintext email with the weather and new articles, then logs into my SMTP server and sends me an email.

All subscription management is handled in an SQLite database that I can easily back up and hand-edit if needed.

### Why email?

I'm not quite sure how I got this idea in the first place, but I like basing this service around email for a few reasons:

- I can view these emails on any device I own
- Links open in the appropriate browsers for each device
- Even if the server dies, my existing daily digest emails remain in my inbox archive
- I can very easily move the script around without fiddling with CNAMES or web proxy configs
- Server uptime is not critical. The script can miss a day, or run late. I don't care
- I can forward interesting digest emails to other people
- Previously visited links are automatically marked as read in my email client

## Closing thoughts

*Make little scripts to solve your problems. Its rewarding.*