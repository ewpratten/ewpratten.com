---
layout: page
title:  "Building a mini maven server"
description: "Project overview: The Ultralight maven server"
date:   2020-09-17 11:00:00 
written: 2020-09-05
tags: project github maven
excerpt: >- 
  In this post, I explain the process of building my own personal 
  maven server, and show how simple maven servers really are.
redirect_from: 
 - /post/2jf002s4/
 - /2jf002s4/
---

I have been looking around for a small, and easy-to-use [maven](https://maven.apache.org/) server to host my personal Java libraries for some time now. I origionally went with [Jitpack.io](https://jitpack.io/), but didn't like the fact I jitpack overwrites artifact `groupID` fields. This means that instead of specifying a package via something like `ca.retrylife:librandom:1.0.0`, a user would have to write `com.github.ewpratten:librandom:1.0.0`. While this is not a huge deal, I prefer to use a `gorupID` under my own domain for branding reasons. Along with this issue, I just didn't have enough control over my artifacts with Jitpack. 

From Jitpack, I moved on to hosting a maven server in a docker container on one of my webservers. This worked fine until my server crashed from a configuration issue. I decided that self-hosting was not the way to go until I have set up a more stable storage infrastructure.

After my attempt at self-hosting, I moved to (and quickly away from) [GitHub Packages](https://github.com/features/packages). GitHub Packages is a great service with a huge drawback. Anyone wanting to use one of my libraries must authenticate with the github maven servers. Along with that, the buildsystem configuration to actually load a GitHub Packages artifact is currently a bit of a mess. While GitHub staff have addressed this issue, and a way to load packages without authentication is roumered to be coming to the platform sometime soon, I don't want to wait. After this adventure, I got curious. 

<div class="center" markdown="1">
> *How hard is it to write my own maven server?* 
</div>

Turns out, not very hard at all.

Maven servers are basically glorified static site generators that serve specific files in specific places. On top of this, the entire protocol is XML-based, which makes building one super easy. When a buildsystem like Maven or Gradle wants to fetch an artifact from a maven server, it first makes a request to `http(s)://<baseurl>/<groupID>/<artifactID>/<version>/<artifactID>-<version>.pom` to find out any needed data about the requested artifact. An example of this file's contents could be:

```xml
<!-- Response for http://maven.example.com/ca/retrylife/librandom/1.0.0/librandom-1.0.0.pom -->
<project 
    xsi:schemaLocation="http://maven.apache.org/POM/4.0.0 http://maven.apache.org/xsd/maven-4.0.0.xsd" 
    xmlns="http://maven.apache.org/POM/4.0.0" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <modelVersion>4.0.0</modelVersion>
  <groupId>ca.retrylife</groupId>
  <artifactId>librandom</artifactId>
  <version>1.0.0</version>
</project>
```

I don't exactly know the reason this file exists in most cases, since all the data returned is data the client already knows. Judging by the [Project Object Model](https://maven.apache.org/guides/introduction/introduction-to-the-pom.html) specifications, some servers might use this file to return additional metadata about the artifact, but none of this data is required for my minimal working example.

Along with this request, another is sometimes made to `http(s)://<baseurl>/<groupID>/<artifactID>/maven-metadata.xml`, which is an XML file containing a list of all artifact versions stored on the server. From my testing with Gradle, a call to this endpoint is only made if there is a wildcard in the asset name in a user's build configuration. An example of this would be `ca.retrylife:librandom:1.+`. An exampe of this file's contents could be:

```xml
<metadata modelVersion="1.1.0">
  <groupId>ca.retrylife</groupId>
  <artifactId>librandom</artifactId>
  <version>1.0.1</version>
  <versioning>
    <latest>1.0.1</latest>
    <release>1.0.1</release>
    <versions>
      <version>1.0.1</version>
      <version>1.0.0</version>
    </versions>
    <lastUpdated>1599079384</lastUpdated>
  </versioning>
</metadata>
```

Finally, a request is made to `http(s)://<baseurl>/<groupID>/<artifactID>/<version>/<artifactID>-<version>.jar`, which should just return the correct JAR file for the library. Pretty simple.

## The magic behind Ultralight

[Ultralight Maven](https://ultralight.retrylife.ca) is a small serverless maven server I built for myself. The Ultralight backend app listens for each of these three requests, and will handle each of the following cases. I use a YAML file to tell the backend what artifact names I want it to "serve", and their GitHub repository names.

***Case 1.*** The client has asked for a Project Object Model for an artifact. In this case, the backend will make sure the requested artifact name is listed in its configuration file, then simply parse all of the needed data out of the request URL, and send it right back to the client.

***Case 2.*** The client has asked for a `maven-metadata.xml` file. In this case, the backend will first make sure the artifact exists, then make a request out to the [GitHub REST API](https://docs.github.com/en/rest), and ask for a list of all tag names in the artifact's repository. For every tag that contains an asset with the same name as the artifact, the tag's version number will be added to the list of valid versions in the response.

***Case 3.*** The client has asked for an artifact's JAR file. In this case, the backend will first make sure the artifact exists, then make a request out to the GitHub API, and ask for the correct asset URL on GitHub's servers. With this url, Ultralight just crafts an [HTTP 302](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/302) response. This makes the client actually request from GitHub itself instead of the Ultralight server, thus Ultralight never needs to store any artifacts.

Both to make the experience faster, and to get around GitHub's rate limiting on the tags API, Ultralight sends the client [`stale-while-revalidate`](https://vercel.com/docs/edge-network/caching#stale-while-revalidate) cache control headers. This forces the Vercel server that hosts Ultralight to only update its cache once per minute (slightly slower than the GitHub rate limit :wink:)

For instructions on how to set up your own maven server using Ultralight, see the [README](https://github.com/Ewpratten/ultralight#ultralight) on GitHub.