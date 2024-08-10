<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$userId = getUserIdByToken();
if (empty($userId)) {
    die(json_encode(['success' => false, 'error' => 'Пользователь не авторизован']));
}

$number = $_GET['number'];
if (is_null($number)) {
    die(json_encode(['success' => false, 'error' => 'Не указано значение для сохранения']));
}

$counter = new Counter();
if ($counter->saveNumber($number)) {
    die(json_encode(['success' => true]));
}
die(json_encode(['success' => false, 'error' => 'Ошибка сохранения данных']));
