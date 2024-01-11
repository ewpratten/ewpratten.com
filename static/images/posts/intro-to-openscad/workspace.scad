// Cube
cube([10, 10, 10]);

// Rectangle
cube([20, 10, 5]);

// Sphere
sphere(r = 10, $fn=100);

// Cylinder
cylinder(r = 10, h = 20, $fn=100);

// Translated Cube
translate([20, 0, 0]) {
  cube([10, 10, 10]);
}

// Dual translated cubes
union(){
    // Right Cube
    translate([20, 0, 0]) {
      cube([10, 10, 10]);
    }

    // Left Cube
    translate([-20, 0, 0]) {
      cube([10, 10, 10]);
    }
}

// Fixed dual cubes
union(){
    // Right Cube
    translate([20, 0, 0]) {
      cube([10, 10, 10]);
    }

    // Left Cube
    translate([-(20 + 10), 0, 0]) {
      cube([10, 10, 10]);
    }
}

// All axes
translate([5, 6, -15]) {
  cube([10, 10, 10]);
}

// Rotation X
rotate([45, 0, 0]) {
  cube([10, 10, 10]);
}

// All rotation
rotate([45, 45, 45]) {
  translate([-5, -5, -5]) {
    cube([10, 10, 10]);
  }
}

// Sphere cut
difference() {
  sphere(r = 10, $fn=100);
  translate([-10, -5, -5]) {
    cube([20, 10, 10]);
  }
}

// Difference Union
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