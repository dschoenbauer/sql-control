<?php
/*
 * Copyright (C) 2016 David Schoenbauer <dschoenbauer@gmail.com>
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
namespace Dschoenbauer\SqlControl\Enum;

/**
 * Description of Events
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Events
{
    const CLEAR = "clear";
    const LOAD = 'load';
    const PREPARE = 'prepare';
    const EXECUTE = 'execute';
    const RESULT = "result";
    
    const SETUP_TABLE = "setup_table";
    const SETUP_DATABASE = "setup_database";
    
    const LOG_EMERGENCY = 'log_emergency';
    const LOG_ALERT     = 'log_alert';
    const LOG_CRITICAL  = 'log_critical';
    const LOG_ERROR     = 'log_error';
    const LOG_WARNING   = 'log_warning';
    const LOG_NOTICE    = 'log_notice';
    const LOG_INFO      = 'log_info';
    const LOG_DEBUG     = 'log_debug';

}
