---
layout: page
title:  "I did some cleaning"
description: "Spring cleaning is fun when it isn't spring, and a computer does all the work"
date:   2019-08-27 12:37:00
tags: random
---

As I am continuing to check items off my TODO list before school starts, I have come to an item I have been putting off for a while. **Clean up GitHub Account**. Luckily, I discovered a little trick to make the process of deleting unused repos a little easier!

## Getting a list of repos to delete
I could have automated this, but I prefer a little control. To get the list, start by opening up a new Firefox window with a single tab. In this tab, open your GitHub profile to the list of repos.
Starting from the top, scroll through, and middle click on anything you want to delete. This opens it in a new tab.

Once you have a bunch of tabs open with repos to remove, use [this Firefox plugin](https://addons.mozilla.org/en-US/firefox/addon/urls-list/) to create a plaintext list of every link you opened, and paste the list of links into VS-code.

## Getting an API token
Next, an API token is needed. Go to GitHub's [token settings](https://github.com/settings/tokens), and generate a new one (make sure to enable repository deletion).

## "Parsing" the links
With our new token, and out VS-code file, we can start "parsing" the data. 

Pressing `CTRL + F` brings up the Find/Search toolbar. In the text box, there are a few icons. Pressing the one farthest to the right will enable [Regex](https://en.wikipedia.org/wiki/Regular_expression) mode. With this set, paste the following:
```
https://github.com/
```

Now, click the arrow on the left to enable *replace mode*, and put this in the new box:
```
curl -XDELETE -H 'Authorization: token <API token from above>' "https://api.github.com/repos/
```

Then press *replace all*.

Finally, replace the contents of the first box with:
```
\n
```

and the second with:
```
"\n
```

and *replace all* again.

## Deleting the repos
Simply copy the entire text file that was made, and paste it in a terminal, then press \<enter\> (this will take a while)