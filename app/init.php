<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/app/database.php';

if (defined('NEED_AUTH') && NEED_AUTH) {
    checkAuth();
}
