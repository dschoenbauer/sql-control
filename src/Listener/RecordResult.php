<?php
namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Visitor\VisitorInterface;

/**
 * Description of RecordResult
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class RecordResult implements VisitorInterface
{
    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::RESULT, [$this,'onResult']);
    }
}
