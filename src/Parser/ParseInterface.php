<?php
namespace Dschoenbauer\SqlControl\Parser;

use Dschoenbauer\SqlControl\Framework\SqlChange;

/**
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
interface ParseInterface
{
    public function Parse(SqlChange $sqlChange);
}
