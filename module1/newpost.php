<?php
require_once('mysql.php');
setPrivateZone($dbcnx, $_SESSION['login']);
move_uploaded_file($_FILES['image']['tmp_name'], "assets/img/uploaded/".$_FILES['image']['name']);
mysqli_query($dbcnx, "INSERT INTO `posts` (`name`, `cat`, `text`, `image`) VALUES ('\"".$_POST['name']."\", \"".$_POST['cat'].", \"".$_POST['text']."\", uploaded/".$_FILES['image']['name']."\"')");
header('Location: ap.php');
