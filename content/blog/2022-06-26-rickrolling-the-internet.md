---
layout: page
title: "Rickrolling the internet" 
description: "Abusing ICMPv6 to inject lyrics into public routes"
date: 2022-06-26
tags: random as204466
draft: false
extra:
  uses_katex: false
  auto_center_images: true
  excerpt: This post covers some of the logistics behind rickrolling the internet with some clever routing tricks.
---

**NOTICE: The service mentioned in this post is currently unavailable due to ongoing network upgrades.**

`mtr` (a modern version of [`traceroute`](https://en.wikipedia.org/wiki/Traceroute)) is a network debugging tool commonly used by network engineers to trace the physical (and sometimes virtual) paths their packets take between two computers over a network. Both `mtr` and `traceroute` will list the addresses or names of as many routers along the path as they can.

The following is an example output of an `mtr` trace from this computer to a Hurricane Electric server:

![MTR command output](/images/posts/rickroll-ipv6/he-mtr.png)

## Traceroute toys

Over time, a few exceptionally bored network engineers have created some fun services that piggyback off of this idea of listing hosts along a path.

For example, there is:

- `mtr cv6.poinsignon.org`: Displays a brief version of [Louis Poinsignon](https://www.mygb.eu/)'s resume
- `mtr bad.horse`: Displays the lyrics to [Bad Horse](https://www.youtube.com/watch?v=rN2U5wkhRWc)
- [Ben Cox](https://benjojo.co.uk)'s old [Traceroute Haiku](https://blog.benjojo.co.uk/post/traceroute-haikus) service

That last one was the inspiration for this project, and I will likely reference Ben's post a fair bit in this one. If you are interested in the lower level technical aspects of what I have set up, go read his post, as I am running a nearly identical setup to him.

## The game plan

My intent for this project was rather simple: [rickroll](https://www.youtube.com/watch?v=dQw4w9WgXcQ) people when they traceroute my website. Now, I technically failed at most of that, and the result is really: rickroll people when they `mtr` *part of* my website. This change of scope was simply due to the fact I'd rather not introduce unwanted latency into the regular viewing experience of this site.

The steps were as follows:

1) Allocate an IPv6 address block for the project
2) Set up [Reverse DNS](https://en.wikipedia.org/wiki/Reverse_DNS_lookup) 
   1) Convert the lyrics of *Never Gonna Give You Up* to [FQDN](https://en.wikipedia.org/wiki/Fully_qualified_domain_name) format
   2) Register the appropriate `PTR` records
3) *Dark magic*
4) [Profit!](https://knowyourmeme.com/memes/profit)

## IP addresses and RDNS

For this project, I ended up using the public address block `2a06:a005:d2b:c011::/64`, as I already own and control the routing for its [parent block](https://bgp.tools/prefix/2a06:a005:d2b::/48).

I then delegated reverse DNS to the [Hurricane Electric DNS service](https://dns.he.net/) for easy management. I'll get back to this in a second.

### Converting lyrics to FQDNs

For this process, I ended up building a little Python tool called `lyrics2ptr` that generates copy-pastable Hurricane Electric settings from a text file full of lyrics.

{{ github(repo="ewpratten/lyrics2ptr") }}
<br>

The specific command for this was:

```sh
python3 lyrics2ptr.py /path/to/rickroll-lyrics.txt --addr-prefix c011::
```

Thus generating output like this:

```text
...
c011::0008 never.gonna.give.you.up
c011::0009 never.gonna.let.you.down
c011::000a never.gonna.run.around.and.desert.you
c011::000b never.gonna.make.you.cry
c011::000c never.gonna.say.goodbye
c011::000d never.gonna.tell.a.lie.and.hurt.you
...
```

While the output format may look weird, it directly corresponds to the input fields in the DNS control panel.

![A screenshot of the HE control panel](/images/posts/rickroll-ipv6/he-dns-fields.png)

## ICMPv6 trickery

Now, for the ~~fun~~ complicated part of this project.

When you run an `mtr` or `traceroute` against a remote host, your computer will send out arbitrary packets to that host, but slowly increment the [Time to live](https://en.wikipedia.org/wiki/Time_to_live) (TTL) field in such packets. 

As a refresher, the TTL field is a number that is decremented every time a packet is passed through a router. If this number ever hits zero, the packet is discarded and an [ICMPv6 Time Exceeded](https://en.wikipedia.org/wiki/Internet_Control_Message_Protocol#Time_exceeded) packet is returned to the sender indicating that their packet spent too long in transit. This mechanism exists to help prevent [routing loops](https://en.wikipedia.org/wiki/Routing_loop). 

Generally, this field is set to a value of `64`, but tracing programs will make it low numbers to attempt to get otherwise hidden routers to announce their presence via a Time Exceeded packet.

For a router to show up with a *name* in the `mtr` output, it must both send a Time Exceeded packet back to your host, and have a reverse DNS record registered (thus, why I did that in the previous section).

### Aren't you going to need a ton of hosts?

Generally, such a setup would involve daisy-chaining routers physically in your network, and setting each of their hostnames, so clients would physically have their packets routed between each of the routers, and get an ICMP response from each of them. This is a lot of work.

Conveniently for my wallet, Linux machines provide something called [Tun/Tap Interfaces](https://en.wikipedia.org/wiki/TUN/TAP). These virtual network interfaces allow programs to pretend to be one of many other computers on the network and act as if they were real hosts. When a program registers one of these interfaces with the kernel, it gets raw access to either the 2<sup>nd</sup> or 3<sup>rd</sup> OSI layer of the network stack in the form of a raw stream.

![Tun/Tap in the OSI stack](https://upload.wikimedia.org/wikipedia/commons/thumb/a/af/Tun-tap-osilayers-diagram.png/400px-Tun-tap-osilayers-diagram.png)

I chose to register a Tun interface, and control things at the Internet Protocol level. This choice was mainly due to simplicity, as I really don't care about hardware addresses.

### Lying about routers

At this point, someone can perform `mtr` on my Tun interface address, and they will get... *nothing*. 

But, importantly, my program sees their request (again, as raw bytes) and has complete control over the response (I could just send `DEADBEEFDEADBEEFDEADBEEF` if I wanted in place of a real IP packet).

When an ICMPv6 Echo Request packet (the type that `mtr` sends for queries) comes in, I simply grab two things: the *source address* and the *ttl field*.

Quick sidenote: the way I had configured my RDNS records, each line of lyrics works out to the next host in line. 

![The PTR record list](/images/posts/rickroll-ipv6/ptr-records.png)

With my RDNS setup, and the fact `mtr` will increment the TTL field for every router it wants to find, the process for mapping a "next router please" request to a "here is the next line of lyrics instead" response is simply to use the TTL itself as the host part of the IP address I pretend to respond from.

Thus, when `mtr` looks for the third router in line, it'll get the address `2a06:a005:d2b:c011::3` in response, and resolve it to `you.know.the.rules.and.so.do.i`.

## Profit!

Well, thats about it. I skipped over some implementation details, but if you'd like to check out the source code for this project, head over to its GitHub page:

{{ github(repo="ewpratten/imaginary-addrs") }}
<br>

And for the end result:

![The result](/images/posts/rickroll-ipv6/result.png)

Try it yourself!

```sh
mtr -rwc 1 rickroll.as204466.va3zza.com
```

For more AS204466 projects, view [my networking page](/as204466).
