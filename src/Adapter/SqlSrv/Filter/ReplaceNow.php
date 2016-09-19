<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of ReplaceNow
 *
 * @author David
 */
class ReplaceNow implements FilterInterface {
    public function filter($value) {
        return str_replace('NOW()', 'GETDATE()', $value);
    }

}
