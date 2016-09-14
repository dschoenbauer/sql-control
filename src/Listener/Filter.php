<?php
namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Enum\Attributes;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Framework\SqlGroup;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use Ctimt\SqlControl\FilterInterface;

use Zend\EventManager\Event;

/**
 * Description of Sorter
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Filter implements VisitorInterface
{
    private $_totalSorted = 0;
    private $_filters = [];
    
    public function __construct(array $filters = []){
        foreach ($filters as $filter) {
            $this->add($filter);
        }
    }
    
    public function add(FilterInterface $filter){
        $this->_filters[] = $filter;
    }


    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::PREPARE, [$this, 'onGroup'], -10000);
    }

    public function onGroup(Event $event)
    {
        $groups = $event->getTarget()->getAttributes()->getValue(Attributes::GROUPS, []);
        foreach ($groups as $group) {
            $this->filterSQL($group);
        }
    }

    private function filterSQL(SqlGroup $group)
    {
        $sqlChanges = $group->getSqlChanges();
        usort($sqlChanges, function($a, $b) {
            return version_compare($a->getVersion(), $b->getVersion());
        });
        $group->setSqlChanges($sqlChanges);
        $this->_totalSorted += count($sqlChanges);
    }
}
