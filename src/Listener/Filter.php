<?php

namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Adapter\FilterInterface;
use Ctimt\SqlControl\Enum\Attributes;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Framework\SqlChange;
use Ctimt\SqlControl\Framework\SqlChangeAwareInterface;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Framework\SqlGroup;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of Sorter
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Filter implements VisitorInterface {

    private $_filters = [];

    public function __construct(array $filters = []) {
        foreach ($filters as $filter) {
            $this->add($filter);
        }
    }

    public function add(FilterInterface $filter) {
        $this->_filters[] = $filter;
    }

    public function visitSqlControlManager(SqlControlManager $sqlControlManager) {
        $sqlControlManager->getEventManager()->attach(Events::PREPARE, [$this, 'onGroup'], -10000);
    }

    public function onGroup(Event $event) {
        $groups = $event->getTarget()->getAttributes()->getValue(Attributes::GROUPS, []);
        foreach ($groups as $group) {
            $this->filterGroup($group);
        }
    }

    public function filterGroup(SqlGroup $group) {
        $sqlChanges = $group->getSqlChanges();
        foreach ($sqlChanges as $sqlChange) {
            $this->filterSqlChange($sqlChange);
        }
    }

    public function filterSqlChange(SqlChange $sqlChange) {
        for ($id = 0; $id < count($sqlChange->getStatements()); $id++) {
            $this->filterStatement($sqlChange, $id);
        }
    }
    
    public function filterStatement(SqlChange $sqlChange, $id){
        $filters = $this->_filters;
        $sql = $sqlChange->getStatement($id);
        /* @var $filters FilterInterface */
        foreach ($filters as $filter) {
            if ($filter instanceof SqlChangeAwareInterface) {
                $filter->setSqlChange($sqlChange);
            }
            $sql = $filter->filter($sql);
        }
        $sqlChange->setStatement($id, $sql);        
    }

}
