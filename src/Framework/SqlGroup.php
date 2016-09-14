<?php
namespace Ctimt\SqlControl\Framework;

/**
 * Description of SqlGroup
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class SqlGroup
{

    private $_name;
    private $_currentVersion = '0.0.0';
    private $_sqlChanges = [];

    public function getCurrentVersion()
    {
        return $this->_currentVersion;
    }

    public function getSqlChanges()
    {
        return $this->_sqlChanges;
    }
    
    public function setSqlChanges($sqlChanges)
    {
        $this->_sqlChanges = $sqlChanges;
        return $this;
    }

    public function incrementVersion($newVersion)
    {
        $origVersion = $this->getCurrentVersion();
        $currentVersion = version_compare($newVersion, $origVersion) == 1 ? $newVersion : $origVersion;
        $this->setCurrentVersion($currentVersion);
        return $this;
    }

    public function setCurrentVersion($currentVersion)
    {
        $this->_currentVersion = $currentVersion;
        return $this;
    }

    public function add(SqlChange $sqlChange)
    {
        $this->_sqlChanges[$sqlChange->getName()] = $sqlChange;
        return $this;
    }
    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }
}
