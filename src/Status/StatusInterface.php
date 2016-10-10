<?php
namespace Ctimt\SqlControl\Status;
/**
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
interface StatusInterface
{
    public function getName();
    public function isLoaded();
    public function isPendingLoad();
}
