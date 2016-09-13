<?php
namespace Dschoenbauer\SqlControl\Parser;

use Dschoenbauer\SqlControl\Framework\SqlChange;
use Dschoenbauer\SqlControl\Enum\Attributes;

/**
 * Description of FileSqlStatements
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class FileSqlStatements implements ParseInterface
{
    public function Parse(SqlChange $sqlChange)
    {
        $fileContents = trim(file_get_contents($sqlChange->getFullPath()));
        $sqlChange->getAttributes()->add(Attributes::ORIGINAL_SQL_STATEMENT, $fileContents);
        return array_filter(explode(";", $fileContents));
    }
}
