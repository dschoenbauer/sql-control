<?php
namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Enum\Attributes;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Clears identified sql files, both applied and pending execution
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Clear implements VisitorInterface
{

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::CLEAR, [$this, 'onClear']);
    }

    public function onClear(Event $event)
    {
        $this->clearData($event->getTarget());
        $eventNames = $event->getParam('events', []);
        foreach ($eventNames as $eventName) {
            $event->getTarget()->getEventManager()->trigger($eventName, $event->getTarget());
        }
    }

    public function clearData(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getAttributes()->add(Attributes::APPLIED_SQL_VERSIONS, []);
        $sqlControlManager->getAttributes()->add(Attributes::SQL_VERSIONS, []);
    }
}
