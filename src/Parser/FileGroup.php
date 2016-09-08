<?php
namespace Dschoenbauer\SqlControl\Parser;

/**
 * Description of FileGroup
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class FileGroup implements ParseInterface
{
    public function Parse(\Dschoenbauer\SqlControl\Components\SqlChange $sqlChange)
    {
        $fileName = $sqlChange->getName();
        preg_match('/^([\w-]+)/', $fileName, $matches);
        $group = array_pop($matches);
        return $group;
    }
}
