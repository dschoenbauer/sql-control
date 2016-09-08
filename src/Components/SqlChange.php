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

use Dschoenbauer\SqlControl\Status\StatusInterface;



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

    public function setAttributes($attributes)
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

    public function setStatus($status)
    {
        $this->_status = $status;
        return $this;
    }

}
