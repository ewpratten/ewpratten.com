---
title: Taking a radio camping
description: The noise floor is a lot lower in the forest
date: 2024-07-26
draft: false
extra:
  auto_center_images: true
aliases:
  - /blog/camping-radio
---

Recently, my father and I took a trip out to a local provincial park for a weekend of camping.

Last time I had been camping happened to coincide with the period of time that I was starting to gain curiosity about amateur radio. I vividly recall being out there wishing I had a radio that I could use to communicate from the campsite.

So, to appease my past self, the present-tense radio-license-having version of me took my HF rig along to make some contacts.

## Taking a step back

A glaring problem in this plan was that I didn't actually have an antenna to bring. So a week in advance, I set out to build one for the trip.

I opted to build a duplicate of my current fixed-in-place at-home antenna, a slightly more sketchy variant of [WB3GCK's speaker wire end-fed half-wave](https://wb3gck.com/tag/speaker-wire-antennas/).

![](/images/posts/camping-radio/spkr-wire-efhw-lengths.png)

Now, I'm not very good at following other people's antenna instructions. I like to tinker with the specifics.

WB3GCK's design was *probably* intended to produce two distinct antennas out of a single 50ft spool of speaker wire, but I prefer to use the whole thing as a single unbalanced dipole. The more I think about it, the more the math regarding that 34ft segment breaks down, so I choose not to think about it too much.

Having already built one of these antennas before, I just set out to the local Canadian Tire to buy the same components again and repeat my last antenna build.

...slight problem, they didn't have speaker wire.

So I began searching for *literally anything conductive*, and came across a pile of spools of 24-ft "lamp wire".

Lamp wire looks like speaker wire, so I figured its probably fine. Although the **24ft** part was a bit more of a problem. You generally don't want to build your antennas *too short*, but :man_shrugging: thats what antenna tuners are for I guess.

Armed with a surprisingly large amount of wire, I began the process of splicing and measuring.

![](/images/posts/camping-radio/PXL_20240713_194740810.jpg)

Everyone in my immediate life has spent the past two weeks listening to me say "100 feet is *a lot* of wire!", so this is now your opportunity to hear it too.

I also decided to hack up the wire packaging and use a little paracord to make insulators for the tips of the antenna.

![](/images/posts/camping-radio/PXL_20240713_202756448.jpg)

## Preflight checks

The next day, I took some time to pack up all my radio gear and give the antenna a test run.

![](/images/posts/camping-radio/PXL_20240714_151953924.jpg)

My original intent was to head to a nearby trail and find some trees to set up in.

![](/images/posts/camping-radio/PXL_20240714_153600599.jpg)

![](/images/posts/camping-radio/PXL_20240714_153706887.jpg)

But I wasn't super satisfied with the area, so I instead did what any sane radio operator would do.

I headed across the street, and set up in a grocery store parking lot.

![](/images/posts/camping-radio/PXL_20240714_162523877.jpg)

Feeling rather *in the open*, I sat down, watched out for people, and spun up [iFTx](https://apps.apple.com/ca/app/iftx/id6446093115) to see what kind of reach I could get with my new antenna.

![](/images/posts/camping-radio/Screenshot_20240714-124916.png)

For two watts into an incorrectly sized and badly tuned antenna laying on the ground, I was very happy with these results.

## Camping time

Fast forward a few days, and I find myself surrounded by trees with a hundred feet of wire in my hand.

I had learned from my earlier trial run that its a good idea to keep some rope with me so I can actually attach my antenna to trees instead of just using hope and friction to keep my little paracord loops attached to twiggy branches.

![](/images/posts/camping-radio/PXL_20240719_200332311.jpg)

![](/images/posts/camping-radio/PXL_20240719_201852022.jpg)

I ended up effectively wrapping the campsite in wire. One end was tied to a tree using some rope, and the other end was tent-pegged into the ground so I could adjust the tension as my brand new wire inevitably stretched over the weekend.

In terms of operation, this setup was *awesome*. The worst noise I had to deal with was barely pushing an [S2](https://en.wikipedia.org/wiki/S_meter), and I was able to make far more (and better) contacts than I had expected.

I had originally intended to spend this trip operating [FT8](https://en.wikipedia.org/wiki/FT8) and [CW](https://en.wikipedia.org/wiki/Continuous_wave), but for some reason I found myself really enjoying [FT4](https://wsjt.sourceforge.io/FT4_Protocol.pdf) (a mode I had never used before), so I spent most of my day camped out on 14080[Kc](https://en.wikipedia.org/wiki/Cycle_per_second), and then shifted to [10136](https://en.wikipedia.org/wiki/WARC_bands) and [7074](https://en.wikipedia.org/wiki/40-meter_band) in the evening.

![](/images/posts/camping-radio/PXL_20240720_200504715.jpg)

## The results

So? How'd I do?

Since I happened to be where the cell service wasn't, I didn't have access to PSKReporter to keep an eye on my signal reports. So those had to wait.

In terms of contacts, I made a bunch. All over the bands (although mainly 20m), and I even set my new distance record! (North-Western Europe from Ontario Canada)

Once I finally caught enough of a glimpse of a network connection, I was blown away by the signal reports. By far the best I've ever received!

![](/images/posts/camping-radio/original_3fd7fa07-f8fe-4dba-aeb1-aa1d689f300c_Screenshot_20240720-193018.png)

Pictured above, days 1 & 2, and below 3 & 4.

![](/images/posts/camping-radio/IMG_0218.jpg)

All on...*checks notes*.. 7 watts :slightly_smiling_face:
