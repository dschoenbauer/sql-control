<?php namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of AlterAddColumn
 *
 * @author David
 */
class AlterAddColumn extends AbstractAlter {

    public function getQualifyingPattern() {
        return '/ALTER\W+TABlE\W+(\w+)[\W\w]+ADD\W+COLUMN/i';
    }

    public function getDataPattern() {
        return '/ADD\W+COLUMN\W+(\w+)\W+([\w. \t\(\)]+?)(?:[\r\n\t ]+After\W\w+,?|,|$)/im';
    }

    public function getSQL($matches, $table) {
        return sprintf("ALTER TABLE %s ADD %s %s", $table, $matches[1], $this->filterSlag($matches[2]));
    }

    private function filterSlag($codeFragment) {
        $pattern = '/(After\W\w+,?|,|$)/im';
        return trim(preg_replace($pattern, '', $codeFragment));
    }

}
