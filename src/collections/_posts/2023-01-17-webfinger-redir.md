---
layout: default
title: Lazy search for Mastodon accounts
description: Webfinger + Cloudflare Workers + Firefox custom search engines
date: 2023-01-17
tags:
- project
- javascript
draft: false
extra:
  auto_center_images: true
  excerpt: I made a custom search prefix for my browser that can resolve ActivityPub
    accounts into their profile pages
  discuss:
    reddit: https://www.reddit.com/r/ewpratten/comments/12xzulo/lazy_search_for_mastodon_accounts/
aliases:
- /blog/webfinger-redir
---

Anyone who has been using Mastodon (or other ActivityPub servers) for a bit might have noticed how its a little annoying to look up someone's "home profile" from their account handle. My personal flow goes something like:

1. Open my own mastodon instance
2. Search the other user's handle
3. Find the account in the results
4. Use the `Open original page` button to jump to their full profile

Luckily, with a little bit of server-side tinkering, this process can be cut down to a single step:

1. Search the user's handle in my browser searchbar

## A bit of background

Most (notable) decentralized social media services are built on a web standard called [ActivityPub](https://www.w3.org/TR/activitypub/){:target="_blank"}. ActivityPub handles all aspects of cross-instance communication, including the process of looking up users on another instance.

This cross-instance user lookup system utilizes [RFC7033: WebFinger](https://www.rfc-editor.org/rfc/rfc7033){:target="_blank"}, a modern replacement / reimplementation of the old [RFC742: Name/Finger](https://www.rfc-editor.org/rfc/rfc742){:target="_blank"} protocol.

For example, if you wanted some information about my personal `@evan@ewpratten.com` account, you can send an HTTP GET request to the following URL:

```text
https://ewpratten.com/.well-known/webfinger?resource=acct:evan@ewpratten.com
```

..and you'll get back a response that looks something like this:

```json
{
  "subject": "acct:evan@ewpratten.com",
  "aliases": [
    "https://social.ewpratten.com/@evan",
    "https://social.ewpratten.com/users/evan"
  ],
  "links": [
    {
      "rel": "http://webfinger.net/rel/profile-page",
      "type": "text/html",
      "href": "https://social.ewpratten.com/@evan"
    },
    {
      "rel": "self",
      "type": "application/activity+json",
      "href": "https://social.ewpratten.com/users/evan"
    },
    {
      "rel": "http://ostatus.org/schema/1.0/subscribe",
      "template": "https://social.ewpratten.com/authorize_interaction?uri={uri}"
    }
  ]
}
```

Notice the `links[0].href` field above? This is exactly the URL for my profile page, on my home instance!

## Plan of action

Now that we know how to get a profile's "home" URL via WebFinger, we can write a little script to convert an account handle query into a [302 redirect](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/302){:target="_blank"} to that account's URL.

The plan is to make a query like:

```text
GET https://mastodon-redirect.example.com/profile/@evan@ewpratten.com
```

and get a repsonse of:

```text
HTTP/1.1 302 Found
Location: https://social.ewpratten.com/@evan
```

## Implementing the redirect script

I chose to do this with a [Cloudflare Worker](https://workers.cloudflare.com/){:target="_blank"}, since my domains are already managed by them, and I have free credits to use.

The script to get this working is pretty simple:

```js
export default {
  async fetch(request, env) {
    try {
      const { pathname } = new URL(request.url);

      // If the root is hit, return a basic info page
      if (pathname == "/" || pathname == "") {
        return new Response("This is a webfinger redirect service.");
      }

      // Put together common info other functions may need
      let profile = pathname.split("/profile").reverse()[0].replaceAll("%40", "@").replace("/@", "").replace("/", "");
      let domain = profile.split("@").reverse()[0];
      let webfinger_url = `https://${domain}/.well-known/webfinger?resource=acct:${profile}`;

      // Handle profile redirects
      if (pathname.startsWith("/profile")) {

        // Make a request to the webfinger url for JSON data
        let response = await fetch(webfinger_url);
        
        // If the response fails, return in
        if (!response.ok){
          return response;
        }
        let response_json = await response.json();

        // Parse the profile url out of the response
        let profile_url = null;
        for (let i = 0; i < response_json.links.length; i++){
          if (response_json.links[i]["rel"] == "http://webfinger.net/rel/profile-page"){
            profile_url = response_json.links[i]["href"];
            break
          }
        }

        // Handle the response
        if (profile_url) {
          return new Response("", {
            status: 302,
            headers: {
              "Location": profile_url
            }
          })
        } else {
          return new Response("Could not find a profile-page link for this profile", {status: 404});
        }
      }
    } catch(e) {
      return new Response(e.stack, { status: 500 })
    }
  }
}
```

For the rest of this post, I'll assume you have this hosted at `mastodon-redirect.example.com`.

## Tying everything together with a Firefox search prefix

*Note: This probably also works in Chromium-based browsers. I just don't remember the details of how*

Firefox lets users set a prefix on their bookmarks. With a prefix set, you can search things with `@yourprefix This is a thing`, and the browser will string-substitute `This is a thing` into the bookmark url. Its a handy way to trigger a search inside a specific website without first opening that site.

To set up a search prefix for the redirect service, we need to do the following:

1. Create a new bookmark
2. Set the url to `https://mastodon-redirect.example.com/profile/%s`
3. Set the prefix to `@mastodon` (or whatever else you want)

Finally, you can search `@mastodon @evan@ewpratten.com` in your searchbar, and you'll end up on my profile page!
