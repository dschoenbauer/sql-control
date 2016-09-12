<?php
namespace Dschoenbauer\SqlControl\Listener;

use Dschoenbauer\SqlControl\Components\SqlGroup;
use Dschoenbauer\SqlControl\Components\SqlChange;
use Dschoenbauer\SqlControl\Enum\Attributes;
use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Enum\Messages;
use Dschoenbauer\SqlControl\Components\SqlControlManager;
use Dschoenbauer\SqlControl\Status\Loaded;
use Dschoenbauer\SqlControl\Status\PendingLoad;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of Grouper
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Grouper implements VisitorInterface
{

    private $_groupsCreated = 0;

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::PREPARE, [$this, 'onGroup']);
    }

    public function onGroup(Event $event)
    {
        $groups = $event->getTarget()->getAttributes()->getValue(Attributes::GROUPS, []);
        $appliedSqls = $event->getTarget()->getAttributes()->getValue(Attributes::APPLIED_SQL_VERSIONS, []);
        $appliedGroups = $this->group($groups, $appliedSqls, new Loaded(), true);

        $allSqls = $event->getTarget()->getAttributes()->getValue(Attributes::SQL_VERSIONS, []);
        $diff = array_diff_key($allSqls, $appliedSqls);

        $grouped = $this->group($appliedGroups, $diff, new PendingLoad());

        $event->getTarget()->getAttributes()->add(Attributes::GROUPS, $grouped);
        $event->getTarget()->getEventManager()->trigger(Events::LOG_INFO, $event->getTarget(),['message'=> Messages::INFO_VERSIONS_GROUPS_CREATED,'context'=>['count'=>$this->_groupsCreated]]);
        $event->getTarget()->getEventManager()->trigger(Events::LOG_INFO, $event->getTarget(),['message'=> Messages::INFO_VERSIONS_PENDING_EXECUTTION,'context'=>['count'=>count($diff)]]);
    }

    private function group(array $groups, array $sqlChanges, $status, $updateVersion = false)
    {
        foreach ($sqlChanges as $sqlChange) {
            /* @var $sqlChange SqlChange */
            if (!array_key_exists($sqlChange->getGroup(), $groups)) {
                $groups[$sqlChange->getGroup()] = new SqlGroup();
                $groups[$sqlChange->getGroup()]->setName($sqlChange->getGroup());
                $this->_groupsCreated++;
            }
            if ($updateVersion) {
                $groups[$sqlChange->getGroup()]->incrementVersion($sqlChange->getVersion());
            }
            $sqlChange->setStatus($status);
            $groups[$sqlChange->getGroup()]->add($sqlChange);
        }
        return $groups;
    }
}
