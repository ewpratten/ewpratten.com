---
layout: post
title:  "Building images from binary data"
description: "Simple, yet fun"
date:   2019-09-11 12:41:00
categories: python images
redirect_from: 
 - /post/ef7b3166/
 - /ef7b3166/
---

During a computer science class today, we were talking about embedding code and metadata in *jpg* and *bmp* files. @exvacuum was showing off a program he wrote that watched a directory for new image files, and would display them on a canvas. He then showed us a special image. In this image, he had injected some metadata into the last few pixels, which were not rendered, but told his program where to position the image on the canvas, and it's size.

This demo got @hyperliskdev and I thinking about what else we can do with image data. After some talk, the idea of converting application binaries to images came up. I had seen a blog post about visually decoding [OOK data](https://en.wikipedia.org/wiki/On%E2%80%93off_keying) by converting an [IQ capture](http://www.ni.com/tutorial/4805/en/) to an image. With a little adaptation, I did the same for a few binaries on my laptop.


<!-- Tweet embed -->
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">I present: &quot;Parts of <a href="https://twitter.com/GIMP_Official?ref_src=twsrc%5Etfw">@GIMP_Official</a>&#39;s binary, represented as a bitmap&quot; <a href="https://t.co/iLljdE4nlK">pic.twitter.com/iLljdE4nlK</a></p>&mdash; Evan Pratten (@ewpratten) <a href="https://twitter.com/ewpratten/status/1171801959197794304?ref_src=twsrc%5Etfw">September 11, 2019</a></blockquote> 

## Program design
Like all ideas I have, I wrote some code to test this idea out. Above is a small sample of the interesting designs found in the [gimp]() binary. The goals for this script were to:

 - Accept any file of any type or size
 - Allow the user to select the file dimensions
 - Generate an image
 - Write the data in a common image format

If you would like to see how the code works, read "*check out the script*".

## A note on data wrapping
By using a [generator](https://wiki.python.org/moin/Generators), and the [range function](https://docs.python.org/3/library/functions.html#func-range)'s 3rd argument, any list can be easily split into a 2d list at a set interval.

```python
# Assuming l is a list of data, and n is an int that denotes the desired split location
for i in range(0, len(l), n):
    yield l[i:i + n]
```

### Binaries have a habit of not being rectangular
Unlike photos, binaries are not generated from rectangular image sensors, but instead from compilers and assemblers (and sometimes hand-written binary). These do not generate perfect rectangles. Due to this, my script simply removes the last line from the image to "reshape" it. I may end up adding a small piece of code to pad the final line instead of stripping it in the future.

## Other file types
I also looked at other file types. Binaries are very interesting because they follow very strict ordering rules. I was hoping that a `wav` file would do something similar, but that does not appear to be the case. This is the most interesting pattern I could find in a `wav` file:

<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Following up my previous post with a tiny segment of an audio file. This one is little less interesting <a href="https://t.co/u9EFloxnK5">pic.twitter.com/u9EFloxnK5</a></p>&mdash; Evan Pratten (@ewpratten) <a href="https://twitter.com/ewpratten/status/1171883910827040774?ref_src=twsrc%5Etfw">September 11, 2019</a></blockquote> 

Back to executable data, these are small segments of a `dll` file:

![Segment 1](/assets/images/dll.png)

![Segment 2](/assets/images/dll2.png)

## Check out the script
This script is hosted [on my GitHub account](https://github.com/Ewpratten/binmap) as a standalone file. Any version of python3 should work, but the following libraries are needed:

 - Pillow
 - Numpy