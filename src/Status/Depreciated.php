<?php
namespace Ctimt\SqlControl\Status;

/**
 * Description of Depreciated
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Depreciated implements StatusInterface
{
    public function getName()
    {
        return "Depreciated";
    }

    public function isLoaded()
    {
        return false;
    }

    public function isPendingLoad()
    {
        return false;
    }
}
