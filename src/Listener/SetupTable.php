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
use Zend\EventManager\Event;

/**
 * Description of SetupTable
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class SetupTable implements VisitorInterface
{

    private $table;
    private $fieldScriptName;
    private $fieldSuccess;

    public function __construct($table, $fieldScriptName, $fieldSuccess)
    {
        $this->setTable($table)->setFieldScriptName($fieldScriptName)->setFieldSuccess($fieldSuccess);
    }

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::SETUP_TABLE, [$this, 'onSetup']);
    }

    public function onSetup(Event $event)
    {
        /* @var $sqlControlManager SqlControlManager */
        $sqlControlManager = $event->getTarget();
        try {
            $sqlControlManager->getAdapter()->exec($this->getCreateSql());
        } catch (Exception $exc) {
            $sqlControlManager
                ->getEventManager()
                ->trigger(Events::LOG_ERROR, $event->getTarget(), [
                    'exception' => $exc,
                    'message' => 'Issues with creating table: {table}',
                    'context' => ['table' => $this->getTable()]
            ]);
        }
    }

    private function getCreateSql()
    {
        return sprintf('CREATE TABLE IF NOT EXISTS %s (
                        id int(10) unsigned NOT NULL AUTO_INCREMENT,
                        %s varchar(100) DEFAULT NULL,
                        created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        %s tinyint(1) DEFAULT \'0\',
                        PRIMARY KEY (id)
                      )', $this->getTable(), $this->getFieldScriptName(), $this->getFieldSuccess());
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getFieldScriptName()
    {
        return $this->fieldScriptName;
    }

    public function getFieldSuccess()
    {
        return $this->fieldSuccess;
    }

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function setFieldScriptName($fieldScriptName)
    {
        $this->fieldScriptName = $fieldScriptName;
        return $this;
    }

    public function setFieldSuccess($fieldSuccess)
    {
        $this->fieldSuccess = $fieldSuccess;
        return $this;
    }
}
