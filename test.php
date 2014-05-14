<?php

require_once __DIR__.'/Controller.php';
$closeDoor = new Event("door closed", "DC");
$openDoor = new Event("door opened", "DO");
$closeWindow = new Event("window closed", "WC");
$openWindow = new Event("window opened", "WO");

$start = new State("dc");
$doorOpened = new State("do");
$windowOpened = new State("wo");
$windowClosed = new State("wc");

$start->addTransition($openDoor, $doorOpened);
$doorOpened->addTransition($openWindow, $windowOpened);
$windowOpened->addTransition($closeWindow, $windowClosed);
$doorOpened->addTransition($closeDoor, $start);

$stateMachine = new StateMachine($start);
$controller = new Controller($stateMachine);

$controller->handle($openDoor->getCode());
$controller->handle($openWindow->getCode());
$currentState = $controller->getCurrentState();
var_dump($currentState->getName());
