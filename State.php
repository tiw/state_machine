<?php

class State
{
    private $_actions;
    private $_transitions;


    public function addTransition(Event $event, State $state)
    {
        $this->_transitions[] = [$event->getCode()];
    }
}
