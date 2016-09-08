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
namespace CTIMT\SqlControl\Components;

/**
 * Description of Attributed
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Attributes
{

    private $_attributes = [];

    public function add($key, $value)
    {
        if(array_key_exists($key, $this->_attributes)){
            $this->_attributes[$key]->setValue($value);
        }else{
            $this->_attributes[$key] = new Attribute($key, $value);
        }
        return $this;
    }

    public function getValue($key, $defaultValue = null)
    {
        return $this->getAttribute($key, $defaultValue)->getValue();
    }

    /**
     * 
     * @param string $key
     * @param mixed $defaultValue
     * @return \CTIMT\SqlControl\Components\Attribute
     */
    public function getAttribute($key, $defaultValue = null)
    {
        if (!array_key_exists($key, $this->_attributes)) {
            return new Attribute($key, $defaultValue);
        }
        return $this->_attributes[$key];
    }
}
