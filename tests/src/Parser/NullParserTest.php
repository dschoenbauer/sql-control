<?php namespace Ctimt\SqlControl\Parser;

use CtimtTest\SqlControl\Mocks\TestParser;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-09-12 at 17:40:34.
 */
class NullParserTest extends TestParser
{

    /**
     * @var NullParser
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new NullParser;
    }

    public function testParse()
    {
        $this->assertEquals(null, $this->object->parse($this->addName($this->getBaseMock(), 'Test.1.1.9.sql')));
        $this->assertEquals(null, $this->object->parse($this->addName($this->getBaseMock(), 'Test.1.1.sql')));
        $this->assertEquals(null, $this->object->parse($this->addName($this->getBaseMock(), 'Test.1.sql')));
        $this->assertEquals(null, $this->object->parse($this->addName($this->getBaseMock(), 'Test.sql')));
    }

    public function testDefaultValue()
    {
        $this->assertEquals('testing', $this->object->setDefaultValue('testing')->getDefaultValue());
    }

    public function testDefaultValueOnParse()
    {
        $this->assertEquals('testing', $this->object->setDefaultValue('testing')->parse($this->getBaseMock()));
    }

    public function testDefaultValueOnConstruct()
    {
        $this->assertEquals('testing', (new NullParser('testing'))->parse($this->getBaseMock()));
    }
}
