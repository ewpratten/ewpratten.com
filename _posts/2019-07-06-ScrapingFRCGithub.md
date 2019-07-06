---
layout: post
title:  "Scraping FRC team's GitHub accounts to gather large amounts of data"
description: "There are a lot of teams..."
date:   2019-07-06 15:08:00
categories: frc
---

I was curious about the most used languages for FRC, so I build a Python script to find out what they where. 

## Some basic data
Before we get to the heavy work done by my script, let's start with some general data.

Thanks to the [TBA API](https://www.thebluealliance.com/apidocs/v3), I know that there are 6917 registered teams. 492 of them have registered at least one account on GitHub.

## How the script works
The script is split into steps:
 - Get a list of every registered team
 - Check for a github account attached to every registered team
   - If a team has an account, it is added to the dataset
 - Load each github profile
   - If it is a private account, move on
   - Use Regex to find all languages used
 - Compile data and sort

### Getting a list of accounts
This is probably the simplest step in the whole process. I used the auto-generated [tbaapiv3client](https://github.com/TBA-API/tba-api-client-python) python library's `get_teams_keys(key)` function, and kept incrementing `key` until I got an empty array. All returned data was then added together into a big list of team keys.

### Checking for a team's github account
The [TBA API](https://www.thebluealliance.com/apidocs/v3) helpfully provides a `/api/v3/team/<number>/social_media` API endpoint that will give the GitHub username for any team you request. (or nothing if they don't use github)

A `for` loop on this with a list of every team number did the trick for finding accounts.

### Fetching language info
To remove the need for an Oauth login to use the script, GitHub data is retrieved using standard HTTPS requests instead of AJAX requests to the API. This gets around the tiny rate limit, but takes a bit longer to complete. 

To check for language usage, a simple Regex pattern can be used: `/programmingLanguage"\>(.*)\</gm`

When combined with an `re.findall()`, this pattern will return a list of all recent languages used by a team.


### Data saves / backup solution
To deal with the fact that large amounts of data are being requested, and people might want to pause the script, I have created a system to allow for "savestates".

On launch of the script, it will check for a `./data.json` file. If this does not exist, one will be created. Otherwise, the contents will be read. This file contains both all the saved data, and some counters. 

Each stage of the script contains a counter, and will increment the counter every time a team has been processed. This way, if the script is stopped and restarted, the parsers will just keep working from where they left off. This was very helpful when writing the script as, I needed to stop and start it every time I needed to implement a new feature.

All parsing data is saved to the json file every time the script completes, or it detects a `SIGKILL`.

## What I learned
After letting the script run for about an hour, I got a bunch of data from every registered team.

This data includes every project (both on and offseason) from each team, so teams that build t-shirt cannons using the CTRE HERO, would have C# in their list of languages. Things like that.

Unsurprisingly, by far the most popular programming language is Java, with 3232 projects. These projects where all mostly, or entirely written in Java. Next up, we have C++ with 725 projects, and Python with 468 projects. 

After Java, C++, and Python, we start running in to languages used for dashboards, design, lessons, and offseason projects. Before I get to everything else, here is the usage of the rest of the valid languages for FRC robots:
 - C (128)
 - LabView (153)
 - Kotlin (96)
 - Rust (4)

Now, the rest of the languages below Python:
```
295 occurrences of JavaScript
153 occurrences of LabVIEW
128 occurrences of C
96 occurrences of Kotlin
72 occurrences of Arduino
71 occurrences of C#
69 occurrences of CSS
54 occurrences of PHP
40 occurrences of Shell
34 occurrences of Ruby
16 occurrences of Swift
16 occurrences of Jupyter Notebook
15 occurrences of Scala
12 occurrences of D
12 occurrences of TypeScript
9 occurrences of Dart
8 occurrences of Processing
7 occurrences of CoffeeScript
6 occurrences of Go
6 occurrences of Groovy
6 occurrences of Objective-C
4 occurrences of Rust
3 occurrences of MATLAB
3 occurrences of R
1 occurrences of Visual Basic
1 occurrences of Clojure
1 occurrences of Cuda
```

I have removed markup and shell languages from that list because most of them are probably auto-generated.

In terms of github account names, 133 teams follow FRC convention and use a username starting with `frc`, followed by their team number, 95 teams use `team` then their number, and 264 teams use something else.

## Using the script
This script is not on PYPI this time. You can obtain a copy from my GitHub repo: [https://github.com/Ewpratten/frc-code-stats](https://github.com/Ewpratten/frc-code-stats)

First, make sure both `python3.7` and `python3-pip` are installed on your computer. Next, delete the `data.json` file. Then, install the requirements with `pip3 install -r requirements.txt`. Finally, run with `python3 main.py` to start the script. Now, go outside and enjoy nature for about an hour, and your data should be loaded!.