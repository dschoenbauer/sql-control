<?php
namespace Ctimt\SqlControl\Parser;

use Ctimt\SqlControl\Framework\SqlChange;
use Ctimt\SqlControl\Enum\Attributes;

/**
 * Description of FileSqlStatements
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class FileSqlStatements implements ParseInterface
{
    public function Parse(SqlChange $sqlChange)
    {
        $fileContents = $this->getFileContents($sqlChange->getFullPath());
        $sqlChange->getAttributes()->add(Attributes::ORIGINAL_SQL_STATEMENT, $fileContents);
        return array_filter(explode(";", $fileContents));
    }
    
    public function getFileContents($fullPath){
        return trim(file_get_contents($fullPath));
    }
}
