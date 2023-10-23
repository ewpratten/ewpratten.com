---
title: Commit syncing across hosted GIT instances
description: How I keep my commit graph alive
date: 2022-05-18
tags:
- random
- git
draft: false
extra:
  auto_center_images: true
  excerpt: This post covers how to keep your commit graph alive across multiple GIT
    instances by syncing your commit history to magic repos.
aliases:
- /blog/commit-sync
---

Since September of 2018 (3 and a half years ago) I have been roughly holding a streak of going no more than three days without making a commit to some project on GitHub.

![A screenshot of my commit history last year](/images/posts/commit-sync/commit_graph.png)

This is not entirely intentional, and I have broken it a few times:

- June 7, 2019
- August 8, 2019
- September 27, 2019
- November 3, 2021

..but a streak is a streak. A few of my friends know about this and keep an eye on my commit graph and I do too. Recently, with most of my programming time allocated to work, my graph started looking like weeks of empty cells, implying I broke my streak for good.

In reality, that couldn't be farther from the truth. I have been writing quite a lot of code actually, its just all tracked in a company GIT instance with a separate account.

## Time for some trickery

I happened to remember a little trick I used in a CI pipeline for [Raider Robotics](https://github.com/frc5024/) where you can backdate empty commits with arbitrary authors. I recall using this for some kind of version tagging system at some point.. idk.. the important part being it is possible to make "fake" commits with the right command-line flags.

### The game plan

My idea was as follows:

1) Scrape all work repos for commits authored by one of my email addresses
2) Keep track of the commit timestamps
3) Make empty commits to a GitHub repo and backdate them to the timestamps from the last step
4) Enjoy having my GitHub contributor graph synced to my work account

*For anyone concerned with the security issue of leaking commit data, In my real implementation, dates are shuffled a bit. This also all happens in a private repo, so the public can only ever see its affect on my commit graph, and can't actually see the commits themselves.*

### Scraping commits from repos

The `git` command has a `log` subcommand for querying info about commits. In its simplest form, you can dump all commits for a repo with:

```sh
git -C /path/to/repo log --pretty=format:"%H"
```

An example output for the repo behind this website:

```text
...
62d0c4833766671182ed0aeeb76bb16cc3f35174
420b3cc4a9d61024e0dd6c32deafb57244d09433
fed6fc374d02c2ae8f67bff837c8c8334760b303
5a64788339afd750c3853468f89d275cf8fa49cd
01992912951d80631fa5069fce7d9a3593bbcd39
d894387400158d231ed6559636169f1464bb630d
4a68456c7a5df699bc7620c9250b7a04aac5bd3c
ff87809b9c14c5132ecd5a39921b1cf2118b12cc
2b8797bbdcec61654540d995aaae67bcab8dc1c1
c4d978c5d098846b8a0105c5b6d3f42b389c6ea7
9791cdd979a17f0d5ebf9028d4778152ca07ae1d
dda08261872d3c2301cc02108c0f466dedaacaca
f408c1fa9785a40038e04b0ef017bd8d2897cdd6
...
```

Its just a bunch of hashes.

As a side note, if you are trying to replicate my work and also commit with multiple email addresses, you can chain `--author` flags together.

```sh
git -C /path/to/repo log --pretty=format:"%H" --author=ewpratten@example.com --author=evan@work.com
```

### Cloning commits

If we iterate over our list of hashes, we can perform the rest of the steps. The main data point we care about is the timestamp.

To fetch a commit timestamp from a repo, use the following, replacing `$COMMIT_HASH` with the hash in question:

```sh
git -C /path/to/repo show -s --format=%ci $COMMIT_HASH
```

And finally, with our timestamp (stored as `$DATE`) a new commit can be written to a target repo:

```sh
git -C /path/to/public/repo commit -m "A message." --date="$DATE" --no-edit --allow-empty
```

Importantly, the `--allow-empty` flag removes the requirement for any files to be contained in the commit, essentially allowing you to have a "zero size" repository.

## Conclusion

Uh, ya. Cool. With your scripting language of choice, you can chain these commands together, toss a `git push` in there, stick this in a cron job, and have yourself a nice, healthy commit graph.
