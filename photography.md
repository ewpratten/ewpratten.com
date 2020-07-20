---
layout: page
title: Photography
---

<div class="row">

{% assign i = 0 %}
{% for photo in site.data.photos %}

{% assign remainder = i | modulo: 2 %}
{% if remainder == 0 %}
<div class="w-100"></div>
{% endif %}


<div class="col photo">
<a href="{{photo.link}}">
<img src="{{photo.src}}" >
</a>
</div>

{% assign i = i | plus: 1 %}
{% endfor %}

</div>