<?php
namespace Dschoenbauer\SqlControl\Parser;

use Dschoenbauer\SqlControl\Components\SqlChange;

/**
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
interface ParseInterface
{
    public function Parse(SqlChange $sqlChange);
}
