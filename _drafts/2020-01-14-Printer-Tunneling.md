---
layout: page
title: "Tunneling a printer from a home network to a VPN" 
description: "Using socat to port-forward between network interfaces" 
date:   2021-01-14 10:00:00 
written: 2020-12-19
tags: projects tutorial snippet
excerpt: >-
    I use a self-hosted VPN to access all my devices at all times, and to deal with my school's aggressive firewall. This post explains the process I use for exposing my home printer to the VPN.
redirect_from: 
 - /post/g494ld99/
 - /g494ld99/
---

For the past few years, I have been using a self-hosted VPN to bring all my personal devices into the same "network" even though many of them are spread across various locations and physical networks. This system never gives me problems, but there was one thing I wished I could do: access non-VPN devices on other networks using one of my VPN devices as a gateway.

Of course, I could actually grab a RaspberryPI and turn it into a real network gateway for the VPN, allowing me to access anything I want as long as it was attached to that PI's network interface. This setup was not entirely practical though, as I wanted the ability to pull multiple devices from multiple networks into my VPN.

