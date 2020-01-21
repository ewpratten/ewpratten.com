---
layout: post
title:  "Compiling BrainFuck with a shell script"
description: "That was easy"
date:   2020-01-20 20:13:00
categories: random
redirect_from: 
 - /post/es3v140d/
 - /es3v140d/
---

[BrainFuck](https://en.wikipedia.org/wiki/Brainfuck) is an [esoteric programming language](https://en.wikipedia.org/wiki/Esoteric_programming_language) that is surprisingly easy to implement. It is almost on the same level as "Hello, world!", but for compilers and interpreters. In this post, ill share my new little BrainFuck compiler I built with a bash script.

## The BrainFuck instruction set

BrainFuck has 8 simple instructions:

| Instruction | Operation                                               |
|-------------|---------------------------------------------------------|
| `>`         | increment  data pointer                                 |
| `<`         | decrement  data pointer                                 |
| `+`         | increment the byte at the data pointer                  |
| `-`         | decrement  the byte at the data pointer                 |
| `.`         | print the current byte to stdout                        |
| `,`         | read one byte from stdin to the current byte            |
| `[`         | jump to the matching `]` if the current byte is 0       |
| `]`         | jump to the matching `[` if the current byte is nonzero |

### The C equivalent

BrainFuck works on a "tape". This is essentially a massive array, with a pointer that moves around. Luckily, this can be implemented with a tiny bit of C. (Thanks [wikipedia](https://en.wikipedia.org/wiki/Brainfuck#Commands))

| BF  | C code            |
|-----|-------------------|
| `>` | `++ptr;`          |
| `<` | `--ptr;`          |
| `+` | `++*ptr;`         |
| `-` | `--*ptr;`         |
| `.` | `putchar(*ptr);`  |
| `,` | `*ptr=getchar();` |
| `[` | `while (*ptr) {`  |
| `]` | `}`               |

## Implementation

Due to the fact BF has a direct conversion to C, I figured: *"Why not just use [sed](https://www.gnu.org/software/sed/manual/sed.html) to make a BF compiler?"*. And so I did.

The script is available at [git.io/JvIHm](https://git.io/JvIHm), and works as follows:

  1. Create a file containing a "header" that contains some C code that imports `stdio.h` and creates a char array
  2. Use SED to replace all BF instructions with the matching C code
  3. Append a file footer with code to return the current value at the program pointer
  4. Compile this c file with [GCC](https://gcc.gnu.org/)