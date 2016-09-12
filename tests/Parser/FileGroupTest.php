<?php namespace DschoenbauerTest\SqlControl\Parser;

use Dschoenbauer\SqlControl\Parser\FileGroup;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-09-12 at 17:05:12.
 */
class FileGroupTest extends \DschoenbauerTest\SqlControl\Parser\TestParser
{

    /**
     * @var FileGroup
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new FileGroup();
    }

    public function testParse()
    {
        $this->assertEquals('Test',$this->object->parse($this->addName($this->getBaseMock(),'Test.1.1.9.sql')));
        $this->assertEquals('Test',$this->object->parse($this->addName($this->getBaseMock(),'Test.1.1.sql')));
        $this->assertEquals('Test',$this->object->parse($this->addName($this->getBaseMock(),'Test.1.sql')));
        $this->assertEquals('Test',$this->object->parse($this->addName($this->getBaseMock(),'Test.sql')));
    }
    
}
