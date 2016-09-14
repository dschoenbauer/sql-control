<?php
namespace Ctimt\SqlControl\Framework;

/**
 * Description of Attributed
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Attributes
{

    private $_attributes = [];

    public function add($key, $value)
    {
        if(array_key_exists($key, $this->_attributes)){
            $this->_attributes[$key]->setValue($value);
        }else{
            $this->_attributes[$key] = new Attribute($key, $value);
        }
        return $this;
    }

    public function getValue($key, $defaultValue = null)
    {
        return $this->getAttribute($key, $defaultValue)->getValue();
    }

    /**
     * 
     * @param string $key
     * @param mixed $defaultValue
     * @return \Ctimt\SqlControl\Framework\Attribute
     */
    public function getAttribute($key, $defaultValue = null)
    {
        if (!array_key_exists($key, $this->_attributes)) {
            return new Attribute($key, $defaultValue);
        }
        return $this->_attributes[$key];
    }
}
