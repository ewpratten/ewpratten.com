---
layout: default
title: Implantable SSH credentials
description: Using somewhat-sketchy crypto to become a walking private key
date: 2025-01-12
draft: false
---

At the end of last year, I had the opportunity to get a small re-programmable dual-frequency Radio Frequency Identification (RFID) circuit implanted into my hand.

Of course, right after doing so, my dad asks me the "dreaded" question: <br>
"So, what are you going to do with it?"

*..uhhh...stuff?*

Of course, I have a bunch of plans for this little thing, but most of them (like most things I do) boil down to different shapes of "screw around with it and figure things out as I go".

So here I am, screwing around.

I've spent the past two weeks at work diving way too deep into the internals of SSH connections. While its been extremely fun work, I've also been unable to get the thoughts of SSH authentication flows out of my head in my free time.

So, armed with an RFID implant, a head full of SSH, and a free weekend, I set out to find out if I could shove an SSH private key into my hand.

I know many people use their implants with external readers to log themselves into their personal computers. To my understanding, this generally works by using one of three methods:

1. Storing a plaintext password inside an NFC Data Exchange Format (NDEF) record on the implant
2. Using the implant's unique identifier as part of, or the entire password
3. Using the implant's unique identifier as an intermediary password to retrieve the real password from memory on the reader

None of these options sit very well with me for storing a private key.

Firstly, SSH keys are pretty big, and NFC tags have very limited memory. Plus, *just* storing a private key in an implant opens you up to an interesting attack (more on that in a second).

Secondly, the options involving using the UID as an intermediary means that the private key needs to (at least in part) live on another device, kind of defeating the coolness of this whole thing.

## Key storage

In order to decide how I should store the private key, I first needed to figure out if it was even possible to store an entire private key in an implant.

My particular implant has ~1KB of memory available for NDEF records.

A quick sanity check shows that I can actually fit a few ED25519 keys onto this device!

```sh
$ ssh-keygen -t ed25519 -f /tmp/test-key 
$ grep -v "-" /tmp/test-key | wc -c
349
```

Additionally, I found that re-encoding the key in base94 can squeeze a few more bytes out of the key too, making me pretty confident that storing the private key on-implant was the way to go.

But what about that attack I mentioned earlier?

Well, if you knew someone had a private key stored in their body, you could pretty easily read it off of them with a powerful reader, or by sneaking up to them with a Proxmark while they are distracted or asleep.
While unlikely sounding, this would be a pretty easy attack to pull off on something like a long plane ride, or perhaps by brushing up to them with a reader in a side bag.

To mitigate this, I think the most sane solution would be to encrypt the private key with a passphrase before writing it to the RFID chip. This way, even if someone were to get ahold of the key, they would still need to know the passphrase to use it.

This is the option I chose.

## Setup & usage

As described above, I generated an ed25519 private key, then base94 encoded it.

I then used this string as the body of an NDEF Text record.

This record was then written to the chip using my Proxmark3 with:

```sh
pm3 -c 'hf mf ndefformat'
pm3 -c 'hf mf ndefwrite -d <ndef_message>'
```

I then put together a custom SSH Agent that acts as a proxy between the SSH client and the `pm3` commandline utility so I could use that same Proxmark as my reader.

Whenever an SSH client asks for keys, the custom agent asks `pm3` to dump all NDEF records it can find, base94 decodes them, and tries to load them as private keys.

Despite the part where passing private keys around between processes like this kind of sketches me out, it works extremely well.

I also implemented a small cache that keeps keys in memory for a moment, in order to reduce the read frequency (since RFID chips do have r/w limits).

## Next steps

I'm not entirely sure if I want to push this project further, but if I do, I have a few ideas:

- Investigate trying to use the MIFARE chip as a real smartcard
- Directly communicate with the Proxmark over serial instead of relying on `pm3`
- Support other readers (perhaps even a phone with Web NFC over a local WebSocket)

Additionally, if this project interests the people over at the Dangerous Things forum, I'll likely open-source my SSH agent, but it is *currently* in a 95% ready state with a few remaining bugs to deal with.

## Demo

Here's what it looks like to use this setup. I have the Proxmark balanced on my hand so you can see it better. The implant sits underneath.

<video controls style="width: 100%">
    <source src="/assets/blog/implant-backed-ssh/SSH-RFID-Demo.mp4" type="video/mp4">
</video>
