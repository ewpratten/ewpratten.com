---
layout: default
title: Raylib FFI
description: Raw Rust bindings for raylib
---

Any time someone new to game and graphics programming asks me how to get started, I point them to [raylib](https://www.raylib.com/). It's a simple, yet powerful, game development library that is perfect for beginners and experts alike.

`raylib-ffi` is a raw binding from Rust to raylib. The library is 100% [`unsafe`](https://doc.rust-lang.org/std/keyword.unsafe.html) code, and thats the point!

I wanted to build a bindings library that can always track the very latest version of raylib without worrying about hand-wrapping every function into a safe Rust equivalent. This raw library is designed to be built *on top of* by other libraries that want to provide a safe interface to raylib through my wrapper.

## The magic

Raylib helpfully exposes a function signatures list for binding authors to reference. My library automatically reads this file and generates Rust code from it on the fly at built time. This means that any version update is a simple `git submodule update && cargo publish` away.

## Learn more

You can find the source code for `raylib-ffi` on [GitHub](https://github.com/ewpratten/raylib-ffi). Additionally, documentation is available on [docs.rs](https://docs.rs/raylib-ffi).
