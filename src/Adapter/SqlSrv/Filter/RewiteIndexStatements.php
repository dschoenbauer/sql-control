<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of RewiteIndexStatements
 *
 * @author David
 */
class RewiteIndexStatements implements \Ctimt\SqlControl\Adapter\FilterInterface {

    public function filter($value) {
        $pattern = '/ALTER\W+TABLE\W+(\w+)\W+ADD(?:\W+FULLTEXT)?\W+INDEX\W+(\w+)\W+\((\w+)\)/';
        if(preg_match($pattern, $value, $matches)){
            return sprintf("CREATE INDEX %s ON %s (%s)", $matches[2], $matches[1], $matches[3]);            
        }
        return $value;
    }

}
