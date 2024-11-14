---
title: Some lesser known WireGuard settings
description: Things I will probably forget in an important moment
date: 2023-02-15
tags:
- random
- networking
draft: false
extra:
  auto_center_images: true
  excerpt: This post covers some lesser known WireGuard configuration options that
    I have found useful
  discuss:
    reddit: https://www.reddit.com/r/ewpratten/comments/12xzvun/some_lesser_known_wireguard_settings/
aliases:
- /blog/wireguard-options
---

I extensively use [WireGuard](https://www.wireguard.com/) to keep various devices connected across foreign and unstable networks. Over the past few years of doing this, I've discovered a few handy configuration tricks that can help in weirdly specific situations. The following is a short overview to be used as reference in the future.

## DNS

When configuring a client, you can specify DNS servers to use. This is useful for sending people config files that automatically point to your own DNS server.

```ini
[Interface]
# ...
DNS = 2606:4700:4700::1111, 1.1.1.1
```

While manually setting DNS servers may not be a huge deal, it is important to note that this also works for search domains.

Thus, if you had records for the clients on your network in `example.com` (like `phone.example.com` and `laptop.example.com`) and added the following to your `Interface` block:

```ini
DNS = example.com
```

The devices would become resolvable by just their hostname. For example, `ping phone` would do the same as `ping phone.example.com`.

## Disabling the routing table

Anyone who has tried using a dynamic routing protocol over WireGuard knows that it is a pain to get traffic to go where you want. Luckily, you can force WireGuard to not touch the routing table at all, allowing you to use your own routing protocol instead.

```ini
[Interface]
# ...
Table = off

[Peer]
# ...
AllowedIPs = ::/0, 0.0.0.0/0
```

**Note:** The `AllowedIPs` line is still required for WireGuard to send traffic to the peer.

## Playing nice with the firewalld

In my own experimentation, I've noticed that WireGuard interfaces on Fedora will by default take the most lax firewall policy on the device. This is sub-optimal for many reasons.

To fix this, you can make `wg-quick` also configure the firewall for you during interface setup.

```ini
[Interface]
# ...
PostUp = firewall-cmd --zone public --add-interface %i
PostDown = firewall-cmd --zone public --remove-interface %i
```

Now, the interface will be governed by the `public` zone, which is generally the *strictest* zone on the system.
