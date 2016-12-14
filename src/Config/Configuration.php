<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Config;

use Ctimt\SqlControl\Enum\Messages;
use Ctimt\SqlControl\Exception\InvalidArgumentException;

/**
 * Description of Configuration
 *
 * @author David
 */
class Configuration {

    const DEFAULT_NAMESPACE = 'default';
    
    private $_config = [];
    private $_nameSpace = '';
    private $_defaultNamespace = self::DEFAULT_NAMESPACE;
    private $_throwErrorOnNoValue = false;

    public function __construct(array $config, $nameSpace, $throwErrorOnNoValue = false) {
        $this->setConfig($config)->setNameSpace($nameSpace)->setThrowErrorOnNoValue($throwErrorOnNoValue);
    }

    public function getProcessedConfig(){
        $defaultConfig = array_key_exists($this->getDefaultNamespace(), $this->getConfig()) ? $this->getConfig()[$this->getDefaultNamespace()] : [];
        $currentNamespace = array_key_exists($this->getNameSpace(), $this->getConfig()) ? $this->getConfig()[$this->getNameSpace()] : [];
        return array_merge_recursive($currentNamespace,$defaultConfig);
    }


    public function getValue($key, $defaultValue = null) {
        $config = $this->getProcessedConfig();
        if(array_key_exists($key, $config)){
            return $config[$key];
        }elseif($this->getThrowErrorOnNoValue()){
            throw New InvalidArgumentException(sprintf(Messages::ERROR_CONFIG_KEY_NOT_FOUND, $key, $this->getNameSpace()));
        }
        return  $defaultValue;
    }

    public function getConfig() {
        return $this->_config;
    }

    public function getNameSpace() {
        return $this->_nameSpace;
    }

    public function setConfig(array $config) {
        $this->_config = $config;
        return $this;
    }

    public function setNameSpace($nameSpace) {
        $this->_nameSpace = $nameSpace;
        return $this;
    }

    public function getDefaultNamespace() {
        return $this->_defaultNamespace;
    }

    public function setDefaultNamespace($defaultNamespace) {
        $this->_defaultNamespace = $defaultNamespace;
        return $this;
    }

    public function getThrowErrorOnNoValue() {
        return $this->_throwErrorOnNoValue;
    }

    public function setThrowErrorOnNoValue($throwErrorOnNoValue = true) {
        $this->_throwErrorOnNoValue = $throwErrorOnNoValue;
        return $this;
    }
}
