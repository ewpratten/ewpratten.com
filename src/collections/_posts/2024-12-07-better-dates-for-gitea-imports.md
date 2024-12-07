---
layout: default
title: Better date handling for projects migrated to Gitea
description: Fussing with Gitea's database to fix sorting
date: 2024-12-07
draft: false
---

Gitea is an easy-to-use self-hosted Git service that I like using for personal projects.

One of its most interesting features is the ability to 1-click import projects from other self-hosted and SAAS services like GitHub, GitLab, and Bitbucket.
These imports (called migrations) are super straightforward and work quite well.

*..except*

The one thing that really bugs me about Gitea's migration system is that it doesn't preserve the original project's creation and last-modified dates.
This means that importing a 4-year-old project from GitHub will make it look like it was created today in the Gitea UI.

Luckily, Gitea is just a wrapper around a database and the filesystem, so you can tweak the underlying data to make it use the correct dates!

## Obtaining the original dates

I have played around with various methods of obtaining the "correct" dates for my projects, and have generally settled on these two `git` commands. (Feel free to try them in a project of your own!)

```sh
# Obtaining the hash and timestamp of the repo's first commit
$ git log --reverse --pretty='format:%H %ct' | head -1
163e0f674a53b76353f6205af120bef20d97f4a7 1503859929
```


```sh
# Obtaining the hash and timestamp of the repo's most recent commit
$ git for-each-ref --sort=-authordate --count=1 --format='%(objectname) %(authordate:unix)'
dbd2c5669b0885e8040a8e38ae489e3f7eb00662 1733591587
```

## How Gitea stores timestamps

*Note: I am only focusing on Gitea instances that use SQLite as their database backend. Tweaks will be required for other databases.*

Gitea keeps a handy table in its underlying database called `repository`. Here's a sample of what it looks like in my personal Gitea instance:

```sql
.mode table

SELECT owner_name, lower_name, created_unix, updated_unix, archived_unix 
FROM repository WHERE owner_name = 'evan' LIMIT 3;

+------------+---------------+--------------+--------------+---------------+
| owner_name |  lower_name   | created_unix | updated_unix | archived_unix |
+------------+---------------+--------------+--------------+---------------+
| evan       | ewpratten.com | 1732811300   | 1733591643   | 0             |
| evan       | raylib-ffi    | 1733155443   | 1733155464   | 0             |
| evan       | ewconfig      | 1732812196   | 1733244092   | 0             |
+------------+---------------+--------------+--------------+---------------+
```

There are many more columns in this table, but these are the interesting ones, the timestamps that directly drive the web UI.

The `owner_name` and `lower_name` columns can be concatenated together to obtain the path to the repository on disk.
This allows us to automate the process of updating the timestamps for all repositories in the database by:

1. Iterating through the table to find repo paths
2. Collecting a pair of timestamps from each repo on disk through the above `git` commands
3. Returning to the table and re-writing the timestamps to the real values

A tiny bit more logic can also be added to make sure the "archive" timestamp lines up with the last commit date if desired.

## Automated date correction

This post was mostly written as a reminder to my future self. I have already needed to do this a few times, and have written multiple (now lost) scripts to do so each time.

So, to tie everything together and to save my future self some work, I've built this little script:

```python
#! /usr/bin/env python3
import argparse
import sqlite3 
import subprocess
from pathlib import Path

if __name__ == "__main__":
    ap = argparse.ArgumentParser()
    ap.add_argument("database", help="Path to the Gitea SQLite database", type=Path)
    ap.add_argument("repo_root", help="Path to Gitea's repository directory", type=Path)
    ap.add_argument("--rewrite-archives", help="Update the archive timestamp to match the last commit", action="store_true")
    args = ap.parse_args()

    # Attempt to open the database
    db_connection = sqlite3.connect(args.database)
    db_cursor = db_connection.cursor()

    # Process all know repositories
    for repo in db_cursor.execute("SELECT owner_name, lower_name, archived_unix FROM repository").fetchall():
        repo_path = args.repo_root / repo[0] / f"{repo[1]}.git"

        if not repo_path.exists():
            print(f"Skipping {repo_path} as it does not exist")
            continue

        # Obtain the first commit timestamp
        # Some versions of git 
        first_commit = subprocess.run(["git", "-C", repo_path.as_posix(), "log", "--reverse", "--pretty=format:%ct"], capture_output=True, text=True).stdout.splitlines()[0]
        first_commit_timestamp = int(first_commit)

        # Obtain the last commit timestamp
        last_commit = subprocess.run(["git", "-C", repo_path.as_posix(), "for-each-ref", "--sort=-authordate", "--count=1", "--format=%(authordate:unix)"], capture_output=True, text=True)
        last_commit_timestamp = int(last_commit.stdout.strip())

        # Update the database with the new timestamps
        db_cursor.execute("UPDATE repository SET created_unix = ?, updated_unix = ? WHERE owner_name = ? AND lower_name = ?", (first_commit_timestamp, last_commit_timestamp, repo[0], repo[1]))

        # If we are rewriting the archive timestamp, copy the "updated" timestamp to the "archived" timestamp
        # Note: 0 means "not archived"
        if args.rewrite_archives and repo[2] > 0:
            db_cursor.execute("UPDATE repository SET archived_unix = ? WHERE owner_name = ? AND lower_name = ?", (last_commit_timestamp, repo[0], repo[1]))

    # Commit the changes to the database
    db_connection.commit()
    db_connection.close()
```

Usage is as follows:

```text
$ ./update-timestamps.py --help
usage: update-timestamps.py [-h] [--rewrite-archives] database repo_root

positional arguments:
  database            Path to the Gitea SQLite database
  repo_root           Path to Gitea's repository directory

options:
  -h, --help          show this help message and exit
  --rewrite-archives  Update the archive timestamp to match the last commit
```

Testing this script with the sampling of repos shown above, I get these results:

```sql
.mode table

SELECT owner_name, lower_name, created_unix, updated_unix, archived_unix 
FROM repository WHERE owner_name = 'evan' LIMIT 3;

+------------+---------------+--------------+--------------+---------------+
| owner_name |  lower_name   | created_unix | updated_unix | archived_unix |
+------------+---------------+--------------+--------------+---------------+
| evan       | ewpratten.com | 1503859929   | 1733591587   | 0             |
| evan       | raylib-ffi    | 1670596072   | 1732716018   | 0             |
| evan       | ewconfig      | 1508951380   | 1733244087   | 0             |
+------------+---------------+--------------+--------------+---------------+
```