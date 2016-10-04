<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of AlterDropColumn
 *
 * @author David
 */
class AlterDropColumn extends AbstractAlter {

    public function getQualifyingPattern() {
        return '/^\W*ALTER\WTABLE\W+(\w+)/i';
    }

    public function getDataPattern() {
        return '/DROP\W+COLUMN\W+(\w+),?\W+?/im';
    }

    public function getSQL($matches, $table) {
        return sprintf("ALTER TABLE %s DROP COLUMN %s", $table, $matches[1]);
    }

}
