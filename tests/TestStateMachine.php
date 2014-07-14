<?php
namespace Tiddr\StateMachine;
use Tiddr\Statemachine\StateMachine;
use Tiddr\Statemachine\Event;
use Tiddr\Statemachine\Transition;
use Tiddr\Statemachine\State;

class TestStateMachine extends \PHPUnit_Framework_TestCase
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

    public function testFromJsonFile()
    {
        $stateMachine = StateMachine::fromJsonFile('./test.json');
        $this->assertEquals(4, count($stateMachine->getStates()));
        $this->assertEquals("dc", $stateMachine->getStartState()->getName());
    }

    public function testArrayStates()
    {
        $stateMachine = StateMachine::fromJsonFile('./array-state.json');
        $this->assertEquals(8, count($stateMachine->getStates()));
    }

    public function testArrayTransition()
    {
        $stateMachine = StateMachine::fromJsonFile('./array-transition.json');
        $controller = new Controller($stateMachine);
        $controller->handle('D');
        $this->assertEquals('dc:sf', $controller->getCurrentState()->getName());
    }


    /**
     * @group test
     */
    public function testComplexTransition()
    {
        $state = new State('150:1');
        $stateMachine = StateMachine::fromFile('./shipping_notice.sm');
        $controller = new Controller($stateMachine, $state);
        $currentState = $controller->getCurrentState();
        $this->assertEquals(1, count($currentState->getAllPosibleTriggers()));
        $this->assertEquals('close', $currentState->getAllPosibleTriggers()[0]->getName());
    }
}
