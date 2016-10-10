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
 * Description of ReplaceInto
 *
 * @author David
 */
class ConvertReplaceInto implements FilterInterface, SqlChangeAwareInterface {

    private $_sqlChange;

    public function filter($value) {
        if (preg_match($this->getQualifyingPattern(), $value, $matches) !== 1) {
            return $value;
        }
        $table = $matches[1];
        preg_match($this->getDataPattern(), $value, $matches);

        $keys = array_flip(preg_split('/\s*,\s*/', $matches[2]));
        $values = explode("','", trim($matches[3], "'"));
        preg_match("/((\s+|{$table}_)`?id`?)[,\s]/i", $matches[0], $idMatches);
        $id = $idMatches[1];

        $this->getSqlChange()->addStatement(str_replace('REPLACE', 'INSERT', $value));
        return "DELETE FROM $table where $id = '{$values[$keys[$id]]}'";

    }

    public function getQualifyingPattern() {
        return '/REPLACE\s+INTO\s+([`\w]+)/i';
    }

    public function getDataPattern() {
        return '/REPLACE\s+INTO\s+([`\w]+)\s+\(([^\)]+)\)\s+VALUES\s*\(([^\)]*)\)/i';
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
