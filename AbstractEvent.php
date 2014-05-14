<?php

abstract class AbstractEvent
{
    protected $name;
    protected $code;

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }
}
