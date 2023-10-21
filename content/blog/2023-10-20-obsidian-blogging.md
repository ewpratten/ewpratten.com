---
layout: page
title: Authoring Blog Posts with Obsidian
description: Trying a new way to write for this site
date: 2023-10-20
tags:
  - meta
  - random
  - product
draft: false
extra:
  auto_center_images: true
  excerpt: A post about authoring blog posts with Obsidian
  uses:
    - mermaid
aliases:
  - /blog/obsidian-blogging
---
It recently occurred to me that [Obsidian](https://obsidian.md) is capable of editing *any* type of markdown document store, not just its own note "Vaults". So, as a test I've been using it to interface with the source files that make up this website.

This post largely exists for the sake of figuring out how Obsidian behaves when forced into an environment that doesn't entirely agree with the "obsidian way of doing things". 

## My Initial Thoughts

***Obsidian is nice, and I would recommend it to a friend.***

I think the learning curve is pretty small as long as you already know some Markdown basics, which most people do weather they know it or not (cough, discord). 

After the initial step of figuring out where to place my Vault on disk, the interface is quite welcoming. Things render nicely, and basically every [GFM](https://github.github.com/gfm/) feature I use exists and functions properly.

Also, for anyone editing Markdown files with embedded YAML front matter, the "properties" editor is a godsend. I wish VSCode had something similar built-in.

![A screenshot of the properties for this post](/images/posts/obsidian-blogging/Pasted%20image%2020231021155654.png)

So ya, I'd totally recommend Obsidian as a Markdown editor and note-taking app.

## Obsidian For This Website

Here's where the story changes a bit.

My website (the one you are looking at right now) is a nearly-thousand-commit GIT repository full of hundreds of Markdown, HTML, and half-Markdown-half-HTML files, all tied together by [Zola](https://www.getzola.org/), some Python scripts, and CI tooling.

This is not at all something Obsidian can handle out of the box, although it did do a surprisingly good job trying.

While I did try re-writing my site's tooling to adapt to Obsidian, it turned out to be way more work than I think is justifiable for the reward. So, I chose to stick with Zola and see how far I can push Obsidian instead.

### Hot Reload

When typing in Obsidian, the file you are working on is automatically written to disk every word or two. Its nice to have constant updates streaming to disk because they trigger the filesystem watcher built into Zola.

This means that if I launch Zola with
```sh
zola serve --drafts --open
```
I'll get a browser window that automatically updates with new content as I type in Obsidian!

### Zola's "Extra" Field

As you can see in the image above, Zola makes use of a frontmatter field called `extra` to pass user-defined data from Markdown files to the templating engine.

For some reason, Obsidian doesn't like this. Clicking on the `extra` field won't even let me edit the body as a string, so I have to hop over to another editor to change the `extra` data. 

Not a huge pain, but something I wish worked natively.
### Internal Links

And now, for the hard part.

Zola and Obsidian disagree on how to link to internal documents.

When authoring a blog post with Zola, you store your posts with a path that looks like:
```
/content/blog/YYYY-MM-DD-slug-text.md
```
But, once the page is rendered, you'd just link to that page with:
```markdown
[check out my other post](/blog/slug-text)
```
It makes for pretty URLs (this page is `/blog/obsidian-blogging`) but Obsidian refuses to handle these paths at all. Instead, assuming that `/blog/slug-text` is the path to a yet-to-be created file (which it "helpfully" tries to create for me).

After digging through the docs for a while to make sure I wasn't missing some little-known setting to alias pages (no, the Aliasing feature doesn't fix this), I settled on trying to write a plugin.

#### Bait & Switch

To get Obsidian to handle Zola paths, I first had to get the two programs to meet as close to the "middle" of the problem as possible.

As it turns out, Zola also supports a second link scheme. To link to the path above, I can actually point things at:
```
@/blog/YYYY-MM-DD-slug-text.md
```

This is *very* close to the path format that Obsidian is looking for! Unfortunately, Obsidian doesn't support prefixes like this (instead assuming that `@` is a yet-to-be-created directory) and it also doesn't meaningfully support symlinks.

With Zola behaving as close to Obsidian's expectations as possible, the last step for me was to put together a small plugin to trick Obsidian into dropping the `@` prefix from paths.

My plugin works by hooking into Obsidian's `file-open` event, and re-writing the target path to a path without a prefix. This means that clicking on a link to `@/blog/YYYY-MM-DD-slug-text.md` will perform the following actions:

- Create `@/blog/YYYY-MM-DD-slug-text.md`
- Try to open the new file
- Open `/blog/YYYY-MM-DD-slug-text.md` instead
- Delete the created invalid file

There isn't an easy way to cancel the "this file doesn't exist" file creation event, so I just let Obsidian create the invalid file, then automatically clean it up after redirecting the tab open event to the correct path. Works well enough.

#### What About the Graph?

In my opinion, Obsidian's coolest feature is the "Graph view".

This is a special node graph that displays all inter-page links, tags, referenced files, and more. Its a very nice way to quickly visualise how documents relate to each other.

Unfortunately, the graph view also thinks that all my new `@` links are actually non-existent files. This means that my graph is full of dead ends that I know are actually real inter-file links.

To solve this, you guessed it, I wrote more plugin code!

Obsidian keeps an internal dictionary at `app.metadataCache.resolvedLinks` that describes all the discovered links between files.

The surprisingly easy way to get the graph view to behave was to just loop through that dict and strip all the `@` prefixes.

And now, with my linking trickery in place, I can get a nice graph of this website:

![This site's Obsidian graph](/images/posts/obsidian-blogging/Pasted%20image.png)

The green nodes are tags that I've applied to every post. The largest of which being `projects`.

## Conclusion

Obsidian is quite cool, and can actually play very nicely with a Zola-based website as long as you don't mind getting your hands a little dirty with some Javascript.

I'll keep using it to write blog posts for the foreseeable future, and maybe report back some day with whatever new tricks I learn.