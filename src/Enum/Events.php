<?php
namespace Ctimt\SqlControl\Enum;

/**
 * Description of Events
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Events
{
    const SETUP = "setup";
    const CLEAR = "clear";
    const LOAD = 'load';
    const PREPARE = 'prepare';
    const EXECUTE = 'execute';
    const RESULT = "result";
    const TEAR_DOWN = "tear_down";
    
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
