<?php
function checkAuth(): void
{
    $token = $_COOKIE[USER_AUTH_COOKIE_NAME] ?? '';
    if (empty($token) || !getUserIdByToken()) {
        header('Location: /auth.php');
        die;
    }
}

function dump($data): void
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function getUserAuthToken(array $user): string
{
    if (empty($user)) {
        return '';
    }

    global $pdo;

    $token = $_COOKIE[USER_AUTH_COOKIE_NAME] ?? '';

    if (empty($token)) {
        $token = md5($user['LOGIN'] . $user['ID'] . time());
        $query = $pdo->prepare('INSERT INTO user_auth (`USER_ID`, `TOKEN`) VALUES (:user_id, :token)');
        $query->execute([
            'user_id' => $user['ID'],
            'token' => $token,
        ]);
    }
    return $token;
}

function getUserIdByToken(): ?int
{
    $token = $_COOKIE[USER_AUTH_COOKIE_NAME] ?? '';
    if (empty($token)) {
        return null;
    }

    global $pdo;

    $query = $pdo->prepare('SELECT `USER_ID` FROM user_auth WHERE `TOKEN` = :token');
    $query->execute(['token' => $token]);
    $data = $query->fetch();
    if (empty($data)) {
        return null;
    }
    return $data['USER_ID'];
}

function auth(string $login, string $password): array|null
{
    global $pdo;

    $errors = [];

    if (empty($login)) {
        $errors[] = 'Не заполнено обязательное поле login!';
    }
    if (empty($password)) {
        $errors[] = 'Не заполнено обязательное поле password!';
    }

    if (!empty($errors)) {
        return $errors;
    }

    $query = $pdo->prepare('SELECT `ID`, `LOGIN`, `PASSWORD` FROM users WHERE `LOGIN` = :login');
    $query->execute(['login' => $login]);
    $user = $query->fetch();
    if (empty($user)) {
        $errors["exist"] = 'Пользователя с таким логином не существует';
    } else {
        $userAuthOk = password_verify($password, $user['PASSWORD']);
        if ($userAuthOk) {
            setcookie(USER_AUTH_COOKIE_NAME, getUserAuthToken($user), time() + USER_AUTH_SESSION_TIME);
            $locationUrl = $_COOKIE['HTTP_REFERER'] ?? '/';
            updateVisitsCounter($user['ID'], $pdo);
            header('Location: ' . $locationUrl);
            die;
        } else {
            $errors[] = 'Неправильный пароль';
        }
    }
    return $errors;
}

function logout(): void
{
    global $pdo;

    $query = $pdo->prepare('DELETE FROM user_auth WHERE `TOKEN` = :token');
    $query->execute(['token' => $_COOKIE[USER_AUTH_COOKIE_NAME]]);

    setcookie(USER_AUTH_COOKIE_NAME, 0, time() - 1);
}

function autoloader($class): void
{
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/classes/"  . $class . ".php";
}

function updateVisitsCounter($userId, $pdo)
{
    $sql = 'INSERT INTO counters (USER_ID, VISITS) VALUES (:user_id, 1) ON DUPLICATE KEY UPDATE VISITS = VISITS + 1;';
    $query = $pdo->prepare($sql);
    $query->execute(['user_id' => $userId]);
}