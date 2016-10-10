<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of ConverTextEscapeChar
 *
 * @author David
 */
class ConverTextEscapeChar implements \Ctimt\SqlControl\Adapter\FilterInterface{
    public function filter($value) {
        return str_replace('\\\'', '\'\'',$value);
    }
}
