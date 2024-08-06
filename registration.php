<?php

require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';
/** @var PDO $pdo */
$errors = [];
if (!empty($_POST)) {
    $name         = $_POST['name'] ?? null;
    $login        = $_POST['login'];
    $password     = $_POST['password'];
    $passwordConf = $_POST['password_confirm'];

    $query = $pdo->prepare('SELECT `ID` FROM users WHERE `LOGIN` = :login');
    $query->execute(['login' => $login]);
    $user = $query->fetch();
    if (!empty($user)) {
        $errors["exist"] = 'Пользователь с таким логином уже существует';
    } else {
        $result = false;
        if ($password !== $passwordConf) {
            $errors[] = "Ошибка при подтверждении. Пароли не совпадают!";
        } else {
            $queryReg  = $pdo->prepare(
                'INSERT INTO users (`NAME`, `LOGIN`, `PASSWORD`) VALUES (:name, :login, :password)'
            );
            $result = $queryReg->execute([
                'name'     => $name,
                'login'    => $login,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
        }

        if ($result) {
            header('Location: /auth.php');
            die;
        } else {
            if (isset($queryReg)) {
                $errors["query"] = $queryReg->errorInfo();
            }
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
        <title>Registranion</title>
    </head>
    <body>
        <div class="form_auth">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <label for="name">Имя</label>
                <input name="name" type="text" placeholder="Введите имя" value="<?=$name??''?>">
                <label for="login">Логин</label>
                <input name="login" type="text" placeholder="Введите логин" value="<?=$login??''?>">
                <label for="password">Пароль</label>
                <input name="password" type="password" placeholder="Введите пароль" value="<?=$password??''?>">
                <label for="password_confirm">Подтвердите пароль</label>
                <input name="password_confirm" type="password" placeholder="Повторите пароль" value="<?=$passwordConf??''?>">
                <button class="auth_btn" type="submit">Зарегистрироваться</button>
            </form>
            <a class="link_reg" href="/auth.php">Войти</a>
            <?php if (!empty($errors)) {
                foreach ($errors as $error) {
                    dump($error);
                }
            } ?>
        </div>
    </body>
</html>