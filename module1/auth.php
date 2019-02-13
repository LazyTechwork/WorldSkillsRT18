<?php
require_once('mysql.php');
if(!isset($_POST['login']) || !isset($_POST['pass']) || !isset($_POST['check'])){
    header('Location: admin.php?status=-1');
    exit();
}
$_SESSION['login'] = $_POST['login'];
$_SESSION['pass'] = $_POST['pass'];
$query = mysqli_query($dbcnx, "SELECT * FROM `users` WHERE `login` LIKE '".$_SESSION['login']."'");

if(!$query){
    header('Location: admin.php?status=0');
    exit();
}else {
    $fetched = mysqli_fetch_array($query);
    if($fetched['pass'] == $_POST['pass'])
        if($fetched['isAdmin']){
            header('Location: ap.php');
            exit();
        }else{
            header('Location: index.php');
            exit();
        }
}
