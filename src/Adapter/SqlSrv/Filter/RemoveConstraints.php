<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of RemoveConstraints
 *
 * @author David
 */
class RemoveConstraints implements \Ctimt\SqlControl\Adapter\FilterInterface {

    public function filter($value) {
        $pattern = '/CONSTRAINT \w+ FOREIGN KEY \(\w+\) REFERENCES [\[\w\]]+ \(\w+\) [\w ]+ACTION,?/';
        return preg_replace($pattern, '', $value);
    }

}
