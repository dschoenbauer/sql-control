<?php

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of ConvertEnum
 *
 * @author David
 */
class ConvertEnum implements FilterInterface {

    CONST PATTERN = '/ENUM\((.*?)\)/i';

    public function filter($value) {
        if (preg_match(self::PATTERN, $value) !== 1) {
            return $value;
        }
        return preg_replace_callback(self::PATTERN, function($matches){
            $inner = preg_split('/[\'\"],[\'\"]/', trim($matches[1],'\'\"'));
            $mx = max(array_map('strlen',$inner));
            return sprintf('VARCHAR(%s)',$mx);
        }, $value);

    }

}
