---
layout: default
title: How I have tweaked my Minecraft client to be 'just right'
description: Pushing the boundaries of a vanilla game, while being able to play on
  un-modified servers
date: 2020-12-19
written: 2020-12-04
tags:
- project
- minecraft
extra:
  excerpt: Over the past 10 years, I have been building the perfect Minecraft experience
    for myself. This post shares the collection of mods I run, and why I use them.
redirect_from:
- /post/gas49g43/
- /gas49g43/
aliases:
- /blog/2020/12/19/vanilla-plus-mods
- /blog/vanilla-plus-mods
---

## The base game

Starting out at the base game. I like to keep this fairly up-to-date. Right now, my base game is version [`1.16.4`](https://minecraft.gamepedia.com/Java_Edition_1.16.4){:target="_blank"}. Along with the base game, my game launcher of choice, [MultiMC](https://multimc.org/){:target="_blank"}, allows using a custom [LWJGL](https://www.lwjgl.org/){:target="_blank"} version. I choose to use version `3.2.2`, as it is the most stable for me.

## Mod loading

Anyone who has played Minecraft for long enough will remember back when installing a mod involved opening up the game JAR, and dropping new class files into it. Mod loaders essentially still do this, but they provide a much cleaner system for you, the user. For years, I used the [Forge Mod Loader](http://files.minecraftforge.net/){:target="_blank"}, but recently switched to the [Fabric Mod Loader](https://fabricmc.net/){:target="_blank"}, as, in my opinion, the [FabricMC documentation](https://fabricmc.net/wiki/doku.php){:target="_blank"} is much nicer to deal with.

Unlike Forge, Fabric generally requires a helper mod to be installed called the [Fabric API](https://www.curseforge.com/minecraft/mc-mods/fabric-api){:target="_blank"}. This exists to provide user-friendly mappings to Minecraft code for mod developers.

In terms of versions, I am running Fabric Loader version `0.10.6+build.214`, and API version [`0.22.1+build.409-1.16`](https://github.com/FabricMC/fabric/releases/tag/0.22.1%2Bbuild.409-1.16){:target="_blank"}.

## Network Protocol Translation

One of my least favorite parts of playing on multiple multiplayer servers is the need to constantly switch Minecraft versions to accommodate every server version I am playing on. For example, the server I talk about in my post about [Minecraft chat over IRC](@/blog/2020-11-21-Minecraft-IRC.md) is running version `1.16.3`. You may have played on some high-end servers like [Hypixel](https://hypixel.net/){:target="_blank"} or [MCCTF](https://www.brawl.com/front/){:target="_blank"}, where you can connect with any client version you want. These servers are both running [Network Protocol Translation](https://en.wikipedia.org/wiki/Protocol_converter){:target="_blank"} plugins that will convert between Minecraft server protocol versions as packets are sent and received.

This can also be set up on the client instead of the server, allowing a single client to connect to multiple server versions. I run both the [Viaversion](https://github.com/ViaVersion/ViaVersion){:target="_blank"} and [Multiconnect](https://github.com/Earthcomputer/multiconnect){:target="_blank"} mods, which together allow my `1.16.4` client to play on servers all the way down to `1.8.0`.

## Rendering

On the rendering side of the game, I run a few specialized mods to improve or replace various functions of Minectaft's built-in game renderer. Starting with the largest change, I use the [Sodium](https://github.com/jellysquid3/sodium-fabric){:target="_blank"} renderer, which includes a large number of rendering improvements, and opens up some extra customizability to the user.

<div class="center" markdown="1">

![Screenshot of Sodium settings](/assets/blog/vanilla-plus/sodium_settings.jpeg)

</div>

The developer of Sodium, @jellysquid3, has a few other rendering or rendering-related projects I use. Mainly: [Phosphor](https://github.com/jellysquid3/phosphor-fabric){:target="_blank"}, which makes large improvements to the game lighting engine, and [Lithium](https://github.com/jellysquid3/lithium-fabric){:target="_blank"} which makes all-around improvements to the game.

Speaking of lighting, I also run [Lamb Dynamic Lights](https://github.com/LambdAurora/LambDynamicLights){:target="_blank"}, which allows you to illuminate the area around you when holding a torch (very helpful for mining). Anyone who remembers the old [Not Enough Items](https://tekkitclassic.fandom.com/wiki/Not_Enough_Items){:target="_blank"} mod, will remember that pressing <kbd>F7</kbd> would bring up an overlay for viewing the light level of any block. I now use the [Light Overlay](https://www.curseforge.com/minecraft/mc-mods/light-overlay){:target="_blank"} mod to do the same thing.

In terms of "nice to have" rendering features, I have [OKZoomer](https://github.com/joaoh1/OkZoomer){:target="_blank"} to give me Optifine-style camera zoom. I don't use Optifine anymore, but am a donator, so, to get my donator cape back on my client, I have the [Minecraft Capes](https://www.curseforge.com/minecraft/mc-mods/minecraftcapes-mod){:target="_blank"} mod installed. Continuing to add small features to the game from Optifine, I use [Connected Glass](https://www.curseforge.com/minecraft/mc-mods/connected-glass){:target="_blank"} to add connected textures, [Diagonal Panes](https://www.curseforge.com/minecraft/mc-mods/diagonal-panes){:target="_blank"} to render glass panes and iron bars on diagonal angles, and [Lambda Better Grass](https://www.curseforge.com/minecraft/mc-mods/lambdabettergrass){:target="_blank"} to connect grass textures together. For no particular reason, I also use [Better Dropped Items](https://www.curseforge.com/minecraft/mc-mods/better-dropped-items){:target="_blank"} to render dropped items *better*.

Finally, a nice rendering mod to have is [Dynamic FPS](https://github.com/juliand665/Dynamic-FPS){:target="_blank"}, which essentially stops game rendering when window focus is lost. This just improves your computer's performance when running Minecraft in the background.

## Audio engine

Not many people know that mods exist to replace or improve Minecraft's audio engine. I quite enjoy using these mods, as the game becomes significantly more immersive. I use the [Dynamic Sound Filters](https://www.curseforge.com/minecraft/mc-mods/dynamic-sound-filters){:target="_blank"} mod to add reverb to caves and the nether (the nether becomes quite scary when game sounds are turned up). Along with Dynamic Sound Filters, I also use a fairly ridiculous mod called [Presence Footsteps](https://www.curseforge.com/minecraft/mc-mods/presence-footsteps){:target="_blank"}. Presence Footsteps is a mod that detects the block each of your feet is standing on, and plays the appropriate sound. This means that walking on the line between two different blocks will play the block steps sounds alternating with each other. This mod also works with 4 legged mobs like horses, and even 8 legged mods.

Not mods, but audio-related resource packs: [Better Sounds](https://www.curseforge.com/minecraft/texture-packs/bettersounds){:target="_blank"} improves upon many of Minecraft's sound resources and notably "makes spiders sound creepy". Also, the [Orchestra Soundpack](https://www.curseforge.com/minecraft/texture-packs/orchestra-soundpack){:target="_blank"} replaces many of [Daniel Rosenfeld](https://en.wikipedia.org/wiki/C418){:target="_blank"}'s great game soundtracks with even better orchestral soundtracks composed by [Andreas Zoeller](https://www.youtube.com/user/andreaszoellermusic){:target="_blank"}.

## UI tweaks

I have a lot of UI tweak mods installed to provide me with the "perfect" game HUD.

Starting with hotbar modifications, I use [AppleSkin](https://www.curseforge.com/minecraft/mc-mods/appleskin){:target="_blank"} to show the nutritional value of whatever food item I am holding, and [Giselbaer's Durability Viewer](https://www.curseforge.com/minecraft/mc-mods/giselbaers-durability-viewer){:target="_blank"} to show me the durability percentage of my armor, and handheld items.

In my inventory, I use [Roughly Enough Items](https://github.com/shedaniel/RoughlyEnoughItems){:target="_blank"} to provide crafting recipe lookup, a list of every item in the game, usages for items, and more. I also use [Roughly Enough Resources](https://www.curseforge.com/minecraft/mc-mods/roughly-enough-resources){:target="_blank"} as a plugin for Roughly Enough Items to provide extra information about mob loot and item / ore rarity in the world. When dealing with shulker boxes, it is annoying to constantly be placing them down to check their contents. For this, I use the [Shulker Box Tooltip](https://www.curseforge.com/minecraft/mc-mods/shulkerboxtooltip){:target="_blank"} mod to show a box's contents when I hover over it, and the [Shulker Box GUIs](https://www.curseforge.com/minecraft/texture-packs/shulker-box-guis){:target="_blank"} resource pack to color-code the shulker box GUI. Despite "requiring Optifine", this pack does not actually require Optifine to work.


<div class="center" markdown="1">

![Screenshot of Roughly Enough Items](/assets/blog/vanilla-plus/rei.png)

</div>

In terms of HUD "extras", I use [Here's What You're Looking At](https://www.curseforge.com/minecraft/mc-mods/hwyla){:target="_blank"} to show basic information about the block I am looking at. This is very helpful for me, as I am still learning what all the new `1.9+` blocks are. I also extend HWYLA with [Hwyla Addon Horse Info](https://www.curseforge.com/minecraft/mc-mods/hwyla-addon-horse-info){:target="_blank"} to show me the stats of any horse I look at, and [cAn i MiNe thIS bLOCk?](https://www.curseforge.com/minecraft/mc-mods/can-i-mine-this-block){:target="_blank"} to tell me the needed tool to harvest a specific block. I also use [Game Info](https://www.curseforge.com/minecraft/mc-mods/gameinfo){:target="_blank"} to tell me the world time in the upper left of my screen.

In the world, I use [Orderly](https://www.curseforge.com/minecraft/mc-mods/orderly/){:target="_blank"} to show the health of mobs above their heads, and [Name Pain](https://www.curseforge.com/minecraft/mc-mods/name-pain){:target="_blank"}, which will give player's names a red tint when they are low on health.

## Utility

There are a few small mods that I have installed to provide some nice-to-have information in game, like [Chat Heads](https://www.curseforge.com/minecraft/mc-mods/chat-heads){:target="_blank"}, which shows a player's face beside their chat messages, [AuthMe](https://www.curseforge.com/minecraft/mc-mods/auth-me){:target="_blank"}, which allows you to switch accounts without restarting the game, [Anti-Ghost](https://www.curseforge.com/minecraft/mc-mods/antighost){:target="_blank"}, which fixes Minecraft's ghost block problem, [BetterF3](https://www.curseforge.com/minecraft/mc-mods/betterf3){:target="_blank"}, which improves the game's <kbd>F3</kbd> screen, [Controlling](https://www.curseforge.com/minecraft/mc-mods/controlling-for-fabric){:target="_blank"}, which allows you to search through the game's keybinds in an easier way, [Craft Presence](https://www.curseforge.com/minecraft/mc-mods/craftpresence){:target="_blank"}, which provides highly-customizable [Discord Rich Presence](https://discord.com/rich-presence){:target="_blank"} data, [Custom Selection Box](https://www.curseforge.com/minecraft/mc-mods/custom-selection-box-port){:target="_blank"}, which makes the block you are looking at more distinct, [Mod Menu](https://www.curseforge.com/minecraft/mc-mods/modmenu){:target="_blank"}, which is used by many mods to provide settings screens, [Not Enough Crashes](https://www.curseforge.com/minecraft/mc-mods/not-enough-crashes){:target="_blank"}, which just brings you back to the title screen if something stops working, instead of closing the game, and [Path Suggestion](https://www.curseforge.com/minecraft/mc-mods/pathsuggestion){:target="_blank"}, which improves Minecraft command auto-complete.

## World map

I hate writing down coordinates of various things, so I use Xaero's [Minimap](https://www.curseforge.com/minecraft/mc-mods/xaeros-minimap){:target="_blank"} and [World Map](https://www.curseforge.com/minecraft/mc-mods/xaeros-world-map){:target="_blank"} mods. These both provide in-world waypoints, and generate a map of everywhere you travel in the world.

<div class="center" markdown="1">

![Xaero's Minimap](/assets/blog/vanilla-plus/minimap_2020.png)

</div>

## Building utilities

I spend a lot of time programmatically editing and copying builds around between worlds and servers. I do this to make redstone templates, generate build platforms, and create Minecraft-based voxel art over on [my Instagram](https://www.instagram.com/evanpratten/){:target="_blank"} page.

To do this, I use [WorldEdit](https://www.curseforge.com/minecraft/mc-mods/worldedit){:target="_blank"} for most of the heavy lifting, [Euclid](https://www.curseforge.com/minecraft/mc-mods/euclid){:target="_blank"} to show me my WorldEdit selections as I create them, and [Litematica](https://www.curseforge.com/minecraft/mc-mods/litematica/){:target="_blank"} to copy builds from servers to singleplayer worlds (since WorldEdit only works in singleplayer).

## World generation

Finally, I use [Terrestria](https://www.curseforge.com/minecraft/mc-mods/terrestria){:target="_blank"}, [Traverse](https://www.curseforge.com/minecraft/mc-mods/traverse){:target="_blank"}, [Cinderscapes](https://www.curseforge.com/minecraft/mc-mods/cinderscapes){:target="_blank"} and [Overworld Two](https://www.curseforge.com/minecraft/mc-mods/overworld-two/){:target="_blank"} to improve terrain generation, and "spice up" my worlds. 

*NOTE: The first three of these mods introduce new blocks to the game, but do not cause issues in vanilla multiplayer games.*
