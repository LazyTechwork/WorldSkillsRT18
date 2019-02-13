<?php
    require_once('mysql.php');
    setPrivateZone($dbcnx, $_SESSION['login']);
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
</head>
<body>
    <h1>Админ-панель сайта <a href="index.php">"<?= $siteinfo['sitename']; ?>"</a></h1>
    <hr>
    <h2>Создать новость</h2>
    <form action="newpost.php" method="POST">
        <input type="text" name="name" placeholder="Название статьи">
        <br>
        <select name="cat">
            <?php foreach(returnCategories($dbcnx) as $val):?>
            <option value="<?= $val['id']; ?>"><?= $val['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <textarea name="text" id="" cols="40" rows="10"></textarea>
        <br>
        <input type="file" accept="image/*" name="image">
        <input type="submit" name="check" value="Создать">
    </form>
</body>
</html>