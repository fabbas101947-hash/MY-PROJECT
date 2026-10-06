<?php
$host = "sql310.infinityfree.com";
$db   = "if0_43081074_dbConnection";
$user = "if0_43081074";
$pass = "RYhyNIfIFsf";

function db(){
    global $host, $db, $user, $pass;
    static $pdo = null;
    if($pdo === null){
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
    return $pdo;
}
?>