<?php
require_once '../config/database.php';
$pdo = db();

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
?>