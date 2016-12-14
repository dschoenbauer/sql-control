<?php

namespace Ctimt\SqlControl\Listener\Logger;

/**
 * Description of LogBuilder
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class DebugLogBuilder implements LogBuilderInterface {

    private $_loggers = [];

    public function __construct($logLevel, LoggerOutputInterface $loggerOutput) {
        $this->addLoggerOutput($logLevel, $loggerOutput);
    }

    public function getLogger(Logger $logger = null) {
        if ($logger instanceof Logger) {
            return $logger->load($this->getLoggers());
        }
        return new Logger($this->getLoggers());
    }

    public function addLoggerOutput($logLevel, LoggerOutputInterface $loggerOutput) {
        if (is_array($logLevel)) {
            foreach ($logLevel as $aLogLevel) {
                $this->addSingleLogger($aLogLevel, $loggerOutput);
            }
        } else {
            $this->addSingleLogger($logLevel, $loggerOutput);
        }
    }

    protected function addSingleLogger($logLevel, $loggerOutput) {
        if (!array_key_exists($logLevel, $this->_loggers)) {
            $this->_loggers[$logLevel] = [];
        }
        $this->_loggers[$logLevel][] = $loggerOutput;
        return $this;
    }

    public function getLoggers() {
        return $this->_loggers;
    }

    public function setLoggers(array $loggers) {
        $this->_loggers = $loggers;
        return $this;
    }

}
