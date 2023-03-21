---
layout: page
title: "A script that hides AI topics from Hacker News" 
description: "Sometimes I want to read about something different"
date: 2023-03-21
tags: random
draft: true
extra:
  auto_center_images: true
  excerpt: "This post shows off a userscript I built that hides AI topics from Hacker News."
---

Ok. AI-backed tools are cool, but sometimes I just want to read about something else on the [Hacker News](https://news.ycombinator.com/news) website.

To tame the sea of AI-related posts on the site, I have built a Tapermonkey user script that will automatically hide all posts containing AI keywords.

## Use the script for yourself!

Want to join me and hiding AI posts? Just pop this script into Tapermonkey or GreaseMonkey (or whatever you use) and you're good to go.

```js
// ==UserScript==
// @name         Hide AI articles
// @namespace    https://ewpratten.com/
// @version      0.1
// @description  Hides AI topics from HackerNews
// @author       Evan Pratten <evan@ewpratten.com>
// @match        https://news.ycombinator.com/news*
// @icon         https://www.google.com/s2/favicons?sz=64&domain=ycombinator.com
// @grant        none
// ==/UserScript==

const BANNED_TERMS = [
    /GPT/,
    /GPT\d/,
    /GPT-\d/,
    /OpenAI/,
    /\s+AI\s+/,
    /^AI\s+/,
    /AI-/,
    /\s+A\.I\.\s+/
];

(function() {
    'use strict';

    // Find all posts on the page (HN calls them "things")
    var things = document.getElementsByClassName("athing");

    // Process each "thing" on the page
    for (var thing of things) {
        // The ID is important
        var id = thing.id;

        // Find the title text
        var title_text = thing.querySelector(".titleline").textContent;

        // If a banned term is in the title, hide it
        for (var term of BANNED_TERMS) {
            if (term.exec(title_text)) {

                // Hide the title line
                thing.hidden = true;

                // The next TR will contain a bit more information. It can be found via the thing ID
                var thing_score = document.getElementById(`score_${id}`);
                if (thing_score) {
                    thing_score.parentNode.parentNode.hidden = true;
                }
            }
        }
    }

})();
```

## A side effect of doing this

And now, after publishing this post, I am about to share it on Hacker News... where I will never be able to find it again because the title of *this post* contains the term `AI` as well :facepalm: