<?php

namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Config\Configuration;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Enum\Messages;
use Ctimt\SqlControl\Enum\Statements;
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
class SetupDatabase implements VisitorInterface {

    private $_databaseName;
    private $_config;

    public function __construct($databaseName, Configuration $config) {
        $this->setDatabaseName($databaseName)->setConfig($config);
    }

    public function visitSqlControlManager(SqlControlManager $sqlControlManager) {
        $sqlControlManager->getEventManager()->attach(Events::SETUP_DATABASE, [$this, 'onSetup'], 100);
    }

    public function onSetup(Event $event) {
        /* @var $pdo PDO */
        $pdo = $event->getTarget()->getAdapter();
        $sql = sprintf($this->getConfig()->getValue(Statements::CREATE_DATABASE), $this->getDatabaseName());
        $pdo->exec($sql);
        $event->getTarget()->getEventManager()->trigger(Events::SETUP_TABLE, $event->getTarget());
    }

    public function getDatabaseName() {
        return $this->_databaseName;
    }

    public function setDatabaseName($databaseName) {
        if (!$databaseName) {
            throw new InvalidArgumentException(Messages::MISSING_DATABASE_NAME);
        }
        $this->_databaseName = $databaseName;
        return $this;
    }

    /**
     * 
     * @return Configuration
     */
    public function getConfig() {
        return $this->_config;
    }

    public function setConfig($config) {
        $this->_config = $config;
        return $this;
    }

}
