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
class AlterAddIndex extends AbstractAlter{
    

    public function getQualifyingPattern() {
        return '/ALTER\W+TABlE\W+(\w+)[\W\w]+ADD\W+INDEX/i';
    }
    
    public function getDataPattern() {
        return '/ADD\W+INDEX\W+(\w+)\W+\(([\w ,]+)\)/im';
    }

    public function getSQL($matches, $table) {
        return sprintf("CREATE INDEX %s ON %s (%s)", $matches[1], $table, $matches[2]);
    }

}
