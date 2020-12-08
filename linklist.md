---
title: The LinkList
description: A collection of interesting content I find around the internet
layout: page
---

The LinkList is an idea provided by @rsninja722. I have a habit of constantly messaging him URLs to things I find, and he suggested just making a proper list. So, here you go. Enjoy!

{% for category in site.data.linklist %}

## {{category[1].name}}

{% for entry in category[1].entries %}
 - [{{entry.text}}]({{entry.url}})
{% endfor %}

{% endfor %}