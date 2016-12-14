<?php
namespace Ctimt\SqlControl\Listener\Logger;

/**
 * Description of LogBuilderInterface
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
interface LogBuilderInterface
{
    public function getLogger(Logger $logger = null);
}
