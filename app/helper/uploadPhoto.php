<?php
if (!empty($_POST['user_id'])) {
    $userId = $_POST['user_id'];
}
if (!empty($_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $type = $photo['type'];
    if (in_array($type, ['image/jpeg', 'image/png'])) {
        move_uploaded_file($photo['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/images/users/' . $userId . '/' . $photo['name']);
    }
}
header('Location: /');
