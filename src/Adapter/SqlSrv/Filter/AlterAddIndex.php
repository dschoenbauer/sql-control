<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of AlterAddColumn
 *
 * @author David
 */
class AlterAddIndex extends AbstractAlter {

    public function getQualifyingPattern() {
        return '/ALTER\W+TABlE\W+(\w+)[\W\w]+ADD(\s+UNIQUE)?\s+INDEX/i';
    }

    public function getDataPattern() {
        return '/ADD(\s+UNIQUE)?\s+INDEX\s+(\w+)\s+\(([\w ,]+)\)/im';
    }

    public function getSQL($matches, $table) {
        return sprintf("CREATE%s INDEX %s ON %s (%s)", $matches[1], $matches[2], $table, $matches[3]);
    }

}
