<?php
namespace Dschoenbauer\SqlControl\Listener\Logger;

/**
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
interface LoggerOutputInterface
{
    public function output($message);
}
