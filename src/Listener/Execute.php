<?php

namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Config\Configuration;
use Ctimt\SqlControl\Enum\Attributes;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Enum\OutputMessages;
use Ctimt\SqlControl\Exception\FailSqlException;
use Ctimt\SqlControl\Framework\SqlChange;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Framework\SqlGroup;
use Ctimt\SqlControl\Listener\Logger\Logger;
use Ctimt\SqlControl\Status\Fail;
use Ctimt\SqlControl\Status\Skipped;
use Ctimt\SqlControl\Status\Success;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use PDO;
use Zend\EventManager\Event;

/**
 * Description of Execute
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Execute implements VisitorInterface {

    private $_sqlControlManager;

    public function visitSqlControlManager(SqlControlManager $sqlControlManager) {
        $sqlControlManager->getEventManager()->attach(Events::EXECUTE, [$this, 'onExecute']);
    }

    public function onExecute(Event $event) {
        $this->setSqlControlManager($event->getTarget());
        $groups = $this->getSqlControlManager()->getAttributes()->getValue(Attributes::GROUPS, []);
        foreach ($groups as $group) {
            $this->executeGroup($group, $this->getSqlControlManager()->getAdapter());
        }
    }

    private function executeGroup(SqlGroup $group, PDO $adapter) {
        $versions = $group->getSqlChanges();
        $hasErrors = false;
        /* @var $version SqlChange */
        foreach ($versions as $version) {
            try {
                if (!$version->getStatus()->isPendingLoad()) {
                    continue;
                }
                if (!$hasErrors) {
                    $this->executeSql($adapter, $version->getStatements());
                    $version->setStatus(new Success());
                } else {
                    $version->setStatus(new Skipped());
                }
            } catch (FailSqlException $exc) {
                $hasErrors = true;
                $version->setStatus(new Fail());
                $this->reportError($exc->getSql(), $exc->getMessage(), $version->getName());
            }
            $this->logStatus($version);
        }
    }

    public function reportError($sql, $message, $file) {

        /* @var $messages Configuration */
        $messages = $this->getSqlControlManager()->getAttributes()->getValue(OutputMessages::ERROR_SQL, '');
        $context = compact('sql', 'message', 'file');

        $this->getSqlControlManager()->getEventManager()->trigger(
                Events::LOG_ERROR, $this->getSqlControlManager(), Logger::Message($messages, $context));
    }

    private function logStatus(SqlChange $sqlChange) {
        $key = ($sqlChange->getStatus()->isLoaded()) ? OutputMessages::STATUS_COMPLETE : OutputMessages::STATUS_ERROR;
        $logLevel = ($sqlChange->getStatus()->isLoaded()) ? Events::LOG_NOTICE : Events::LOG_WARNING;
        $message = $this->getSqlControlManager()->getAttributes()->getAttribute($key, "{status} - {file}{error}");
        $context = [
            'file' => $sqlChange->getName(),
            'status' => $sqlChange->getStatus()->getName(),
            'success' => $sqlChange->getStatus()->isLoaded(),
            'error' => $sqlChange->getAttributes()->getValue('error'),
        ];
        $em = $this->getSqlControlManager()->getEventManager();
        $em->trigger($logLevel, $this->getSqlControlManager(), Logger::Message($message, $context));
        $em->trigger(Events::RESULT, $this->getSqlControlManager(), $context);
    }

    private function executeSql(\PDO $adapter, $sqls) {
        try {
            foreach ($sqls as $sql) {
                if (strlen(trim($sql)) == 0) {
                    continue;
                }
                $message = $this->getSqlControlManager()->getAttributes()->getValue(OutputMessages::DEBUG_SQL, 'sql: {sql}');
                $this->getSqlControlManager()->getEventManager()->trigger(Events::LOG_DEBUG, $this->getSqlControlManager(), Logger::Message($message, ['sql' => trim($sql)]));
                $adapter->prepare($sql)->execute();
            }
        } catch (\Exception $exc) {
            throw new FailSqlException($exc->getMessage(), 0, $exc, $sql);
        }
    }

    /**
     * @return SqlControlManager
     */
    public function getSqlControlManager() {
        return $this->_sqlControlManager;
    }

    public function setSqlControlManager($sqlControlManager) {
        $this->_sqlControlManager = $sqlControlManager;
        return $this;
    }

}
