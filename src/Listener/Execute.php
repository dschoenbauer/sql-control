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
use CTIMT\SqlControl\Components\SqlChange;
use CTIMT\SqlControl\Enum\Attributes;
use CTIMT\SqlControl\Enum\Events;
use CTIMT\SqlControl\SqlControlManager;
use CTIMT\SqlControl\Status\Fail;
use CTIMT\SqlControl\Status\Skipped;
use CTIMT\SqlControl\Status\Success;
use CTIMT\SqlControl\Visitor\VisitorInterface;
use Exception;
use PDO;
use Zend\EventManager\Event;

/**
 * Description of Execute
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Execute implements VisitorInterface
{

    private $_sqlControlManager;

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::EXECUTE, [$this, 'onExecute']);
    }

    public function onExecute(Event $event)
    {
        $this->setSqlControlManager($event->getTarget());
        $groups = $this->getSqlControlManager()->getAttributes()->getValue(Attributes::GROUPS, []);
        foreach ($groups as $group) {
            $this->executeGroup($group, $this->getSqlControlManager()->getAdapter());
        }
    }

    private function executeGroup(SqlGroup $group, PDO $adapter)
    {
        $versions = $group->getSqlChanges();
        $noErrors = true;
        /* @var $version SqlChange */
        foreach ($versions as $version) {
            try {
                if(!$version->getStatus()->isPendingLoad()){
                    continue;
                }
                if ($noErrors) {
                    $this->executeSql($adapter, $version->getStatements());
                    $version->setStatus(new Success());
                }else{
                    $version->setStatus(new Skipped());
                }
            } catch (Exception $exc) {
                $noErrors = false;
                $version->setStatus(new Fail());
                $version->getAttributes()->add('error', ' - ' . $exc->getMessage());
            }
            $this->logStatus($version);
        }
    }

    private function logStatus(SqlChange $sqlChange)
    {
        $message = "{status} - {file}{error}";
        $context = [
            'file' => $sqlChange->getName(),
            'status' => $sqlChange->getStatus()->getName(),
            'success' => $sqlChange->getStatus()->isLoaded(),
            'error' => $sqlChange->getAttributes()->getValue('error'),
        ];
        $em = $this
            ->getSqlControlManager()
            ->getEventManager();

        $em->trigger(Events::LOG_INFO, $this->getSqlControlManager(), compact('message', 'context'));
        $em->trigger(Events::RESULT, $this->getSqlControlManager(), $context);
    }

    private function executeSql(\PDO $adapter, $sqls)
    {
        foreach ($sqls as $sql) {
            $adapter->prepare($sql)->execute();
        }
    }

    /**
     * @return SqlControlManager
     */
    public function getSqlControlManager()
    {
        return $this->_sqlControlManager;
    }

    public function setSqlControlManager($sqlControlManager)
    {
        $this->_sqlControlManager = $sqlControlManager;
        return $this;
    }
}
