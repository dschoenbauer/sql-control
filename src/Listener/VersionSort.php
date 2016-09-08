<?php
/*
 * Copyright (C) 2016 David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
namespace CTIMT\SqlControl\Listener;

use CTIMT\SqlControl\Components\SqlGroup;
use CTIMT\SqlControl\Enum\Attributes;
use CTIMT\SqlControl\Enum\Events;
use CTIMT\SqlControl\Enum\Messages;
use CTIMT\SqlControl\SqlControlManager;
use CTIMT\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of Sorter
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
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
