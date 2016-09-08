<?php
namespace Dschoenbauer\SqlControl\Listener;

use Dschoenbauer\SqlControl\Components\SqlGroup;
use Dschoenbauer\SqlControl\Enum\Attributes;
use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Enum\Messages;
use Dschoenbauer\SqlControl\SqlControlManager;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of Sorter
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class VersionSort implements VisitorInterface
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
