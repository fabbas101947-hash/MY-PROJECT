<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['admins'])){ header("Location: login.php"); exit(); }
$pdo = db();
try { $rows = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(); } catch(Exception $e){ $rows = []; $error = $e->getMessage(); }
?>
<h2>Products</h2>
<a href="index.php">Back to Dashboard</a><hr>
<?php if(isset($error)) echo "Error: $error - Table not found. Import database.sql"; ?>
<table border="1" cellpadding="10"><tr><th>ID</th><th>Name</th><th>Price</th></tr>
<?php foreach($rows as $r): ?>
<tr><td><?= $r['id'] ?></td><td><?= htmlspecialchars($r['name'] ?? $r['product_name'] ?? 'N/A') ?></td><td><?= $r['price'] ?? '' ?></td></tr>
<?php endforeach; ?>
</table>
<?php if(empty($rows)) echo "<p>No products yet. Add data in phpMyAdmin.</p>"; ?>