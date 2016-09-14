<?php
namespace Ctimt\SqlControl\Parser;

use Ctimt\SqlControl\Framework\SqlChange;

/**
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
interface ParseInterface
{
    public function Parse(SqlChange $sqlChange);
}
