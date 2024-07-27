<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$currentUri = $_SERVER["REQUEST_URI"];
$arMenu     = include $_SERVER['DOCUMENT_ROOT'] . '/menu/main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css">
    <title>Main</title>
</head>
<body>
<header>
    <div class="logo">
        <? if ($currentUri !== '/') { ?>
            <a href="/">
        <? } ?>
        <img src="/images/logo.png">
        <? if ($currentUri !== '/') { ?>
            </a>
        <? } ?>
    </div>
    <div class="navigation">
        <ul class="main_menu">
            <? foreach ($arMenu as $menuItem) { ?>
                <li>
                <? if ($currentUri !== $menuItem['uri']) { ?>
                    <a href="<?= $menuItem['uri'] ?>">
                <? }
                     echo $menuItem['title'];
                if ($currentUri !== $menuItem['uri']) { ?>
                    </a>
                <? } ?>
                </li>
            <? } ?>
        </ul>
    </div>
    <div class="auth">
        <div>
            <span class="user_name">Александр</span>
            <a href="logout"><span>Выйти</span></a>
        </div>
    </div>
</header>
