<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of RemoveEngineSpecification
 *
 * @author David
 */
class RemoveEngineSpecification implements \Ctimt\SqlControl\Adapter\FilterInterface{
    public function filter($value) {
        $pattern = '/ENGINE.*CHARSET=\w+/';
        return preg_replace($pattern, '', $value);
    }

}
