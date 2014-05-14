<?php

class State
{
    private $_actions;
    private $_transitions;


    public function addTransition(Event $event, State $targetState)
    {
        $this->_transitions[] = [
            $event->getCode() => new Transition($this, $event, $targetState)
        ];
    }

    public function getAllTargets()
    {
        $target = [];
        foreach($this->_transitions as $ts) {
            $target[] = $ts->getTargetState();
        }
        return $target;
    }
}
