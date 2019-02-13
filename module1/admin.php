<?php
    require_once('mysql.php');
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>
<body>
    <form action="auth.php" method="POST">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="pass" placeholder="Пароль" required>
        <input type="submit" name="check" value="Войти">
    </form>
</body>
</html>