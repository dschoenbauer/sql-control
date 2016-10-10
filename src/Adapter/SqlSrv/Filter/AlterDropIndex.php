<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of AlterDropIndex
 *
 * @author David
 */
class AlterDropIndex extends AbstractAlter {

    public function getQualifyingPattern() {
        return '/^\W*ALTER\WTABLE\W+(\w+).*?DROP\W+INDEX/im';
    }
    
    public function getDataPattern() {
        return '/DROP\W+INDEX\W+(\w+),?\W+/im';
    }

    public function getSQL($matches, $table) {
        return sprintf("DROP INDEX %s ON %s",$matches[1], $table);
    }

}
