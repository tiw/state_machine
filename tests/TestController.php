<?php
require_once __DIR__.'/../Controller.php';
require_once __DIR__.'/../StateMachine.php';

class TestController extends PHPUnit_Framework_TestCase
{
    public function testCreateNewController()
    {
        $sm = StateMachine::fromFile('./test.sm');
        $controller = new Controller($sm);
        $this->assertEquals('dc', $controller->getCurrentState()->getName());
        $controller->handle('OD');
        $this->assertEquals('do', $controller->getCurrentState()->getName());
        try {
            $controller->handle('CW');
        } catch(Exception $e) {
            $this->assertEquals($e->getMessage(), 'Do not accept the event CW');
        }
    }
}
