<?php
function checkAuth(): void
{
    $token = $_COOKIE[USER_AUTH_COOKIE_NAME] ?? '';
    if (empty($token) || !getUserIdByToken($token)) {
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

function getUserIdByToken(string $token): ?int
{
    global $pdo;

    $query = $pdo->prepare('SELECT `USER_ID` FROM user_auth WHERE `TOKEN` = :token');
    $query->execute(['token' => $token]);
    $data = $query->fetch();
    if (empty($data)) {
        return null;
    }
    return $data['USER_ID'];
}

function logout(): void
{
    global $pdo;

    $query = $pdo->prepare('DELETE FROM user_auth WHERE `TOKEN` = :token');
    $query->execute(['token' => $_COOKIE[USER_AUTH_COOKIE_NAME]]);

    setcookie(USER_AUTH_COOKIE_NAME, 0, time() - 1);
}