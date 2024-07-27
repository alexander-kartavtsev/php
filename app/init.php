<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/functions.php';

if (defined('NEED_AUTH') && NEED_AUTH) {
    checkAuth();
}
