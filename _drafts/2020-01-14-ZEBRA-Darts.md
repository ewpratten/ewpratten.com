---
layout: post
title:  "Interpolating motor control commands from Dart data"
description: "And other weird things to do with XY datasets"
date:   2020-01-14 20:13:00
categories: frc data
redirect_from: 
 - /post/eb3v140d/
 - /eb3v140d/
---

At some FRC events, [ZEBRA Technologies](https://www.zebra.com/us/en.html) places dart trackers for their [MotionWorks](https://www.zebra.com/us/en/solutions/intelligent-edge-solutions/rtls.html) system on robots. They then provide real-time motion tracking data for all bots on the field. I got my hands on a few data archives from various events in 2019 that used the darts. Here is a little post about what I have been able to do with this data.

## The data
For this post, I will be working with data from [Chezy Champs 2019](https://chezychamps.com/). I recived the tracking data in the following CSV format:

```csv
X position (Feet), Y position (Feet), UNIX epoch time (UTC)
```

## Data analysis 

I wrote a little parser that converts the CSV data to pose data. A pose is a vector containing the following field-absolute components:

```c++
struct Pose {
    double x;
    double y;
    double theta;
}
```

While we are at it, Ill define a "Transpose", which is like a pose, but relative to other poses, and a "ChassisSpeed" vector:

```c++
struct ChassisSpeed {
    double left;
    double right;
}

class Transpose {
    private:
        double x;
        double y;
        double theta;

    public:
        ChassisSpeed fromTranspose();
}
```

### Converting a difference to a Transpose

The only data we can directly read from the Dart data is poses over time (all poses have an angle of 0 degrees). To convert these to Transposes, we need to do a little math. Basically, we can take two poses, then calculate their differences:

```python
# Find the differences in coords
dx: float = now.x - last.x
dy: float = now.y - last.y

# Calculate a heading from translation
theta: float = atan2(dx, dy)
```

Now, with this data, we can build a Transpose out of any pair of data points.

### Converting a transpose to a ChassisSpeed

To be completely honest, I originally had no idea what I was going to use this data for, but ended up deciding to try to reconstruct motor data from the position data. This is just a form of [Inverse Kinematics](https://en.wikipedia.org/wiki/Inverse_kinematics).

To do this, all we need is a little math:

```java
ChassisSpeed fromTranspose(){
    double delta = TRACK_WIDTH * this.theta / 2 * 1.0469745223;
    return (new ChassisSpeed(this.x - deltaV, this.x + deltaV);
}
```

This will calculate the heading difference between 0,0 and the transpose, then apply that to the X vector as a wheel velocity. `TRACK_WIDTH` is the width of the robot drivebase in inches (I used `25.4` because that is team [254](https://www.thebluealliance.com/team/254)'s track width)

#### Chassis speeds over time

Here is a little graph of the calculated chassis speeds over time. (Keeping in mind that inaccuracies in the Dart system cause some "drift")

![Chassis Speeds](/assets/images/chassis-speeds.png)

### Extrapolating further

