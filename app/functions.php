<?php

use JetBrains\PhpStorm\NoReturn;

function checkAuth(): void
{
    $currentUserId = $_COOKIE[USER_AUTH_COOKIE_NAME] ?? '';
    if (empty($currentUserId)) {
        header('Location: /auth.php');
        die;
    }
}

function dump($data): void
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

#[NoReturn]
function dd($data): void
{
    dump($data);
    die;
}
