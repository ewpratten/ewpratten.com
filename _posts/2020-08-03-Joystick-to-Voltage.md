---
layout: page
title:  "Notes from FRC: Converting joystick data to tank-drive outputs"
description: "and making a tank-based robot's movements look natural"
date:   2020-08-03 09:07:00 
tags: frc
redirect_from: 
 - /post/6j49kjl4/
 - /6j49kjl4/
uses:
 - katex
---

I am starting a new little series here called "Notes from FRC". The idea is that I am going to write about what I have learned over the past three years of working (almost daily) with robots, and hopefully someone in the future will find them useful. The production source code I based this post around is available [here](https://github.com/frc5024/lib5k/blob/cd8ad407146b514cf857c1d8ac82ac8f3067812b/common_drive/src/main/java/io/github/frc5024/common_drive/calculation/DifferentialDriveCalculation.java).

Today's topic is quite simple, yet almost nobody has written anything about it. One of the very first problems presented to you when working with an FRC robot is: *"I have a robot, and I have a controller.. How do I make this thing move?"*. When I first started as a software developer at *Raider Robotics*, I decided to do some Googling, as I was sure someone would have at least written about this from the video-game industry.. Nope.

Let's lay out the problem. We have an application that needs to run some motors from a joystick input. Periodically, we are fed a vector of joystick data, $$\lbrack\begin{smallmatrix}T\\S\end{smallmatrix}\rbrack$$, where the values follow $$-1\leq \lbrack\begin{smallmatrix}T\\S\end{smallmatrix}\rbrack \leq 1$$. $$T$$ denotes our *throttle* input, and $$S$$ denotes something we at Raider Robotics call *"rotation"*. As you will see later on, rotation is not quite the correct word, but none of us can come up with anything better. Some teams, who use a steering wheel as input instead of a joystick, call this number *wheel*, which makes sense in their context. For every time an input is received, we must also produce an output, $$\lbrack\begin{smallmatrix}L\\R\end{smallmatrix}\rbrack$$, where the values follow $$-12\leq \lbrack\begin{smallmatrix}L\\R\end{smallmatrix}\rbrack \leq 12$$. $$\lbrack\begin{smallmatrix}L\\R\end{smallmatrix}\rbrack$$ is a vector containing *left* and *right* side motor output voltages respectively. Since we build [tank-drive](https://en.wikipedia.org/wiki/Tank_steering_systems)-style robots, when $$\lbrack\begin{smallmatrix}L\\R\end{smallmatrix}\rbrack = \lbrack\begin{smallmatrix}12\\12\end{smallmatrix}\rbrack$$, the robot would be moving forward at full speed, and when $$\lbrack\begin{smallmatrix}L\\R\end{smallmatrix}\rbrack = \lbrack\begin{smallmatrix}12\\0\end{smallmatrix}\rbrack$$, the robot would be pivoting right around the centre of its right track at full speed. The simplest way to convert a throttle and rotation input to left and right voltages is as follows:

$$ output = 12\cdot\begin{bmatrix}T + S \\ T - S\end{bmatrix} $$

This can be expressed in Python as:

```python
def computeMotorOutputs(T: float, S: float) -> Tuple[float, float]: 
    return (12 * (T + S), 12 * (T - S))
```

In FRC, we call this method "arcade drive", since the controls feel like you are driving a tank in an arcade game. Although this is very simple, there is a big drawback. At high values of $$T$$ and $$S$$, precision is lost. The best solution I have seen to this problem is to divide both $$L$$ and $$R$$ by the result of $$\max(abs(T), abs(S))$$ if the resulting value is greater than $$1.0$$. With this addition, the compute function now looks like this:

```python
def computeMotorOutputs(T: float, S: float) -> Tuple[float, float]: 
    # Calculate normal arcade values
    L = 12 * (T + S)
    R = 12 * (T - S)

    # Determine maximum output
    m = max(abs(T), abs(S))

    # Scale if needed
    if m > 1.0:
        L /= m
        R /= m

    return (L, R)
```

Perfect. Now we have solved the problem!

Of course, I'm not stopping here. Although arcade drive works, the result is not great. Small movements are very hard to get right, as a small movement on your controller will translate to a fairly large one on the robot (on an Xbox controller, we are fitting the entire range of 0m/s to 5m/s in about half an inch of joystick movement). This is generally tolerable when moving forward and turning, but when sitting still, it is near impossible to make precise rotational movements. Also, unless you have a lot of practice driving tank-drive vehicles, sharp turns are a big problem, as overshooting and skidding are very common. Wouldn't it be nice if we could have a robot that manuevers in graceful curves like a car? This is where the second method of joystick-to-voltage conversion comes in to play.

FRC teams like [254](https://www.team254.com/) and [971](https://frc971.org/) use variations of this calculation method called *"constant curvature drive"*. Curvature drive is only slightly different from arcade drive. Here is the new formula:

$$output = 12\cdot\begin{bmatrix}T + abs(T) \cdot S \\ T - abs(T) \cdot S\end{bmatrix}$$

If we also add the speed scaling from arcade drive, we are left with the following Python code:

```python
def computeMotorOutputs(T: float, S: float) -> Tuple[float, float]:
    # Calculate normal curvature values
    L = 12 * (T + abs(T) * S)
    R = 12 * (T - abs(T) * S)

    # Determine maximum output
    m = max(abs(T), abs(S))

    # Scale if needed
    if m > 1.0:
        L /= m
        R /= m

    return (L, R)

```

The $$S$$ component now changes the curvature of the robot's path, rather than the heading's rate of change. This makes the robot much more controllable at high speeds. There is one downside to this method though. As a tradeoff to making high-speed driving much more controllable, we have completely removed the robot's ability to turn when stopped. 

This is where the final drive method comes in to play. At Raider Robotics, we call it *"semi-constant curvature drive"*, and have been using it in gameplay with great success since 2019. Since we want to take the best parts of arcade drive and constant curvature drive, we came to the simple conclusion that we should just average the two methods. Doing this results in this new formula:

$$output = 12\cdot\begin{bmatrix}\frac{(T + abs(T) * S) + (T + S)}{2} \\ \frac{(T - abs(T) * S) + (T - S)}{2}\end{bmatrix}$$

And here is the associated Python code:


```python
def computeMotorOutputs(T: float, S: float) -> Tuple[float, float]:
    # Calculate semi-constant curvature values
    L = 12 * (((T + abs(T) * S) + (T + S)) / 2)
    R = 12 * (((T - abs(T) * S) + (T - S)) / 2)

    # Determine maximum output
    m = max(abs(T), abs(S))

    # Scale if needed
    if m > 1.0:
        L /= m
        R /= m

    return (L, R)
```

---

I hope someone will some day find this post helpful. I am working on a few more FRC-related posts about more advanced topics, and things I have learned through my adventures at Raider Robotics. If you would like to check out the code that powers all of this, take a look at our core software library: [Lib5K](https://github.com/frc5024/lib5k)