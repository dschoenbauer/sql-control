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

use CTIMT\SqlControl\Enum\Events;
use CTIMT\SqlControl\Enum\Messages;
use CTIMT\SqlControl\Exception\InvalidArgumentException;
use CTIMT\SqlControl\SqlControlManager;
use CTIMT\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of Setup
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class SetupDatabase implements VisitorInterface
{

    private $_databaseName;

    public function __construct($databaseName)
    {
        $this->setDatabaseName($databaseName);
    }

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::SETUP_DATABASE, [$this, 'onSetup'], 100);
    }

    public function onSetup(Event $event)
    {
        $sql = sprintf('CREATE DATABASE IF NOT EXISTS %s;', $this->getDatabaseName());
        $event->getTarget()->getAdapter()->exec($sql);
        $event->getTarget()->getEventManager()->trigger(Events::SETUP_TABLE,$event->getTarget());
    }

    public function getDatabaseName()
    {
        return $this->_databaseName;
    }

    public function setDatabaseName($databaseName)
    {
        if(!$databaseName){
            throw new InvalidArgumentException(Messages::MISSING_DATABASE_NAME);
        }
        $this->_databaseName = $databaseName;
        return $this;
    }
}
