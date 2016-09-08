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
 * Description of Attributes
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class Attributes
{
    const ORIGINAL_SQL_STATEMENT = 'originalSqlStatement';
    const SQL_VERSIONS = "sqlChanges";
    const APPLIED_SQL_VERSIONS = "appliedSqlChanges";
    const GROUPS = "groups";

}
