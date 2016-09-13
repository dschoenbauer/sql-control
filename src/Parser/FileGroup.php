<?php namespace Dschoenbauer\SqlControl\Parser;

use Dschoenbauer\SqlControl\Framework\SqlChange;

/**
 * Description of FileGroup
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class FileGroup implements ParseInterface
{

    public function Parse(SqlChange $sqlChange)
    {
        $fileName = $sqlChange->getName();
        preg_match('/^([\w-]+)/', $fileName, $matches);
        return array_pop($matches);
    }
}
