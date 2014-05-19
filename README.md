[![Build status](http://travis-ci.org/tiw/state_machine.svg?branch=develop)](http://travis-ci.org/tiw/state_machine)

state_machine
=============

[中文介绍](https://github.com/tiw/state_machine/blob/master/README_cn.md)

A state machine implemetation in PHP.
This implementation is mostly inspired from "Domain Specifi Languages" of Martin Flower.

State Machine in essential is a collection of State, Event and Transistion.
```

+---------+               +---------+
|         |               |         |
|         +---------------+         |
+---------+               +---------+
    State1     Event        target

```


In this implementation the description of a state machine could be written in yml.

An example state machine could be like:

```
Name: door

Start: "dc"

Event:
- ["close door", "CD"]
- ["open door", "OD"]
- ["open window", "OW"]
- ["close window", "CW"]


State:
- "dc"
- "do"
- "wo"
- "wc"

Transition:
- ["dc", "OD", "do"]
- ["do", "OW", "wo"]
- ["wo", "CW", "wc"]
- ["do", "CD", "dc"]
```

In '''Event''' block all events are listed in the format [name, code]. Code
must be unique. This code is also used to drive the machine.

In '''State''' block all states are listed in the format "name". 

In '''Transition''' block all transitions are listed in the format [startState, event, targetState].


The sample use of state machine and controller could be see in the test directory.


Install per Composer
=============
```
{

    "require": {
        "tiddr/state_machine": "dev-master"
    }
}
```

Then just add
```
require_once __DIR__.'/vendor/autoload.php';
```


Example
===============
Take a look at the files under directory [tests](https://github.com/tiw/state_machine/tree/master/tests)

