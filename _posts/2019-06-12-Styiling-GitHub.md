---
layout: page
title:  "GitHub's CSS is boring. So I refreshed the design"
date:   2019-06-12 13:09:00+0000
tags: projects
---

I have been using GitHub since 2017, and have been getting tired of GitHub's theme. I didn't need a huge change, just a small refresh. So, to solve this, I whipped out [Stylus](https://addons.mozilla.org/en-CA/firefox/addon/styl-us/) and made a nice little CSS file for it.

## The CSS
Here is the CSS. Feel free to play with it.

```css
@-moz-document url-prefix("https://github.com/") {
.Header {
    background-color: #1a3652;
}

.repohead.experiment-repo-nav {
    background-color: #fff;
}
.reponav-item.selected {
    border-color: #fff #fff #4a79a8;
}

.btn.hover,
.btn:hover,
.btn,
.btn {
    background-color: #fafafa;
    background-image: linear-gradient(-180deg, #fafafa, #fafafa 90%);
}

.btn-primary.hover,
.btn-primary:hover,
.btn-primary,
.btn-primary {
    background-color: #1aaa55;
    background-image: linear-gradient(-180deg, #1aaa55, #1aaa55 90%);
}

.overall-summary {}
}
```

## Use it yourself
I put this theme on userstyles.org. You can download and install it by going to [my userstyles page](https://userstyles.org/styles/172679/ewpratten-s-githubtheme).