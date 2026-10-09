<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    $pdo = db();
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll();
    echo json_encode($products);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>