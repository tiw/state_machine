<?php

class Controller
{
    private $_currentState;
    private $_stateMachine;
    private $_commandChannel;

    public function getCommandChannel()
    {
    }

    public function handle($eventCode)
    {
        if ($this->_currentState->hasTransition($eventCode)) {
            $this->_transitionTo($this->_currentState->targetState($eventCode));
        }
    }

    private function _transitionTo($target)
    {
        $this->_currentState = $target;
        $this->_currentState->executeActions($this->_commandChannel);
    }
}
