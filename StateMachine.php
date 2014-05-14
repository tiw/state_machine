<?php

class StateMachine
{
    /**
     * @var State start state
     */
    private $_start;

    public function __construct($start)
    {
        $this->_start = $start;
    }

    public function getStates()
    {
        $states = [];
        $this->_collectStates(&$states, $this->_start);
        return $states;
    }

    /**
     * @param [State] $states states
     * @param state   $s      start state
     *
     */
    private function _collectStates(&$states, $start)
    {
        if(in_array($start, $states)) {
            return;
        }
        $states[] = $start;
        foreach($start->getAllTargets() as $target) {
            $this->collectStates(&$states, $target);
        }
    }
}
