---
layout: page
title:  "Programming a live robot"
description: "Living on the edge is an understatement"
date:   2019-11-20 10:04:00
tags: random frc
redirect_from: 
 - /post/e9gdhj90/
 - /e9gdhj90/
---

> *"So.. what if we could skip asking for driver inputs, and just have the robot operators control the bot through a commandline interface?"* 

This is exactly the kind of question I randomly ask while sitting in the middle of class, staring at my laptop. So, here is a post about my real-time programming adventure!

## Geting started

To get started, I needed a few things. Firstly, I have a laptop running [a Linux distribution](/about/#my-gear). This allows me to use [SSH](https://en.wikipedia.org/wiki/Secure_Shell) and [SCP](https://en.wikipedia.org/wiki/Secure_copy). There are Windows versions of both of these programs, but I find the "linux experience" easier to use. Secondly, I have grabbed one of [5024](https://www.thebluealliance.com/team/5024)'s [robots](https://cs.5024.ca/webdocs/docs/robots) to be subjected to my experiment. The components I care about are: 

 - A RoboRIO running 2019v12 firmware
 - 2 [TalonSRX](https://www.ctr-electronics.com/talon-srx.html) motor controllers 
 - An FRC router

Most importantly, the RoboRIO has [RobotPy](https://robotpy.readthedocs.io/en/stable/install/robot.html#install-robotpy) and the [CTRE Libraries](https://robotpy.readthedocs.io/en/stable/install/ctre.html) installed.

### SSH connection

To get some code running on the robot, we must first connect to it via SSH. Depending on your connection to the RoboRIO, this step may be different. Generally, the following command will work just fine to connect (assuming your computer has an [mDNS](https://en.wikipedia.org/wiki/Multicast_DNS) service):

```sh
ssh admin@roborio-<team>-frc.local
```

If you have issues, try one of the following addresses instead:

```
roborio-<team>-FRC
roborio-<team>-FRC.lan
roborio-<team>-FRC.frc-field.local
10.TE.AM.2
172.22.11.2 # Only works on a USB connection
```

If you are asked for a password, and have not set one, press <kbd>Enter</kbd> 3 times (Don't ask why.. this just works).

## REPL-based control

If you have seen my work before, you'll know that I use Python for basically everything. This project is no exception. Conveniently, the RoboRIO is a linux-based device, and can run a Python3 [REPL](https://en.wikipedia.org/wiki/Read%E2%80%93eval%E2%80%93print_loop). This allows real-time robot programming using a REPL via SSH. 

WPILib requires a robot class to act as a "callback" for robot actions. My idea was to build a special robot class with static methods to allow me to start it, then use the REPL to interact with some control methods (like `setSpeed` and `stop`).

After connecting to the robot via SSH, a Python REPL can be started by running `python3`. If there is already robot code running, it will be automatically killed in the next step. 

With Python running, we will need 2 libraries imported. `wpilib` and `ctre`. When importing `wpilib` a message may appear to notify you that the old robot code has been stopped.

```python
>>> import wpilib
Killing previously running FRC program...
FRC pid 1445 did not die within 0ms. Force killing with kill -9
>>> import ctre
```
Keep in mind, this is a REPL. Lines that start with `>>>` or `...` are *user input*. Everything else is produced by code.

Next, we need to write a little code to get the robot operational. To save time, I wrote this "library" to do most of the work for me. Just save this as `rtrbt.py` somewhere, then use SCP to copy it to `/home/lvuser/rtrbt.py`.

```python
# RealTime FRC Robot control helper
# By: Evan Pratten <ewpratten>

# Import normal robot stuff
import wpilib
import ctre

# Handle WPI trickery
try:
    from unittest.mock import patch
except ImportError:
    from mock import patch
import sys
from threading import Thread


## Internal methods ##
_controllers = []
_thread: Thread


class _RTRobot(wpilib.TimedRobot):

    def robotInit(self):

        # Create motors
        _controllers.append(ctre.WPI_TalonSRX(1))
        _controllers.append(ctre.WPI_TalonSRX(2))

        # Set safe modes
        _controllers[0].setSafetyEnabled(False)
        _controllers[1].setSafetyEnabled(False)



def _start():
    # Handle fake args
    args = ["run", "run"]
    with patch.object(sys, "argv", args):
        print(sys.argv)
        wpilib.run(_RTRobot)

## Utils ##


def startRobot():
    """ Start the robot code """
    global _thread
    _thread = Thread(target=_start)
    _thread.start()


def setMotor(id, speed):
    """ Set a motor speed """
    _controllers[id].set(speed)

def arcadeDrive(speed, rotation):
    """ Control the robot with arcade inputs """
    
    l = speed + rotation
    r = speed - rotation

    setMotor(0, l)
    setMotor(1, r)
```

The idea is to create a simple robot program with global hooks into the motor controllers. Python's mocking tools are used to fake commandline arguments to trick robotpy into thinking this script is being run via the RIO's robotCommand.

Once this script has been placed on the robot, SSH back in as `lvuser` (not `admin`), and run `python3`. If using `rtrbt.py`, the imports mentioned above are handled for you. To start the robot, just run the following:

```python
>>> from rtrbt import *
>>> startRobot()
```

WPILib will dump some logs into the terminal (and probably some spam) from it's own thread. Don't worry if you can't see the REPL prompt. It's probably just hidden due to the use of multiple threads in the same shell. Pressing <kbd>Enter</kbd> should show it again.

I added 2 functions for controlling motors. The first, `setMotor`, will set either the left (0), or right (1) motor to the specified speed. `arcadeDrive` will allow you to specify a speed and rotational force for the robot's drivetrain.

To kill the code and exit, press <kbd>CTRL</kbd> + <kbd>D</kbd> then <kbd>CTRL</kbd> + <kbd>C</kbd>.

Here is an example where I start the bot, then tell it to drive forward, then kill the left motor:
```python
Python 3.6.8 (default, Oct  7 2019, 12:59:55) 
[GCC 8.3.0] on linux
Type "help", "copyright", "credits" or "license" for more information.
>>> from rtrbt import *
>>> startRobot()
['run', 'run']
17:53:46:472 INFO    : wpilib              : WPILib version 2019.2.3
17:53:46:473 INFO    : wpilib              : HAL base version 2019.2.3; 
17:53:46:473 INFO    : wpilib              : robotpy-ctre version 2019.3.2
17:53:46:473 INFO    : wpilib              : robotpy-cscore version 2019.1.0
17:53:46:473 INFO    : faulthandler        : registered SIGUSR2 for PID 5447
17:53:46:474 INFO    : nt                  : NetworkTables initialized in server mode
17:53:46:497 INFO    : robot               : Default IterativeRobot.disabledInit() method... Override me!
17:53:46:498 INFO    : robot               : Default IterativeRobot.disabledPeriodic() method... Override me!
17:53:46:498 INFO    : robot               : Default IterativeRobot.robotPeriodic() method... Override me!
>>> 
>>> arcadeDrive(1.0, 0.0)
>>> setMotor(0, 0.0)
>>> 
^C
Exception ignored in: <module 'threading' from '/usr/lib/python3.6/threading.py'>
Traceback (most recent call last):
  File "/usr/lib/python3.6/threading.py", line 1294, in _shutdown
    t.join()
  File "/usr/lib/python3.6/threading.py", line 1056, in join
    self._wait_for_tstate_lock()
  File "/usr/lib/python3.6/threading.py", line 1072, in _wait_for_tstate_lock
    elif lock.acquire(block, timeout):
KeyboardInterrupt
```

The message at the end occurs when killing the code.

## Conclusion

I have no idea why any of this would be useful, or if it is even field legal.. It's just a fun project for a monday morning. 