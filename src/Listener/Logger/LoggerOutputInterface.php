<?php
namespace Ctimt\SqlControl\Listener\Logger;

/**
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
interface LoggerOutputInterface
{
    public function output($message);
}
