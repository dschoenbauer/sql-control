<?php namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of RemoveComments
 *
 * @author David
 */
class RemoveComments implements FilterInterface {

    public function filter($value) {
        $pattern = '/\/\*[\S\s]*\*\/|^\#.*$/im';
        return preg_filter($pattern, '', $value);
    }

}
