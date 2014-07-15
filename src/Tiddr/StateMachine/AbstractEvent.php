<?php
namespace Tiddr\StateMachine;

/**
 * Class AbstractEvent
 * @package Tiddr\StateMachine
 */
abstract class AbstractEvent
{
    /** @var  string */
    protected $name;

    /** @var  string */
    protected $code;

    /**
     * @param $name
     * @param $code
     */
    public function __construct($name, $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
