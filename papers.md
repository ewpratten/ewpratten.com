---
title: My Papers
layout: page
header_red: true
backing_img: /assets/images/innovation__monochromatic.svg
backing_scalar: "height:90%;"
---

I have recently started publishing some small papers I have written. As of now, these are mostly from presentations I have given, or are from my school notes.

<div class="list-group" id="posts">

    {% assign i = 0 %}
    {% for paper in site.papers %}

    {% if i == 0 %}
    <a href="{{paper.src}}" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
            <div class="card-body">
                <h5 class="mb-1">{{paper.title}}</h5>
                <p class="card-text">{{paper.subtitle}}</p>
                <p class="card-text">
                {% for author in paper.authors %}
                    <span class="badge badge-secondary">{{author}}</span>
                {% endfor %}</p>
            </div>
            <small style="color:gray;">{{paper.date}}</small>
        </div>
    </a>


    {% else %}


    <a href="{{paper.src}}" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{paper.title}}</h5>
            <small style="color:gray;">{{paper.date}}</small>
        </div>
        <p class="card-text">{{paper.subtitle}}</p>
        <p class="card-text">
        {% for author in paper.authors %}
            <span class="badge badge-secondary">{{author}}</span>
        {% endfor %}</p>
    </a>

    {% endif %}
    {% assign i = i | plus:1 %}
    {% endfor %}
</div>