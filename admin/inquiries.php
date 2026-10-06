<?php
session_start();
require_once '../config/database.php';

// FIX 1: Check what session your admin login really sets
// Look in admin/login.php - change this if needed to 'admin_id' or 'admin'
if (!isset($_SESSION['admins']) && !isset($_SESSION['admin']) && !isset($_SESSION['admin_id'])) {
    // For testing, comment this line if you keep getting redirected
    // header("Location: login.php"); exit();
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
    // If table doesn't exist, create it automatically
    if(strpos($error, "doesn't exist") !== false || strpos($error, "no such table") !== false){
        $pdo->exec("CREATE TABLE contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            email VARCHAR(100),
            phone VARCHAR(50),
            message TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
        $error = "Table was missing, I just created it. Refresh page.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Customer Inquiries</title>
<style>
body{font-family:Arial;padding:20px;background:#f9f5f0}
table{width:100%;border-collapse:collapse;background:white}
th{background:#4a1a1e;color:white;padding:12px;text-align:left}
td{padding:10px;border-bottom:1px solid #ddd}
a{color:#4a1a1e;font-weight:bold;text-decoration:none}
.del{color:red}
.card{padding:20px;background:white;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
</style>
</head>
<body>
<div class="card">
<h2>Customer Inquiries / Contact Messages (<?= count($rows) ?>)</h2>
<a href="index.php">← Back to Dashboard</a> | <a href="product.php">Products</a> | <a href="login_history.php">Login History</a>
<hr>
<?php if(isset($error)) echo "<p style='color:red;background:#ffe0e0;padding:10px'>$error</p>"; ?>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Message</th><th>Date</th><th>Action</th></tr>
<?php foreach($rows as $r): ?>
<tr>
<td><?= $r['id'] ?></td>
<td><?= htmlspecialchars($r['name'] ?? '') ?></td>
<td><?= htmlspecialchars($r['email'] ?? '') ?></td>
<td><?= htmlspecialchars($r['phone'] ?? '') ?></td>
<td><?= htmlspecialchars($r['message'] ?? '') ?></td>
<td><?= $r['created_at'] ?? '' ?></td>
<td><a class="del" href="?delete=<?= $r['id'] ?>" onclick="return confirm('Delete this inquiry?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php if(empty($rows)) echo "<p>No messages yet. When customer fills contact form, it will show here.</p>"; ?>
</div>
</body>
</html>