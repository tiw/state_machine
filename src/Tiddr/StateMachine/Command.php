<?php
namespace Tiddr\StateMachine;

use AbstractEvent;

abstract class Command extends AbstractEvent
{
    abstract public function send($eventCode);
}
