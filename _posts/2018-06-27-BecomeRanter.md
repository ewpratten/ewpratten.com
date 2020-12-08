---
layout: page
title:  "Using a python script to create devRant posts based on the style and content of another user"
description: "if/else ++"
date:   2018-06-27 18:32:00
tags: projects
---


Ok... The title is slightly wrong. There are actually 2 scripts.. Sorry about that.

This is a guide on installing and using the [BecomeRanter](https://github.com/Ewpratten/BecomeRanter) script.

## Getting dependancies
The scripts use Google's tensorflow library to do its "magic". So first, we should install Tensorflow's dependencies.

```
sudo apt install python3 python3-pip #change this command to fit your distro
pip3 install numpy
```
Then install Tensorflow
```
pip3 install tensorflow #for cpu processing
pip3 install tensorflow-gpu #for gpu processing
```

Next up, install the rest of the stuff:
```
pip3 install textgenrnn pandas keras
```

## Clone the repo
This is pretty simple. just make sure you have `git` installed and run
```
git clone https://github.com/Ewpratten/BecomeRanter.git
```

## Generate some rants with a .hdf5 file
As of the time of writing this, I have pre-generated some files for the two most popular ranters. These files can be found in `BecomeRanter/Checkpoint\ Files`.

Higher epoch numbers mean that they have had more time to train. The files with lower numbers are generally funnier.

To change the .hdf5 file you would like to use, open the file called `createsomerants.py` and change the variable called `input_file` to the path of your file. By default, the script generates from the `Linuxxx-epoch-90.hdf5` file.

Next, save that file and run the following in your terminal:
```
python3 createsomerants.py >> output.txt
```
It will not print the results out to the screen and put them in the file instead. 

To stop the script, press CTRL + C

## Create your own .hdf5 file
If you want to make your own hdf5 file, you just have to use the other script in the repo.

By default, you can just put all your text to train on in the `input.txt` file.

If you want to use a different file, or change the number of epochs, those variables can be found at the top of the `createhfd5frominput.py` file.

To start training, run:
```
python3 createhfd5frominput.py
```

A new hdf5 file will be generated in the same folder as the script

