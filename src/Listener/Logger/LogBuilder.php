<?php
namespace Ctimt\SqlControl\Listener\Logger;

use Psr\Log\LogLevel;

/**
 * Description of LogBuilder
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class LogBuilder implements LogBuilderInterface
{

    public function buildLogger()
    {
        return new Logger([
            LogLevel::ALERT => [new ToScreen()],
            LogLevel::CRITICAL => [new ToScreen()],
            LogLevel::DEBUG => [new ToScreen()],
            LogLevel::EMERGENCY => [new ToScreen()],
            LogLevel::ERROR => [new ToScreen()],
            LogLevel::INFO => [new ToScreen()],
            LogLevel::NOTICE => [new ToScreen()],
            LogLevel::WARNING => [new ToScreen()],
        ]);
    }
}
