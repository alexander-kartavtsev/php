<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$currentUri  = $_SERVER["REQUEST_URI"];
$currentUser = new CurrentUser();
$page = new Page($currentUri);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css">
    <title><?=$page->getTitle()?></title>
</head>
<body>
<header>
    <div class="logo">
        <?php if ($currentUri !== '/') { ?>
            <a href="/">
        <?php } ?>
        <img src="/images/logo.png">
        <?php if ($currentUri !== '/') { ?>
            </a>
        <?php } ?>
    </div>
    <div class="navigation">
        <?php $page->showMainMenu(); ?>
    </div>
    <div class="auth">
        <div>
            <span class="user_name"><?= $currentUser->getName() ?></span>
            <a href="/logout.php"><span>Выйти</span></a>
        </div>
    </div>
</header>
