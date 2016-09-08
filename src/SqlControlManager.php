<?php namespace CTIMT\SqlControl;

use CTIMT\SqlControl\Components\Attributes;
use CTIMT\SqlControl\Enum\Events;
use CTIMT\SqlControl\Visitor\VisiteeInterface;
use CTIMT\SqlControl\Visitor\VisitorInterface;

/**
 * Description of SqlControlManager
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class SqlControlManager implements VisiteeInterface
{

    use \Zend\EventManager\EventManagerAwareTrait;

    private $_adapter;
    private $_attributes;

    public function __construct()
    {
        $this->setAttributes(new Attributes());
    }

    /**
     * @return Attributes
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }

    public function setAttributes(Attributes $attributes)
    {
        $this->_attributes = $attributes;
        return $this;
    }

    public function accept(VisitorInterface $visitor)
    {
        $visitor->visitSqlControlManager($this);
    }

    /**
     * @return \PDO
     */
    public function getAdapter()
    {
        return $this->_adapter;
    }

    public function setAdapter($adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }

    public function update()
    {
        $this->getEventManager()->trigger(Events::LOAD, $this);
        $this->getEventManager()->trigger(Events::PREPARE, $this);
        $this->getEventManager()->trigger(Events::EXECUTE, $this);
    }
}
