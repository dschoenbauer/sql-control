<?php

namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Enum\OutputMessages;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Listener\Logger\Logger;
use Ctimt\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of MessageSetupTearDown
 *
 * @author David
 */
class MessageSetupTearDown implements VisitorInterface {

    public function visitSqlControlManager(SqlControlManager $sqlControlManager) {
        $sqlControlManager->getEventManager()->attach(Events::SETUP, [$this,'onSetup']);
        $sqlControlManager->getEventManager()->attach(Events::TEAR_DOWN, [$this,'onTearDown']);
    }

    public function onSetup(Event $event) {
        $this->triggerMessage($event->getTarget(), OutputMessages::HEADER);
    }

    public function onTearDown(Event $event) {
        $this->triggerMessage($event->getTarget(), OutputMessages::FOOTER);
    }

    protected function triggerMessage(SqlControlManager $sqlControlManager, $messageKey) {
        $message = $sqlControlManager->getAttributes()->getAttribute($messageKey);
        $sqlControlManager->getEventManager()->trigger(Events::LOG_INFO, $sqlControlManager, Logger::Message($message));
    }

}
