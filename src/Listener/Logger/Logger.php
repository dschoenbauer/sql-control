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

/**
 * Description of Logger
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Logger implements \Psr\Log\LoggerInterface
{

    use LoggerLevelValidateTrait;

use \Psr\Log\LoggerTrait;

    public function __construct(array $outputs = [])
    {
        foreach ($outputs as $level => $logOutputs) {
            $this->validateLogLevel($level);
            if (is_array($logOutputs)) {
                foreach ($logOutputs as $logOutput) {
                    $this->add($level, $logOutput);
                }
            } else {
                $this->add($level, $logOutput);
            }
        };
    }

    public function add($level, LoggerOutputInterface $logOutput)
    {
        $this->validateLogLevel($level);
        $this->_outputs[$level][] = $logOutput;
        return $this;
    }

    public function log($level, $message, array $context = array())
    {
        $this->validateLogLevel($level);
        if (!array_key_exists($level, $this->_outputs)) {
            return; //Nothing to do
        }
        $outputs = $this->_outputs[$level];
        $compiledMessage = $this->interpolate($message, $context);
        /* @var $output Logger\LoggerOutputInterface */
        foreach ($outputs as $output) {
            $output->output($compiledMessage);
        }
    }

    public function interpolate($message, array $context = array())
    {
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }
        return strtr($message, $replace);
    }
}
