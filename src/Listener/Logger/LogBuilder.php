<?php
/*
 * Copyright (C) 2016 David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
namespace CTIMT\SqlControl\Listener\Logger;

use Psr\Log\LogLevel;

/**
 * Description of LogBuilder
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
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
