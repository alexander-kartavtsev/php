<?php
function checkAuth(): void
{
    if (empty($_COOKIE[USER_AUTH_COOKIE_NAME])) {
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