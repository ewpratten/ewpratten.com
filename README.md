# RetryLife.ca

This repository contains the source code for [retrylife.ca](https://retrylife.ca), [@ewpratten](https://github.com/ewpratten)'s personal website.

## Development

To begin developing with this project, the following are required:

 - [VsCode](https://code.visualstudio.com/)
 - [Docker](https://www.docker.com/get-started)
 - [Remote Development plugin](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.vscode-remote-extensionpack)

### Starting up the workspace

Once the prerequisite programs are installed, clone this repo to your computer, and open it with VsCode. A small box will pop up in the lower right of your screen asking if you would like to re-open the project in a `devcontainer`. Once accepting that box, VsCode will reload, and start download all the dependancies and tools needed for development. This will take a few minutes, and there will be a progress bar in the lower right corner of the screen.

### The development process

Once you have loaded the workspace, press <kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>P</kbd>, type `run task`, and press <kbd>Enter</kbd>. This will open the project tasks menu. This is where you can interact with the build tools. The first time you load the project, you will need to select `Update dependencies`, and run it *without scanning task output*. This will load the needed Ruby libraries for the website.

Once done, open the tasks menu again, and start the server with the `Start local server` command. The website will now be live at [localhost:4000](http://localhost:4000).