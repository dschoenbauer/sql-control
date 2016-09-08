<?php
namespace Dschoenbauer\SqlControl\Visitor;

use Dschoenbauer\SqlControl\SqlControlManager;

/**
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
interface VisitorInterface
{
    public function visitSqlControlManager(SqlControlManager $sqlControlManager);
}
