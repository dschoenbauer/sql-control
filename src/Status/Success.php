<?php
namespace Ctimt\SqlControl\Status;

/**
 * Description of Success
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Success implements StatusInterface
{
    public function getName()
    {
        return 'Success';
    }

    public function isLoaded()
    {
        return true;
    }

    public function isPendingLoad()
    {
        return false;
    }
//put your code here
}
