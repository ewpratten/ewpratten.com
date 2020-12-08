---
layout: page
title:  "Reading metadata from a bitmap file"
description: "A project writeup"
date:   2020-10-01 12:25:00 
written: 2020-09-15
tags: project c images
excerpt: >-
    Inspired from one of my friend's projects, I built a small 
    tool for displaying bitmap file info from the command line.
redirect_from: 
 - /post/XcaMdj2m/
 - /XcaMdj2m/
uses:
 - github-cards
---

Recently, @rsninja722 was telling me about [a project](https://github.com/rsninja722/file2bmp) he was working on. The basic idea is that you pass a file into his program, and it generates a bitmap of the binary data. This was inspired by [an old post of mine](/post/ef7b3166) where I did the same thing with a horribly written Python script and the library [`pillow`](https://github.com/python-pillow/Pillow). 

Both of us are currently teaching ourselves the **C** programming language. Him, for a break from JavaScript. Me, for no particular reason. As somebody who mostly lives in the world of high-level C-family languages (C++ and Python), learning C has been a challenging, fun, and rewarding experience. I enjoy immersing myself in *"the old way of doing things"*. This means sitting down with my Father's old [*ANSI Standard C Programmer's Reference*](https://archive.org/search.php?query=external-identifier%3A%22urn%3Aoclc%3Arecord%3A1028045558%22) book, and looking up what I need to know through a good old appendix full of libc headers and their function lists.

While @rsninja722 was working on his project, I found myself using `xxd` and `python3` a lot to debug small issues he encountered. This is fairly tedious, so I set out to write myself a tool to help. I have a small GitHub repository called [smalltools](https://github.com/Ewpratten/smalltools) where I keep the source code to a few small programs I write for fun. I added a new tool file to the repo (called `bmpinfo`) and got to work.

## How does a bitmap work?

This was the first big question. I had learned a while ago when working on another project that the image data stored in a bitmap is just raw pixel values, but aside from that, I had no clue how this file format works. Luckily, Wikipedia came to the rescue (as per usual) with [this great article](https://en.wikipedia.org/wiki/BMP_file_format). It turns out that the file metadata, like the pixel values, is stupidly simple to work with**<sup>1, 2</sup>**. 

<div style="color:gray;" markdown="1">
***1.** I am going to cover only images with `24-bit` color, with no compression*<br>
***2.** All integers in a bitmap are little-[endian](https://en.wikipedia.org/wiki/Endianness). These must be converted to the host's endianness*
</div>

A simple bitmap file consists of only three parts (although the specification can support more data):

 1. A file header
 2. File information / metadata
 3. Pixel data

I will cover each individually.

### The file header

Like any other standard binary file format, bitmaps start with a file header. This is a block of data that tells programs what this file is, and how it works. The bitmap file header starts with two characters that tell programs what type of bitmap this is. I have only worked with **BM** type files, but the following are all possible file types:

| Identifier | Type                           |
|------------|--------------------------------|
| **BM**     | Windows 3.1x, 95, NT, ... etc. |
| **BA**     | OS/2 struct bitmap array       |
| **CI**     | OS/2 struct color icon         |
| **CP**     | OS/2 const color pointer       |
| **IC**     | OS/2 struct icon               |
| **PT**     | OS/2 pointer                   |


The rest of the data is fairly standard. Since I am working in **C**, I have defined this data as a [`struct`](https://en.wikipedia.org/wiki/Struct_(C_programming_language)). Here is the header:

```c
typedef struct {
    // File signature
    char signature[2];

    // File size
    uint32_t size;

    // Reserved data
    uint16_t reservedA;
    uint16_t reservedB;

    // Location of the first pixel
    uint32_t data_offset;
} header_t;
```

### Bitmap Information Header

The *Bitmap Information Header* (also called **DIB**) contains more information about the file, and can vary in size based on the program that created it. As mentioned earlier, I will only cover the simplest implementation. Due to the possibility of multiple DIB formats, the first element of the header is its own size in bytes. This way, any program can handle any size of DIB without needing to actually implement every header tpe.

Like the file header, I have also written this as a `struct`.

```c
typedef struct {
    // Size of self
    uint32_t size;

    // Image dimensions in pixels
    int32_t width;
    int32_t height;

    // Image settings
    uint16_t color_planes;
    uint16_t color_depth;
    uint32_t compression;
    uint32_t raw_size; // This is generally unused

    // Resolution in pixels per metre
    int32_t horizontal_ppm;
    int32_t vertical_ppm;

    // Other settings
    uint32_t color_table;
    uint32_t important_colors;
} info_t;
```

Some notes about the data in this header:

 - Image dimensions are **signed** integers. Using a negative size will cause image data to be read right-to-left and bottom-to-top
 - A setting is present for the pixel density of the image. This is measured in pixels-per-metre (usually `3780`)
 - The `color_table` is the number of colors used in the palette. This defaults to `0` (meaning *all*)
 - The `important_colors` is the number of colors that are important in the image. This defaults to `0` (meaning *all*) and is almost never used 

### Pixel data

After the file headers comes the pixel data. This is written pixel-by-pixel, and is stored as 3 bytes in the format `BBGGRR` (little-endian, remember?).

## Loading a bitmap file into a C program

For simplicity, I am going to write this for a computer that is based on a little-endian architecture. In reality, most computers are big-endian, and require that you [reverse the endian](https://codereview.stackexchange.com/a/151070) of everything read in.

```c
#include <stdlib.h>
#include <stdio.h>
#include <stdint.h>

// Headers defined above
extern struct header_t;
extern struct info_t;

typedef struct {
    uint8_t blue;
    uint8_t green;
    uint8_t red;
} pixel_t;

int main(){
    // Read a bitmap
    FILE* p_bmp = fopen("myfile.bmp", "rb");

    // Create header and info data
    header_t header;
    info_t info;

    // Read from the file.
    // Some compilers will pad structs, so I have 
    // manually entered their sizes (14, and 40 bytes)
    fread(&header, 14, 1, p_bmp);
    fread(&info, 40, 1, p_bmp);

    // Read every pixel
    while(1){
        pixel_t pixel;
        if(fread(&pixel, 3, 1, p_bmp) == 0) break;

        // Do something with the pixel
        // ...
    }


    return 0;
}
```

## And thats it!

Reading bitmap data is really quite simple. Of course, there are many sub-standards and formats that require more code, and sometimes decompression algorithms, but this is just an overview.

If you would like to see the small library I built for myself for doing this, take a look [here](https://github.com/Ewpratten/smalltools/tree/master/utils/img). (it includes endianness handling)
