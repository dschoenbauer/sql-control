<?php
namespace Dschoenbauer\SqlControl\Parser;

use Dschoenbauer\SqlControl\Components\SqlChange;

/**
 * Description of FileVersion
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class FileVersion implements ParseInterface
{
    public function Parse(SqlChange $sqlChange)
    {
        $fileName = $sqlChange->getName();
        preg_match('/\.([\d\.]+)\./', $fileName, $matches);
        $versionRaw = explode('.', array_pop($matches));
        $major = (int) array_shift($versionRaw);
        $minor = (int) array_shift($versionRaw);
        $patch = (int) array_shift($versionRaw);
        return sprintf('%s.%s.%s', $major, $minor, $patch);
    }
}
