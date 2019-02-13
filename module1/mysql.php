<?php
$dbcnx = mysqli_connect("localhost", "webrt11", "dT6mQocX", "webrt11"); 
/**
*   Открываем соединение MySQL и при ошибке подключения выводим соответствующую информацию
*/
if(!$dbcnx){
    echo "Ошибка при подключении к базе данных!";
    exit();
}
// Подключаем основное оперирующее ядро
require_once('core.php');
$siteinfo = getSiteInfo($dbcnx);
session_start();
