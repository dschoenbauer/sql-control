<?php

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;
use Ctimt\SqlControl\Framework\SqlChange;
use Ctimt\SqlControl\Framework\SqlChangeAwareInterface;

/**
 * Description of AbstractAlterColumn
 *
 * @author David
 */
abstract class AbstractAlter implements FilterInterface, SqlChangeAwareInterface {

    private $_sqlChange;
    const SUCCESS_STATENT = "/* query parsed out */";

    public function filter($value) {
        $matches = [1 => null]; //Shut up netbeans
        if (preg_match($this->getQualifyingPattern(), $value, $matches) !== 1) {
            return $value;
        }
        //Get the table name
        $table = $matches[1];
        $pattern = $this->getDataPattern();
        $remnant = preg_replace_callback($pattern, function($matches) use($table) {
            $sql = $this->getSQL($matches, $table);
            $this->getSqlChange()->addStatement($sql);
            $this->extraCall($matches, $table);
            return null;
        }, $value);
        return $this->checkRemnant($remnant);
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

    /**
     * Validates that the statement has a specific statement, must identify the 
     * table in the first group
     */
    abstract function getQualifyingPattern();

    /**
     * extracts the data from each of the individual patterns
     */
    abstract function getDataPattern();

    abstract function getSQL($matches, $table);

    public function checkRemnant($remnant) {
        if (preg_match('/^ALTER\W+TABLE\W+\[?\w+\]?+\W*\z/im', trim($remnant)) === 1) {
            return self::SUCCESS_STATENT;
        }
        return $remnant;
    }
    
    /**
     * To be overridden for more functionality
     * @param type $matches
     * @param type $table
     */
    protected function extraCall($matches, $table){
        //void
    }

}
