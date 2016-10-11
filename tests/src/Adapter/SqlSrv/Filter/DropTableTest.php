<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of DropTableTest
 *
 * @author David
 */
class DropTableTest extends \PHPUnit_Framework_TestCase{
    /* @var $variable DropTable */
    private $object;
    
    protected function setUp() {
        $this->object = new DropTable();
    }
    
    public function testFilterIfExists(){
        $sql = "DROP TABLE IF EXISTS SettingValue";
        $expected = "IF EXISTS(SELECT * FROM [SettingValue]) DROP TABLE [SettingValue]";
        $this->assertEquals($expected, $this->object->filter($sql));
    }
    
    public function testFilter(){
        $sql = "DROP TABLE SettingValue";
        $expected = "DROP TABLE [SettingValue]";
        $this->assertEquals($expected, $this->object->filter($sql));
    }
    
    public function testFilterNoMatch(){
        $sql = "DROP INDEX SettingValue";
        $this->assertEquals($sql, $this->object->filter($sql));
    }
}
