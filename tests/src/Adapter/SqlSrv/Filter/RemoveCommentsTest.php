<?php namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use PHPUnit_Framework_TestCase;

/**
 * Description of RemoveComments
 *
 * @author David
 */
class RemoveCommentsTest  extends PHPUnit_Framework_TestCase {

    /* @var $variable RemoveComments */
    protected $object;

    protected function setUp() {
        $this->object = new RemoveComments();
    }
    
    public function testFilterSlashStar(){
        $sql = "/*
            This is a multi line comment
            */
Select * FROM Stuff";
        $expected = "
Select * FROM Stuff";
        $this->assertEquals($expected, $this->object->filter($sql));
    }
    
    public function testFilterHashComment(){
        $sql = "#This is a multi line comment
Select * FROM Stuff";
        $expected = "
Select * FROM Stuff";
        $this->assertEquals($expected, $this->object->filter($sql));
    }

}
