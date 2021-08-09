---
title: Discord Bots
---

With Discord being my most used chat platform, I commonly find myself build bots of various size to extend the functionality of various servers. The following are some notable bots I've built. These are all built specifically for groups of people, and include features "outsiders" may find useless or annoying.

## Benson

**Benson** is a Discord bot built for a large group of students at Sheridan College called *Res 3*. The bot has a variety of features, all specifically built around inside jokes, and a few utility commands for managing a server of over 100 people. This bot is *not* available for public use, but is open source.

{{ github(repo="res-3/benson") }}

## RenameBot

**RenameBot** is a custom Discord bot that lives on a server where all members have admin privileges. Due to the way we have configured permissons on this server, some users cannot change eachother's nicknames (we like to rename eachother after quotes we say).

The solution to this is to create a bot (**RenameBot**) that has higher permissons than all server members. **RenameBot** then acts as a nickname change broker for all users. Usage is a simple *slash command*:

```text
/rename @user <Name>
```

This bot is open source, and available for use on your own servers. Check out the code.

{{ github(repo="homie-pile/rename-bot") }}

## *HACKERMAN*

***HACKERMAN*** is a bot built for a few programming-related servers I am a member of. The bot contains a few joke functions, and some utilities including:

- DNS and rDNS lookups
- Internet LookingGlass functionality
- Text-to-Image conversion
- Minecraft server status checking
- Discord debugging commands
- IETF RFC reference
- GitHub and GitLab snippet embedding
- various joke commands

The source code is available on GitHub.

{{ github(repo="nwnd/hackerman") }}

## Tiny Audio Bot

**Tiny Audio Bot** is a custom YouTube music bot for a few Discord servers. This bot was built to show {{mention(user="LuS404")}} and {{mention(user="SNOWZ7Z")}} how to develop a simple bot in Rust. This music bot has two extremely simple commands:

```text
!play <URL>
!fuckoff
```

The source code is available on GitHub:

{{ github(repo="ewpratten/tab") }}