<?php
namespace Dschoenbauer\SqlControl\Status;

/**
 * Description of PendingLoad
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class PendingLoad implements StatusInterface
{
    public function getName()
    {
        return "Pending Load";
    }

    public function isLoaded()
    {
        return false;
    }

    public function isPendingLoad()
    {
        return true;
    }
}
