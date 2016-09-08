<?php
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
