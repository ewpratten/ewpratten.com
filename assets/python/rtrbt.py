# RealTime FRC Robot control helper
# By: Evan Pratten <ewpratten>

# Import norma robot stuff
import wpilib
import ctre

# Handle WPI trickery
try:
    from unittest.mock import patch
except ImportError:
    from mock import patch
import sys
from threading import Thread


## Internal mathods ##
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