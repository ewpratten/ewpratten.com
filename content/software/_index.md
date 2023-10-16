---
title: Software
---

# Software Showcase

This page showcases a *small* subset of my personal projects.

Looking for a full list of things I've worked on?
<span style="background-color:#dbffdb"><strong>Check out my <a href="https://github.com/ewpratten">GitHub profile</a>.</strong></span>

## Libraries

<div class="card card-dropshadow">
<h3>Raylib FFI</h3>

`raylib-ffi` is a very low-level Rust FFI binding to the raylib graphics library.

The goal of this library is to provide something that tracks the latest version of upstream raylib, and gets in the way as little as possible. The core features are:

- Direct FFI bindings to C functions
- Rust-ified enums & structs
- Rust-ified default palette definitions

Thats it! Go use this library directly, or build a higher-level abstraction on top of it if you'd like.

The whole binding, mapping, and documentation process is entirely automated. Targeting a new raylib version just takes a `git pull` and `cargo build`.

Check out the [Source Code](https://github.com/ewpratten/raylib-ffi) and [Documentation](https://docs.rs/raylib-ffi).
</div>

<div class="card card-dropshadow">
<h3>Amateur Data Interchange Format library for Rust</h3>

`adif-rs` is a Rust implementation of the Amateur Data Interchange Format. 

This library is used to read and write ADIF files, allowing Rust programs to exchange logging data with other pieces of amateur radio software.

Check out the [Source Code](https://github.com/ewpratten/adif-rs) and [Documentation](https://docs.rs/adif).
</div>

## Programs, Tools, Add-ons, and Scripts

<div class="card card-dropshadow">
<h3>Protomask</h3>

Protomask is a user space NAT64 implementation.

The protomask NAT64 daemon currently powers single-stack networking inside AS54041. The project also encompasses some general-purpose Rust libraries for working with inter-protocol networking.

For more information, see the [GitHub page](https://github.com/ewpratten/protomask) for this project.
</div>

## Things that were made for fun

Hey, I'm allowed to have fun with software sometimes too right?!

The following projects were mostly made as one-offs for friends in tight time constraints, so don't judge 'em too hard <em class="gray">..ok?</em>. Do keep in mind, that if you want to self-host any of these, you *might* need to tweak some hard-coded UUIDs and endpoints.

<div class="card card-dropshadow">
<h3>UwU Types</h3>

UwU and OwO your Rust integer types.

`u8` becomes `uwu8`, `i16` becomes `owo16`, and of course, `usize` is now `uwusize`.

Check out the [Source Code](https://github.com/ewpratten/uwu-types) or [use it in a project](https://crates.io/crates/uwu-types) <em class="gray">(please don't)</em>.
</div>

<div class="card card-dropshadow">
<h3>Other names for Rust's <code>unsafe</code> keyword</h3>

The `foot-gun` Rust library adds some additonal names for the `unsafe` keyword.

```rust
foot_gun!({
    // Unsafe code here
});

here_be_dragons!({
    // Unsafe code here
});

beware!({
    // Unsafe code here
});

// ... etc
```

Check out the [Source Code](https://github.com/ewpratten/foot-gun) or [use it in a project](https://crates.io/crates/foot-gun).
</div>

<div class="card card-dropshadow">
<h3>No Bitches? Discord Bot</h3>

A discord bot that tries its very best to turn images of people into the "No Bitches?" meme.

![](https://raw.githubusercontent.com/ewpratten/no-bitches-bot/master/assets/no-cv.jpg)

[Source Code](https://github.com/ewpratten/no-bitches-bot) available on GitHub.
</div>