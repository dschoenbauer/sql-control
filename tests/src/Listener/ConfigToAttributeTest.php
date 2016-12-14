<?php

namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Config\Configuration;
use Ctimt\SqlControl\Framework\Attributes;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use PHPUnit_Framework_TestCase;

/**
 * Description of MessagingTest
 *
 * @author David
 */
class ConfigToAttributeTest extends PHPUnit_Framework_TestCase {

    private $object;

    protected function setUp() {
        $config = $this->getMockConfigurtation();
        $this->object = new ConfigToAttribute($config);
    }

    public function testIsListener() {
        $this->assertInstanceOf(VisitorInterface::class, $this->object);
    }

    public function testMessagingConfig() {
        $mock = $this->getMockConfigurtation();
        $this->assertEquals($mock, $this->object->setMessagingConfig($mock)->getMessagingConfig());
    }

    public function testConstructorPassThrough() {
        $mock = $this->getMockConfigurtation();
        $this->assertEquals($mock, (new ConfigToAttribute($mock))->getMessagingConfig());
    }

    /**
     * @dataProvider getTestData
     */
    public function testConvertConfigToAttributes($data) {

        $mockAttribute = $this->getMockBuilder(Attributes::class)->getMock();
        $i = 0;
        foreach ($data as $key => $value) {
            $mockAttribute->expects($this->at($i))->method('add')->with($key, $value);
            $i++;
        }
        $mock = $this->getMockSqlControlManager();
        $mock->expects($this->exactly(count($data)))->method('getAttributes')->willReturn($mockAttribute);
        $this->object->convertConfigToAttributes($data, $mock);
    }

    public function testVisitSqlControlManager() {
        $config = $this->getMockConfigurtation();
        $config->expects($this->exactly(1))->method('getConfig')->willReturn([]);
        $sqlControlManager = $this->getMockSqlControlManager();

        $this->object->setMessagingConfig($config);
        $this->object->visitSqlControlManager($sqlControlManager);
    }

    protected function getMockConfigurtation() {
        return $this->getMockBuilder(Configuration::class)
                        ->disableOriginalConstructor()
                        ->getMock();
    }

    protected function getMockSqlControlManager() {
        return $this->getMockBuilder(SqlControlManager::class)
                        ->disableOriginalConstructor()
                        ->getMock();
    }

    public function getTestData() {
        return [
            'data' => [[
                'test' => 'value',
                'test2' => 'value2',
                'test3' => 'value3',
                'test4' => 'value4',
                'test5' => 'value5',
                'test6' => 'value6',
                'test7' => 'value7',
            ]]
        ];
    }

}
