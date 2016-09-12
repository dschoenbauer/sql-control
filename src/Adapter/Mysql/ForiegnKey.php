<?php
namespace Dschoenbauer\SqlControl\Adapter\Mysql;

use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Components\SqlControlManager;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
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
