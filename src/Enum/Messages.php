<?php
namespace Ctimt\SqlControl\Enum;

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
