<?php
$dsn="mysql:host=localhost;dbname=library";
$user="root";
$pass="";
$option=array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
);
try {
    $conn=new pdo($dsn,$user,$pass,$option);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOexecption $e) {
 echo $e->getmessage();
}