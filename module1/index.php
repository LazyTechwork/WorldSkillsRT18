<?php
    require_once('mysql.php');
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header>
    <a class="btn" href="admin.php">Авторизация</a><br><br>
    <img src="assets/img/<?= $siteinfo['header_image']; ?>" alt="" width="35%">
    <h1><?= $siteinfo['sitename']; ?></h1>
    <h3><?= $siteinfo['description'] ?></h3>
    </header>
    <div id="main">
        <?php foreach(returnPosts($dbcnx) as $val): ?>
        <h2><?= $val['name']; ?></h2>
        <p class="cat"><?= getCatById($dbcnx, $val['cat']); ?></p>
        <img src="assets/img/<?= $val['image']; ?>" alt="" width="35%">
        <p><?= $val['text']; ?></p>
        <?php endforeach; ?>
    </div>
</body>
</html>