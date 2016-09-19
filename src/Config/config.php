<?php

use Ctimt\SqlControl\Enum\Drivers;
use Ctimt\SqlControl\Enum\Statements;

return [
    Drivers::MYSQL => [
        Statements::CREATE_DATABASE => 'CREATE DATABASE IF NOT EXISTS %s;',
        Statements::CREATE_TABLE => 'CREATE TABLE IF NOT EXISTS %s (
                        id int(10) unsigned NOT NULL AUTO_INCREMENT,
                        %s varchar(100) DEFAULT NULL,
                        created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        %s tinyint(1) DEFAULT \'0\',
                        PRIMARY KEY (id)
                      )',
        Statements::GET_EXECUTED_CHANGES => 'SELECT %s from %s where %s = true'
    ],
    Drivers::DBLIB => [
        Statements::CREATE_DATABASE => 'IF NOT EXISTS (SELECT name FROM master.dbo.sysdatabases WHERE name = N\'%1$s\') CREATE DATABASE [%1$s]',
        Statements::CREATE_TABLE => 'CREATE TABLE %s (
                        id int NOT NULL IDENTITY,
                        %s varchar(100) DEFAULT NULL,
                        created_at DATETIME not NULL DEFAULT (GETDATE()),
                        %s  tinyint DEFAULT \'0\',
                        PRIMARY KEY (id)
                      )',
        Statements::GET_EXECUTED_CHANGES => 'SELECT %s from %s where %s = 1'
    ],
    Drivers::SQL_SRV => [
        Statements::CREATE_DATABASE => 'IF NOT EXISTS (SELECT name FROM master.dbo.sysdatabases WHERE name = N\'%1$s\') CREATE DATABASE [%1$s]',
        Statements::CREATE_TABLE => 'CREATE TABLE %s (
                        id int NOT NULL IDENTITY,
                        %s varchar(100) DEFAULT NULL,
                        created_at DATETIME not NULL DEFAULT (GETDATE()),
                        %s  tinyint DEFAULT \'0\',
                        PRIMARY KEY (id)
                      )',
        Statements::GET_EXECUTED_CHANGES => 'SELECT %s from %s where %s = 1'
    ]
];
