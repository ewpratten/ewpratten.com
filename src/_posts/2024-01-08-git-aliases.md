---
title: Git Aliases
description: Using aliases to become a slightly faster Git user
date: 2024-01-08
draft: false
extra:
  auto_center_images: true
aliases:
  - /blog/git-aliases
---

I use Git a lot. I use it for work, I use it for personal projects, I use it for this website, *etc.* I like it.

Through my time using Git, I've collected a small set of [aliases](https://git-scm.com/book/en/v2/Git-Basics-Git-Aliases) that I use pretty much daily. This post is a little overview of those aliases with the hope that whoever stumbles across this page finds them useful in the future.

## Author Ranking

Ever wondered who on your team does the most work? Well, most *commits*. Git can show you!

I have this command aliased as `git authors`:

```sh
git shortlog --summary --numbered --email
```

An example output from an old [Raider Robotics](/robotics/5024) codebase:

```sh
# git authors
727  Evan Pratten <evan@ewpratten.com>
 44  William Meathrel <REDACTED>
 23  Carter Tomlenovich <REDACTED>
...
```

## Commit Graph

One day, I noticed that the only reason I used [GitKraken](https://www.gitkraken.com/) was to see the commit graph, so I decided to make an alias to display it in the terminal instead, removing my reliance on GitKraken all together.

I keep tweaking this one over time, but as of writing, I have the following command aliased as `git tree`:

```sh
git log --graph --decorate --abbrev-commit --all \
  --pretty=format:'%C(yellow)commit %h%C(auto)%d%n%C(cyan)Author:%Creset %aN %C(dim white)<%aE>%n%C(cyan)Date:%Creset %C(dim white)%ad (%ar)%n%s%n' \
  --date=format:'%b %d %Y %H:%M:%S %z'
```

Ya.. thats a long one. Feel free to check out all the [formatting options](https://git-scm.com/docs/pretty-formats) Git provides.

Basically, this command displays an ASCII-art commit graph, complete with information about the commit and author. Heres a screenshot of it in action in that same Raider Robotics codebase:

![Git Tree in action](/images/posts/git-aliases/tree.png)

## Branch Overview

When working in a large team, its rather easy to loose track of other people's branch names.

To help with that, I've aliased this command as `git branches`:

```sh
git branch -a -l -vv
```

Continuing to use robotics codebases as an example, here is the output of this command:

![Git Branches in action](/images/posts/git-aliases/branches.png)

## Hot Files

This one is more out of curiosity than anything else. Sometimes I want to know what files are changed the most often.

I have this command aliased as `git lscommits`:

```sh
! ( echo -e "Commits\tFile" && git log --pretty=format: --name-only | sed '/^$/d' | sort | uniq -c | sort -g -r ) | less
```

See that exclamation mark at the start? Git aliases can actually be bound to arbitrary shell commands, not just other Git commands. This is a great way to make a command that does something Git can't do on its own.

Switching up my example repository, heres the output of this command in the [bird](https://gitlab.nic.cz/labs/bird) repository:

![Git lscommits in action](/images/posts/git-aliases/lscommits.png)

## Small but Mighty

These last two are by far my most used, and simultaneously the most boring aliases.

- `git aa` is aliased to `git add .` (aka: "add all")
- `git c` is aliased to `git commit`
  
:shrug: efficiency is efficiency.

### Bonus: Why isn't `git push` aliased as `git p`?

I wanted pushing my code upstream to remain a conscious decision, so I didn't want to make it *too* easy.
