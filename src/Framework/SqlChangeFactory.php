<?php
namespace Ctimt\SqlControl\Framework;

use Ctimt\SqlControl\Parser\ParseInterface;

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

    /**
     * @param string $fileName
     * @param string $path
     * @return SqlChange
     */
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
