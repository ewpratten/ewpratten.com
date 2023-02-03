---
title: Game Development
---

# Game Development

One of many software fields I am interested in is game development. I have been developing small to medium sized games since around 10th grade, both for school projects and for fun.

## FlippyCat

One of the first games I remember *finishing* was called [FlippyCat](https://github.com/ewpratten/flippycat). FlippyCat was a Flappy Bird clone built by myself and my friend [Carter](https://github.com/hyperliskdev) with the goal of being intentionally hard and with low quality graphics. All assets were roughly hand-drawn and designed to look quickly thrown together to add comedic value. For this project, I built my own game engine from scratch, called [PicoEngine](https://github.com/ewpratten/picoengine), and also learned how to program paralax scrolling backgrounds.

<div style="text-align:center;">
<img src="/images/hobbies/software/games/flippycat.png" alt="FlippyCat Screenshot" style="max-width:350px">
<p style="margin-top: 0;"><em>FlippyCat</em></p>
</div>

## ***SLATE:* Infiltration**

Closely following the FlippyCat project and as a part of the same computer science class, I built another game with my friend [Silas](https://github.com/ExVacuum) called [***SLATE:* Infiltration**](https://github.com/Java-prog-class-2019/slate) which was a text-based adventure game with portals and non-euclidean buildings. The whole project was a crazy learning experience. 

The game's main concept was that you explored a building in search of a vault, except some of the rooms had doors that connected to rooms elsewhere on the map, essentially acting as portals. This raised an interesting problem of requiring rooms to be instanced and referenced to each other, which was a good way to learn about memory management and how to use pointers.

On top of the architectural challenges, we also opted to make the game as forgiving as possible input-wise. Other groups in our computer science class had lists of set commands one could use to interact with their games, but Silas and I wanted to essentially create our own mini natural language processing engine, which we did via a large eBNF definition set, and the ANTLR toolchain.

<div style="text-align:center;">
<img src="/images/hobbies/software/games/slate_map.jpg" alt="A drawing of the SLATE map" style="max-width:500px">
<p style="margin-top: 0;"><em>The drawing Silas and I made of the SLATE map</em></p>
</div>

## Micromanaged Mike

The next year, in 2020, myself, [James](https://github.com/rsninja722), [Will](https://github.com/wm-c), and Silas banded together to produce our first game jam game together for [Ludum Dare 46](https://ldjam.com/events/ludum-dare/46), called [Micromanaged Mike](https://ldjam.com/events/ludum-dare/46/micromanaged-mike).

> "Truly put your multitasking skills to the test as you help Mike do daily tasks, hard parts is, Mike doesn’t have any autonomous body functions. You have to do everything for him, even making him blink."

The objective of the game was to get the main character, Mike, through his morning routine without letting him die. As the player, you were responsible for controlling each of Mike's limbs, plus manually beating his heart, making him breathe, and making him blink. We did use the word *micromanaged* in the title after all :wink:

<div style="text-align:center;">
<img src="https://static.jam.vg/raw/da2/d2/z/320a1.png" alt="Screenshot of Micromanaged Mike" style="max-width:500px">
<p style="margin-top: 0;"><em>Mike, walking down some stairs</em></p>
</div>

## Deep Breath

Participating in Ludum Dare quickly became a tradition for my friends and I. In early 2021, we participated in [Ludum Dare 48](https://ldjam.com/events/ludum-dare/48), and produced the game [Deep Breath](https://ldjam.com/events/ludum-dare/48/deep-breath). This time, the team consisted of myself, James, Will, and [Cat](https://github.com/catarinaburghi).

> "**Deep Breath** is an exploration game where you explore an underwater cave in hopes of finding your lost transponder. Items and upgrades can be acquired along the way to assist your search."

This was my first time going in-depth into shader programming, and I had a lot of fun on the whole project. For this game, we all decided to program in the Rust programming language, and *none* of us had any prior experience with it. So, as a group of four people, thrown into a new programming language and toolset, we did extremely well! I am very happy with this project, and everyone else on the team seemed to enjoy the experience.

<div style="text-align:center;">
<img src="/images/hobbies/software/games/deep_breath.png" alt="Screenshot of Deep Breath" width="100%">
<p style="margin-top: 0;"><em>The start of Deep Breath</em></p>
</div>

## **[data::loss]**

In late 2021, I once again participated in Ludum Dare, this time with a whole new group of friends to help out. For both this and the previous game jam, I acted as the team lead, both writing the majority of the software, and also coordinating everyone involved in the project. 

The team for our [Ludum Dare 49](https://ldjam.com/events/ludum-dare/49) game, [**[data::loss]**](https://ldjam.com/events/ludum-dare/49/dataloss) was made up of myself, Carter, [Marcelo](https://github.com/SNOWZ7Z), [Luna](https://github.com/LuS404), [Emilia](https://www.instagram.com/demilurii/), [Kori](https://www.instagram.com/korigama/), Emmet, [James](https://twitter.com/jamesmakesgame), and Taya. Managing a team of 9 was quite the challenge, but also very fun, and everyone thuroughly enjoyed the process and end result of this game.

> "**[data::loss]** is a fast-paced side-scroller platforming game where you navigate a world full of graphical inconsistencies that have a habit of causing physical consequences."

The inspiration for **[data::loss]** was essentially: *"What if we made Geometry Dash, but it was infuriating to play?"* According to the game's reviews, we appear to have nailed that goal. Here are some of my favorites:

> *"Why would you make this game? Why would you do this to another person? Not everyone chose violence for this game jam. There was a game about a kobold making inventions out of junk to buy a nice rock. There was a physics game about mixing colored beads to make new colors. I saved some pirates from a dragon and some parrots in one game. This game took all my ideas of space and time and called them cringe. I don’t know what pit of hell you came from, but I hope you’re happy. 10/10."*
> <br>\[[DragonSheep](https://ldjam.com/users/dragonsheep)\]

> *"... Overall this is a great game, the art and music is awesome, and there’s a good dose of humor and sass to the game. Awesome job!!"* 
> <br>\[[lukeoco1234](https://ldjam.com/users/lukeoco1234)\]

> *"Great game, really liked the aesthetic, it takes what would be an already cool reflex based autorun game and enhances is it with unique challenges in the levels."*
> <br>\[[AidanV03](https://ldjam.com/users/AidanV03)\]

<div style="text-align:center;">
<img src="https://raw.githubusercontent.com/Ewpratten/ludum-dare-49/master/game/assets/logos/game-banner.png" alt="[data::loss] cover art" width="100%">
<p style="margin-top: 0;"><em><strong>[data::loss]</strong> cover art</em></p>
</div>