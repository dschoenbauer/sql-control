<?php

use Dschoenbauer\SqlControl\Adapter\Mysql\ForiegnKey;
use Dschoenbauer\SqlControl\Enum\Events;
use Dschoenbauer\SqlControl\Listener\Clear;
use Dschoenbauer\SqlControl\Listener\Connection;
use Dschoenbauer\SqlControl\Listener\DepreciationManager;
use Dschoenbauer\SqlControl\Listener\Execute;
use Dschoenbauer\SqlControl\Listener\Existing\TableOfFiles;
use Dschoenbauer\SqlControl\Listener\Grouper;
use Dschoenbauer\SqlControl\Listener\Loader\SqlFiles;
use Dschoenbauer\SqlControl\Listener\Logger\LogBuilder;
use Dschoenbauer\SqlControl\Listener\Logger\LogBuilderDirector;
use Dschoenbauer\SqlControl\Listener\LogManager;
use Dschoenbauer\SqlControl\Listener\SetupDatabase;
use Dschoenbauer\SqlControl\Listener\SetupTable;
use Dschoenbauer\SqlControl\Listener\VersionSort;
use Dschoenbauer\SqlControl\SqlControlManager;

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
