<?php
namespace Tiddr\StateMachine;
use Tiddr\StateMachine\Controller;
use Tiddr\StateMachine\StateMachine as SM;
use Tiddr\StateMachine\Publisher;

class TestController extends \PHPUnit_Framework_TestCase
{
    public function testCreateNewController()
    {
        $sm = SM::fromFile('./test.sm');
        $controller = new Controller($sm);
        $states = $sm->getStates();
        $publisher = new Publisher();
        $publisher->register('do', function($state) {
            $this->assertEquals('do', $state->getName());
        });
        $controller->setPublisher($publisher);
        $this->assertEquals('dc', $controller->getCurrentState()->getName());
        $controller->handle('OD');
        $this->assertEquals('do', $controller->getCurrentState()->getName());

        try {
            $controller->handle('CW');
        } catch(\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Do not accept the event CW');
        }
    }
}
