<?php
namespace Dschoenbauer\SqlControl\Parser;

use Dschoenbauer\SqlControl\Components\SqlChange;

/**
 * Description of NullParser
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class NullParser implements ParseInterface
{

    private $defaultValue = null;

    public function __construct($defaultValue = null)
    {
        $this->setDefaultValue($defaultValue);
    }

    public function Parse(SqlChange $sqlChange)
    {
        return $this->getDefaultValue();
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }
}
