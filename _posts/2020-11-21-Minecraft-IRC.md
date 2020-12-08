---
layout: page
title:  "Connecting to a Minecraft server over IRC"
description: "For server administration, or just chatting with friends"
date:   2020-11-21 10:00:00 
written: 2020-10-25
tags: minecraft project irc
excerpt: >-
    This post outlines the process of writing a custom IRC server that can bridge between your favorite IRC client, and any Minecraft server
redirect_from: 
 - /post/lls5jkd4/
 - /lls5jkd4/
---

As I talked about in my post [about Minecraft modpack development](/blog/2020/10/24/corepack-development), I got back in to playing Minecraft earlier this year. I primairly play on a server full of friends, where the server owner has [dynmap](https://github.com/webbukkit/dynmap) installed. Dynmap is a handy tool that provides a near-real-time overview of the minecraft world in the form of a webapp. I always keep Dynmap open on my laptop so I can chat with whoever is online, and see whats being worked on.

While dynmap has a built-in chat log, and the ability to send chats, the incoming chat messages do not persist, and the outgoing chat messages don't always show your in-game username (but instead, your public IP address). Since I always have an IRC client open, I figured that making use of my IRC client to generate a persistent chat log in the background would be a good solution. Unfortunately, I could not find anyone who has ever built a `Minecraft <-> IRC` bridge. Thus my project, [chatster](https://github.com/Ewpratten/chatster), was born. 

The most basic IRC server consists of a TCP socket, and only 7 message handlers:

| Message Type | Description                                      |
|--------------|--------------------------------------------------|
| `NICK`       | Handles a user setting their nickname            |
| `USER`       | Handles a user setting their identity / username |
| `PASS`       | Handles a user authenticating with the server    |
| `PING`       | A simple ping-pong system                        |
| `JOIN`       | Handles a user joining a channel                 |
| `QUIT`       | Handles a user leaving a channel                 |
| `PRIVMSG`    | Handles a user sending a message                 |

On the Minecraft side, the following subset of the [in-game protocol](https://wiki.vg/Protocol) must be implemented (I just used the [`pyCraft`](https://github.com/ammaraskar/pyCraft) library for this):

 - User authentication
 - Receiving [`clientbound.play.ChatMessage`](https://wiki.vg/Protocol#Chat_Message_.28clientbound.29) packets
 - Sending [`serverbound.play.ChatMessage`](https://wiki.vg/Protocol#Chat_Message_.28serverbound.29) packets


The whole idea of chatster is that a user connects to the IRC server using their [Mojang account](https://account.mojang.com/) email and password at their IRC nickname, and server password. The server temporarily stores these values in memory.

Connecting to a server is done via specific IRC channel names. If you wanted to connect to `mc.example.com` on port `12345`, you would issue the following IRC command:

```
/JOIN #mc.example.com:12345
```

Upon channel join, the server opens a socket to the specified Minecraft server, and relays chat messages (along with their sender) to both Minecraft and IRC. This means that ingame users show up in your IRC user list, and you can send commands and chats to the game.