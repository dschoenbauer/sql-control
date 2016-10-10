<?php
namespace Ctimt\SqlControl\Adapter\Mysql;

use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of ForiegnKey
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class ForiegnKey implements VisitorInterface
{
    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::LOAD, [$this,'onLoad']);
    }
    
    public function onLoad(Event $event){
        $event->getTarget()->getAdapter()->exec('SET foreign_key_checks = 0');
    }
}
