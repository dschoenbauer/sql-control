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

use Dschoenbauer\SqlControl\Components\SqlGroup;
use Dschoenbauer\SqlControl\Components\SqlChange;
use Dschoenbauer\SqlControl\Enum\Attributes;
use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Enum\Messages;
use Dschoenbauer\SqlControl\SqlControlManager;
use Dschoenbauer\SqlControl\Status\Depreciated;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Marks any sql change as depreciated if a newer major version is available
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class DepreciationManager implements VisitorInterface
{

    private $_filesDepreciated = 0;
    
    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::PREPARE, [$this, 'onGroup'], -10000);
    }
    
    public function onGroup(Event $event){
        $groups = $event->getTarget()->getAttributes()->getValue(Attributes::GROUPS,[]);
        /* @var $group SqlGroup */
        foreach ($groups as $group){
            $this->processMajorVersionChanges($group);
            $this->depreciateOutdatedVersions($group);
        }
        $event->getTarget()->getEventManager()->trigger(Events::LOG_INFO, $event->getTarget(),['message'=> Messages::INFO_VERSIONS_DEPRECIATED,'context'=>['count'=>$this->_filesDepreciated]]);
    }

    public function processMajorVersionChanges(SqlGroup $group)
    {
        $versions = $group->getSqlChanges();
        /* @var $version SqlChange */
        foreach ($versions as $version) {
            if(!$version->getStatus()->isPendingLoad()){
                continue;
            }
            $majorVersion = $this->getMajorVersion($version->getVersion());
            if(version_compare($majorVersion, $group->getCurrentVersion()) == 1){
                $group->incrementVersion($majorVersion);
            }
        }
    }
    
    public function getMajorVersion($version){
        $versions = explode('.', $version);
        $majorVersion = array_shift($versions);
        return sprintf('%s.0.0', $majorVersion);
    }


    private function depreciateOutdatedVersions(SqlGroup $group)
    {
        $versions = $group->getSqlChanges();
        /* @var $version SqlChange */
        foreach ($versions as $version) {
            if(!$version->getStatus()->isPendingLoad()){
                continue;
            }
            if(version_compare($group->getCurrentVersion(), $version->getVersion()) == 1){
                $version->setStatus(new Depreciated());
                $this->_filesDepreciated ++;
            }
        }
    }
}
