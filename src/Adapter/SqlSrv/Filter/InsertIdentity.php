<?php namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;
use Ctimt\SqlControl\Framework\SqlChange;
use Ctimt\SqlControl\Framework\SqlChangeAwareInterface;

/**
 * Description of InsertIdentity
 *
 * @author David
 */
class InsertIdentity implements FilterInterface, SqlChangeAwareInterface {

    private $_SqlChange;

    public function filter($value) {
        $pattern = "/insert\W+into\W+(\w+)(?:\W*\(([\w, ]+)\))?/i";
        if (preg_match($pattern, $value, $matches) !== 1) {
            return $value;
        }

        $table = $matches[1];
        $fields = isset($matches[2]) ? $matches[2] : null;
        $isIndexInPlayPattern = "/(?:^|[,\s])(id|" . $table . "[_-]?id)(?:$|[,\s])/i";
        if (preg_match($isIndexInPlayPattern, $fields) !== 1) {
            return $value;
        }

        $sqlOn = sprintf("SET IDENTITY_INSERT dbo.[%s] ON;", $table);
        $sqlOff = sprintf("SET IDENTITY_INSERT dbo.[%s] OFF;", $table);
        return $sqlOn . $this->addSuffix($value, ";") . $sqlOff;
    }

    public function getSqlChange() {
        return $this->_SqlChange;
    }

    public function setSqlChange(SqlChange $SqlChange) {
        $this->_SqlChange = $SqlChange;
        return $this;
    }

    private function addSuffix($value, $suffix) {
        return substr($value, -1 * strlen($suffix)) !== $suffix ? $value . $suffix : $value;
    }

}
