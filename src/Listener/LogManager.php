<?php
namespace Dschoenbauer\SqlControl\Listener;

use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Components\SqlControlManager;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Zend\EventManager\Event;

/**
 * Description of Logger
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
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
