<?php

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of InsertOnDuplicateKey
 *
 * @author David
 */
class InsertOnDuplicateKey implements FilterInterface {

    public function filter($value) {
        $pattern = '/(INSERT\W+INTO\W+\w+.*?)(\W?ON\W+DUPLICATE\W+KEY\W+UPDATE.*?)(?:;|$)/i';
        return preg_replace($pattern, '$1;', $value);
    }

}
