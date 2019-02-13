<?php

/**
*   Возвращает полную информацию о пользователе
*/
function getUserInfo($conn, $login){
    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `login` LIKE '".$login."'");
    if($query)
        return mysqli_fetch_array($query);
    else
        return false;
}

/**
*   Возвращает информацию сайта
*/
function getSiteInfo($conn){
    return mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `site_info`"));
}

/**
*   Устанавливает приватную зону для этой страницы (требуется аутентификация)
*/
function setPrivateZone($conn, $userLogin){
    if(!getUserInfo($conn, $userLogin)['isAdmin']){
        header('Location: index.php');
        exit();
    }
}

/**
*   Возвращает полный список новостей
*/
function returnPosts($conn){
    return mysqli_fetch_all(mysqli_query($conn, "SELECT *  FROM `posts` ORDER BY `id` ASC"), MYSQLI_ASSOC);
}

function getCatById($conn, $id){
    $query = mysqli_query($conn, "SELECT * FROM `categories` WHERE `id` = ".$id);
    if($query)
        return mysqli_fetch_array($query);
    else
        return false;
}

function returnCategories($conn){
    return mysqli_fetch_all(mysqli_query($conn, "SELECT *  FROM `categories`"), MYSQLI_ASSOC);
}
