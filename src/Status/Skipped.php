<?php
namespace Ctimt\SqlControl\Status;

/**
 * Description of Skipped
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Skipped implements StatusInterface
{
    public function getName()
    {
        return "Skipped";
    }

    public function isLoaded()
    {
        return false;
    }

    public function isPendingLoad()
    {
        return false;
    }
//put your code here
}
