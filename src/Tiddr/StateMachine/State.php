<?php
namespace Tiddr\StateMachine;
use Tiddr\StateMachine\Event;

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

    public function addAction(Command $action)
    {
        if (!in_array($action, $this->_actions)) {
            $this->_actions[] = $action;
        }
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
        if(!isset($this->_transitions[$eventCode])) {
            throw new \Exception('Do not accept the event ' . $eventCode);
        }
        return $this->_transitions[$eventCode]->getTargetState();
    }

    public function getAllTargets()
    {
        $target = [];
        foreach($this->_transitions as $code => $ts) {
            $target[] = $ts->getTargetState();
        }
        return $target;
    }


    /**
     * @return \ArrayIterator
     */
    public function getAllPosibleTriggers()
    {
        $triggers  = new \ArrayIterator();
        foreach($this->_transitions as $transition) {
            $triggers->append( $transition->getTrigger());
        }
        return $triggers;
    }
}
