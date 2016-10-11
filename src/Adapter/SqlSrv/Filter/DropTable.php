<?php

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of DropTable
 *
 * @author David
 */
class DropTable implements FilterInterface {

    const PATTERN_QUALIFY = '/DROP\sTABLE(\s+IF\s+EXISTS)?\s+(\w+)/i';

    public function filter($value) {
        $matches = [];
        if (preg_match(self::PATTERN_QUALIFY, $value, $matches) !== 1) {
            return $value;
        }
        $table = $matches[2];
        if($matches[1]){
            return sprintf('IF EXISTS(SELECT * FROM [%1$s]) DROP TABLE [%1$s]', $table);
        }
        return sprintf('DROP TABLE [%s]', $table);

    }

}
