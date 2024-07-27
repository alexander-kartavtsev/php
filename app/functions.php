<?php
function checkAuth(): void
{
    if (empty($_COOKIE['userAuthToken'])) {
        header('Location: /auth.php');
        die;
    }
}