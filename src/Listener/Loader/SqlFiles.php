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
namespace CTIMT\SqlControl\Listener\Loader;

use CTIMT\SqlControl\Components\SqlChangeFactory;
use CTIMT\SqlControl\Enum\Attributes;
use CTIMT\SqlControl\Enum\Events;
use CTIMT\SqlControl\Enum\Messages;
use CTIMT\SqlControl\Exception\InvalidArgumentException;
use CTIMT\SqlControl\Parser\FileGroup;
use CTIMT\SqlControl\Parser\FileSqlStatements;
use CTIMT\SqlControl\Parser\FileVersion;
use CTIMT\SqlControl\SqlControlManager;
use CTIMT\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of SqlFiles
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class SqlFiles implements VisitorInterface
{

    private $_pathToFiles;
    private $_filesLoaded;

    public function __construct($pathToFiles)
    {
        $this->setPathToFiles($pathToFiles);
    }

    public function visitSqlControlManager(SqlControlManager $sqlControlManager)
    {
        $sqlControlManager->getEventManager()->attach(Events::LOAD, [$this, 'onLoad']);
    }

    public function onLoad(Event $event)
    {
        /* @var $sqlConstrolManager SqlControlManager */
        $sqlConstrolManager = $event->getTarget();
        $versions = $sqlConstrolManager->getAttributes()->getValue(Attributes::SQL_VERSIONS, []);

        $factory = new SqlChangeFactory(new FileVersion(), new FileGroup(), New FileSqlStatements());
        $files = $this->getFiles($this->getPathToFiles());
        foreach ($files as $file) {
            $versions[$file] = $factory->getSqlChange($file, $this->getPathToFiles());
        }
        $this->_filesLoaded += count($versions);
        $sqlConstrolManager->getAttributes()->add(Attributes::SQL_VERSIONS, $versions);
        $event->getTarget()->getEventManager()->trigger(Events::LOG_INFO, $event->getTarget(),['message'=> Messages::INFO_VERSIONS_LOADED,'context'=>['count'=>$this->_filesLoaded]]);
    }
    
    private function getFiles($pathToFiles, $extension = 'sql'){
        $rawFiles = scandir($pathToFiles);
        return array_filter($rawFiles, function($file) use ($extension) {
            $l = strlen($extension);
            return substr($file, strlen($file) - $l, $l) == $extension;
        });        
    }

    public function getPathToFiles()
    {
        return $this->_pathToFiles;
    }

    public function setPathToFiles($pathToFiles)
    {
        if (!file_exists($pathToFiles)) {
            throw new InvalidArgumentException(printf(Messages::INVALID_PATH, $pathToFiles));
        }
        $this->_pathToFiles = $pathToFiles;
        return $this;
    }
}
