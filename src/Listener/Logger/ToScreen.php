<?php

namespace Ctimt\SqlControl\Listener\Logger;

/**
 * Description of ToScreen
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class ToScreen implements LoggerOutputInterface {

    private $suffix = null;
    private $prefix = null;

    public function __construct($prefix = null, $suffix = null) {
        $this->setPrefix($prefix)->setSuffix($suffix);
    }
    
    public function output($message) {
        echo $this->getPrefix(), $message, $this->getSuffix(), PHP_EOL;
    }

    public function getSuffix() {
        return $this->suffix;
    }

    public function getPrefix() {
        return $this->prefix;
    }

    public function setSuffix($suffix) {
        $this->suffix = $suffix;
        return $this;
    }

    public function setPrefix($prefix) {
        $this->prefix = $prefix;
        return $this;
    }

}
