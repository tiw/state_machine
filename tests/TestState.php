<?php
require_once __DIR__.'/../Event.php';
require_once __DIR__.'/../Transition.php';
require_once __DIR__.'/../State.php';


class TestState extends PHPUnit_Framework_TestCase
{
    private $_start;

    public function setUp()
    {
        $this->_start = new State('start');
    }

    public function testGetTargets()
    {
        $openDoor = new Event('open the door', 'OD');
        $openWindow = new Event('open the window', 'OW');
        $closeDoor = new Event('close the door', 'CD');

        $doorOpenedState = new State('door is opened');
        $this->_start->addTransition($openDoor, $doorOpenedState);
        $doorOpenedState->addTransition($closeDoor, $this->_start);

        $windowOpenedState = new State('window is opened');
        $this->_start->addTransition($openWindow, $windowOpenedState);

        $allTargets = $this->_start->getAllTargets();
        $this->assertEquals(2, count($allTargets));
        $this->assertTrue(in_array($doorOpenedState, $allTargets));
        $this->assertTrue(in_array($windowOpenedState, $allTargets));
    }

    public function testHasTarget()
    {
        $openDoor = new Event('open the door', 'OD');
        $openWindow = new Event('open the window', 'OW');
        $closeDoor = new Event('close the door', 'CD');

        $doorOpenedState = new State('door is opened');
        $this->_start->addTransition($openDoor, $doorOpenedState);
        $doorOpenedState->addTransition($closeDoor, $this->_start);

        $windowOpenedState = new State('window is opened');
        $this->_start->addTransition($openWindow, $windowOpenedState);

        $this->assertTrue($this->_start->hasTransition('OD'));
        $this->assertTrue($this->_start->hasTransition('OW'));
    }

    public function testAddTransition()
    {
        $event = new Event('open the door', 'OD');
        $targetState = new State('opened');
        $this->_start->addTransition($event, $targetState);
    }

    public function tearDown()
    {
        $this->_start = new State('start');
    }
}
