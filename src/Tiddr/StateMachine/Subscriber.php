<?php

namespace Tiddr\StateMachine;
use Tiddr\StateMachine\State;

/**
 * Class Subscriber
 * @package Tiddr\StateMachine
 */
abstract class Subscriber
{
    /**
     * @param State $newState
     * @return mixed
     */
    abstract public function handle(State $newState);
}
