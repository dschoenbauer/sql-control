<?php namespace Ctimt\SqlControl\Listener\Logger;

/**
 * Description of DebugLogBuilderTest
 *
 * @author David
 */
class DebugLogBuilderTest extends \PHPUnit_Framework_TestCase {
    
    private $object;
    
    protected function setUp() {
        $this->object = new DebugLogBuilder();
    }
    
    public function testDefaultLoggersAreSetInitially(){
        $this->assertEquals($this->object->getDefaultLoggers(),$this->object->getLoggers());
    }

    public function testLoggers(){
        $tests = [];
        $this->assertEquals($tests, $this->object->setLoggers($tests)->getLoggers());
    }
    
}
