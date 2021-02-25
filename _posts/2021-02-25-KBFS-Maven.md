---
layout: page
title: "Using KBFS as a makeshift maven server" 
description: "A free and secure way to host personal Java libraries and applications" 
date:   2021-02-25 10:00:00 
written: 2021-02-22
tags: writeup maven projects
excerpt: >-
    In my never-ending hunt for a suitable solution for hosting Java libraries, I take a stop to try out Keybase Filesystem (KBFS)
redirect_from: 
 - /post/g4lk45j3/
 - /g4lk45j3/
---

As I continue to write more and more Java libraries for personal and public use, I keep finding myself limited by my library hosting solutions. Maven servers are currently my go-to way of storing and organizing all things Java. I have gone through a solid handful of servers over the past few years, here are my comments on each:

 - GitHub Releases
   - No [dependabot](https://dependabot.com/) integration
   - No easy way to get Gradle to load files directly from GitHub
 - [JitPack](https://jitpack.io/)
   - Slow builds
   - No easy way to publish custom artifacts or use custom groups
   - Sometimes unusably long cache policy
 - [Ultralight](/blog/2020/09/17/ultralight-writeup)
   - Has a file transfer limit
   - Uses my personal API keys to interact with GitHub
   - No way to automate package updates
 - [GitHub Packages](https://github.com/features/packages)
   - Requires users to authenticate even for public assets
   - Has a file transfer limit
   - Uses a separate maven url per project

As a student, I prefer not to do the sensible solution--*spin up an [Artifactory](https://jfrog.com/artifactory/) server*--as that costs money I could be spending on coffee.

## What makes a maven server special?

Really, not much. As outlined in my [previous maven-related post](/blog/2020/09/17/ultralight-writeup), a maven server is just a simple webserver with a specific directory structure, and some metadata files placed in specific locations.

Let's say we wanted to publish a package with the following attributes:

| Attribute  | Value                  |
| ---------- | ---------------------- |
| GroupID    | `ca.retrylife.example` |
| ArtifactID | `example-artifact`     |
| Version    | `1.0.4`                |

The resulting directory structure would end up looking like:

```text
.
└── ca
    └── retrylife
        └── example
            └── example-artifact
                ├── maven-metadata.xml
                ├── maven-metadata.xml.sha1
                └── 1.0.4
                    ├── example-artifact-1.0.4.jar
                    ├── example-artifact-1.0.4.jar.sha1
                    ├── example-artifact-1.0.4.pom
                    └── example-artifact-1.0.4.pom.sha1
```

<div class="center" markdown="1">
*Generated with [tree.nathanfriend.io](https://tree.nathanfriend.io)*
</div>

In this example. I chose to use the `sha1` hashing algorithm, but maven clients support pretty much any algorithm I can think of. 

As you can see, the files are layed out very logically. Packages are organized similarly to how you organize your source code; each artifact is accompanied by a [Project Object Model](https://maven.apache.org/guides/introduction/introduction-to-the-pom.html) describing it, `maven-metadata` files keep track of versioning, and every file also has a hash alongside it.

For reference, the `maven-metadata.xml` in this example would look something like this:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<metadata>
  <groupId>ca.retrylife.example</groupId>
  <artifactId>example-artifact</artifactId>
  <versioning>
    <release>1.0.4</release>
    <latest>1.0.4</latest>
    <versions>
      <version>1.0.4</version>
    </versions>
    <lastUpdated>20210216203206</lastUpdated>
  </versioning>
</metadata>
```

As far as I know, `maven-metadata` is not actually required, but I always include them so that I can make use of [dynamic versions](https://docs.gradle.org/current/userguide/dynamic_versions.html) in Gradle.

## Using a static CDN as a maven server

Since there is nothing special about a maven server aside from its directory structure, anywhere that can host files can become a server. My choice for now is [Keybase](https://keybase.io/)'s [KBFS](https://book.keybase.io/docs/files). KBFS is a pgp-signed file store that allows every user 250GB of free storage. This web filesystem is mounted to the user's device using [FUSE](https://www.kernel.org/doc/html/latest/filesystems/fuse.html) in a similar way to [rclone](https://rclone.org/).

This local mount & sync setup allows me to interact with my `/keybase` mountpoint like any other directory, while having all its contents automatically backed up and published.

### Taking advantage of this

Gradle's [`maven-publish`](https://docs.gradle.org/current/userguide/publishing_maven.html) plugin is designed to publish packages to remote servers, but will also work with local URIs. Simply pointing a [`MavenPublication`](https://docs.gradle.org/current/dsl/org.gradle.api.publish.maven.MavenPublication.html) to `/keybase/public/ewpratten/maven/release` (my directory of choice for now) will automatically generate everything mentioned in the section about file structure above.

My exact configuration for doing this in gradle is as follows ([source](https://github.com/Ewpratten/gradle_scripts/blob/master/keybase_publishing.gradle)):

```groovy
apply plugin: "maven-publish"

// Determine SNAPSHOT vs release
def isRelease = !project.findProperty("version").contains("-SNAPSHOT")
if (!isRelease) {
    println "Detected SNAPSHOT"
}

publishing {
    repositories {
        maven {
            name = "KBFS"
            if (isRelease) {
                url = uri(
                    project.findProperty("kbfs.maven.release") ?: "/keybase/public/ewpratten/maven/release"
                )
            } else {
                url = uri(
                    project.findProperty("kbfs.maven.snapshot") ?: "/keybase/public/ewpratten/maven/snapshot"
                )
            }
        }
    }
}
```

This configuration is a bit fancy as it will separate snapshots from releases, and allow me to completely override the endpoint(s) in my `settings.gradle` file if I choose. A minimal approach would be:

```groovy
apply plugin: "maven-publish"

publishing {
    repositories {
        maven {
            name = "KBFS"
            url = uri("/keybase/public/<your username>/maven")
        }
    }
}
```

### Pretty URLs

With the solution outlined in this post, the end user would end up specifying one of the following URLs in their maven client:

 - `https://<username>.keybase.pub/maven/release/`
 - `https://<username>.keybase.pub/maven/snapshot/`

While that is perfectly fine, I prefer to keep all of my projects / services / etc under my personal domain (`retrylife.ca`). Unlike the rest of this post, this step does cost some money.

I already rent two servers for various other projects, and one of them is running the [Caddy](https://caddyserver.com/) webserver and acting as a reverse proxy. I have pointed two domains (`release.maven.retrylife.ca` and `snapshot.maven.retrylife.ca`) at this server and am using the following rules to route them:

```text
release.maven.retrylife.ca {
    route /* {
        rewrite * /maven/release/{path}
        reverse_proxy https://ewpratten.keybase.pub {
            header_up Host ewpratten.keybase.pub
        }
    }
}

snapshot.maven.retrylife.ca {
    route /* {
        rewrite * /maven/snapshot/{path}
        reverse_proxy https://ewpratten.keybase.pub {
            header_up Host ewpratten.keybase.pub
        }
    }
}
```

This means that I can point users at one of the following domains, and they will get the packages they are looking for:

 - `https://release.maven.retrylife.ca/`
 - `https://snapshot.maven.retrylife.ca/`

I am also now able to switch out backend servers / services whenever I want, and users will see no difference.

## Future improvements

Some time in the future, I plan to move from KBFS to the S3-based [DigitalOcean Spaces](https://www.digitalocean.com/products/spaces/) so I can speed up the download time for packages, and have better global distribution of files.