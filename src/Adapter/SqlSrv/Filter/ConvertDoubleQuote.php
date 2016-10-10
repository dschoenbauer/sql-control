<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of ConvertDouble
 *
 * @author David
 */
class ConvertDoubleQuote implements FilterInterface {

    public function filter($value) {
        return preg_replace_callback('/\"([^\"]*)\"/', function($matches){
            return "'" . str_replace("'","''",$matches[1]) . "'";
        }, $value);
    }

}
