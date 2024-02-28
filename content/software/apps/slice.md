---
title: Slice (WearOS Watchface)
description: The WearOS watchface that fuses a 24-hour clock with a digital display
extra:
    og_image: /images/software/apps/slice/slice.png
---

It started from a simple question. *What would it be like to use a 24-hour analog clock?*

<img
    src="/images/software/apps/slice/slice.png"
    style="border-radius: 100%; box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.5); width: 100%; max-width: 300px; margin: 0 auto; display: block;"
    alt="Slice watchface"
>

Slice is an analog/digital hybrid watchface that features four main components:

- The date
- The current local time
- The current UTC time
- A 24-hour-long analog clock

## The Center Cluster

The center cluster features the key elements that make a watch useful to *me*.

Somewhat surprisingly, I mainly check my watch to know the date. As such, the current date is displayed in a minimal, yet unambiguous manner at the top of the cluster.

The dual timestamps are a recent addition to my watchface setup. I've found the presence of a UTC clock to be quite useful when coordinating with people in different timezones, and understanding server logs.

## The Outer Ring

The outer ring features four ticks at `00:00`, `06:00`, `12:00`, and `18:00`. These ticks act like the "homing keys" of the outer ring, allowing for a rough estimation of the current time.

Additionally, a thick tick and a thin tick slowly make their way around the outer ring to represent hours and seconds, respectively.

## Observations

Slice has been the one and only watchface on my smartwatch since 2022. 

I quite like the "hour hand" on the outer ring, and use it as a quick visual indicator of my progress through the day. The "second hand" was a later addition to, allowing me to use my watchface as an impromptu timer.

In the future, I plan to add a Google Calendar integration to the watchface. I would like to display important calendar events as arcs across the 24-hour timeline, allowing me to quickly see how my day is structured.

## Try Slice

Slice is available for purchase on the [Google Play store](https://play.google.com/store/apps/details?id=com.ewpratten.wearos.slice).