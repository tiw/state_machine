<?php

class State
{
    /**
     * @var [Command] $_actions
     */
    private $_actions = [];
    private $_transitions = [];
    private $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function addTransition(Event $event, State $targetState)
    {
        $this->_transitions[$event->getCode()] =
            new Transition($this, $event, $targetState);
    }

    public function hasTransition($eventCode)
    {
        return in_array($eventCode, array_keys($this->getAllTargets()));
    }

    public function targetState($eventCode)
    {
        return $this->_transitions[$eventCode]->getTargetState();
    }


    public function executeActions($commandChannel)
    {
        foreach($this->_actions as $command) {
            $commandChannel->send($command->getCode());
        }
    }

    public function getAllTargets()
    {
        $target = [];
        foreach($this->_transitions as $code => $ts) {
            $target[] = $ts->getTargetState();
        }
        return $target;
    }
}
