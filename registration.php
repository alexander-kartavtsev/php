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
            <form action="/registration.html" method="post">
                <label for="name">Имя</label>
                <input name="name" type="text" placeholder="Введите имя">
                <label for="login">Логин</label>
                <input name="login" type="text" placeholder="Введите логин">
                <label for="password">Пароль</label>
                <input name="password" type="password" placeholder="Введите пароль">
                <label for="password_confirm">Подтвердите пароль</label>
                <input name="password_confirm" type="password" placeholder="Повторите пароль">
                <button class="auth_btn" type="button">Зарегистрироваться</button>
            </form>
            <a class="link_reg" href="/auth.php">Войти</a>
        </div>
    </body>
</html>