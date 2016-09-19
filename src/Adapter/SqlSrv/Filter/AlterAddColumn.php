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
 * Description of AlterAddColumn
 *
 * @author David
 */
class AlterAddColumn implements FilterInterface, SqlChangeAwareInterface {

    private $_sqlChange;
    
    public function filter($value) {
        $checkPattern = '/ALTER\W+TABlE\W+(\w+)[\W\w]+ADD\W+COLUMN/i';
        if(preg_match($checkPattern, $value, $matches) !== 1){
            return $value;
        }
        //Get the table name
        $table = $matches[1];
        //Get each add column
        $pattern = '/ADD\W+COLUMN\W+(\w+)\W+([\w\W\(\)]+)(?:\W+After\W\w+,?|,|$)/im';
        $remnant = preg_replace_callback($pattern, function($matches) use($table) {
            $sql = sprintf("ALTER TABLE %s ADD %s %s", $table, $matches[1], $this->filterSlag($matches[2]));
            $this->getSqlChange()->addStatement($sql);
            return null;
        }, $value);
        if(preg_match('/^ALTER\W+TABLE\W+\w+$/', trim($remnant)) === 1){
            return '/* query parsed out */';
        }
        return $remnant;
    }
    private function filterSlag($codeFragment){
        $pattern = '/(After\W\w+,?|,|$)/im';
        return trim(preg_replace($pattern, '', $codeFragment));
    }
    
    /**
     * @return SqlChange
     */
    public function getSqlChange() {
        return $this->_sqlChange;
    }

    public function setSqlChange(SqlChange $sqlChange) {
        $this->_sqlChange = $sqlChange;
        return $this;
    }
}
