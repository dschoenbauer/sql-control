<?php namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Enum\Messages;
use Ctimt\SqlControl\Exception\InvalidArgumentException;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use PDO;
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
        /* @var $pdo PDO */
        $pdo = $event->getTarget()->getAdapter();
        $sqlTemplate = [
            'dblib' => 'IF  NOT EXISTS (SELECT name FROM master.dbo.sysdatabases WHERE name = N\'%1$s\') CREATE DATABASE [%1$s]',
            'sqlsrv' => 'IF  NOT EXISTS (SELECT name FROM master.dbo.sysdatabases WHERE name = N\'%1$s\') CREATE DATABASE [%1$s]',
            'mysql' => 'CREATE DATABASE IF NOT EXISTS %s;'
        ];
        $sql = sprintf($sqlTemplate[$pdo->getAttribute(PDO::ATTR_DRIVER_NAME)], $this->getDatabaseName());
        $pdo->exec($sql);
        $event->getTarget()->getEventManager()->trigger(Events::SETUP_TABLE, $event->getTarget());
    }

    public function getDatabaseName()
    {
        return $this->_databaseName;
    }

    public function setDatabaseName($databaseName)
    {
        if (!$databaseName) {
            throw new InvalidArgumentException(Messages::MISSING_DATABASE_NAME);
        }
        $this->_databaseName = $databaseName;
        return $this;
    }
}
