<?php namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of ConvertHashComments
 *
 * @author David
 */
class ConvertHashComments implements FilterInterface{
    //put your code here
    public function filter($value) {
        return preg_replace('/^#(.*)$/im', '/*$1*/', $value);
    }

}
