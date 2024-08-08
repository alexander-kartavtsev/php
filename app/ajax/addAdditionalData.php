<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';
/**
 * @var PDO $pdo
 * @var CurrentUser $user
 */

$_POST = json_decode(file_get_contents('php://input'),true);

$post = [];
$errors = [];

if (!empty($_POST['name'])) {
    $post['name'] = $_POST['name'];
} else {
    $errors[] = 'Не передано название параметра';
}

if (!empty($_POST['value'])) {
    $post['value'] = $_POST['value'];
} else {
    $errors[] = 'Не передано значение параметра';
}

if (!empty($_POST['user_id'])) {
    $post['userId'] = $_POST['user_id'];
} else {
    $post['userId'] = $user->getId();
}

if (!empty($errors)) {
    die(json_encode(['success' => false, "errors" => $errors]));
}

$queryGet = $pdo->prepare('SELECT `DATA` FROM users WHERE `ID` = :id');
$querySet = $pdo->prepare('UPDATE users SET `DATA` = :data WHERE `ID` = :id');

$queryGet->execute(['id' => $post['userId']]);
$dataJson = $queryGet->fetch()['DATA'] ?? '[]';
$data = json_decode($dataJson, true);

$data[] = [
    'name' => $post['name'],
    'value' => $post['value'],
];

$jsonData = json_encode($data);

$result = $querySet->execute([
    'id' => $post['userId'],
    'data' => $jsonData,
]);
if ($result) {
    $data['success'] = true;
} else {
    $data['success'] = false;
    $data['errors'][] = 'Не удалось добавить данные';
}

echo json_encode($data);