<?php
namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Framework\SqlGroup;
use Ctimt\SqlControl\Enum\Attributes;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Enum\Messages;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of Sorter
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class SortVersion implements VisitorInterface
{
    private $_totalSorted = 0;

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::PREPARE, [$this, 'onGroup'], -10000);
    }

    public function onGroup(Event $event)
    {
        $groups = $event->getTarget()->getAttributes()->getValue(Attributes::GROUPS, []);
        foreach ($groups as $group) {
            $this->sortGroup($group);
        }
        $event->getTarget()->getEventManager()->trigger(Events::LOG_INFO, $event->getTarget(),['message'=>  Messages::INFO_VERSIONS_ORDERED,'context'=>['count'=>$this->_totalSorted]]);
    }

    public function sortGroup(SqlGroup $group)
    {
        $sqlChanges = $group->getSqlChanges();
        usort($sqlChanges, function($a, $b) {
            return version_compare($a->getVersion(), $b->getVersion());
        });
        $group->setSqlChanges($sqlChanges);
        $this->_totalSorted += count($sqlChanges);
    }
}
