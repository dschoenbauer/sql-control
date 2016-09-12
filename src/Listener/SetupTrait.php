<?php
namespace Dschoenbauer\SqlControl\Listener;

use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Components\SqlControlManager;
use Exception;

/**
 * Description of SetupTrait
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
trait SetupTrait
{

    public function setup(Exception $exc, SqlControlManager $sqlControlManager)
    {
        $errorEvents = [
            "42000" => Events::SETUP_DATABASE,
            "3D000" => Events::SETUP_DATABASE,
            "42S02" => Events::SETUP_TABLE, 
            ];
        if (!in_array($exc->getCode(), array_keys($errorEvents))) {
            throw $exc;
        }
        $sqlControlManager->getEventManager()->trigger($errorEvents[$exc->getCode()], $sqlControlManager);
    }
}
