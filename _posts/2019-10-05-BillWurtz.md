---
layout: page
title:  "Using an RNN to generate Bill Wurtz notes"
description: "Textgenrnn is fun"
date:   2019-10-05 18:54:00
tags: project
redirect_from: 
 - /post/99g9j2r90/
 - /99g9j2r90/
---

[Bill Wurtz](https://billwurtz.com/) is an American musician who became [reasonably famous](https://socialblade.com/youtube/user/billwurtz/realtime) through short musical videos posted to Vine and YouTube. I was searching through his website the other day, and stumbled upon a page labeled [*notebook*](https://billwurtz.com/notebook.html), and thought I should check it out.

Bill's notebook is a large (about 580 posts) collection of random thoughts, ideas, and sometimes just collections of words. A prime source of entertainment, and neural network inputs..

> *"If you are looking to burn something, fire may be just the ticket"* - Bill Wurtz

## Choosing the right tool for the job
If you haven't noticed yet, Im building a neural net to generate notes based on his writing style and content. Anyone who has read [my first post](/blog/2018/06/27/becomeranter) will know that I have already done a similar project in the past. This means *time to reuse come code*!

For this project, I decided to use an amazing library by @minimaxir called [textgenrnn](https://github.com/minimaxir/textgenrnn). This Python library will handle all of the heavy (and light) work of training an RNN on a text dataset, then generating new text. 

## Building a dataset
This project was a joke, so I didn't bother with properly grabbing each post, categorizing them, and parsing them. Instead, I build a little script to pull every HTML file from Bill's website, and regex out the body. This ended up leaving some artifacts in the output, but I don't really mind.

```python
import re
import requests


def loadAllUrls():
    page = requests.get("https://billwurtz.com/notebook.html").text

    links = re.findall(r"HREF=\"(.*)\"style", page)

    return links


def dumpEach(urls):
    for url in urls:
        page = requests.get(f"https://billwurtz.com/{url}").text.strip().replace(
            "</br>", "").replace("<br>", "").replace("\n", " ")

        data = re.findall(r"</head>(.*)", page, re.MULTILINE)

        # ensure data
        if len(data) == 0:
            continue

        print(data[0])


urls = loadAllUrls()
print(f"Loaded {len(urls)} pages")
dumpEach(urls)

```

This script will print each of Bill's notes to the console (on it's own line). I used a simple redirect to write this to a file.

```sh
python3 scrape.py > posts.txt
```

## Training
To train the RNN, I just used some of textgenrnn's example code to read the posts file, and build an [HDF5](https://en.wikipedia.org/wiki/Hierarchical_Data_Format) file to store the RNN's neurons.

```python
from textgenrnn import textgenrnn

generator = textgenrnn()
generator.train_from_file("/path/to/posts.txt", num_epochs=100)
```

This takes quite a while to run, so I offloaded it to a [Droplet](https://www.digitalocean.com/products/droplets/), and left it running overnight.

## The results
Here are some of my favorite generated notes:

> *"note: do not feel better"*

> *"hi  I am a car."*

> *"i am stuff and think about this before . this is it, the pond. how do they make me feel better?"*

> *"i am still about the floor"*

Not perfect, but it is readable english, so i call it a win!

## Play with the code
I have uploaded the basic code, the scraped posts, and a partial hdf5 file [to GitHub](https://github.com/Ewpratten/be-bill) for anyone to play with. Maybe make a twitter bot out of this?