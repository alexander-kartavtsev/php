<?php
include $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';
/** @var PDO $pdo */
$errors = [];
if (!empty($_POST)) {
    $login        = $_POST['login'];
    $password     = $_POST['password'];

    $query = $pdo->prepare('SELECT `ID`, `PASSWORD` FROM users WHERE `LOGIN` = :login');
    $query->execute(['login' => $login]);
    $user = $query->fetch();
    if (empty($user)) {
        $errors["exist"] = 'Пользователя с таким логином не существует';
    } else {
        $userAuthOk = password_verify($password, $user['PASSWORD']);
        if ($userAuthOk) {
            setcookie(USER_AUTH_COOKIE_NAME, $user['ID'], time() + USER_AUTH_SESSION_TIME);
            $locationUrl = $_COOKIE['HTTP_REFERER'] ?? '/';
            header('Location: ' . $locationUrl);
            die;
        } else {
            $errors[] = 'Неправильный пароль';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/style.css">
        <title>Auth</title>
    </head>
    <body>
        <div class="form_auth">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <label for="login">Логин</label>
                <input name="login" type="text" placeholder="Введите логин">
                <label for="password">Пароль</label>
                <input name="password" type="password" placeholder="Введите пароль">
                <button class="auth_btn" type="submit">Войти</button>
            </form>
            <a class="link_reg" href="/registration.php">Зарегистрироваться</a>
            <? if (!empty($errors)) {
                foreach ($errors as $error) {
                    dump($error);
                }
            } ?>
        </div>
    </body>
</html>