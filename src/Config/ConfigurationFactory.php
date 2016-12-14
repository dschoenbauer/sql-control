<?php

namespace Ctimt\SqlControl\Config;

use PDO;

/**
 * Description of OutputMessageConfigurationFactory
 *
 * @author David
 */
class ConfigurationFactory {

    public function makeOutputMessageConfiguration() {
        $config = include 'src/Config/outputMessages.php' ?: [];
        $nameSpace = php_sapi_name();
        return new Configuration($config, $nameSpace);
    }

    public function makeSqlStatementConfiguration(PDO $connection) {
        return new Configuration(include 'src/Config/config.php', $connection->getAttribute(PDO::ATTR_DRIVER_NAME));
    }

}
