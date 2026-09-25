<?php
$host = "localhost";
$db   = "inquire_store";
$user = "root";
$pass = "";

function db(){
    global $host, $db, $user, $pass;
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
    return $pdo;
}
?>