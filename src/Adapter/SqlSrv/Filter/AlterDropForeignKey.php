<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of AlterDropForeignKey
 *
 * @author David
 */
class AlterDropForeignKey extends AbstractAlter {

    public function getQualifyingPattern() {
        return '/^\W*ALTER\WTABLE\W+(\w+).*?DROP\W+FOREIGN\W+KEY\W+/im';
    }

    public function getDataPattern() {
        return '/DROP\W+FOREIGN\W+KEY\W+(\w+)/im';
    }

    public function getSQL($matches, $table) {
        return sprintf('IF (OBJECT_ID(\'%2$s\', \'F\') IS NOT NULL)
BEGIN
    ALTER TABLE %1$s DROP CONSTRAINT %2$s
END', $table, $matches[1]);
    }

}
