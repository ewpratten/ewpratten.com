---
title: "RFC: A fast system for repeater linking using modern web technology"
date: 2021-11-17
extra:
    is_rfc: true
    uses_graphviz: true
---

The three common standards for amateur radio repeater linking are all built on old and cumbersome technology. In the world of repeater linking, the most predominant standards for interconnection are:

- [Echolink](https://secure.echolink.org/)
  - Closed-source
  - Strict governance
  - A strong lack of APIs
  - Does not allow cross-system linking
    - ex: cannot link Echolink conferences to Allstar nodes
- [AllStarLink](https://allstarlink.org/)
  - Absolute overkill
  - Most node configurations require special hardware to set up
  - Built on the Asterisk PBX
  - Uses phone networks to link repeaters
- [IRLP](http://www.irlp.net/)
  - Requires specialized hardware
  - Uses old connection standards
  - Closed-source

In my ideal world, there would be a small, lightweight, and configurable linking backend that developers could extend in any way they wished. This proposal is not the end-all-be-all solution, but a step in the direction of this vision.

## Node discovery 

In a linking system like Echolink, *all* clients announce themselves to a central directory server. This server then decides if a client is "worthy" (verified license, not banned from the service, ...) then lists the client on [a somewhat parsable webpage](https://secure.echolink.org/logins.jsp). The topology for such a setup is as follows:

<div class="mermaid">
flowchart LR
    You(You) --- D1((Directory Server))
    D1 --- NA(Node A) & NB(Node B) & P1(Proxy) & ND(Node D)
    P1 --- NC(Node C)
</div>

In most cases, this works just fine. However, there are two off the top of my head that raise an issue:

- `Node A` and `Node B` are owned by a club that wants to keep the nodes private for member use only.
- `Node C` is behind a restrictive firewall, or does not want to expose a host to the public internet.

The second of the two scenarios is solved already in the above graph using a proxy. Echolink proxies have become extremely common due to the fact very few people have access to a network where their host can be exposed publicly for other nodes to directly connect to when making a link.

Echolink's solution to the first issue is fairly lacking in my opinion. Nodes only have the option to restrict connections based on a REGEX on their callsign. This means maintaining a list of allowed users, and updating *every* club-owned node when that changes.

### Decentralizing directory services

While I like Echolink a lot, I think some improvements could be made to both the node directory system, and how nodes link to each other. Ideally, I see a setup as follows:

<div class="mermaid">
flowchart TD
    D1((Directory A))
    D1 --- NA(Node A) & NB(Node B) & NC(Node C)
    D2((Directory B))
    D2 --- NC & ND(Node D)
    D3((Private Directory))
    D3 --- NE(Node E) & NF(Node F)
    NE --> D2
</div>

In this world, anyone could host a directory server, and either open it up to the public, or restrict it by means of their choosing (callsign rules, password, key-based access, ...). Nodes can then connect to one or many directories of their choosing. This could allow situations where a node could sit on the edge between two private intranets and have access to other nodes on *both* sides of the boundary without requiring either side to expose some part of itself to the public internet.

### Routing

I also envision a routing system where nodes attached to more than one directory service would periodically propagate information about their first-hop directories to other first-hop directories. An example of such interaction from the perspective of `Node C` would be:

```text
Node C -> Directory A: You can find Directory B at <address>
Node C -> Directory B: You can find Directory A at <address>
```

`Node E` would have a different interaction. Since `Private Directory` is *private*, its announcement would *exclude* that directory:

```text
Node E -> Private Directory: You can find Directory B at <address>
```

At this point, the directory servers should then be able to directly query eachother about their "routing tables". Over time, each directory server would build a list of which directory servers it can reach for information about nodes.

The rable for `Private Directory` would look like this:

| Server      | Address     | Hops |
|-------------|-------------|------|
| Directory B | `<address>` | 1    |
| Directory A | `<address>` | 2    |

If `Node F` were to try connecting to `Node A`, the order of messages would be:

```text
Node F -> Private Directory: Do you know Node A?

# Private Directory queries the first table entry
Private Directory -> Directory B: Do you know Node A?
Directory B -> Private Directory: No

# Private Directory queries the second table entry
Private Directory -> Directory A: Do you know Node A?
Directory A -> Private Directory: Node A is at <address>

# Node F is informed of the address of Node A
Private Directory -> Node F: Node A is at <address>
```

Of course, since `Node F` is *only* connected to a *private* directory service, if `Node A` were to try connecting to `Node F`, the order of messages would be:

```text
Node A -> Directory A: Do you know Node F?

# Directory A queries the first table entry
Directory A -> Directory B: Do you know Node F?
Directory B -> Directory A: No

# Directory A was never informed that Private Directory exists, since it is private
# Thus, there is no route to Node F
Directory A -> Node A: No
```

Like every other piece of amateur radio backbone software, this routing system relies on trust. I am not an expert in identity verification, and I will not attempt to devise a system for stopping bad actors from poisoning the routing tables in this document.

## Audio transport using modern tech

So far in this document, node addresses have been used extensively, yet nodes are not expected to expose any ports to the internet. In the real-world, it has become very common to see peer-to-peer real-time media links in the form of video conferencing services. These services largely rely on WebRTC, a standardized, strong, and reliable protocol for peer-to-peer content streams.

While WebRTC still struggles to deliver perfect quality audio and video simultaneously, it is more than capable of *just* streaming audio, with the added benefit that basically every browser supports it natively. Most programming languages also have one or many strong WebRTC libraries to work with.

This means that a full implementation of this document would result in something similar to the following:

- Directory server
  - Handles incoming clients
  - Handles routing tables
  - Handles access rules
  - Performs client lookups when requested
  - Possibly provides telemetry information
- Client library
  - Establishes connections with one or more directories
  - Periodically propagates information about connected directories
  - Can request to create or destroy a link
  - When a link is created, it exposes a direct WebRTC connection to the remote node
  - Hands off responsibility for the connection to whatever software wraps the library

The wrapping software could be one of:

- A website
- A smartphone app
- A headless application running on a Raspberry Pi that connects straight to a radio for a simplex node
- An application running on a repeater controller
- Anything else