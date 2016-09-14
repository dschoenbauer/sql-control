<?php
namespace Dschoenbauer\SqlControl\Framework;

use Dschoenbauer\SqlControl\Framework\Attributes;
use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Visitor\VisiteeInterface;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
use PDO;

/**
 * Description of SqlControlManager
 *v
 * @author David Schoenbauer <dschoenbauer@gmail.com>
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

    protected function setAttributes(Attributes $attributes)
    {
        $this->_attributes = $attributes;
        return $this;
    }

    public function accept(VisitorInterface $visitor)
    {
        $visitor->visitSqlControlManager($this);
    }

    /**
     * @return PDO
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
