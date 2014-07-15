<?php
namespace Tiddr\StateMachine;
use Tiddr\StateMachine\Event;
use Tiddr\StateMachine\Transition;

/**
 * Class State
 * @package Tiddr\StateMachine
 */
class State
{
    /**
     * @var Command[] $_actions
     */
    private $_actions = [];

    /**
     * @var Transition[]
     */
    private $_transitions = [];

    /**
     * @var String
     */
    private $_name;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->_name = $name;
    }

    /**
     * @param Command $action
     */
    public function addAction(Command $action)
    {
        if (!in_array($action, $this->_actions)) {
            $this->_actions[] = $action;
        }
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param Event $event
     * @param State $targetState
     */
    public function addTransition(Event $event, State $targetState)
    {
        $this->_transitions[$event->getCode()] =
            new Transition($this, $event, $targetState);
    }

    /**
     * @param $eventCode
     * @return bool
     */
    public function hasTransition($eventCode)
    {
        return in_array($eventCode, array_keys($this->getAllTargets()));
    }

    /**
     * @param $eventCode
     * @return State
     * @throws \Exception
     */
    public function targetState($eventCode)
    {
        if(!isset($this->_transitions[$eventCode])) {
            throw new \Exception('Do not accept the event ' . $eventCode);
        }
        return $this->_transitions[$eventCode]->getTargetState();
    }


    /**
     * @return Event[]
     */
    public function getAllTargets()
    {
        /** @var Event[] $targets */
        $targets = [];
        foreach($this->_transitions as $code => $ts) {
            $targets[] = $ts->getTargetState();
        }
        return $targets;
    }


    /**
     * @return \ArrayIterator
     */
    public function getAllPossibleTriggers()
    {
        $triggers  = new \ArrayIterator();
        foreach($this->_transitions as $transition) {
            $triggers->append( $transition->getTrigger());
        }
        return $triggers;
    }
}
