<?php
namespace Ctimt\SqlControl\Status;

/**
 * Description of Fail
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Fail implements StatusInterface
{
    public function getName()
    {
        return 'Fail';
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
