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

use CTIMT\SqlControl\Enum\Attributes;
use CTIMT\SqlControl\Enum\Events;
use CTIMT\SqlControl\SqlControlManager;
use CTIMT\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Clears identified sql files, both applied and pending execution
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
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
