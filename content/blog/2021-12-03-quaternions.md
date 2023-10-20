---
layout: page
title: A rusty guide to quaternions
description: Fast and efficient 3D object manipulation
date: 2021-12-03
tags:
  - reference
  - math
draft: false
extra:
  uses:
    - katex
  excerpt: This post is an overview of Quaternions for Rust programmers, and anyone willing to learn.
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

## An intro to quaternions

> In mathematics, the quaternion number system extends the complex numbers. Quaternions were first described by Irish mathematician William Rowan Hamilton in 1843 and applied to mechanics in three-dimensional space.<br>
> \[[Wikipedia](https://en.wikipedia.org/wiki/Quaternion)\]

Quaternions are essentially 4-dimensional numbers consisting of one real, and three imaginary components. They are expressed with the components $w$, $i$, $j$, and $k$. So far, this sounds pretty scary, but it is a lot simpler to deal with when you remember mathematicians like overcomplicating their variable names :wink:

The following is a slightly modified version of the quaternion expression, made to express the concept in a more computer-oriented manner:

$$
q = w + x \mathbf{i} + y \mathbf{j} + z \mathbf{k}
$$

$i$, $j$, and $k$ can be interpreted as unit-vectors pointing along the three spatial axes.

You may notice the quaternion expression is split into two distinct parts: the <em>real</em> and <em>vector</em> parts:

$$
q = \overbrace{w}^{\text{real}} + \overbrace{x \mathbf{i} + y \mathbf{j} + z \mathbf{k}}^{\text{vector}}
$$

The real part is a single <em>real number</em>, and the vector part is simply a 3-dimensional vector ($x,y,z$) with some pesky imaginary basis vectors attached to the components ($i,j,k$). From a programming standpoint, we can simply ignore the imaginary numbers, and treat a quaternion as a structure similar to the following:

```rust
// Don't actually implement a quaternion this way
// This is just to show how I imagine them when working with them
struct Quaternion {
    pub real: f32,
    pub vector: Vector3<f32>
}
```

An important fact to keep in mind is that quaternions can <em>and will</em> be found in their normalized form, where all the coefficients (real and vector) are values between $-1$ and $1$.

<div style="text-align:center;">
<img src="/images/posts/quaternions/quat_vec3.png" style="max-width:300px;">
</div>

## Quaternions are transformations

For the next few sections, there is a single important detail:

<em>Quaternions are transformations</em>

Like everything else in this post, this statement is not true for all applications of quaternions, but is true for the two core uses in graphics programming: <em>rotations</em> and <em>translations</em>.

You can essentially treat a quaternion as an action applied to a 3-dimensional vector. For example, a quaternion that rotates $90^{\circ}$ around the $z$ axis, applied to the vector $\big[\begin{smallmatrix}1 \\\\ 0 \\\\ 0\end{smallmatrix}\big]$ would produce: $\big[\begin{smallmatrix}0 \\\\ -1 \\\\ 0\end{smallmatrix}\big]$. Similairly, a quaternion could move a vector to a new origin (turning it into a line segment). We will get to the second transformation in a bit.

### Transforms: expressed mathematically

To transform any vector by a quaternion ($q$ in this case), you must first turn the vector into a <em>pure quaternion</em> (in this case, $k$):

$$
\begin{aligned}
v &= \begin{bmatrix} 1 \\\\ 2 \\\\ 3 \end{bmatrix} \\\\
k &= 0 + 1 \mathbf{i} + 2 \mathbf{j} + 3 \mathbf {k}
\end{aligned}
$$

As you can see, a pure quaternion is a quaternion with a real part of $0$ and a vector part equal to the vector it is being made of. 

Next, you need the conjugate of the quaternion (which is called $q^\*$). The following are both the expressions for a quaternion, and a conjugate quaternion:

$$
\begin{aligned}
q &= w + x \mathbf{i} + y \mathbf{j} + z \mathbf{k} \\\\
q^\* &= w - x \mathbf{i} - y \mathbf{j} - z \mathbf{k}
\end{aligned}
$$

With all the required parts, the transformed vector ($p$) is equal to:

$$
p = q^\*kq
$$

<strong>NOTE:</strong> Quaternion multiplicaiton is [noncommutative](https://en.wikipedia.org/wiki/Commutative_property), meaning that the order you multiply things <em>matters</em>. This is not normal multiplication.

<div style="text-align:center;">
<img src="/images/posts/quaternions/quat_mul.jpg">
</div>

### Expressing a rotation with a quaternion

An extremely intuitive way to work with rotations in general, and especially in the quaternion world, is via something called an <em>axis-angle</em>.

The name is quite self-explanitory, but to describe it better, an axis-angle is made up of a 3-dimensional unit vector pointing in an arbitrary direction, and a single angle (in radians) describing the clockwise twist around that axis.

Conveniently, as I pointed out earlier, quaternions also work in the same way, with a $w$ value (essentially the angle), and a vector part (essentially the axis). In rust, we can construct a quaternion from an axis-angle as follows:

```rust
// In this example, we will describe a rotation of
// 90 degrees around the positive Z axis
let axis = Vector3::z_axis();
let angle = std::f32::consts::FRAC_PI_2;

let quaternion = UnitQuaternion::from_axis_angle(&axis, angle);
```

Now, if we wanted to rotate the vector $\big[\begin{smallmatrix}1 \\\\ 2 \\\\ 3\end{smallmatrix}\big]$ by `quaternion`, we could simply write:

```rust
let rotated_vector = quaternion.transform_vector(&Vector3::new(1.0, 2.0, 3.0));
```

### Expressing a translation <em>and</em> a rotation with a quaternion

## Further "reading"

So, do you know what you are doing when it comes to quaternions now?

<em>No?</em>

Well, I can't say I'm surprised. Now that you have learned the basics of quaternions, I recommend working through [Grant Sanderson](https://www.3blue1brown.com/)'s videos on the topic:

<iframe width="100%" height="426" src="https://www.youtube.com/embed/zjMuIxRvygQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<br><br>
<em>ya, I'm not sure why I decided to fill this with memes either...</em>
