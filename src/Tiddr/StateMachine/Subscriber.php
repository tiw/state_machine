<?php

namespace Tiddr\StateMachine;
use Tiddr\StateMachine\State;

abstract class Subscriber
{
    abstract public function handle(State $newState);
}
