<?php

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of CreateTemporyTable
 *
 * @author David
 */
class CreateTemporyTable implements FilterInterface {

    /**
     * @todo devise a plan to kill session temporary tables.
     */
    const PATTERN = "/CREATE\s+TEMPORARY\s+TABLE\s+(\w+)\s+AS\s+\(([\W\w]+)\)/i";

    private $_tables = [];

    public function filter($value) {
        if (preg_match(self::PATTERN, $value, $matches) !== 1) {
            return strtr($value, $this->getTables());
        }
        $table = $matches[1];
        $sql = $matches[2];
        $this->addTable($table);
        return str_ireplace('FROM', sprintf(' INTO %s FROM', $table), $sql);
    }

    public function addTable($table) {
        $this->_tables[$table] = '#' . $table;
        return $this;
    }

    public function getTables() {
        return $this->_tables;
    }

}
