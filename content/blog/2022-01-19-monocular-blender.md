---
layout: page
title: Monocular depth mapping in Blender
description: My 3D pipeline is backed by neural networks
date: 2022-01-19
tags:
- random
- 3d-pipeline
- python
draft: false
extra:
  excerpt: This post covers the process I went through to write a Neural-Network-assisted
    Blender plugin for converting monocular images into 3D textured meshes.
aliases:
- /blog/monocular-blender
---

A while back, I encountered an interesting trend going on over on TikTok. People were turning their photos into videos with 3D camera movements.

Having created content like this before myself in both Adobe After Effects and Blender, I just assumed I had come across a few people who also knew the process for creating [2.5D](https://en.wikipedia.org/wiki/2.5D_(visual_perception)) content. For anyone who has not seen 2.5D content before, check out the video below by the amazing artist [Spencer Miller](https://www.instagram.com/SpencerMiller/), who is well know  for his 2.5D and 3D concert videos.

<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/CCeBnxmjfuY/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: auto; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="https://www.instagram.com/p/CCeBnxmjfuY/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div></div></a><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/p/CCeBnxmjfuY/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by spencer miller (@spencermiller)</a></p></div></blockquote> <script async src="//www.instagram.com/embed.js"></script>

<br>

Alright. Back to TikTok, here is an example of one of the trend videos I came across. Notice how there is some graphical artifacting near the top and bottom of this video? This made me realize these videos are not your standard 2.5D content, but something else was going on.

<br>

<blockquote class="tiktok-embed" cite="https://www.tiktok.com/@flash_supercars/video/7016749321043463430" data-video-id="7016749321043463430" style="max-width: 605px;min-width: 325px;" > <section> <a target="_blank" title="@flash_supercars" href="https://www.tiktok.com/@flash_supercars">@flash_supercars</a> This is a nice Effekt!👍🔥😍<a title="münchen" target="_blank" href="https://www.tiktok.com/tag/m%C3%BCnchen">#münchen</a> <a title="hypercars" target="_blank" href="https://www.tiktok.com/tag/hypercars">#hypercars</a> <a title="supercars" target="_blank" href="https://www.tiktok.com/tag/supercars">#supercars</a> <a title="carspotting" target="_blank" href="https://www.tiktok.com/tag/carspotting">#carspotting</a> <a title="münchencars" target="_blank" href="https://www.tiktok.com/tag/m%C3%BCnchencars">#münchencars</a> <a title="flashsupercars" target="_blank" href="https://www.tiktok.com/tag/flashsupercars">#flashsupercars</a> <a title="fürdich" target="_blank" href="https://www.tiktok.com/tag/f%C3%BCrdich">#fürdich</a> <a title="fy" target="_blank" href="https://www.tiktok.com/tag/fy">#fy</a> <a title="carlovers" target="_blank" href="https://www.tiktok.com/tag/carlovers">#carlovers</a> <a title="richlifestyle" target="_blank" href="https://www.tiktok.com/tag/richlifestyle">#richlifestyle</a> <a title="bugatti" target="_blank" href="https://www.tiktok.com/tag/bugatti">#bugatti</a> <a title="ferrari" target="_blank" href="https://www.tiktok.com/tag/ferrari">#ferrari</a> <a title="3d" target="_blank" href="https://www.tiktok.com/tag/3d">#3d</a> <a title="3dzoompro" target="_blank" href="https://www.tiktok.com/tag/3dzoompro">#3dzoompro</a> <a title="3dtrend" target="_blank" href="https://www.tiktok.com/tag/3dtrend">#3dtrend</a> <a title="trend" target="_blank" href="https://www.tiktok.com/tag/trend">#trend</a> <a title="3dzoomeffect" target="_blank" href="https://www.tiktok.com/tag/3dzoomeffect">#3dzoomeffect</a> <a target="_blank" title="♬ original sound - 6X Camps 🏆🏆🏆🏆🏆🏆" href="https://www.tiktok.com/music/original-sound-7013166802171644677">♬ original sound - 6X Camps 🏆🏆🏆🏆🏆🏆</a> </section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>

<br>

There was no way so many people could have suddenly learned how to work in 2.5D, all had the required software, and all had the time to painstakingly rotoscope out every depth level of their photo to make it all look good.

Conveniently, it took very little effort to find out that this was all being done by a video editing app called [CapCut](https://www.capcut.net/). I'll spare you the details of researching this CapCut effect to find out how it works, and we will skip right to the technology powering it.

## Playing with Neural Networks

From my research, this techololgy (called *context-aware inpainting*) stems from a paper called [*3D Photography Using Context-Aware Layered Depth Inpainting*](https://doi.org/10.1109/CVPR42600.2020.00805). I wanted to try replicating this effect in Blender, so I loaded up the [demo for this paper](https://github.com/vt-vl-lab/3d-photo-inpainting), tried it out on some images I had lying around, and immediately ran in to issues with incorrect depth estimation results.

After some experimentation, I decided to take a step back from neural-network-powered inpainting and instead started experimenting with the underlying depth estimation research this paper was build on top of.

The [Embodied AI Foundation](https://www.embodiedaifoundation.org/) has a paper called [Towards Robust Monocular Depth Estimation: Mixing Datasets for Zero-shot Cross-dataset Transfer](https://doi.org/10.1109/TPAMI.2020.3019967) (much better known as **MiDaS**). This paper and [accompanying Python library](https://github.com/isl-org/MiDaS) describes an implements a high-accuracy method for estimating depth maps from a monocular (single-lense camera) image.

## My goal

My goal for this side-project at this point was to create a "zero-thought, one-click" system for bringing monocular images into Blender as full 3D meshes with projection-mapped textures.

This requires three parts:

- A simple system for creating depth maps from images
- An in-DCC interface for image importing in Blender
- Some code to tie everything together and actually create the object

### Using Docker with GPU-passthrough for fast depth computation

I happen to have grabbed myself an NVIDIA graphics card with around 4800 CUDA cores last year with the plan of using it for 3D rendering and machine learning experimentation, so my top priority was to make sure I could actually use it for this project.

Luckily, NVIDIA has a solution for doing just this through their project called the [NVIDIA Container Toolkit](https://github.com/NVIDIA/nvidia-docker) (aka `nvidia-docker`).

> The NVIDIA Container Toolkit allows users to build and run GPU accelerated Docker containers. The toolkit includes a container runtime library and utilities to automatically configure containers to leverage NVIDIA GPUs.<br>
> \[source: [NVIDIA](https://github.com/NVIDIA/nvidia-docker#introduction)\]

Essentially, this toolkit leverages an existing Docker Engine on a host, and provides a bit of a "side channel" for containers with the appropriate client software to access the Host's GPU resources.

Using the toolkit, I threw together a quick project called `midas-depth-solve` that provides a Docker container to run MiDaS through a little [batch-processing wrapper script](https://github.com/Ewpratten/midas-depth-solve/blob/master/solve.py) I wrote. Simply provide a directory full of images in whatever format you'd like along with some configuration flags, and it will spit out each image as a grayscale depth map.

{{ github(repo="ewpratten/midas-depth-solve") }}
<br>

Information on how to use this container stand-alone yourself can be found in the project README.

An example of an output from MiDaS is shown below. I have boosted the exposure a lot to make it easier to see the depth levels. Generally, depth maps are low-contrast.

![Example Depth Image](/images/posts/monocular-blender/exaggerated-depth.png)

### The Blender plugin

I have a personal project called [*Evan's DCC Scripts*](https://github.com/Ewpratten/dcc_scripts) where I keep personal plugins for 3D software. 

I decided to piggy-back off the pipeline infrastructure I have already set up there for this project. Thus, bringing my MiDaS tool into blender was as simple as creating a new QT GUI, and hooking it up to a custom operator. 

*For anyone curious, my Blender plugins use QT for maximum interoperability with the rest of my toolset.*

<div style="text-align:center;">
<img src="/images/posts/monocular-blender/blender-importer-window.png">
<p>Plugin Dialog: <em>Import Monocular Image</em></p>
</div>

### Actually creating textured 3D meshes

The process for converting a depth map and texture to a 3D object is quite simple:

1) Create a plane (this can be done through [*Images As Planes*](https://docs.blender.org/manual/en/latest/addons/import_export/images_as_planes.html))
2) Subdivide the plane (I have been using 128 subdivisions, and it seems to work well)
3) Apply a [*Displace Modifier*](https://docs.blender.org/manual/en/latest/modeling/modifiers/deform/displace.html) to the plane, using the depth map as the source texture, and configuring the modifier to work with UV coordinates

The first time I tried this, I encountered a slight issue with depth mapping:

<div style="text-align:center;">
<img src="/images/posts/monocular-blender/ayo_bro.png">
<p>A failed attempt</p>
</div>

But then, I quickly figured out how to set up the displacement modifier, and got my expected result:

<table>
<tr>
<td>
<div style="text-align:center;">
<img src="/images/posts/monocular-blender/ayo_displaced.png">
<p>Displaced, untextured</p>
</div>
</td>
<td>
<div style="text-align:center;">
<img src="/images/posts/monocular-blender/ayo_textured.png">
<p>Textured, viewed from the original camera position</p>
</div>
</td>
</tr>
</table>

## Conclusion

This whole project was a fun experiment with some tools that are designed for very different applications. I plan to continue refining the quality of the outputs of my plugin. I'll likely look in to reducing un-needed subdivisions using [OpenSubdiv](https://graphics.pixar.com/opensubdiv) in the near future.

If you are interested in experimenting with my depth mapping plugin yourself, feel free to send me [an email](mailto:contact@ewpratten.com) and I'll help you set it up. Currently, my tools are Linux-exclusive.

And finally, a demo render:

<video style="max-width:100%;" controls>
<source src="/images/posts/monocular-blender/demo_render.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>
