<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';
/**
 * @var PDO $pdo
 * @var CurrentUser $user
 */

$errors = [];

$_POST = json_decode(file_get_contents('php://input'),true);

$id = isset($_POST['id']) ? (int)$_POST['id'] : null;

if (!empty($_POST['user_id'])) {
    $userId = $_POST['user_id'];
} else {
    $userId = $user->getId();
}

if (is_null($id)) {
    $errors[] = 'Ошибка получения данных из запроса';
    die(['success' => false, 'errors' => $errors]);
}

$queryGet = $pdo->prepare('SELECT `DATA` FROM users WHERE `ID` = :id');
$querySet = $pdo->prepare('UPDATE users SET `DATA` = :data WHERE `ID` = :id');

$queryGet->execute(['id' => $userId]);
$dataJson = $queryGet->fetch()['DATA'] ?? '[]';
$data = json_decode($dataJson, true);

foreach ($data as $key => $item) {
    if ($key === $id) {
        unset($data[$key]);
    }
}

$jsonData = json_encode($data);

$result = $querySet->execute([
    'id' => $userId,
    'data' => $jsonData,
]);

if ($result) {
    $data['success'] = true;
} else {
    $data['success'] = false;
    $data['errors'][] = 'Не удалось удалить данные';
}


echo json_encode($data);