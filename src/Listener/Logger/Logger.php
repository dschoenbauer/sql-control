<?php
namespace Ctimt\SqlControl\Listener\Logger;

/**
 * Description of Logger
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Logger implements \Psr\Log\LoggerInterface
{

    use LoggerLevelValidateTrait;

use \Psr\Log\LoggerTrait;

    public function __construct(array $outputs = [])
    {
        foreach ($outputs as $level => $logOutputs) {
            $this->validateLogLevel($level);
            if (is_array($logOutputs)) {
                foreach ($logOutputs as $logOutput) {
                    $this->add($level, $logOutput);
                }
            } else {
                $this->add($level, $logOutput);
            }
        };
    }

    public function add($level, LoggerOutputInterface $logOutput)
    {
        $this->validateLogLevel($level);
        $this->_outputs[$level][] = $logOutput;
        return $this;
    }

    public function log($level, $message, array $context = array())
    {
        $this->validateLogLevel($level);
        if (!array_key_exists($level, $this->_outputs)) {
            return; //Nothing to do
        }
        $outputs = $this->_outputs[$level];
        $compiledMessage = $this->interpolate($message, $context);
        /* @var $output Logger\LoggerOutputInterface */
        foreach ($outputs as $output) {
            $output->output($compiledMessage);
        }
    }

    public function interpolate($message, array $context = array())
    {
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }
        return strtr($message, $replace);
    }
}
