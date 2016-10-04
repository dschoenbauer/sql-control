<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of ReplaceAutoIncrement
 *
 * @author David
 */
class ReplaceAutoIncrement implements \Ctimt\SqlControl\Adapter\FilterInterface{
    public function filter($value) {
        $pattern = '/(NOT\W+NULL\W+)?AUTO_INCREMENT/i';
        return preg_replace($pattern, 'IDENTITY', $value);
    }

}
