---
layout: default
title: Coercing a Magic MIFARE credential into being an iPhone-compatible NFC tag
description: My life is full of very obscure problems
date: 2024-12-13
draft: false
---

Over the years, I have lent out many NFC cards to friends for use as virtual business cards.

I program these cards to open portfolio websites or directly share contact information when scanned with a mobile phone. I even embedded one of these into my conference badge at an animation industry event last year.

Being *that person* with the custom NFC badge at an event is generally a great way to be remembered and has a habit of starting interesting conversations too.

Unfortunately, my pile of spares has a few cards that I could never get to work on iPhones for some reason. I'd never bothered to really investigate why, but I recently made the mental connection that I had mixed in some "Magic" MIFARE cards with my regular generic ISO14443-A stock.

While absolutely magical in ability, the Magic MIFARE cards "can't be read" by iPhones for reasons that nobody online seems to quite agree with each other about.

So.. here I am to teach you how to get a Magic MIFARE card to be read by an iPhone.

## Card preparation

I am using a Magic MIFARE Gen 1a credential for this demonstration. Since I'm not tinkering with the UID, I assume this will work on other cards, but I have none to try with.

Performing a quick HF scan with a Proxmark3 reveals the following info about this blank card:

```text
[usb] pm3 --> hf search
 🕑  Searching for ISO14443-A tag...
[=] ---------- ISO14443-A Information ----------
[+]  UID: 00 56 78 BB   ( ONUID, re-used )
[+] ATQA: 00 04
[+]  SAK: 08 [2]
[+] Possible types:
[+]    MIFARE Classic 1K
[=] proprietary non iso14443-4 card found, RATS not supported
[=]

[+] Magic capabilities... Gen 1a
[+] Magic capabilities... Gen 4 GDM / USCUID ( Gen1 Magic Wakeup )
[+] Prng detection....... weak

[?] Hint: use `hf mf c*` magic commands
[?] Hint: use `hf mf gdm* --gen1a` magic commands
[?] Hint: try `hf mf` commands


[+] Valid ISO 14443-A tag found
```

Since this is a magic card, I'm going to take a moment to re-wipe it to make sure I'm starting from a blank slate.
This way, there won't be any encryption keys in my way for the next steps.

```text
[usb] pm3 --> hf mf cwipe
 🕒 wipe block 63
[+] Card wiped successfully
```

Now, using `ndefformat`, I'll turn this into a blank NDEF tag.

```text
[usb] pm3 --> hf mf ndefformat
[-] ⛔ Error - can't find `hf-mf-005678BB-key.bin`
 🕚 Formatting block 63
```

At this point, many Android devices will be able to interact with this tag normally, but iPhones still refuse to acknowledge its existence.

## iPhone magic

Luckily, its very easy to turn this now-formatted card into something iPhones will play nicely with.

To do this, you need access to a modern iPhone with the [NFC Tools](https://apps.apple.com/us/app/nfc-tools/id1252962749) application installed.

Once installed, you'll need to open the app's settings and switch to "compatibility mode" for a moment.

<div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-evenly; margin-bottom: 1em;">
    <img src="/assets/blog/iphone-mifare-magic/IMG_0496.PNG" style="max-width: 350px; margin: 5px;">
    <img src="/assets/blog/iphone-mifare-magic/IMG_0497.PNG" style="max-width: 350px; margin: 5px;">
</div>

Next, tap the card to the phone in "read" mode to make sure the app can see it. Then, switch to "write" mode and write some arbitrary data to the card. I chose "Hello, World!".

<div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-evenly; margin-bottom: 1em;">
    <img src="/assets/blog/iphone-mifare-magic/IMG_0498.PNG" style="max-width: 350px; margin: 5px;">
    <img src="/assets/blog/iphone-mifare-magic/IMG_0499.PNG" style="max-width: 350px; margin: 5px;">
</div>

This write operation performs some kind of additional format operation I don't quite understand. For whatever reason, this particular series of events puts the card into a state that all iPhones can now recognize.

Back on the Proxmark, I'll take a moment to read back the data I wrote from the iPhone.

```text
[usb] pm3 --> hf mf ndefread
[#] Auth error
[=] reading data from tag
 🕑 14

[=] --- NDEF parsing ----------------
[+] --- NDEF NULL block ---

[+] --- NDEF Message ---
[+] Found NDEF message ( 20 bytes )

[+] Record 1
[=] -----------------------------------------------------
[=]
[=] Text
[=]     UTF 8... en, Hello, World!
[=]
[?] Try `hf mf ndefread -v` for more details
```

## Writing records

Now, with the properly formatted card, we can write NDEF records to it like normal.

For this example, I'm using the `ndeflib` Python library to create records for me.

```sh
$ python3 -m pip install ndeflib
```

The following snippet generates an NDEF-formatted URI record for my website.

```py
>>> import ndef
>>> "00000312" + b"".join(ndef.message_encoder([ndef.UriRecord("https://ewpratten.com")])).hex() + "fe"
'00000312d1010e550465777072617474656e2e636f6dfe'
```

Pasting the resulting string into the Proxmark shell, I can write the record to the card.

```text
[usb] pm3 --> hf mf ndefwrite --1k -d 00000312d1010e550465777072617474656e2e636f6dfe
 🕛 5
```

## Success

And just like that, the card works on an iPhone!

![](/assets/blog/iphone-mifare-magic/IMG_0500.PNG)