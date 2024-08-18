<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$currentUri  = $_SERVER["REQUEST_URI"];
$currentUser = new CurrentUser();
$arMenu      = include $_SERVER['DOCUMENT_ROOT'] . '/menu/main.php';
$page = new Page();
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
        <?php
        if ($currentUri !== '/') { ?>
        <a href="/">
            <?php
            } ?>
            <img src="/images/logo.png">
            <?php
            if ($currentUri !== '/') { ?>
        </a>
    <?php
    } ?>
    </div>
    <div class="navigation">
        <ul class="main_menu">
            <?php
            foreach ($arMenu as $menuItem) { ?>
                <li>
                    <?php
                    if ($currentUri !== $menuItem['uri']) { ?>
                    <a href="<?= $menuItem['uri'] ?>">
                        <?php
                        }
                        echo $menuItem['title'];
                        if ($currentUri !== $menuItem['uri']) { ?>
                    </a>
                <?php
                } ?>
                </li>
                <?php
            } ?>
        </ul>
    </div>
    <div class="auth">
        <div>
            <span class="user_name"><?= $currentUser->getName() ?></span>
            <a href="/logout.php"><span>Выйти</span></a>
        </div>
    </div>
</header>
