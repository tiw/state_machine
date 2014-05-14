<?php
require_once __DIR__.'/CommandChannel.php';
require_once __DIR__.'/Transition.php';
require_once __DIR__.'/State.php';
require_once __DIR__.'/Event.php';
require_once __DIR__.'/Command.php';
require_once __DIR__.'/StateMachine.php';

class Controller
{
    private $_currentState;
    private $_stateMachine;
    private $_commandChannel;

    public function __construct($stateMachine, $currentState=null)
    {
        if (is_null($currentState)) {
            $this->_currentState = $stateMachine->getStartState();
        } else {
            $this->_currentState = $currentState;
        }
        $this->_stateMachine = $stateMachine;
    }

    public function getCommandChannel()
    {
    }

    public function getCurrentState()
    {
        return $this->_currentState;
    }

    public function handle($eventCode)
    {
        if ($this->_currentState->hasTransition($eventCode)) {
            $this->_transitionTo($this->_currentState->targetState($eventCode));
        } else {
            throw new Exception('Can\' not handle event ' . $eventCode);
        }
    }

    private function _transitionTo($target)
    {
        $this->_currentState = $target;
        $this->_currentState->executeActions($this->_commandChannel);
    }
}
