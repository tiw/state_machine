<?php
namespace Tiddr\StateMachine;
use Tiddr\StateMachine\State;

/**
 * State Machine
 *
 */
class StateMachine
{
    /**
     * @var State start state
     */
    private $_start;

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
     * @return [State]
     */
    public function getStates()
    {
        $states = [];
        $this->_collectStates($states, $this->_start);
        return $states;
    }

    /**
     * @param [State] $states states
     * @param state   $s      start state
     *
     */
    private function _collectStates(&$states, $start)
    {
        if(in_array($start, $states)) {
            return;
        }
        $states[] = $start;
        foreach($start->getAllTargets() as $code=>$target) {
            $this->_collectStates($states, $target);
        }
    }


    /**
     * @param string $file state machine
     *
     * @return StateMachine state machine
     *
     */
    public static function fromJsonFile($file)
    {
        if(!\file_exists($file)) {
            throw new \Exception("Cannot found file {$file}");
        }
        $lex = Json_decode(file_get_contents($file), true);
        return self::_generateFromLex($lex);
    }

    private static function _generateFromLex($lex)
    {
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
     * Generate State Machine from a DSL file, now in Yaml.
     *
     * @param string $file file path
     *
     * @return StateMachine
     *
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
