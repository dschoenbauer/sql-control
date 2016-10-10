<?php
namespace Ctimt\SqlControl\Visitor;

use Ctimt\SqlControl\Framework\SqlControlManager;

/**
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
interface VisitorInterface
{
    public function visitSqlControlManager(SqlControlManager $sqlControlManager);
}
