<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of RepairDelete
 *
 * @author David
 */
class RepairDelete implements \Ctimt\SqlControl\Adapter\FilterInterface{
    
    public function filter($value) {
        $pattern = "/DELETE\W+(\w+)\.\*/i";
        return preg_replace($pattern, 'DELETE', $value);
    }

}
