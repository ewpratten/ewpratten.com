---
layout: page
title: "Rainbow keyboard" 
description: "Game-specific keyboard layouts are really handy"
date: 2023-06-15
tags: keyboards
draft: false
extra:
  auto_center_images: true
  excerpt: "This post shows off my custom keyboard layout for playing Rainbow Six Siege"
  # discuss:
  #   reddit: https://www.reddit.com/r/ewpratten/comments/1356u1t/i_performed_a_button_swap_on_my_mouse/
  #   hacker_news: https://news.ycombinator.com/item?id=35781662
---

In my ever-continuing quest to do interesting things with custom keyboards, I recently had the idea to take the left half of my [Ferris sweep](https://github.com/davidphilipbarr/Sweep) and configure it specifically for use in the game [Rainbow Six Siege](https://en.wikipedia.org/wiki/Tom_Clancy%27s_Rainbow_Six).

This post isn't much of a tutorial, just a showcase of the end result.

## Movement

![](/images/posts/rainbow-keyboard/movement_layout.png)

## Actions

![](/images/posts/rainbow-keyboard/action_layout.png)

## The code

The actual firmware file lives [here](https://github.com/ewpratten/qmk_firmware/blob/d6eda8f6a96b2f1753cd59cbb161763500a8afb5/keyboards/ferris/keymaps/ewpratten/keymap.c#L82-L87). In short, the QMK layout definition behind this is as follows:

```c
[_RAINBOW] = LAYOUT(
  KC_ESC,  KC_Q, KC_W, KC_E, KC_T,       KC_NO, KC_NO, KC_NO, KC_NO, KC_NO,
  KC_LSFT, KC_A, KC_S, KC_D, KC_G,       KC_NO, KC_NO, KC_NO, KC_NO, KC_NO,
  KC_LCTL, KC_Z, KC_X, KC_C, KC_V,       KC_NO, KC_NO, KC_NO, KC_NO, KC_NO,
                   KC_SPACE, KC_X,       KC_NO, KC_NO
)
```
