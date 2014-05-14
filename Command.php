<?php

require_once __DIR__.'/AbstractEvent';

abstract class Command extends AbstractEvent
{
    abstract public function send($eventCode);
}
