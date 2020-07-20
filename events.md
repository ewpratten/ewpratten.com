---
title: Events
description: Notable events I am attending / have attended
layout: page
---

<div class="list-group" id="posts">

    {% for event in site.data.events %}

        <a href="{{event.url}}" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">
                {% if event.upcoming %}
                    <span class="badge badge-secondary">Upcoming</span>
                {% else %}
                    {% if event.team.yes %}
                        <span class="badge badge-success">Team</span>
                    {% else %}
                        <span class="badge badge-danger">Solo</span>
                    {% endif %}
                {% endif %}
                <br>
                    {{event.name}} 
            </h5>
            <small style="text-align:right;">{{event.date.start}} to {{event.date.end}}</small>
        </div>
        <p class="card-text">{{event.info}}</p>
    </a> 
    {% endfor %}
</div>