---
title: A quick introduction to OpenSCAD
description: Low-effort CAD like a programmer
date: 2024-01-10
tags:
  - cad
draft: true
extra:
  auto_center_images: true
aliases:
  - /blog/intro-to-openscad
---

So you want to use OpenSCAD...

I'm writing this post as a straight-to-the point guide to hand to people who need to make a basic shape or two for 3D printing. This guide assumes you already have OpenSCAD installed.

## Basic shapes

OpenSCAD uses code to describe 3D objects. When you open a new project, you'll see a layout that looks roughly like this:

![OpenSCAD](/images/posts/intro-to-openscad/scad-window.png)

On the left is a text editor, and the yellow area is the viewport. Writing (valid) code in the editor will modify the contents of the viewport. The viewport is also interactive, so you can click and drag to rotate the view.

### Cube

Lets start with some code, starting with a simple cube that has equal side lengths of 10mm:

```c
cube([10, 10, 10]);
```

Save your file to see the result.

![A cube with equal side lengths of 10mm](/images/posts/intro-to-openscad/cube-10mm.png)

### Rectangle

As you may have noticed, we typed `10` three times in the cube definition above. These three entries correspond to the three dimensions of our cube.

![](/images/posts/intro-to-openscad/axis-arguments.png)

Before we change these values, you should understand OpenSCAD's coordinate system. In OpenSCAD land, the X and Y axes make up the "ground plane", and the Z axis is the vertical axis. You can always reference the little axis gadget in the bottom left corner of the viewport to see which way is which.

![](/images/posts/intro-to-openscad/gadget.png)

Ok, with the coordinate system in mind, let's make a rectangle. We'll make it 20mm wide, 10mm deep, and 5mm tall:

```c
cube([20, 10, 5]);
```

![A rectangle with dimensions 20mm x 10mm x 5mm](/images/posts/intro-to-openscad/rectangle.png)

### Sphere

Spheres are pretty simple. We just need to specify the radius (in this case, 10mm):

```c
sphere(r = 10);
```

![A sphere](/images/posts/intro-to-openscad/sphere.png)

Notice how the sphere is a bit blocky? We can smooth it out by adding an `$fn` argument to the `sphere` function:

```c
sphere(r = 10, $fn=100);
```

The higher the `$fn` value, the smoother the sphere will be. I like to use 100 for most things. Heres the new result:

![A sphere with a higher $fn value](/images/posts/intro-to-openscad/smooth-sphere.png)

### Cylinder

The final shape I'll show off is the cylinder. It works much like a sphere, but takes a *height* argument in addition to the radius. Here's a cylinder with a radius of 10mm and a height of 20mm:

```c
cylinder(r = 10, h = 20);
```

![A cylinder](/images/posts/intro-to-openscad/cylinder.png)

Again (like the sphere), we can smooth out the cylinder by adding an `$fn` argument:

```c
cylinder(r = 10, h = 20, $fn=100);
```

![A cylinder with a higher $fn value](/images/posts/intro-to-openscad/smooth-cylinder.png)

## Transformations

Currently, we have only been able to pace shapes at the origin. This means that adding all of our shapes together into a single file would produce a result with all the meshes overlapping.

```c
// Cube
cube([10, 10, 10]);

// Rectangle
cube([20, 10, 5]);

// Sphere
sphere(r = 10, $fn=100);

// Cylinder
cylinder(r = 10, h = 20, $fn=100);
```

![All the shapes overlapping](/images/posts/intro-to-openscad/overlapping.png)

### Translation

Let's start by moving a shape away from the origin. The following code will place a cube (with side lengths of 10mm) 20mm away from the origin in the X direction:

```c
translate([20, 0, 0]) {
  cube([10, 10, 10]);
}
```

![A cube translated 20mm in the X direction](/images/posts/intro-to-openscad/translated-cube-x.png)

Notice what happens if we create two cubes, and translate them an equal distance in opposite directions:

```c
// Right Cube
translate([20, 0, 0]) {
  cube([10, 10, 10]);
}

// Left Cube
translate([-20, 0, 0]) {
  cube([10, 10, 10]);
}
```

![Two cubes translated in opposite directions](/images/posts/intro-to-openscad/unequal-translated-cubes.png)

They end up an unequal distance from the origin! This is because cubes (and rectangles) are not centered by default (see the cube or rectangle example above as a refresher). 

This means that in order to move that left cube the expected distance away from the origin, we would need to translate it by the original 20mm *plus* the cube's width (10mm):

![](/images/posts/intro-to-openscad/cube-distance.png)

```c
// Right Cube
translate([20, 0, 0]) {
  cube([10, 10, 10]);
}

// Left Cube
translate([-(20 + 10), 0, 0]) {
  cube([10, 10, 10]);
}
```

![Fixed cubes](/images/posts/intro-to-openscad/translated-cubes.png)

*Much better.*

Of course, we can also translate objects in all of the axes at once, like this:

```c
translate([5, 6, -15]) {
  cube([10, 10, 10]);
}
```

![A cube translated in all axes](/images/posts/intro-to-openscad/all-axis-translate.png)

### Rotation

OpenSCAD rotates objects *about an axis*. This means that to rotate a cube 45 degrees around the X axis, we could do this:

```c
rotate([45, 0, 0]) {
  cube([10, 10, 10]);
}
```

![A cube rotated 45 degrees around the X axis](/images/posts/intro-to-openscad/cube-rotate-x-45.png)

Heres an example where we center the cube at the origin, then rotate it 45 degrees in all axes:

```c
rotate([45, 45, 45]) {
  translate([-5, -5, -5]) {
    cube([10, 10, 10]);
  }
}
```

![A cube rotated 45 degrees in all axes](/images/posts/intro-to-openscad/cube-rotate-all.png)

As you can see, individual transformations can be nested together to create more complex transformations.

## Cutting & Joining

With some basic prerequisites out of the way, we can start to make more complex shapes. In this section, we'll cover how to cut and join shapes together.

### Difference

Lets make a sphere, and punch a rectangular hole out of it. 

We can do this with the `difference` function:

```c
difference() {
  sphere(r = 10, $fn=100);
  translate([-10, -5, -5]) {
    cube([20, 10, 10]);
  }
}
```

![A sphere with a rectangular hole cut out of it](/images/posts/intro-to-openscad/sphere-cube-cut.png)

The `difference` function can operate on multiple shapes. The first shape will always be the displayed shape, and all subsequent shapes will be subtracted from it.

### Union

What if we want to join two shapes together, then cut a third shape out of the result? 

Since the `difference` function only shows the first shape given to it, we need to make use of `union` to join multiple shapes together before cutting them.

```c
difference() {
  union() {
    sphere(r = 10, $fn=100);
    translate([-10, -5, -5]) {
      cube([20, 10, 10]);
    }
  }
  translate([0, 0, -5]) {
    cube([20, 20, 10]);
  }
}
```

![A complex shape](/images/posts/intro-to-openscad/broken-union.png)

See that weird overhang? Its a render artifact and not actually there in the shape.

To conserve on computation time, OpenSCAD doesn't do an awesome job of rendering really tight tolerances in the viewport. If we want to make it properly compute our shape, we'll have to press the <kbd>F6</kbd> key to render it.

![A complex shape](/images/posts/intro-to-openscad/union.png)

Much better.

## Next steps

At this point, you know everything you need in order to create most things you'd want to 3D print.

If you'd like to learn some more complex functions, check out the [OpenSCAD documentation](https://en.wikibooks.org/wiki/OpenSCAD_User_Manual).
