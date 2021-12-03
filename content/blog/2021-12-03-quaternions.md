---
layout: page
title: "A rusty guide to quaternions" 
description: "Fast and efficient 3D object manipulation"
date:   2021-12-03
tags: reference
draft: true
extra:
  uses_katex: true
---

The running joke in the graphics programming world is that nobody understands quaternions. These big scary math-filled types are always <em>someone else's problem</em>. While quaternions <del>are</del> may be scary, they serve an important purpose in the world of computing as they

- Don't suffer from [Gimbal Lock](https://en.wikipedia.org/wiki/Gimbal_lock)
- Are extremely efficient to work with computationally

![Quaternion Meme](/images/posts/quaternions/quaternion_meme.png)

> Gimbal lock is the loss of one degree of freedom in a three-dimensional, three-gimbal mechanism that occurs when the axes of two of the three gimbals are driven into a parallel configuration, "locking" the system into rotation in a degenerate two-dimensional space.<br>
> \[[Wikipedia](https://en.wikipedia.org/wiki/Gimbal_lock)\]

Over the past few years, I have made it my personal goal to work with quaternions in my code as much as possible whenever applicable. This choice was partly to help me better understand quaternions, and partly to simply set my code apart from others due to the use of <em>"fancy math stuff"</em>.

## What is this post for?

My goal here in writing about quaternions is to help explain the concept to other programmers in a fairly approachable way. 

This post will prefer code snippets over complicated math, and will leave out some details not relavant to the normal use of quaternions in code. For a more in-depth look at quaternions, there are many complicated papers to be read on the topic, and they are all one easy Google search away. 

As a final note before I get started, all code snippets will be centered around the Rust programming language (although easily translatable to anything else). I'll also be making heavy use of [Nalgebra](https://nalgebra.org/) by [Dimforge](https://dimforge.com/) for the actual mathematical implementations.

## Prerequisite knowledge: Vectors

Most programmers already have a good grasp on at least the basics of vectors, but I was learning about quaternions in 10th grade, and had yet to even take a math class that covered them. Due to this, I'll briefly cover vectors here as a refresher, and in case anyone else is in a similar situation to younger me.

N-dimensional vectors are expressed as a list of `N` real numbers. This is simply a point in space, except we tend to visualize vectors as arrows, and points as...well...points. All vectors start at the origin ($\big[\begin{smallmatrix}0 \\\\ 0\end{smallmatrix}\big]$ in $2$ dimensions for example) and "point to" the coordinate denoted by the vector.

Importantly, vectors cannot start anywhere other than the origin. If you want to do that, you'd need to express a vector as two seperate vectors (a start, and an end). This definition is a <em>line segment</em>.

```rust
struct LineSegment2D {
    pub start: Vector2<f32>,
    pub end: Vector2<f32>
}
```

With this data structure, we could define a "vector" (line) starting at $\big[\begin{smallmatrix}1 \\\\ 2\end{smallmatrix}\big]$ and ending at $\big[\begin{smallmatrix}3 \\\\ 4\end{smallmatrix}\big]$ as:

```rust
let line = LineSegment2D {
    start: Vector2::new(1.0, 2.0),
    end: Vector2::new(3.0, 4.0),
};
```


