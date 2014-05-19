状态机
==============
状态机描述了一组状态之间的转换关系，状态的转变是由事件引起的。状态改变后， 还可能
触发一些事件。

我的实现灵感来源于Martin Flower所著的Domain Specific Languages中的例子。大部分是
书中实现的PHP版本。


本实现中， 可以用一个yml文件来定义一个状态机:

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

例子中， Event块定义了状态机可能接受的所有事件，格式为[事件名称， 事件代码]。 
事件是由事件代码做标记的， 所以事件代码要唯一。

State模块定义了所有的状态， 格式为 "状态代码"。 代码也是唯一的。

Transition块定义了转换规则， 格式为 [起始状态,  事件, 目标状态]。 表述的意思为：
在"起始状态时"， 收到了"事件"， 状态变为"目标状态"。


通过composer安装
==============
在你的composer.json中添加下面的内容， 之后compose.phar install即可。

```
{

    "require": {
        "tiddr/state_machine": "dev-master"
    }
}
```

例子
===============
可以参看[tests](https://github.com/tiw/state_machine/tree/master/tests)目录下的测试， 有详细使用状态机的例子
