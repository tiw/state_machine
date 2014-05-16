<?php
namespace Tiddr\StateMachine;

abstract class AbstractEvent
{
    protected $name;
    protected $code;

    public function __construct($name, $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }
}
