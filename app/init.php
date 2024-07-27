<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/database.php';

define('USER_AUTH_COOKIE_NAME', 'currentUserId');
define('USER_AUTH_SESSION_TIME', 60 * 60 * 24 * 30);

if (defined('NEED_AUTH') && NEED_AUTH) {
    checkAuth();
}
