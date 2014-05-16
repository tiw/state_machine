<?php
require_once __DIR__.'/../StateMachine.php';
require_once __DIR__.'/../Event.php';
require_once __DIR__.'/../Transition.php';
require_once __DIR__.'/../State.php';

class TestStateMachine extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_start = new State('start');
    }

    public function testGetAllStates()
    {
        $openDoor = new Event('open the door', 'OD');
        $openWindow = new Event('open the window', 'OW');
        $closeDoor = new Event('close the door', 'CD');

        $doorOpenedState = new State('door is opened');
        $this->_start->addTransition($openDoor, $doorOpenedState);
        $doorOpenedState->addTransition($closeDoor, $this->_start);

        $windowOpenedState = new State('window is opened');
        $doorOpenedState->addTransition($openWindow, $windowOpenedState);

        $stateMachine = new StateMachine($this->_start);
        $allStates = $stateMachine->getStates();
        $this->assertEquals(3, count($allStates));
        $this->assertTrue(in_array($doorOpenedState, $allStates));
        $this->assertTrue(in_array($windowOpenedState, $allStates));
    }

    public function testFromFile()
    {
        $stateMachine = StateMachine::fromFile('./test.sm');
        $this->assertEquals(4, count($stateMachine->getStates()));
        $this->assertEquals("dc", $stateMachine->getStartState()->getName());
    }
}
