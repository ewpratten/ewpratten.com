---
layout: page
title:  "Using Bazel to create Minecraft modpacks"
description: "An overview of how I automated the build process for CorePack"
date:   2020-10-24 08:00:00 
written: 2020-09-27
tags: bazel workflow git minecraft
excerpt: >-
    I decided to modernize my system for producing builds of my personal Minecraft modpack using the Bazel buildsystem.
redirect_from: 
 - /post/XlA00k24/
 - /XlA00k24/
---

*All content of this post is based around the work I did [here](https://github.com/Ewpratten/corepack)*

Back in [2012](https://minecraft.gamepedia.com/Java_Edition_1.2.5), I got in to Minecraft mod development, and soon after, put together an almost-vanilla client-side modpack for myself that mainly contained rendering, UI, and quality-of-life tweaks. While this modpack never got published, or was even given a name, I kept maintaining it for years until I eventually stopped playing Minecraft just before the release of Minecraft [`1.9`](https://minecraft.gamepedia.com/Java_Edition_1.9) (in 2016). I had gotten so used to the features of this modpack, that playing truly vanilla Minecraft didn't feel correct.

Recently, a few friends invited me to join their private Minecraft server, and despite having not touched the game for around four years, I decided to join. This was a bit of a mistake on their part, as they now get the pleasure of someone who used to main [`1.6.4`](https://minecraft.gamepedia.com/Java_Edition_1.6.4) constantly walking up to things and asking *"What is this and how does it work?"*. I have started to get used to the very weird new collection of blocks, completely reworked command system, over-complicated combat system, and a new rendering system that makes everything "look wrong".

One major thing was still missing though, *where was my modpack?* I set out to rebuild my good old modpack (and finally give it a name, *CorePack*). Not much has changed, most of the same rendering and UI mods are back, along with the same [GLSL](https://en.wikipedia.org/wiki/OpenGL_Shading_Language) shaders, and similar textures. Although, I did decide to take a *"major step"* and switch from the [Forge Mod Loader](http://files.minecraftforge.net/) to the [Fabric Loader](https://fabricmc.net/), since I prefer Fabric's API. 

## Curseforge & Bazel

I don't remember [Curseforge](https://curseforge.com/) existing back when I used to play regularly. It is a huge improvement over the [PlanetMinecraft](https://www.planetminecraft.com/) forums, as curse provides a clean way to access data about published Minecraft mods, and even has an API! Luckily, since I switched the modpack to Fabric, every mod I was looking for was available through curse (although, it seems [NEI](https://www.curseforge.com/minecraft/mc-mods/notenoughitems) is a thing of the past).

My main goal for the updated version of CorePack was to design it in such a way I could make a CI pipeline generate new releases for me when mods are updated. This requires programmatically pulling information about mods, and their JAR files using a buildsystem script. Since this project involves working with a large amount of data from various external sources, I once-again chose to use [Bazel](https://bazel.build), a buildsystem that excels at these kinds of projects.

While Curseforge provides a very easy to use API for working with mod data, @Wyn-Price (a fellow mod developer) has put together an amazing project called [Curse Maven](https://www.cursemaven.com/) that I decided to use instead. Curse Maven is a serverless API that acts much like my [Ultralight project](/blog/2020/09/17/ultralight-writeup). Any request for an artifact to Curse Maven will be redirected, and served from the [Curseforge Maven server](https://authors.curseforge.com/knowledge-base/projects/529-api#Maven) without the need for me to figure out the long-form artifact identifiers used internally by curse.

Curse Maven makes loading a mod (in this case, [`fabric-api`](https://www.curseforge.com/minecraft/mc-mods/fabric-api)) into Bazel as easy as:

```python
# WORKSPACE
# Load bazel_maven_repository
http_archive(
    name = "maven_repository_rules",
    strip_prefix = "bazel_maven_repository-1.2.0",
    type = "zip",
    urls = ["https://github.com/square/bazel_maven_repository/archive/1.2.0.zip"],
)
load("@maven_repository_rules//maven:maven.bzl", "maven_repository_specification")
load("@maven_repository_rules//maven:jetifier.bzl", "jetifier_init")
jetifier_init()

# Declare any mods as maven artifacts
maven_repository_specification(
    name = "maven",
    artifacts = {
        "curse.maven:fabric-api:3049174": {"insecure": True}
    },
    repository_urls = [
        "https://www.cursemaven.com",
    ],
)
```

The above snippet uses a Bazel ruleset developed by [Square, Inc.](https://squareup.com/ca/en) called [`bazel_maven_repository`](https://github.com/square/bazel_maven_repository). 

## Modpack configuration

Since my pack is designed for use with [MultiMC](https://multimc.org/), two sets of configuration files are needed. The first set tells MultiMC which versions of [LWJGL](https://www.lwjgl.org/), Minecraft, and Fabric to use, and the second set are the in-game config files. Many of these files contain information that I would like to modify from Bazel during the modpack build step. Luckily, the [Starlark](https://docs.bazel.build/versions/master/skylark/language.html) core library comes with an action called [`expand_template`](https://docs.bazel.build/versions/2.0.0/skylark/lib/actions.html#expand_template). `expand_template` is basically a find-and-replace tool that will perform substitutions on files. Since this is an action, and not a rule, it must be wrapped with a small rule declaration:

```python
# tools/template.bzl
def expand_template_impl(ctx):
    ctx.actions.expand_template(
        template = ctx.file.template,
        output = ctx.outputs.out,
        substitutions = {
            k: ctx.expand_location(v, ctx.attr.data)
            for k, v in ctx.attr.substitutions.items()
        },
        is_executable = ctx.attr.is_executable,
    )

expand_template = rule(
    implementation = expand_template_impl,
    attrs = {
        "template": attr.label(mandatory = True, allow_single_file = True),
        "substitutions": attr.string_dict(mandatory = True),
        "out": attr.output(mandatory = True),
        "is_executable": attr.bool(default = False, mandatory = False),
        "data": attr.label_list(allow_files = True),
    },
)
```

In a `BUILD` file, template rules can be defined as follows:

```python
# BUILD
load("//tools:template.bzl", "expand_template")

expand_template(
    name = "my_config",
    template = "config.json.in",
    out = "config.json",
    substitutions = {
        "TEST_SUBS": "hello world"
    }
)
```

Using the following example file as `config.json.in`, this rule would have the following effect:

```js
// config.json.in
{
    "key": "TEST_SUBS"
}

// config.json
{
    "key": "hello world"
}
```


## Packaging

Once mods are loaded, and configuration files are defined in the buildsystem, I use a large number of [`filegroup`](https://docs.bazel.build/versions/master/be/general.html#filegroup) and [`genrule`](https://docs.bazel.build/versions/master/be/general.html#genrule) rules to set up a directory hierarchy in the workspace, and wrap everything in a call to [`zipper`](https://sourcegraph.com/github.com/v2ray/ext/-/blob/bazel/zip.bzl#L23:25) to package the modpack into a ZIP file.

Finally, I use [GitHub Actions](https://github.com/features/actions) to automatically run the buildscript, and publish the resulting MultiMC instance zip to the [GitHub repo](https://github.com/Ewpratten/corepack) for this project.