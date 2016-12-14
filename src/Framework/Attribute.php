<?php

namespace Ctimt\SqlControl\Framework;

/**
 * Description of Attribute
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Attribute {

    private $_key;
    private $_value;

    public function __construct($key, $value) {
        $this->setKey($key)->setValue($value);
    }

    public function getKey() {
        return $this->_key;
    }

    public function getValue() {
        return $this->_value;
    }

    public function setKey($key) {
        $this->_key = $key;
        return $this;
    }

    public function setValue($value) {
        $this->_value = $value;
        return $this;
    }

    public function __toString() {
        if (!is_array($this->_value) && (!is_object($this->_value) || method_exists($this->_value, '__toString'))) {
            return $this->_value == null ? "" : $this->_value;
        };
        return "";
    }

}
