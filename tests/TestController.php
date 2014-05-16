<?php
namespace Tiddr\StateMachine;
use Tiddr\StateMachine\Controller;
use Tiddr\StateMachine\StateMachine as SM;

class TestController extends \PHPUnit_Framework_TestCase
{
    public function testCreateNewController()
    {
        $sm = SM::fromFile('./test.sm');
        $controller = new Controller($sm);
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
