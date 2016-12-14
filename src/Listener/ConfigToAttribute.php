<?php namespace Ctimt\SqlControl\Listener;

use Ctimt\SqlControl\Config\Configuration;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Visitor\VisitorInterface;

/**
 * Description of Messaging
 *
 * @author David
 */
class ConfigToAttribute implements VisitorInterface{
    
    private $messagingConfig;
    
    public function __construct(Configuration $messagingConfig) {
        $this->setMessagingConfig($messagingConfig);
    }
    
    public function visitSqlControlManager(SqlControlManager $sqlControlManager) {
        $this->convertConfigToAttributes($this->getMessagingConfig()->getProcessedConfig(), $sqlControlManager);
    }
    
    public function convertConfigToAttributes(array $configArray, SqlControlManager $sqlControlManager){
        foreach ($configArray as $key => $value) {
            $sqlControlManager->getAttributes()->add($key, $value);
        }
    }

    public function getMessagingConfig() {
        return $this->messagingConfig;
    }

    public function setMessagingConfig(Configuration $messagingConfig) {
        $this->messagingConfig = $messagingConfig;
        return $this;
    }


}
