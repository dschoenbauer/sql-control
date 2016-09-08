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
namespace Dschoenbauer\SqlControl\Listener;

use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\SqlControlManager;
use Exception;

/**
 * Description of SetupTrait
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
trait SetupTrait
{

    public function setup(Exception $exc, SqlControlManager $sqlControlManager)
    {
        $errorEvents = [
            "42000" => Events::SETUP_DATABASE,
            "3D000" => Events::SETUP_DATABASE,
            "42S02" => Events::SETUP_TABLE, 
            ];
        if (!in_array($exc->getCode(), array_keys($errorEvents))) {
            throw $exc;
        }
        $sqlControlManager->getEventManager()->trigger($errorEvents[$exc->getCode()], $sqlControlManager);
    }
}
