<?php

use Ctimt\SqlControl\Adapter\SqlSrv\Filter\AlterAddColumn;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\ConvertBoolean;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\ConvertDouble;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\ConverTextEscapeChar;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\ConvertInt;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\ConvertTimeStamp;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\EscapeKeyWords;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\InsertIdentity;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\ManageCreateKeys;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\RebuildPrimaryKey;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\RemoveComments;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\RemoveConstraints;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\RemoveEngineSpecification;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\RemoveFieldByFieldCharType;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\RemoveTick;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\RemoveUnsigned;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\ReplaceAutoIncrement;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\ReplaceNow;
use Ctimt\SqlControl\Adapter\SqlSrv\Filter\RewiteIndexStatements;
use Ctimt\SqlControl\Adapter\SqlSrv\IdentityInsert;
use Ctimt\SqlControl\Config\Configuration;
use Ctimt\SqlControl\Enum\Events;
use Ctimt\SqlControl\Framework\SqlControlManager;
use Ctimt\SqlControl\Listener\Clear;
use Ctimt\SqlControl\Listener\Connection;
use Ctimt\SqlControl\Listener\DepreciationManager;
use Ctimt\SqlControl\Listener\Execute;
use Ctimt\SqlControl\Listener\Existing\TableOfFiles;
use Ctimt\SqlControl\Listener\Filter;
use Ctimt\SqlControl\Listener\Grouper;
use Ctimt\SqlControl\Listener\Loader\SqlFiles;
use Ctimt\SqlControl\Listener\Logger\LogBuilder;
use Ctimt\SqlControl\Listener\Logger\LogBuilderDirector;
use Ctimt\SqlControl\Listener\LogManager;
use Ctimt\SqlControl\Listener\SetupDatabase;
use Ctimt\SqlControl\Listener\SetupTable;
use Ctimt\SqlControl\Listener\SortGroup;
use Ctimt\SqlControl\Listener\SortVersion;

include './vendor/autoload.php';
try {
    $database = "springs_local13";
    $table = 'VersionController';
    $fieldScriptName = 'VersionController_script';
    $fieldSuccess = 'VersionController_success';
    //$connection = new PDO('mysql:host=127.0.0.1', 'root');
    $connection = new PDO('sqlsrv:Server=CTT-DSCHOEN\\SQLEXPRESS;Database=springs_local', 'admin', 'admin');


    $logDirector = new LogBuilderDirector(new LogBuilder());

    $config = new Configuration(include 'src/Config/config.php', $connection->getAttribute(PDO::ATTR_DRIVER_NAME));

    $controller = new SqlControlManager();
    $controller->accept(new Connection($connection, $database));
    $controller->accept(new Clear());
    $controller->accept(new IdentityInsert());
    $controller->accept(new SetupDatabase($database, $config));
    $controller->accept(new SetupTable($table, $fieldScriptName, $fieldSuccess, $config));

    $controller->accept(new LogManager([$logDirector->buildLogger()]));
    $controller->accept(new SqlFiles('c:/users/david/Documents/Source/meeting-springs/data/Schema/Inc/'));
    $controller->accept(new TableOfFiles($connection, $config, $table, $fieldScriptName, $fieldSuccess));
    $controller->accept(new Grouper());
    $controller->accept(new DepreciationManager());
    $controller->accept(new SortVersion());
    $controller->accept(new SortGroup());
    $controller->accept(new Filter([
        new RemoveTick(),
        new RemoveUnsigned(),
        new ReplaceAutoIncrement(),
        new ReplaceNow(),
        new EscapeKeyWords(['User', 'Profile','File']),
        new ConvertDouble(),
        new ConvertTimeStamp(),
        new ConvertBoolean(),
        new ConvertInt(),
        new ManageCreateKeys(),
        new RemoveEngineSpecification(),
        new RemoveFieldByFieldCharType(),
        new RemoveConstraints(),
        new RewiteIndexStatements(),
        new RebuildPrimaryKey(),
        new ConverTextEscapeChar(),
        new RemoveComments(),
        new InsertIdentity(),
        new AlterAddColumn(),
    ]));
    $controller->accept(new Execute());
    $controller->update();
} catch (Exception $exc) {
    echo $exc->getCode(), PHP_EOL, $exc->getMessage(), PHP_EOL, $exc->getTraceAsString();
    $controller->getEventManager()->trigger(Events::LOG_ERROR, $controller, ['message' => 'Epic Error:{message}', 'context' => ['message' => $exc->getMessage()]]);
}
