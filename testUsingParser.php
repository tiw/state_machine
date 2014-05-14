<?php
require_once __DIR__.'/Controller.php';
$stateMachine = parseStateMachine('./door.sm');

$controller = new Controller($stateMachine);

$controller->handle('OD');
$controller->handle('OW');
$currentState = $controller->getCurrentState();
var_dump($currentState->getName());

/**
 * @return StateMachine
 */
function parseStateMachine($file)
{
    $lex = yaml_parse(file_get_contents('./door.sm'));
    $events = [];
    foreach($lex['Event'] as $eventData) {
        $events[$eventData[1]] = new Event($eventData[0], $eventData[1]);
    }

    foreach($lex['State'] as $stateData) {
        $states[$stateData] = new State($stateData);
    }

    foreach($lex['Transition'] as $transitionData) {
        $states[$transitionData[0]]->addTransition(
            $events[$transitionData[1]],
            $states[$transitionData[2]]
        );
    }
    $stateMachine = new StateMachine($states[$lex['Start']]);
    return $stateMachine;
}

/**
 * @return Controller
 */
function parseController($file)
{
}
