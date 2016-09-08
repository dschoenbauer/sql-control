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

use Dschoenbauer\SqlControl\Parser\ParseInterface;

/**
 * Description of SqlChangeFactory
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class SqlChangeFactory
{

    private $versionParser;
    private $groupParser;
    private $sqlParser;

    public function __construct(ParseInterface $versionParser, ParseInterface $groupParser, ParseInterface $sqlParser)
    {
        $this->setVersionParser($versionParser)->setGroupParser($groupParser)->setSqlParser($sqlParser);
    }

    public function getSqlChange($fileName, $path)
    {
        $sqlChange = new SqlChange();
        $sqlChange->setName($fileName);
        $sqlChange->setFullPath($path . $fileName);
        $sqlChange->setVersion($this->getVersionParser()->Parse($sqlChange));
        $sqlChange->setGroup($this->getGroupParser()->Parse($sqlChange));
        $sqlChange->setStatements($this->getSqlParser()->Parse($sqlChange));
        return $sqlChange;
    }

    /**
     * 
     * @return ParseInterface 
     */
    public function getVersionParser()
    {
        return $this->versionParser;
    }

    /**
     * 
     * @return ParseInterface 
     */
    public function getGroupParser()
    {
        return $this->groupParser;
    }

    /**
     * 
     * @return ParseInterface
     */
    public function getSqlParser()
    {
        return $this->sqlParser;
    }

    public function setVersionParser(ParseInterface $versionParser)
    {
        $this->versionParser = $versionParser;
        return $this;
    }

    public function setGroupParser(ParseInterface $groupParser)
    {
        $this->groupParser = $groupParser;
        return $this;
    }

    public function setSqlParser(ParseInterface $sqlParser)
    {
        $this->sqlParser = $sqlParser;
        return $this;
    }
}
