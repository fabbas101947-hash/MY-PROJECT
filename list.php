<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require "config/database.php";
try {
  $pdo = db();
  echo "DB Connected OK<br><br>";
  $stmt = $pdo->query("SHOW TABLES");
  $tables = $stmt->fetchAll(PDO::FETCH_NUM);
  if(empty($tables)){
    echo "NO TABLES FOUND - Database is empty!";
  } else {
    echo "Tables found: ". count($tables). "<br><br>";
    foreach($tables as $row){
      echo "- ". $row[0]. "<br>";
    }
  }
} catch(Exception $e){
  echo "ERROR: ". $e->getMessage();
}
?>