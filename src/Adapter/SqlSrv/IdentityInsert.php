<?php
/*
 * Copyright (c) 2016, David Schoenbauer <dschoenbauer@gmail.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     - Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *
 *     - Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 *     - Neither the name of David Schoenbauer, Ctimt nor the names of its 
 *       contributors may be used to endorse or promote products derived
 *       from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Ctimt\SqlControl\Adapter\SqlSrv;

use Ctimt\SqlControl\Enum\Attributes;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of IdentityInsert
 *
 * @author Bruce Schubert
 */
class IdentityInsert implements VisitorInterface
{

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::LOAD, [$this, 'onLoad']);
    }

    public function onLoad(Event $event)
    {
        $database = $event->getTarget()->getAttributes()->getValue(Attributes::TARGET_DATABASE,null);
        if(!$database){
            throw new \Ctimt\SqlControl\Exception\InvalidArgumentException('No database specified');
        }
        $sql = sprintf('SET IDENTITY_INSERT dbo.%s ON',$database);
        //print_r($sql);
        //$event->getTarget()->getAdapter()->exec($sql);
    }

}
