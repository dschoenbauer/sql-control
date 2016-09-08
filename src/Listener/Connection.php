<?php
/*
 * Copyright (C) 2016 David Schoenbauer <dschoenbauer@gmail.com>
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
namespace Dschoenbauer\SqlControl\Listener;

use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\SqlControlManager;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
use Exception;
use PDO;
use Zend\EventManager\Event;

/**
 * Sets up the sql control manager database connection
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Connection implements VisitorInterface
{

    use SetupTrait;    
    private $_connection;
    private $_targetDatabaseName = null;
    
    public function __construct($connection,$targetDatabaseName)
    {
        $this
            ->setConnection($connection)
            ->setTargetDatabaseName($targetDatabaseName);
        $this->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::LOAD, [$this,'onLoad']);
    }
    
    public function onLoad(Event $event){
        try {
            $sql = sprintf("USE %s", $this->getTargetDatabaseName());
            $event->getTarget()
                ->setAdapter($this->getConnection())
                ->getAdapter()->exec($sql);
        } catch (Exception $exc) {
            $this->setup($exc, $event->getTarget());
            $event->getTarget()->getEventManager()->trigger(Events::CLEAR,$event->getTarget(),['events'=>[Events::LOAD]]);
        }
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    public function setConnection($connection)
    {
        $this->_connection = $connection;
        return $this;
    }
    
    public function getTargetDatabaseName()
    {
        return $this->_targetDatabaseName;
    }

    public function setTargetDatabaseName($targetDatabaseName)
    {
        $this->_targetDatabaseName = $targetDatabaseName;
        return $this;
    }


}
