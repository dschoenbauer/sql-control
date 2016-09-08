<?php
/*
 * Copyright (C) 2016 David Schoenbauer <dschoenbauer@gmail.com>
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
namespace Dschoenbauer\SqlControl\Components;

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

    public function incrementVersion($newVersion)
    {
        $origVersion = $this->getCurrentVersion();
        $currentVersion = version_compare($newVersion, $origVersion) == 1 ? $newVersion : $origVersion;
        $this->setCurrentVersion($currentVersion);
    }

    public function setCurrentVersion($currentVersion)
    {
        $this->_currentVersion = $currentVersion;
        return $this;
    }

    public function setSqlChanges(array $sqlChanges)
    {
        $this->_sqlChanges = $sqlChanges;
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
