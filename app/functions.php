<?php
function checkAuth(): void
{
    if (empty($_COOKIE['userAuthToken'])) {
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