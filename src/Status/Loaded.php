<?php
namespace Dschoenbauer\SqlControl\Status;

/**
 * Description of Loaded
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Loaded implements StatusInterface
{
    public function getName()
    {
        return 'Loaded';
    }

    public function isLoaded()
    {
        return true;
    }

    public function isPendingLoad()
    {
        return false;
    }
}
