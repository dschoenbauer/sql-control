<?php
namespace Dschoenbauer\SqlControl\Listener\Loader;

use Dschoenbauer\SqlControl\Components\SqlChangeFactory;
use Dschoenbauer\SqlControl\Enum\Attributes;
use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Enum\Messages;
use Dschoenbauer\SqlControl\Exception\InvalidArgumentException;
use Dschoenbauer\SqlControl\Parser\FileGroup;
use Dschoenbauer\SqlControl\Parser\FileSqlStatements;
use Dschoenbauer\SqlControl\Parser\FileVersion;
use Dschoenbauer\SqlControl\SqlControlManager;
use Dschoenbauer\SqlControl\Visitor\VisitorInterface;
use Zend\EventManager\Event;

/**
 * Description of SqlFiles
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
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
