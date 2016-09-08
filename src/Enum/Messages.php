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
 * Description of Messages
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Messages
{
    const INVALID_LOG_LEVEL = '%s is an invalid log level.';
    const INVALID_PATH = '%s is not a valid path.';
    const MISSING_DATABASE_NAME = 'You mush provide a DATABASE name';
    
    const INFO_VERSIONS_LOADED = "Loaded {count} file(s).";
    const INFO_VERSIONS_IDENTIFIED = "Identified {count} applied file(s).";
    const INFO_VERSIONS_GROUPS_CREATED = "Created {count} group(s).";
    const INFO_VERSIONS_PENDING_EXECUTTION = "{count} Pending Execution";
    const INFO_VERSIONS_DEPRECIATED = "{count} pending file(s) Depreciated";
    const INFO_VERSIONS_ORDERED = "Ordered {count} file(s).";

}
