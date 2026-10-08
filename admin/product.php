<?php
session_start();
require_once '../config/database.php';
$pdo = db();
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<title>Products - Admin</title>
<style>
body{font-family:Arial;background:#f5f5f5;padding:20px}
.card{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
table{width:100%;border-collapse:collapse;margin-top:15px}
th,td{padding:12px 15px;border:1px solid #ddd;text-align:left}
th{background:#222;color:white}
tr:hover{background:#f1f1f1}
a{color:#6c5ce7;text-decoration:none}
.btn{padding:6px 12px;background:#222;color:white;border-radius:5px}
</style>
</head>
<body>
<div class="card">
<h2>Products (<?= count($products) ?>)</h2>
<a href="index.php">← Back to Dashboard</a> | <a href="login_history.php">View Login History</a>
<table>
<tr><th>ID</th><th>Name</th><th>Price</th><th>Action</th></tr>
<?php foreach($products as $p): ?>
<tr>
<td><?= $p['id'] ?></td>
<td><?= htmlspecialchars($p['name'] ?? $p['product_name'] ?? 'Item #'.$p['id']) ?></td>
<td>Rs. <?= number_format($p['price'], 0) ?> PKR</td>
<td><a href="update.php?id=<?= $p['id'] ?>"><button>Update</button></a> 
<a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')"><button>Delete</button></a>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>
</body>
</html>