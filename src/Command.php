<?php

require_once __DIR__.'/AbstractEvent.php';

abstract class Command extends AbstractEvent
{
    abstract public function send($eventCode);
}
