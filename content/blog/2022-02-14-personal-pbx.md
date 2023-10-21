---
layout: page
title: I built my own private telephone network
description: Nobody makes phone calls anymore
date: 2022-02-14
tags: project pbx
draft: true
extra:
  auto_center_images: true
aliases:
- /blog/personal-pbx
---

Over the past few months, I have built my own [internet backbone router](@/blog/2021-11-14-amprnet-bgp.md) (and an [internet exchange](https://ffixp.net)). So logically, the next step is to branch off into telephony... *right?*

Eh, even if I never get any practical use out of any of this in the end, at least its content for the blog.

## A simplistic introduction to telephone networking

This is all coming from someone that has very little experience with the telephony world, but I *have* managed to make all my gear work, so this can't go too badly.

As far as I have ever been concerned, the telephone network looks as follows:

![The magical phone network](/images/posts/personal-pbx/magic_phones.png)

But in reality, it looks a little more like the internet (I guess that makes sense, since dialup was a thing).

![The magical phone network, with more phones](/images/posts/personal-pbx/phone_internet.png)

The *Dark Magic* still exists, and I am still not entirely sure whats going on there. Presumably some kind of routing protocols exists to handle country codes and such, but I have had no need (yet) to explore this further.

Continuing on with terminology, **Phones** are simply endpoints. Such endpoints could be cellphones, VOIP clients, automated answering machines, etc. **Carriers** are the same as the internet world. Big companies that own switching gear and phone number blocks they charge you to connect up to. 

Finally, **PBX**es. A [Private Branch eXchange](https://en.wikipedia.org/wiki/Business_telephone_system#Private_branch_exchange) (PBX) combines the concepts of routers and [NATs](https://en.wikipedia.org/wiki/Network_address_translation) in the telephony world. A PBX can be hardware-controlled, or software-defined through something like [Asterisk](https://en.wikipedia.org/wiki/Asterisk_(PBX)).

I have personally used Asterisk a fair bit due to its heavy use in the Amateur Radio world as the backbone for repeater interconnections. More on this in a bit.

## The goals for this project

Going in to this project, I had a few seperate goals I decided to complete at the same time:

- Build my own PBX without using someone else's base configs
- Play around with [Twilio](https://www.twilio.com/)'s services
- Spice up my existing [Hamshack Hotline](https://hamshackhotline.com/) connection

And of course, like all my other projects, this one is running on a budget. Less than $10 per month for all required SAAS and IAAS subscriptions.

## Acquiring a PSTN phone number

The [Public Switched Telephone Network](https://en.wikipedia.org/wiki/Public_switched_telephone_network) (PSTN) is likely the only phone network you have interacted with knowingly. This is the network your cellphone number will be allocated under, and the network that routes your calls to your friends.

Generally, if you wanted a PSTN number, you have to go to a phone carrier and get a landline or cellular subscription. Since I needed a number for a PBX, I took a slightly different approach.

*Twilio* provides a programatically controllable PSTN service. Their services include:

- SMS/MMS messaging APIs
- VOIP phone numbers
- Email APIs
- Elastic SIP trunking
- ..and much more

I am personally interested in their [SIP Trunking](https://www.twilio.com/sip-trunking) service. When renting a number from Twilio (which costs just a dollar a month), you can create a SIP trunk from your PBX to theirs, and they will route all inbound calls back to you, plus allow you to place outbound calls to the PSTN through them.

*Hey students, you practically do all of the Twillio stuff in this post for **free** through [GitHub Student Pack](https://education.github.com/pack/offers)* :wink:

## Software PBXes and Trunking

Before I get much further, I should explain the options for hosting a PBX, along with an explanation of trunking.

Ignoring physical PBXes, there are a few options for self-hosting a phone network.

- Using a commercial service like [3CX](https://www.3cx.com/)
- Using one of the many Asterisk-based sofware packages
- Using [SIPFoundry](https://www.sipfoundry.org/)

As previously stated, I chose to go with an Asterisk-based system. Specifically, [FreePBX 15](https://www.freepbx.org/). There are other Asterisk-based systems available as well:

- Simply running Asterisk on a server without any management software
- [VitalPBX](https://www.vitalpbx.com/)
- [PBXInAFlash](https://sourceforge.net/projects/pbxinaflash/)

### Trunking

Trunking in the telephony world, is essentially the same as VLANs in the computer networking world. A trunk is a seperate network that can be routed to and from based on your PBX routing rules.

In my system, I have two trunks, one for Twilio (and by extension the whole PSTN), and one for Hamshack Hotline.

![My trunking setup](/images/posts/personal-pbx/my_trunks.png)

## Provisioning an IAX2 Trunk through Hamshack Hotline

*Hamshack Hotline* is a service for Amateur Radio operators that allows us to connect physical VOIP phones to a private phone network for direct-calling other operators, clubs, and even [supported repeaters](https://apps.hamshackhotline.com:9091/links.php). All users must prove their licence status.

Since this section does not apply to the majority of my audience, I will not go into the details of how to link up with Hamshack Hotline. Instead, I'll just link [their guide for doing this](https://wiki.hamshackhotline.com/doku.php?id=kb:iax:trunk.info).

## Pulling everything together

To get this whole system working, I spun up a droplet on [Digital Ocean](https://m.do.co/c/34e43c62fd02) and used their [FreePBX image](https://marketplace.digitalocean.com/apps/freepbx-1?refcode=34e43c62fd02&utm_campaign=Referral_Invite&utm_medium=Referral_Program&utm_source=badge) to quickly get up and running.

Then, I set up a number on Twilio and followed their [Elastic SIP Trunking guide](https://twilio-cms-prod.s3.amazonaws.com/documents/TwilioElasticSIPTrunking-FreePBX-Configuration-Guide-Version1-0-FINAL-06122018.pdf). As well as the Hamshack Hotline guide linked above.


## Conclusion

In the end, with some additional tweaking to the [IVR](https://en.wikipedia.org/wiki/Interactive_voice_response) settings to allow external password access, I was able to get a working PBX up and running.

I can now place a PSTN call from my cellphone to the PBX, enter a password, then dial a Hamshack Hotline RF-Link number to call up repeaters from my phone.
