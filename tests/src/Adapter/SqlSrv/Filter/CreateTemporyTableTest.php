<?php

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of CreateTemporyTableTest
 *
 * @author David
 */
class CreateTemporyTableTest extends \PHPUnit_Framework_TestCase {

    /* @var $object CreateTemporyTable */
    protected $object;

    protected function setUp() {
        $this->object = new CreateTemporyTable();
    }

    public function testFilter(){
        $sql = "CREATE TEMPORARY TABLE TEMP_PERMISSIONS AS (SELECT p.permission_id FROM 
Permission p
INNER JOIN Container c ON c.container_id = p.object_id AND c.containerType_id IN(2,3)
WHERE realm_id = 5 AND p.role_id IN(2,4,16,9))";
        $expected = "SELECT p.permission_id  INTO TEMP_PERMISSIONS FROM 
Permission p
INNER JOIN Container c ON c.container_id = p.object_id AND c.containerType_id IN(2,3)
WHERE realm_id = 5 AND p.role_id IN(2,4,16,9)";
        $this->assertEquals($expected, $this->object->filter($sql));
    }

    public function testFilterSubsequent(){
        $sql = "CREATE TEMPORARY TABLE TEMP_PERMISSIONS AS (SELECT p.permission_id FROM 
Permission p
INNER JOIN Container c ON c.container_id = p.object_id AND c.containerType_id IN(2,3)
WHERE realm_id = 5 AND p.role_id IN(2,4,16,9))";
        $expected = "SELECT p.permission_id  INTO TEMP_PERMISSIONS FROM 
Permission p
INNER JOIN Container c ON c.container_id = p.object_id AND c.containerType_id IN(2,3)
WHERE realm_id = 5 AND p.role_id IN(2,4,16,9)";
        $this->assertEquals($expected, $this->object->filter($sql));
        
        $actual = "SELECT TEMP_PERMISSIONS.permission_id  FROM TEMP_PERMISSIONS";
        $expected = "SELECT #TEMP_PERMISSIONS.permission_id  FROM #TEMP_PERMISSIONS";
        $this->assertEquals($expected, $this->object->filter($actual));
        $this->assertEquals(['TEMP_PERMISSIONS'=>'#TEMP_PERMISSIONS'], $this->object->getTables());
    }

    public function testNonEmptyFilterForNoMatch(){
        $actual = "SELECT TEMP_PERMISSIONS.permission_id  FROM TEMP_PERMISSIONS";
        $this->assertEquals($actual, $this->object->filter($actual));
    }
    
    public function testTables(){
        $this->assertEquals(['TEMP_PERMISSIONS'=>'#TEMP_PERMISSIONS'], $this->object->addTable('TEMP_PERMISSIONS')->getTables());
    }
}
