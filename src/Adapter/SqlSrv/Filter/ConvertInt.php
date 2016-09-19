<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of ConvertInt
 *
 * @author David
 */
class ConvertInt implements FilterInterface{

    public function filter($value) {
        $pattern = "/int\(\d{0,3}\)/i";
        return preg_replace($pattern, "int", $value);
    }

}
