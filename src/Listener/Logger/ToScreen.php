<?php
namespace Ctimt\SqlControl\Listener\Logger;

/**
 * Description of ToScreen
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class ToScreen implements LoggerOutputInterface
{
    public function output($message)
    {
        echo $message,PHP_EOL;
    }
}
