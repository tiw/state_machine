<?php

namespace Tiddr\StateMachine;

use Tiddr\StateMachine\State;
use Tiddr\StateMachine\Subscriber;

/**
 * Class Publisher
 * @package Tiddr\StateMachine
 */
class Publisher
{

    /**
     * @var Subscriber $_subscribers
     */
    private $_subscribers;

    /**
     * @param $stateName
     * @param $subscriber
     */
    public function register($stateName, $subscriber)
    {
        if(!isset($this->_subscribers[$stateName])) {
            $this->_subscribers[$stateName] = [];
        }
        if(!in_array($subscriber, $this->_subscribers[$stateName])) {
            $this->_subscribers[$stateName][] = $subscriber;
        }
    }

    /**
     * @param State $newState
     */
    public function publish(State $newState)
    {
        foreach($this->_subscribers[$newState->getName()] as $subscriber) {
            call_user_func($subscriber, $newState);
        }
    }
}
