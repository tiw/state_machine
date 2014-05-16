<?php
namespace Tiddr\StateMachine;

class Transition
{
    /**
     * @var State $_source source state
     */
    private $_source;

    /**
     * @var State $_target target state
     */
    private $_target;

    /**
     * @var Event $_trigger trigger event;
     */
    private $_trigger;


    public function __construct(State $source, Event $trigger, State $target)
    {
        $this->_source = $source;
        $this->_trigger = $trigger;
        $this->_target = $target;
    }

    /**
     * @return State 
     */
    public function getTargetState()
    {
        return $this->_target;
    }
}
