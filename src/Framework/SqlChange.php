<?php
namespace Ctimt\SqlControl\Framework;

use Ctimt\SqlControl\Status\StatusInterface;



/**
 * Description of SqlChange
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class SqlChange
{
    private $_name;
    private $_fullPath;
    private $_group;
    private $_version;
    private $_statements = [];
    private $_attributes;
    private $_status;
    
    public function __construct()
    {
        $this->setAttributes(new Attributes());
    }
    
    public function getGroup()
    {
        return $this->_group;
    }

    public function getVersion()
    {
        return $this->_version;
    }

    public function getStatements()
    {
        return $this->_statements;
    }

    /**
     * @return Attributes
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }

    public function setGroup($group)
    {
        $this->_group = $group;
        return $this;
    }

    public function setVersion($version)
    {
        $this->_version = $version;
        return $this;
    }

    public function setStatements($statements)
    {
        $this->_statements = $statements;
        return $this;
    }

    protected function setAttributes($attributes)
    {
        $this->_attributes = $attributes;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getFullPath()
    {
        return $this->_fullPath;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function setFullPath($fullPath)
    {
        $this->_fullPath = $fullPath;
        return $this;
    }

    /**
     * @return StatusInterface
     */
    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(StatusInterface $status)
    {
        $this->_status = $status;
        return $this;
    }

}
