<?php
session_start();
require_once '../config/database.php'; // your PDO file

// Optional: check if admin is logged in
// if(!isset($_SESSION['admin_id'])){ header("Location: login.php"); exit(); }

$pdo = db();
$stmt = $pdo->query("SELECT * FROM login_logs ORDER BY login_time DESC LIMIT 100");
$logs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<title>Customer Login History - InquireStore</title>
<style>
body{font-family:Arial;background:#f5f5f5;padding:20px}
table{width:100%;background:white;border-collapse:collapse;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
th,td{padding:12px 15px;border:1px solid #ddd;text-align:left}
th{background:#222;color:white}
tr:hover{background:#f1f1f1}
h2{margin-bottom:20px}
</style>
</head>
<body>
<h2>Last 100 Customer Logins - InquireStore</h2>
<table>
<tr><th>ID</th><th>User ID</th><th>Email</th><th>IP Address</th><th>Time (Karachi)</th></tr>
<?php foreach($logs as $row): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['user_id'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['ip_address'] ?></td>
<td><?= $row['login_time'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<p><a href="index.php">Back to Admin Dashboard</a></p>
</body>
</html>