---
layout: page
title: A Java development cheatsheet for my classmates
description: 'PROG10082: Reference Material'
date: 2022-03-15
tags: reference
draft: true
extra:
  excerpt: This document is written for my PROG10082 classmates as a quick reference
    for some Java concepts that were skipped over in the course.
  hidden: true
  auto_center_images: true
aliases:
- /blog/java-cheatsheet
---

This document is written for my PROG10082 classmates as a quick reference for some Java concepts that were skipped over in the course. This document may be updated as needed.

## VSCode Tips

*Remember*, you can open [intelisense](https://code.visualstudio.com/docs/editor/intellisense) by pressing <kbd>Ctrl</kbd> + <kbd>Space</kbd>. This is a super handy tool for auto-complete in your code no matter the language you are working in.

Typing the following then opening intelisense will give you some shorthand options for quickly typing common code. Just select the option you want with arrow keys, and press <kbd>Enter</kbd> to apply it.

| Shortcut | Description                                 |
|----------|---------------------------------------------|
| `syso`   | Automatically print `System.out.println();` |
| `syserr` | Automatically print `System.err.println();` |

## Upper and lowercase types

Many types you encounter in Java have an uppercase and lowercase variant, for example `int` and `Integer`. The difference is important. Here are the avalible uppercase variants of common types:

| Standard type | Uppercase type |
|---------------|----------------|
| `short`       | `Short`        |
| `char`        | `Character`    |
| `byte`        | `Byte`         |
| `int`         | `Integer`      |
| `double`      | `Double`       |
| `float`       | `Float`        |
| `long`        | `Long`         |

### Null and optional values

One uses of the uppercase variant of a type is to allow `null` values. In most languages, `null` means "Nothing". In Java, you can use `null` to indicate that a variable is not yet assigned a value. This can be checked with the `==` operator.

An example usage of this could be the following:

```java
// We want to ask for a number of records to read
Scanner input = new Scanner(System.in);
int recordCount = input.nextInt();

// Create a value to store the highest record in
// I have made this `null` so we can know if we didnt get a value
Integer highestRecord = null;

// Read the records
for (int i = 0; i < recordCount; i++) {
    // Read a value
    int record = input.nextInt();

    // If the value is higher than the current highest record
    // or the highest record is `null`, update the highest record
    if (highestRecord == null || record > highestRecord) {
        highestRecord = record;
    }
}

// We now have the highest record
if (highestRecord != null) {
    System.out.println("The highest record is " + highestRecord);
} else {
    System.out.println("No records were entered");
}
```

### Pass-by-reference

Another use of uppercase types is pass-by-reference. 

```java
// This is a function that will try to add `1` to a value
void addOne(int value) {
    value = value + 1;
}

void main(String ...args) {
    // We can make a value
    int myNumber = 1;

    // And pass it to a function. You would expect this to work
    addOne(myNumber);

    // But at this point, `myNumber` is still `1`
}
```

Now, we can switch to using uppercase types to make the function edit the value.

```java
// This is a function that will try to add `1` to a value
void addOne(Integer value) {
    value = value + 1;
}

void main(String ...args) {
    // We can make a value
    Integer myNumber = 1;

    // And pass it to a function. This will work, since we have an upprcase type
    addOne(myNumber);

    // At this point, `myNumber` is now `2`
}
```
