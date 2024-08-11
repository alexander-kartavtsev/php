<?php

$requiredFields = [
    'login',
    'password',
    'password_confirm',
];
$reqFieldClass = function ($fieldName) use ($requiredFields) {
    return in_array($fieldName, $requiredFields) ? ' class="require-field"' : '';
};

require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';
/** @var PDO $pdo */
$errors = [];
if (!empty($_POST)) {
    $name         = $_POST['name'] ?? null;
    $login        = $_POST['login'];
    $password     = $_POST['password'];
    $passwordConf = $_POST['password_confirm'];

    $result = registration($name, $login, $password, $passwordConf, $requiredFields);
    if (!$result['success']) {
        $errors = $result['errors'];
    }
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
        <title>Registranion</title>
    </head>
    <body>
        <div class="form_auth">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-item">
                    <label for="name"<?= $reqFieldClass('name')?>>
                        Имя
                    </label>
                    <input
                            name="name"
                            type="text"
                            placeholder="Введите имя"
                            value="<?= $name ?? '' ?>"
                            <?= $errorClass('name') ?>
                    >
                    <div class="error-message"><?= $errors['name'] ?? '' ?></div>
                    </div>
                <div class="form-item">
                    <label for="login"<?= $reqFieldClass('login')?>>Логин</label>
                    <input
                            name="login"
                            type="text"
                            placeholder="Введите логин"
                            value="<?= $login ?? '' ?>"
                            <?= $errorClass('login') ?>
                    >
                    <div class="error-message"><?= $errors['login'] ?? '' ?></div>
                </div>
                <div class="form-item">
                    <label for="password"<?= $reqFieldClass('password')?>>Пароль</label>
                    <input
                            name="password"
                            type="password"
                            placeholder="Введите пароль"
                            value="<?= $password ?? '' ?>"
                            autocomplete="new-password"
                            <?= $errorClass('password') ?>
                    >
                    <div class="error-message"><?= $errors['password'] ?? '' ?></div>
                </div>
                <div class="form-item">
                    <label
                            for="password_confirm"<?= $reqFieldClass('password_confirm')?>
                    >Подтвердите пароль</label>
                    <input
                            name="password_confirm"
                            type="password"
                            placeholder="Повторите пароль"
                            value="<?= $passwordConf ?? '' ?>"
                            <?= $errorClass('password_confirm') ?>
                    >
                    <div class="error-message"><?= $errors['password_confirm'] ?? '' ?></div>
                </div>
                <button class="auth_btn" type="submit">Зарегистрироваться</button>
            </form>
            <a class="link_reg" href="/auth.php">Войти</a>
        </div>
    </body>
</html>