<?php
include $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';
/** @var PDO $pdo */
$errors = [];
if (!empty($_POST)) {
    $login        = $_POST['login'] ?? '';
    $password     = $_POST['password'] ?? '';

    $errors = auth($login, $password);
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
            <?php if (!empty($errors)) {
                foreach ($errors as $error) {
                    dump($error);
                }
            } ?>
        </div>
    </body>
</html>