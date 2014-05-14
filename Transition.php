<?php

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


    public function __construct($source, $trigger, $target)
    {
        $this->_source = $source;
        $this->_trigger = $trigger;
        $this->_target = $target;
    }

    public function getTargetState()
    {
        return $this->_target;
    }
}
