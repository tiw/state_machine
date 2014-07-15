<?php
namespace Tiddr\StateMachine;
use Tiddr\StateMachine\State;

/**
 * Class StateMachine
 * @package Tiddr\StateMachine
 */
class StateMachine
{
    /**
     * @var State start state
     */
    private $_start;

    /**
     * @param State $start
     */
    public function __construct(State $start)
    {
        $this->_start = $start;
    }

    /**
     *
     * @return State
     */
    public function getStartState()
    {
        return $this->_start;
    }

    /**
     *
     * @return State[]
     */
    public function getStates()
    {
        $states = [];
        $this->_collectStates($states, $this->_start);
        return $states;
    }

    /**
     * @param State[] $states states
     * @param State   $start
     *
     * @internal param \Tiddr\StateMachine\State $s start state
     */
    private function _collectStates(&$states, State $start)
    {
        $keys = [];
        foreach($states as $state) {
            $keys[] = $state->getName();
        }
        if(in_array($start->getName(), $keys)) {
            return;
        }
        $states[] = $start;
        foreach($start->getAllTargets() as $target) {
            $this->_collectStates($states, $target);
        }
    }


    /**
     * @param string $file state machine
     *
     * @throws \Exception
     * @return StateMachine state machine
     */
    public static function fromJsonFile($file)
    {
        if(!\file_exists($file)) {
            throw new \Exception("Cannot found file {$file}");
        }
        $lex = Json_decode(file_get_contents($file), true);
        foreach(self::_getExtensions() as $extension) {
            $lex = call_user_func($extension, $lex);
        }
        return self::_generateFromLex($lex);
    }


    private static function _getExtensions()
    {
        return [
            // add state definition
            function($lex) {
                foreach($lex['State'] as $key => $state) {
                    if (is_array($state)) {
                        if (count($state) != 2) {
                            throw new \Exception("Your must define prefix and suffix");
                        }
                        foreach ($state[0] as $pre) {
                            $stateName = $pre . ':' . $state[1];
                            $lex['State'][]= $stateName;
                        }
                        unset($lex['State'][$key]);
                    }
                }
                return $lex;
            },
            // add transition definition
            function($lex) {
                foreach($lex['Transition'] as $key => $transition) {
                    if (count($transition) != 3) {
                        throw new \Exception("Transition needs three params");
                    }
                    if (is_array($transition[0])) {
                        foreach ($transition[0] as $t) {
                            $lex['Transition'][] =
                                [$t, $transition[1], $t . ':' . $transition[2]];
                        }
                        unset($lex['Transition'][$key]);
                    }
                }
                return $lex;
            }
        ];
    }

    /**
     * @param $lex
     * @return StateMachine
     */
    private static function _generateFromLex($lex)
    {
        $events = [];
        foreach($lex['Event'] as $eventData) {
            $events[$eventData[1]] = new Event($eventData[0], $eventData[1]);
        }

        /** @var State[] $states */
        $states = [];
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
     * Generate State Machine from a DSL file, now in Yaml.
     *
     * @param string $file file path
     *
     * @throws \Exception
     * @return StateMachine
     */
    public static function fromFile($file)
    {
        if(!\file_exists($file)) {
            throw new \Exception("Cannot found file {$file}");
        }
        $lex = \yaml_parse(file_get_contents($file));
        return self::_generateFromLex($lex);
    }
}
