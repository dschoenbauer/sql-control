<?php

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-09-19 at 18:03:01.
 */
class RemoveTickTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RemoveTick
     */
    protected $object;

    protected function setUp() {
        $this->object = new RemoveTick();
    }

    public function testFilter() {
        $value = "This is a `test` ";
        $result = "This is a test ";
        $this->assertEquals($result, $this->object->filter($value));
    }

}
