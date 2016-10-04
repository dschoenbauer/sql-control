<?php
namespace Ctimt\SqlControl\Config;

use PHPUnit_Framework_TestCase;

class ConfigurationTest extends PHPUnit_Framework_TestCase {

    /* @var $_object Configuration */
    private $_object;
    
    protected function setUp() {
        $config = [
            'test' => [
                'onlyHere' => 'onlyHere',
                'overridden' => 'test',
            ],
            Configuration::DEFAULT_NAMESPACE => [
                'overridden' => 'default',
                'onlyDefault' => 'onlyDefaultValue',
            ]
        ];

        $this->_object = new Configuration($config, 'test', false);
    }

    public function testGetValuePresent() {
        $this->assertEquals('onlyHere', $this->_object->getValue('onlyHere'));
    }
    
    public function testGetValueDefault() {
        $this->assertEquals('onlyDefaultValue', $this->_object->getValue('onlyDefault'));
        
    }
    
    public function testGetValueNotPresent() {
        $this->assertEquals('notValid', $this->_object->getValue('notValid','notValid'));
        
    }

    public function testConfig() {
        $this->assertEquals([],$this->_object->setConfig([])->getConfig());
        
    }

    public function testNameSpace(){
        $this->assertEquals('newTest',$this->_object->setNameSpace('newTest')->getNameSpace());
    }

    public function testDefaultNamespace() {
        $this->assertEquals('defaultTest',$this->_object->setDefaultNamespace('defaultTest')->getDefaultNamespace());
    }

    public function testThrowErrorOnNoValue() {
        $this->assertEquals(true, $this->_object->setThrowErrorOnNoValue()->getThrowErrorOnNoValue());
        $this->assertEquals(true, $this->_object->setThrowErrorOnNoValue(true)->getThrowErrorOnNoValue());
        $this->assertEquals(false, $this->_object->setThrowErrorOnNoValue(false)->getThrowErrorOnNoValue());
    }
    
}
