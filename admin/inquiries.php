<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admins'])) {
    header("Location: login.php");
    exit();
}

$pdo = db();

// Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $pdo->prepare("DELETE FROM contact_messages WHERE id = ?")->execute([$id]);
    header("Location: inquiries.php");
    exit();
}

try {
    $rows = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC")->fetchAll();
} catch (Exception $e) {
    $rows = [];
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head><title>Customer Inquiries</title>
<style>
body{font-family:Arial;padding:20px;background:#f9f5f0}
table{width:100%;border-collapse:collapse;background:white}
th{background:#4a1a1e;color:white;padding:12px}
td{padding:10px;border-bottom:1px solid #ddd}
a{color:#4a1a1e;font-weight:bold;text-decoration:none}
.del{color:red}
</style>
</head>
<body>
<h2>Customer Inquiries / Contact Messages</h2>
<a href="index.php">← Back to Dashboard</a><hr>
<?php if(isset($error)) echo "<p style='color:red'>Error: $error</p>"; ?>
<table border="1" cellpadding="10">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Message</th><th>Date</th><th>Action</th></tr>
<?php foreach($rows as $r): ?>
<tr>
<td><?= $r['id'] ?></td>
<td><?= htmlspecialchars($r['name'] ?? '') ?></td>
<td><?= htmlspecialchars($r['email'] ?? '') ?></td>
<td><?= htmlspecialchars($r['phone'] ?? $r['mobile'] ?? '') ?></td>
<td><?= htmlspecialchars($r['message'] ?? '') ?></td>
<td><?= $r['created_at'] ?? '' ?></td>
<td><a class="del" href="?delete=<?= $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php if(empty($rows)) echo "<p>No messages yet. Your table has 0 rows right now.</p>"; ?>
</body>
</html>