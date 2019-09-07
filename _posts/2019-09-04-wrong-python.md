---
layout: post
title:  "Doing Python OOP the wrong way"
description: "In the name of science!"
date:   2019-09-07 13:13:00
categories: projects random
---

If you know me, you probably know of the many weird things I do with python. Most recent of which being this [FizzBuzz](https://en.wikipedia.org/wiki/Fizz_buzz) implementation in one line of python code:
```python
_=[print("FizzBuzz"[_*_%3*4:8--_**4%5] or _) for _ in range(101)]
```

This installment of "weird things I do with python" will not focus on one-liners (that's going on my todo list though). But instead, playing with Python's classes and object system.

## A quick introduction to classes
Im going to assume that you, the reader, have some reasonable knowledge of how computers work, and OOP concepts. If you do not, there are [many great online resources](https://medium.com/swlh/5-free-object-oriented-programming-online-courses-for-programmers-156afd0a3a73) to help you out.

As a quick refresher, this is the Python syntax for a basic class:
```python
class MyClass:

    # This is the constructor. __init__ is an overridable python built-in
    def __init__(self, arg1: int):

        # Here we set the class' scoped my_number to arg1
        self.my_number = arg1
    
    def printMyNumber(self):
        print(self.my_number)
```

This is really just a fancy setter and getter. Here is some example usage:
```python
my_object = MyClass(10)
my_object.printMyNumber() # Prints 10
```

## Noticing something odd
Before reading the following, keep in mind that (as of now) I have not actually looked at the Python interpreter's source code enough to know about their memory system. The following is just an educated guess.

Looking at any python class, you may notice that **at least** 1 argument is required. `self` is used to access the class' data from itself. This is not present in most other languages I know, which means there might be something interesting happening behind the scenes. Here is a re-implementation of `MyClass` from above in java:
```java
public class MyClass {
    int my_int;

    public MyClass(int arg1){
        my_int = arg1;
    }

    public void printMyNumber(){
        System.out.println(my_int);
    }
}
```

Notice the fact that there is no `self`? Yet Java methods can still access class data.

## Implementing objects in a non-object oriented language
In a non-OOP language (like C), objects can be faked by creating [structures](https://en.wikipedia.org/wiki/Struct_(C_programming_language)) and some standard functions. These functions then take a pointer to their "parent" structure. Confusing? yes. But it works, and I see it used all over the place. Here a pseudocode example:
```
struct MyClass {
    int my_int; // Scpoed int
}

fn printMyNumber(MyClass* self){
    print(self.my_int);
}

```

`printMyNumber` takes a pointer to it's "parent class", called `self`. Look familiar? This is how Python works.

## Let's do some Python 
Alright.. Time for some "broken" Python. Here is yet another implementation of `MyClass`, except this time, each function is globally scoped:
```python

# Private, globally scoped functions
def _init_myclass(self, arg1: int):
    self.my_number = arg1

def _myclass_printMyNumber(self):
    print(self.my_number)


# struct-like class containing function pointers
class MyClass:

    __init__ = _init_myclass
    printMyNumber = _myclass_printMyNumber
    
```

This code will still function like a normal class. Unlike a regular class definition, the above code defines the constructor and `printMyNumber` methods in the global scope (marked as private with an underscore). A class is then created with function pointers to each of the global functions. This means that calling `MyClass.printMyNumber` will point to, and execute `_myclass_printMyNumber`. The interpreter still treats the underscore functions as members of `MyClass`, and passes the `self` argument along to them.

## Why?
I have absolutely no idea why this would ever be useful. If you think you should start doing this in your code, **don't**. It leads to very messy and confusing code, and is bad practice in just about every way. 

The point of this post is to show yet another instance of the Python interpreter saying "[idgaf](https://www.urbandictionary.com/define.php?term=idgaf)", and letting us have a little fun.