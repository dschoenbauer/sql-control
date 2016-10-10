<?php

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-09-19 at 18:02:57.
 */
class ConvertTimeStampTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ConvertTimeStamp
     */
    protected $object;
    protected function setUp() {
        $this->object = new ConvertTimeStamp;
    }

    public function testFilter() {
        $sql = "CREATE TABLE `Api` ( `api_timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP)";
        $expexted = "CREATE TABLE `Api` ( `api_timeStamp` DATETIME DEFAULT(GETDATE()))";
        $this->assertEquals($expexted, $this->object->filter($sql));
    }

    
    public function testFilterAddColumn(){
        $sql = "ALTER TABLE `Container` ADD COLUMN `container_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER `container_deleted`;";
        $expected = "ALTER TABLE `Container` ADD COLUMN `container_created` DATETIME DEFAULT(GETDATE()) AFTER `container_deleted`;";
        $this->assertEquals($expected, $this->object->filter($sql));
    }
}
