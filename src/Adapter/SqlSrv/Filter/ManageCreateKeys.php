<?php namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;
use Ctimt\SqlControl\Framework\SqlChange;
use Ctimt\SqlControl\Framework\SqlChangeAwareInterface;

/**
 * Description of ManageCreateKeys
 *
 * @author David
 */
class ManageCreateKeys implements FilterInterface, SqlChangeAwareInterface {

    private $_sqlChange;

    public function filter($value) {
        /* @var $table type */

        if (!preg_match('/CREATE TABLE ([\[\w\]]+) \(/', $value, $matches)) {
            return $value;
        }
        $table = $matches[1];
        $pattern = '/(?:UNIQUE)?\WKEY\s+(\w+)\s+\(([\w, ]+)\),?/i';
        return preg_replace_callback($pattern, function($matches) use($table) {
            $sql = sprintf("CREATE INDEX %s ON %s (%s)", $matches[1], $table, $matches[2]);
            $this->getSqlChange()->addStatement($sql);
            return null;
        }, $value);
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
