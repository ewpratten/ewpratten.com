---
layout: page
title:  "Taking a look back at GMAD"
description: "Fun, Simple, and Quick"
date:   2019-07-13 14:43:00
tags: projects
---

One day, back in June of 2018, I was both looking for a new project to work on, and trying to decide which Linux distro to install on one of my computers. From this, a little project was born. [Give Me a Distro](/gmad) (or, GMAD, as I like to call it) is a little website that chooses a random distribution of Linux and shows a description of what you are about to get yourself into, and a download link for the latest ISO.

## Backend tech
This is one of the simplest projects I have ever made. All the backend does is:
 - Select a random number (n)
 - Fetch the nth item from a list of distros
 - Push the selected data to the user via DOM

## Frontend
This website is just plain HTML and CSS3, built without any CSS framework. 

## My regrets
There are two things I do not like about this project. Firstly, on load, the site breifly suggests Arch Linux before flashing to the random selection. This is due to the fact that Arch is the default for people with Javascript disabled. Some kind of loading animation would fix this.

Secondly, the version of the site hosted on [retrylife.ca](https://retrylife.ca/gmad) is actually just an iframe to [ewpratten.github.io](https://ewpratten.github.io/GiveMeADistro) due to some CNAME issues.

## Contributing
If you would like to add a distro or three to the website, feel free to make a pull request over on [GitHub](https://github.com/Ewpratten/GiveMeADistro).

## Why make a post about it a year later?
I just really enjoyed working with the project and sharing it with friends, so I figured I should mention it here too. Maybe it will inspire someone to make something cool!