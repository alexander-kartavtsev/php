<?php

const USER_AUTH_COOKIE_NAME  = 'userAuthToken';
const USER_AUTH_SESSION_TIME = 60 * 60 * 24 * 30;

require $_SERVER['DOCUMENT_ROOT'] . '/app/database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/functions.php';

if (defined('NEED_AUTH') && NEED_AUTH) {
    checkAuth();
}

spl_autoload_register('autoloader');