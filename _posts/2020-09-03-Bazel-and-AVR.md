---
layout: page
title:  "Compiling AVR-C code with a modern build system"
description: "Bringing Bazel to 8-bit microcontrollers"
date:   2020-09-03 9:30:00 
tags: avr embedded bazel
excerpt: >-
    In this post, I cover my process of combining low level 
    programming with a very high level buildsystem.
redirect_from: 
 - /post/68dk02l4/
 - /68dk02l4/
---

*The GitHub repository for everything in this post can be found [here](https://github.com/Ewpratten/avr-for-bazel-demo)*

When writing software for an Arduino, or any other [AVR](https://en.wikipedia.org/wiki/AVR_microcontrollers)-based device, there are generally three main options. You can use the [Arduino IDE](https://www.arduino.cc/en/main/software) with [arduino-cli](https://github.com/arduino/arduino-cli), which is in my opinion, a clunky system that is great for high levels of abstraction and teaching people how to program, but lacks any kind of easy customization I am interested in. If you are looking for something more advanced (and works in your favorite IDE), you might look at [PlatformIO](https://platformio.org/). Finally, you can just program without any Hardware Abstraction Library at all, and use [avr-libc](https://www.nongnu.org/avr-libc/) along with [avr-gcc](https://www.microchip.com/mplab/avr-support/avr-and-arm-toolchains-c-compilers) and [avrdude](https://www.nongnu.org/avrdude/). 

This final option is my favorite by far, as it both forces me to think about how the system I am building is actually working "behind the scenes", and lets me do everything exactly the way I want. Unfortunately, when working directly with the AVR system libraries, the only buildsystem / tool that is available (without a lot of extra work) is [Make](https://en.wikipedia.org/wiki/Make_(software)). As somebody who spends 90% of his time working with higher-level buildsystems like [Gradle](https://gradle.org/) and [Bazel](https://bazel.build), I don't really like needing to deal with Makefiles, and manually handle dependency loading. This got me thinking. I have spent a lot of time working in Bazel, and cross-compiling for the armv7l platform via the [FRC Toolchain](https://launchpad.net/~wpilib/+archive/ubuntu/toolchain/). How hard can it be to add AVR Toolchain support to Bazel?

*The answer: Its pretty easy.*

The Bazel buildsystem allows users to define custom toolchains via the [toolchain](https://docs.bazel.build/versions/master/toolchains.html) rule. I am going to assume you have a decent understanding of the [Starlark](https://docs.bazel.build/versions/master/skylark/language.html) DSL, or at least Python3 (which Starlark is syntactically based on). To get started setting up a Bazel toolchain, I create empty `WORKSPACE` and `BUILD` files, along with a new bazel package named `toolchain` that has a bazel file inside for the toolchain settings, a `.bazelrc` file, and a package to store my test program.

```
/project
    |
    +-.bazelrc
    +-BUILD
    +-example
    |   |
    |   +-BUILD
    |   +-main.cc
    +-toolchain
    |   |
    |   +-BUILD
    |   +-avr.bzl
    +-WORKSPACE
```

I only learned about this recently, but you can use a `.bazelrc` file to define constant arguments to be passed to the buildsystem per-project. For this project, I am adding the following arguments to the config file to define which toolchain to use for which target:

```sh
# .bazelrc

# Use our custom-configured c++ toolchain.
build:avr_config --crosstool_top=//toolchain:avr_suite
build:avr_config --cpu=avr

# Use the default Bazel C++ toolchain to build the tools used during the
# build.
build:avr_config --host_crosstool_top=@bazel_tools//tools/cpp:toolchain
```

This config will default all builds to use a custom toolchain named `avr_suite`, and compile to target the `avr` CPU architecture. But, the final line will make sure to use the host's toolchain for compiling tools needed for Bazel itself (since we can't run AVR code on the host machine). With this, we now have everything needed to tell Bazel what to use when building, but we have not actually defined the toolcahin in the first place. This step comes in two parts. First, we need to define a toolchain implementation (this happens in `avr.bzl`). This implementation will define things like, where to find every tool on the host, which libc version to use, and what types of tools are provided by avr-gcc in the first place. We can start out by adding some `load` statements to the file to tell Bazel what functions we need to use.

```python
# toolchain/avr.bzl

load("@bazel_tools//tools/build_defs/cc:action_names.bzl", "ACTION_NAMES")
load(
    "@bazel_tools//tools/cpp:cc_toolchain_config_lib.bzl",
    "feature",
    "flag_group",
    "flag_set",
    "tool_path",
)
```

Once this is done, we need to define everything that this toolchain implementation can do. In this case avr-gcc can link executables, link dynamic libraries, and link a "nodeps" dynamic library.

```python
# ...

all_link_actions = [
    ACTION_NAMES.cpp_link_executable,
    ACTION_NAMES.cpp_link_dynamic_library,
    ACTION_NAMES.cpp_link_nodeps_dynamic_library,
]
```

We also need to tell Bazel where to find every tool. This may vary platform-to-platform, but with a standard avr-gcc install on Linux, the following should work just fine. Experienced Bazel users may wish to make use of Bazel's [`config_setting` and `select`](https://docs.bazel.build/versions/master/configurable-attributes.html) rules to allow the buildsystem to run on any type of host via a CLI flag.

```python
# ...

tool_paths = [
    tool_path(
        name = "gcc",
        path = "/usr/bin/avr-gcc",
    ),
    tool_path(
        name = "ld",
        path = "/usr/bin/avr-ld",
    ),
    tool_path(
        name = "ar",
        path = "/usr/bin/avr-ar",
    ),
    tool_path(
        name = "cpp",
        path = "/usr/bin/avr-g++",
    ),
    tool_path(
        name = "gcov",
        path = "/usr/bin/avr-gcov",
    ),
    tool_path(
        name = "nm",
        path = "/usr/bin/avr-nm",
    ),
    tool_path(
        name = "objdump",
        path = "/usr/bin/avr-objdump",
    ),
    tool_path(
        name = "strip",
        path = "/usr/bin/avr-strip",
    ),
]
```

Finally, we need to define the actual avr-toolchain implementation. This can be done via a simple function, and the creation of a new custom rule:

```python
# ...

def _avr_impl(ctx):
    features = [
        feature(
            name = "default_linker_flags",
            enabled = True,
            flag_sets = [
                flag_set(
                    actions = all_link_actions,
                    flag_groups = ([
                        flag_group(
                            flags = [
                                "-lstdc++",
                            ],
                        ),
                    ]),
                ),
            ],
        ),
    ]

    return cc_common.create_cc_toolchain_config_info(
        ctx = ctx,
        toolchain_identifier = "avr-toolchain",
        host_system_name = "local",
        target_system_name = "local",
        target_cpu = "avr",
        target_libc = "unknown",
        compiler = "avr-g++",
        abi_version = "unknown",
        abi_libc_version = "unknown",
        tool_paths = tool_paths,
        cxx_builtin_include_directories = [
            "/usr/lib/avr/include",
            "/usr/lib/gcc/avr/5.4.0/include"
        ],
    )

cc_toolchain_config = rule(
    attrs = {},
    provides = [CcToolchainConfigInfo],
    implementation = _avr_impl,
)
```

The `cxx_builtin_include_directories` argument is very important. This tells the compiler where to find the libc headers. **Both** paths are required, as the headers are split between two directories on Linux for some reason. We are now done with the `avr.bzl` file, and can add the following to the `toolchain` package's `BUILD` file to register our custom toolcahin as an official CC toolchain for Bazel to use:

```python
# toolchain/BUILD

load("@rules_cc//cc:defs.bzl", "cc_toolchain", "cc_toolchain_suite")
load(":avr.bzl", "cc_toolchain_config")

cc_toolchain_config(name = "avr_toolchain_config")

cc_toolchain_suite(
    name = "avr_suite",
    toolchains = {
        "avr": ":avr_toolchain",
    },
)

filegroup(name = "empty")

cc_toolchain(
    name = "avr_toolchain",
    all_files = ":empty",
    compiler_files = ":empty",
    dwp_files = ":empty",
    linker_files = ":empty",
    objcopy_files = ":empty",
    strip_files = ":empty",
    supports_param_files = 0,
    toolchain_config = ":avr_toolchain_config",
    toolchain_identifier = "avr-toolchain",
)
```

Thats it. Now, if we wanted to compile a simple blink program in AVR-C, we can add the following to `main.cc`:

```cpp
#ifndef F_CPU
#define F_CPU 16000000UL
#endif

#include <avr/io.h>
#include <util/delay.h>

int main(void)
{
  DDRC = 0xFF;
  while(1) {
    PORTC = 0xFF; 
    _delay_ms(1000); 
    PORTC= 0x00; 
    _delay_ms(1000); 
  }
}
```

To compile this, just define a `cc_binary` in the example `BUILD` file just like any normal Bazel program.

```python
# example/BUILD

load("@rules_cc//cc:defs.bzl", "cc_binary")

cc_binary(
    name = "example",
    srcs = ["main.cc"],
    # Add any needed cc options here for your specific platform
)
```

This can be compiled with `bazel build //example --config=avr_config`, and the output binary will be in the `bazel-bin` directory. You can run `avr-objcopy` and `avrdude` manually just like with a normal program.

Importantly, every normal Bazel function will still work. Want to include [EigenArduino](https://github.com/vancegroup/EigenArduino) in your project? Just import the [`rules_foreign_cc`](https://github.com/bazelbuild/rules_foreign_cc) ruleset and load the Eigen library like normal. You can also run unit tests through Bazel's regular [testing rules](https://docs.bazel.build/versions/master/be/c-cpp.html#cc_test). If you are a masochist, you could even try loading the [pybind11 rules](https://github.com/pybind/pybind11_bazel) and embedding a Python interpreter in your code.