---
title: Protomask
description: Fast & reliable user space NAT64
---

The protomask tool suite is a collection of user space tools that translate packets between OSI layer 3 protocol versions.

`protomask` (the main binary) is a user space NAT64 implementation that acts as the core NAT64 translator inside AS54041 (my autonomous system). It prioritizes efficiency and ease of use from the operator's standpoint.

I began the protomask project in 2023 as a replacement for `tayga` (the translator I was using at the time). It has since served as a robust & reliable NAT64 translator for my network, and has been a great way for me to learn more about the inner workings of both versions of the Internet Protocol.

## The tool suite

Alongside `protomask` itself, the project provides a handful of Rust crates that perform each of the tasks needed to build a NAT64 translator. This way, even if you don't like my implementation specifically, it is easy to build on top of my work. I hope that my protocol translation logic comes to be of use to others in the future.

The libraries exposed by this project are as follows:

<table style="margin:auto;">
    <thead>
        <tr>
            <td><strong>Crate</strong></td>
            <td><strong>Info</strong></td>
            <td><strong>Latest Version</strong></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>easy-tun</code></td>
            <td>A pure-rust TUN interface library</td>
            <td>
                <a target="_blank" href="https://crates.io/crates/easy-tun"><img src="https://img.shields.io/crates/v/easy-tun" alt="crates.io" style="margin:0;display:unset;"></a>
                <a target="_blank" href="https://docs.rs/easy-tun"><img src="https://docs.rs/easy-tun/badge.svg" alt="docs.rs" style="margin:0;display:unset;"></a>
            </td>
        </tr>
        <tr>
            <td><code>fast-nat</code></td>
            <td>An OSI layer 3 Network Address Table built for speed</td>
            <td>
                <a target="_blank" href="https://crates.io/crates/fast-nat"><img src="https://img.shields.io/crates/v/fast-nat" alt="crates.io" style="margin:0;display:unset;"></a>
                <a target="_blank" href="https://docs.rs/fast-nat"><img src="https://docs.rs/fast-nat/badge.svg" alt="docs.rs" style="margin:0;display:unset;"></a>
            </td>
        </tr>
        <tr>
            <td><code>interproto</code></td>
            <td>Utilities for translating packets between IPv4 and IPv6</td>
            <td>
                <a target="_blank" href="https://crates.io/crates/interproto"><img src="https://img.shields.io/crates/v/interproto" alt="crates.io" style="margin:0;display:unset;"></a>
                <a target="_blank" href="https://docs.rs/interproto"><img src="https://docs.rs/interproto/badge.svg" alt="docs.rs" style="margin:0;display:unset"></a>
            </td>
        </tr>
        <tr>
            <td><code>rfc6052</code></td>
            <td>A Rust implementation of RFC6052</td>
            <td>
                <a target="_blank" href="https://crates.io/crates/rfc6052"><img src="https://img.shields.io/crates/v/rfc6052" alt="crates.io" style="margin:0;display:unset;"></a>
                <a target="_blank" href="https://docs.rs/rfc6052"><img src="https://docs.rs/rfc6052/badge.svg" alt="docs.rs" style="margin:0;display:unset;"></a>
            </td>
        </tr>
        <tr>
            <td><code>rtnl</code></td>
            <td>Slightly sane wrapper around rtnetlink</td>
            <td>
                <a target="_blank" href="https://crates.io/crates/rtnl"><img src="https://img.shields.io/crates/v/rtnl" alt="crates.io" style="margin:0;display:unset;"></a>
                <a target="_blank" href="https://docs.rs/rtnl"><img src="https://docs.rs/rtnl/badge.svg" alt="docs.rs" style="margin:0;display:unset;"></a>
            </td>
    </tbody>
</table>

Additionally, a secondary binary (`protomask-clat`) is shipped alongside the project. This binary is a simple CLAT implementation that can be used to deploy IPv4 networks across IPv6-only links.

## Learn more

The protomask tool suite is Open Source. Check it out [on GitHub](https://github.com/ewpratten/protomask).
