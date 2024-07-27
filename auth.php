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
            <form action="/auth.php" method="post">
                <label for="login">Логин</label>
                <input name="login" type="text" placeholder="Введите логин">
                <label for="password">Пароль</label>
                <input name="password" type="password" placeholder="Введите пароль">
                <button class="auth_btn" type="button">Войти</button>
            </form>
            <a class="link_reg" href="/registration.php">Зарегистрироваться</a>
        </div>
    </body>
</html>