<?php

$dbHost     = "mysql";
$dbName     = "phpdb";
$dbUser     = "phpdbuser";
$dbPassword = "phpdbpassword";

$dsn    = sprintf('mysql:dbname=%s;host=%s', $dbName, $dbHost);
$pdo = new PDO($dsn, $dbUser, $dbPassword);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `users` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `LOGIN` VARCHAR(50) NOT NULL,
    `PASSWORD` VARCHAR(255) NOT NULL,
    `NAME` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `DATA` TEXT NULL DEFAULT NULL,
    `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `UPDATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`) USING BTREE
)
COLLATE='utf8_unicode_ci';
SQL;

$pdo->exec($sql);
