<?php

$dbHost     = "mysql";
$dbName     = "phpdb";
$dbUser     = "phpdbuser";
$dbPassword = "phpdbpassword";

$dsn = sprintf('mysql:dbname=%s;host=%s', $dbName, $dbHost);
$pdo = new PDO($dsn, $dbUser, $dbPassword);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `users` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `LOGIN` VARCHAR(50) NOT NULL,
    `PASSWORD` VARCHAR(255) NOT NULL,
    `NAME` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `DATA` JSON NULL DEFAULT NULL,
    `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `UPDATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`) USING BTREE
)
COLLATE='utf8_unicode_ci';
SQL;

$pdo->exec($sql);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `user_auth` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `USER_ID` INT(11) NOT NULL,
    `TOKEN` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID`) USING BTREE,
    FOREIGN KEY (`USER_ID`) REFERENCES `users`(`ID`) ON DELETE CASCADE
)
COLLATE='utf8_unicode_ci';
SQL;

$pdo->exec($sql);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `counters` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `USER_ID` INT(11) NOT NULL,
    `VISITS` INT NOT NULL,
    `NUMBER` INT NOT NULL,
    `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `UPDATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`) USING BTREE,
    FOREIGN KEY (`USER_ID`) REFERENCES `users`(`ID`) ON DELETE CASCADE
)
COLLATE='utf8_unicode_ci';
SQL;

$pdo->exec($sql);
