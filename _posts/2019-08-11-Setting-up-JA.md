---
layout: page
title:  "How I set up ひらがな input on my laptop"
description: "I3wm makes everything 10x harder than it should be"
date:   2019-08-12 19:40:00
tags: notes languages
---

I am currently working with [ひらがな](https://en.wikipedia.org/wiki/Hiragana), [かたかな](https://en.wikipedia.org/wiki/Katakana), and, [かんじ](https://en.wikipedia.org/wiki/Kanji) in some projects, and needed a more reliable way to write than running some [romaji](https://en.wikipedia.org/wiki/Romanization_of_Japanese) through an online translator. So, this post will detail what I did to enable native inputs on my laptop. This guide is specifically for [i3wm](https://i3wm.org/), because it does not obey system settings for languages and inputs.

## Adding font support to Linux
Firstly, we need fonts. Depending on your system, these may already be installed. For Japanese, I only used `vlgothic`, so here in the package for it:
```
sudo apt install fonts-vlgothic
```

## Language support
Im not sure if this matters, but I have seen other people do it, so why not be safe?

I am currently running a stock Ubuntu [18.04]() base, which means that everything is pre-configured for Gnome. To set language support in Gnome, pull up the settings panel:
```bash
# This line fixes some compatibility issues between 
# Gnome and I3 when launching the settings menu. 
# I recommend aliasing it.
env XDG_CURRENT_DESKTOP=GNOME gnome-control-center
```

![Gnome language settings](/assets/images/language-settings.png)

Next, go to *Settings > Language and Region > Input Sources*, and click on *Manage Installed Languages*.
This will bring up a window where you can select a new language to install. From here, I clicked on *Install / Remove Language*.

![Language installation panel](/assets/images/language-installation.png)

In this list, I just selected the languages I wanted (English and Japanese), and applied my changes. You may be asked to enter your password while installing the new languages. Once installation is complete, log out, and in again.

With the new language support installed, return to the *Input Sources* settings, and press the `+` button to add a new language. From here, search the language you want (it may be under *Other*) and select it. For Japanese, select the `mozc` variant.

Gnome's language settings are now configured. If you are using Gnome (not I3), you can stop here. 

## Configuring ibus
Don't get me wrong, I love I3wm, but sometimes it's configurability drives me crazy. 

After searching through various forums and wikis looking for an elegant way to switch languages in I3, I found a link to an [ArchWiki page](https://wiki.archlinux.org/index.php/IBus) at the bottom of a mailing list (I blame Google for not showing this sooner). It turns out that a program called `ibus` is exactly what I needed. Here is how to set it up:

Remember `mozc` from above? If you are not using it, this package may not work. Search for the appropriate `ibus-` package for your selected language(s).
```bash
# Install ibus-mozc for Japanese (mozc)
sudo apt install ibus-mozc
```

Now that `ibus` is installed, run the setup script:
```bash
ibus-setup
```

![Ibus settings](/assets/images/ibus-general.png)

From here, set your shortcut to something not used by I3 (I chose `CTRL+Shift+Space`, but most people prefer `Alt+Space`), and enable the system tray icon.
Now, go to the *Input Method* settings.

![Ibus input settings](/assets/images/ibus-input.png)

From here, press the `+`, and add your language(s).


## Configuring .profile
According to the Wiki page, I needed to add the following to my `~/.profile`:
```bash
# Language support
export GTK_IM_MODULE=ibus
export XMODIFIERS=@im=ibus
export QT_IM_MODULE=ibus
ibus-daemon -d -x
```

It turns out that this [causes issues with some browsers](https://github.com/ibus/ibus/issues/2020), so I actually put *this* in my `~/.profile` instead:
```bash
# Language support
export GTK_IM_MODULE=xim
export XMODIFIERS=@im=ibus
export QT_IM_MODULE=xim
ibus-daemon -drx
```

Now, log out and in again to let ibus properly start again, and there should now be a new applet in your bar for language settings.

## Workflow
`ibus` runs in the background and will show an indication of your selected language upon pressing the keyboard shortcut set in the [setup tool](#configuring-ibus). For languages like Japanese, where it's writing systems do not use the English / Latin-based alphabets, `ibus` will automatically convert your words as you type (this behavior will be different from language to language).

An example of this is as follows. I want to write the word *Computer* in Japanese (Katakana to be exact). I would switch to `mozc` input, and start typing the romaji word for computer, *Pasokon*. This will automatically be converted to Hiragana, *ぱそこん*. *Computer* is not a word that one would write in Hiragana as far as I know, so Katakana would be a better choice. To convert this word, I just press `Space` (This is indicated in the bottom left of my screen by `ibus`), and I now have *パソコン*, the Katakana word for *Computer*!

---

#### After Note: Languages
In case you can't tell, English is my native language. If I messed up my spelling or context with the small amount of Japanese in this post, [let me know](/about#chat-with-me)!