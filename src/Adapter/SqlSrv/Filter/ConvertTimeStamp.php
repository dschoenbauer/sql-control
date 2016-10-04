<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of ConvertTimeStamp
 *
 * @author David
 */
class ConvertTimeStamp implements FilterInterface {

    public function filter($value) {
        $pattern = "/\Wtimestamp(?: NOT NULL)?( DEFAULT CURRENT_TIMESTAMP)?( ON UPDATE CURRENT_TIMESTAMP)?(?: NOT NULL)?/i";
        $replacement = ' DATETIME DEFAULT(GETDATE())';
        return preg_replace($pattern, $replacement, $value);
    }

}
