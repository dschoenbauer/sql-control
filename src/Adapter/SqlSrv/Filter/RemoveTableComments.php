<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of RemoveComments
 *
 * @author David
 */
class RemoveTableComments implements FilterInterface{

    public function filter($value) {
        $pattern = "/COMMENT=[\W\w]+/";
        return preg_replace($pattern, '', $value);
    }

}
