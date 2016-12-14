<?php

namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Config\Configuration;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Enum\OutputMessages;
use Ctimt\SqlControl\Enum\Statements;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Listener\Logger\Logger;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use Exception;
use Zend\EventManager\Event;

/**
 * Description of SetupTable
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class SetupTable implements VisitorInterface {

    private $table;
    private $fieldScriptName;
    private $fieldSuccess;
    private $config;

    public function __construct($table, $fieldScriptName, $fieldSuccess, Configuration $config) {
        $this->setTable($table)
                ->setFieldScriptName($fieldScriptName)
                ->setFieldSuccess($fieldSuccess)
                ->setConfig($config);
    }

    public function visitSqlControlManager(SqlControlManager $sqlControlManager) {
        $sqlControlManager->getEventManager()->attach(Events::SETUP_TABLE, [$this, 'onSetup']);
    }

    public function onSetup(Event $event) {
        /* @var $sqlControlManager SqlControlManager */
        $sqlControlManager = $event->getTarget();
        try {
            $sql = $this->getCreateSql();
            $sqlControlManager->getAdapter()->exec($sql);
        } catch (Exception $exc) {
            $message = "Issues with creating table: {table} \n  {sql} \n {errorMessage}";
            $context = ['file' => $this->getTable(), 'sql' => $sql, 'message' => $exc->getMessage()];
            $key = OutputMessages::ERROR_SQL;
            $outputMessage = Logger::Message($sqlControlManager->getAttributes()->getAttribute($key, $message), $context);
            $sqlControlManager->getEventManager()->trigger(Events::LOG_ERROR, $event->getTarget(), $outputMessage);
        }
    }

    private function getCreateSql() {
        return sprintf(
                $this->getConfig()->getValue(Statements::CREATE_TABLE), $this->getTable(), $this->getFieldScriptName(), $this->getFieldSuccess());
    }

    public function getTable() {
        return $this->table;
    }

    public function getFieldScriptName() {
        return $this->fieldScriptName;
    }

    public function getFieldSuccess() {
        return $this->fieldSuccess;
    }

    public function setTable($table) {
        $this->table = $table;
        return $this;
    }

    public function setFieldScriptName($fieldScriptName) {
        $this->fieldScriptName = $fieldScriptName;
        return $this;
    }

    public function setFieldSuccess($fieldSuccess) {
        $this->fieldSuccess = $fieldSuccess;
        return $this;
    }

    /**
     * @return Configuration
     */
    public function getConfig() {
        return $this->config;
    }

    public function setConfig(Configuration $config) {
        $this->config = $config;
        return $this;
    }

}
