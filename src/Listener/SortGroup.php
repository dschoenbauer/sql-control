<?php
namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Enum\Attributes;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of Sorter
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class SortGroup implements VisitorInterface
{
    private $_totalSorted = 0;

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::PREPARE, [$this, 'onGroup'], -10000);
    }

    public function onGroup(Event $event)
    {
        $groups = $event->getTarget()->getAttributes()->getValue(Attributes::GROUPS, []);
        ksort($groups);
        $event->getTarget()->getAttributes()->add(Attributes::GROUPS, $groups);
    }

}
