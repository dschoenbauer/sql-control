<?php
namespace Dschoenbauer\SqlControl\Listener;

use Dschoenbauer\SqlControl\Framework\SqlChange;
use Dschoenbauer\SqlControl\Framework\SqlControlManager;
use Dschoenbauer\SqlControl\Framework\SqlGroup;
use Dschoenbauer\SqlControl\Enum\Attributes;
use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Status\Fail;
use Dschoenbauer\SqlControl\Status\Skipped;
use Dschoenbauer\SqlControl\Status\Success;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
use Exception;
use PDO;
use Zend\EventManager\Event;

/**
 * Description of Execute
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
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
        $hasErrors = false;
        /* @var $version SqlChange */
        foreach ($versions as $version) {
            try {
                if(!$version->getStatus()->isPendingLoad()){
                    continue;
                }
                if (!$hasErrors) {
                    $this->executeSql($adapter, $version->getStatements());
                    $version->setStatus(new Success());
                }else{
                    $version->setStatus(new Skipped());
                }
            } catch (Exception $exc) {
                $hasErrors = true;
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
