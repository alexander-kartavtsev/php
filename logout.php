<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';
logout();
setcookie('HTTP_REFERER', $_SERVER['HTTP_REFERER'], time() + 60 * 60 * 24);
header('Location:' . $_SERVER['HTTP_REFERER']);
