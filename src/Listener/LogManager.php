<?php
/*
 * Copyright (C) 2016 David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
namespace CTIMT\SqlControl\Listener;

use CTIMT\SqlControl\Enum\Events;
use CTIMT\SqlControl\SqlControlManager;
use CTIMT\SqlControl\Visitor\VisitorInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Zend\EventManager\Event;

/**
 * Description of Logger
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class LogManager implements LoggerInterface, LoggerAwareInterface, VisitorInterface
{

    use \Psr\Log\LoggerTrait;

    private $_loggers = [];

    public function __construct(array $loggers)
    {
        foreach ($loggers as $logger) {
            $this->addLogger($logger);
        }
    }

    public function log($level, $message, array $context = array())
    {
        /* @var $logger LoggerInterface */
        foreach ($this->_loggers as $logger) {
            $logger->log($level, $message, $context);
        }
    }

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $mapping =[
            Events::LOG_ALERT => LogLevel::ALERT,
            Events::LOG_CRITICAL => LogLevel::CRITICAL,
            Events::LOG_DEBUG => LogLevel::DEBUG,
            Events::LOG_EMERGENCY => LogLevel::EMERGENCY,
            Events::LOG_ERROR => LogLevel::ERROR,
            Events::LOG_INFO => LogLevel::INFO,
            Events::LOG_NOTICE => LogLevel::NOTICE,
            Events::LOG_WARNING => LogLevel::WARNING,
        ];
        
        $callback = function(Event $e) use ($mapping){
            $level = $mapping[$e->getName()];
            extract(array_merge(['message'=>null,'context'=>[]],$e->getParams()));
            $this->log($level, $message, $context);
        };
        $sqlControlManager->getEventManager()->attach(Events::LOG_ALERT, $callback);
        $sqlControlManager->getEventManager()->attach(Events::LOG_CRITICAL, $callback);
        $sqlControlManager->getEventManager()->attach(Events::LOG_DEBUG, $callback);
        $sqlControlManager->getEventManager()->attach(Events::LOG_EMERGENCY, $callback);
        $sqlControlManager->getEventManager()->attach(Events::LOG_ERROR, $callback);
        $sqlControlManager->getEventManager()->attach(Events::LOG_INFO, $callback);
        $sqlControlManager->getEventManager()->attach(Events::LOG_NOTICE, $callback);
        $sqlControlManager->getEventManager()->attach(Events::LOG_WARNING, $callback);
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->addLogger($logger);
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this;
    }

    public function addLogger(LoggerInterface $logger)
    {
        $this->_loggers[] = $logger;
    }
}
