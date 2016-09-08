<?php

use CTIMT\SqlControl\Adapter\Mysql\ForiegnKey;
use CTIMT\SqlControl\Enum\Events;
use CTIMT\SqlControl\Listener\Clear;
use CTIMT\SqlControl\Listener\Connection;
use CTIMT\SqlControl\Listener\DepreciationManager;
use CTIMT\SqlControl\Listener\Execute;
use CTIMT\SqlControl\Listener\Existing\TableOfFiles;
use CTIMT\SqlControl\Listener\Grouper;
use CTIMT\SqlControl\Listener\Loader\SqlFiles;
use CTIMT\SqlControl\Listener\Logger\LogBuilder;
use CTIMT\SqlControl\Listener\Logger\LogBuilderDirector;
use CTIMT\SqlControl\Listener\LogManager;
use CTIMT\SqlControl\Listener\SetupDatabase;
use CTIMT\SqlControl\Listener\SetupTable;
use CTIMT\SqlControl\Listener\VersionSort;
use CTIMT\SqlControl\SqlControlManager;

include './vendor/autoload.php';
try {
    $database = "springs_local9";
    $table = 'VersionController';
    $fieldScriptName = 'VersionController_script';
    $fieldSuccess = 'VersionController_success';
    $connection = new PDO('mysql:host=127.0.0.1', 'root');

    $logDirector = new LogBuilderDirector(new LogBuilder());

    $controller = new SqlControlManager();
    $controller->accept(new Connection($connection, $database));
    $controller->accept(new Clear());
    $controller->accept(new ForiegnKey());
    $controller->accept(new SetupDatabase($database));
    $controller->accept(new SetupTable($table, $fieldScriptName, $fieldSuccess));

    $controller->accept(new LogManager([$logDirector->buildLogger()]));
    $controller->accept(new SqlFiles('c:/users/david/Documents/Source/meeting-springs/data/Schema/Inc/'));
    $controller->accept(new TableOfFiles($connection, $table, $fieldScriptName, $fieldSuccess));
    $controller->accept(new Grouper());
    $controller->accept(new DepreciationManager());
    $controller->accept(new VersionSort());
    $controller->accept(new Execute());
    $controller->update();
} catch (Exception $exc) {
    echo $exc->getCode(), PHP_EOL, $exc->getMessage(), PHP_EOL, $exc->getTraceAsString();
    $controller->getEventManager()->trigger(Events::LOG_ERROR, $controller, ['message' => 'Epic Error:{message}', 'context' => ['message' => $exc->getMessage()]]);
}
