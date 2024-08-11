<?php
include $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';
/** @var PDO $pdo */
$errors = [];
if (!empty($_POST)) {
    $login        = $_POST['login'] ?? '';
    $password     = $_POST['password'] ?? '';

    $errors = auth($login, $password);
}
$errorClass = function ($fieldName) use ($errors) {
    return isset($errors[$fieldName]) ? ' class="input-error"' : '';
};
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
                <div class="form-item">
                    <label for="login" class="require-field">Логин</label>
                    <input
                            name="login"
                            type="text"
                            placeholder="Введите логин"
                            autocomplete="on"
                            <?= $errorClass('login') ?>
                    >
                    <div class="error-message"><?= $errors['login'] ?? '' ?></div>
                </div>
                <div class="form-item">
                    <label for="password" class="require-field">Пароль</label>
                    <input
                            name="password"
                            type="password"
                            placeholder="Введите пароль"
                            autocomplete="on"
                            <?= $errorClass('password') ?>
                    >
                    <div class="error-message"><?= $errors['password'] ?? '' ?></div>
                    <div class="error-message"><?= $errors['other'] ?? '' ?></div>
                </div>
                <button class="auth_btn" type="submit">Войти</button>
            </form>
            <a class="link_reg" href="/registration.php">Зарегистрироваться</a>
        </div>
    </body>
</html>