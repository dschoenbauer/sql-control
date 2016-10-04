<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;
use Ctimt\SqlControl\Framework\SqlChange;
use Ctimt\SqlControl\Framework\SqlChangeAwareInterface;

/**
 * Description of RebuildPrimaryKey
 *
 * @author David
 */
class RebuildPrimaryKey implements FilterInterface, SqlChangeAwareInterface {

    private $_sqlChange;

    public function filter($value) {
        $pattern = '/ALTER\W+TABLE\W+(\w+)\W+DROP\W+PRIMARY\W+KEY,\W+ADD\W+PRIMARY\W+KEY\W+\(([\w ,]+)\)/';
        if (!preg_match($pattern, $value, $matches)) {
            return $value;
        }
        $this->buildIndexDrop($matches[1], $this->getSqlChange());
        $this->createIndex($matches[1], $matches[2], $this->getSqlChange());
        return "/* Query Rebuilt */";
    }

    private function buildIndexDrop($tableName, SqlChange $change) {
        $change->addStatement("DECLARE @sql NVARCHAR(MAX);"
                . "SELECT @sql = 'ALTER TABLE $tableName '
            + ' DROP CONSTRAINT ' + name + ';'
            FROM sys.key_constraints
            WHERE [type] = 'PK'
            AND [parent_object_id] = OBJECT_ID('$tableName');"
                . "EXEC sp_executeSQL @sql;");
    }

    private function createIndex($tableName, $fields, SqlChange $change) {
        $sql = "ALTER TABLE $tableName ADD CONSTRAINT pk_$tableName PRIMARY KEY ($fields)";
        $change->addStatement($sql);
    }

    public function getSqlChange() {
        return $this->_sqlChange;
    }

    public function setSqlChange(SqlChange $sqlChange) {
        $this->_sqlChange = $sqlChange;
        return $this;
    }

}
