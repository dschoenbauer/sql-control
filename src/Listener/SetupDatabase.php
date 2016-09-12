<?php
namespace Dschoenbauer\SqlControl\Listener;

use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Enum\Messages;
use Dschoenbauer\SqlControl\Exception\InvalidArgumentException;
use Dschoenbauer\SqlControl\Components\SqlControlManager;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of Setup
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
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
