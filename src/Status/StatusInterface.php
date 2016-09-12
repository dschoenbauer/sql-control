<?php
namespace Dschoenbauer\SqlControl\Status;
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
