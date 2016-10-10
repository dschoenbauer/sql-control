<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of ManageVarcharMax
 *
 * @author David
 */
class ManageVarcharMax implements \Ctimt\SqlControl\Adapter\FilterInterface {

    const MSSQL_LIMIT = 8000;
    
    public function filter($value) {
        $pattern = "/VARCHAR\W*?\((\w+)\)/i";
        return preg_replace_callback($pattern, function($matches){
            if(is_numeric($matches[1]) && (int)$matches[1] > self::MSSQL_LIMIT){
                return str_replace($matches[1], 'max', $matches[0]);
            }
            return $matches[0];
        }, $value);
    }

}
