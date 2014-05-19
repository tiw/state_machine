<?php
namespace Tiddr\StateMachine;
use Tiddr\StateMachine\Publisher;
use Tiddr\StateMachine\Transition;
use Tiddr\StateMachine\State;
use Tiddr\StateMachine\Event;
use Tiddr\StateMachine\Command;
use Tiddr\StateMachine\StateMachine;

class Controller
{
    private $_currentState;
    private $_stateMachine;
    private $_publisher;

    public function __construct($stateMachine, $currentState=null)
    {
        if (is_null($currentState)) {
            $this->_currentState = $stateMachine->getStartState();
        } else {
            $this->_currentState = $currentState;
        }
        $this->_stateMachine = $stateMachine;
    }

    public function setPublisher(Publisher $publisher)
    {
        $this->_publisher = $publisher;
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
            throw new \Exception('Can\' not handle event ' . $eventCode);
        }
    }

    private function _transitionTo($target)
    {
        $this->_currentState = $target;
        if(isset($this->_publisher)){
           $this->_publisher->publish($this->_currentState);
        }
    }
}
