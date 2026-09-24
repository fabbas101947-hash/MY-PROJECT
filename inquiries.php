<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['admins'])){ header("Location: login.php"); exit(); }
$pdo = db();
$rows = [];
$error = '';
// try different possible table names
$tables_to_try = ['inquiries', 'inquiry', 'inquires', 'contact', 'messages', 'contacts'];
foreach($tables_to_try as $t){
  try {
    $rows = $pdo->query("SELECT * FROM `$t` ORDER BY id DESC")->fetchAll();
    $error = "Showing table: $t";
    break;
  } catch(Exception $e){ continue; }
}
if(empty($rows) && $error==''){
  try {
    // list what tables you really have
    $list = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $error = "No inquiry table found. Your tables are: " . implode(", ", $list);
  } catch(Exception $e){ $error = $e->getMessage(); }
}
?>
<h2>Inquiries</h2>
<a href="index.php">Back to Dashboard</a><hr>
<?php if($error) echo "<p style='color:red'>$error</p>"; ?>
<table border="1" cellpadding="10"><tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr>
<?php foreach($rows as $r): ?>
<tr>
<td><?= $r['id'] ?? '' ?></td>
<td><?= htmlspecialchars($r['name'] ?? $r['full_name'] ?? $r['customer_name'] ?? 'N/A') ?></td>
<td><?= htmlspecialchars($r['email'] ?? 'N/A') ?></td>
<td><?= htmlspecialchars($r['message'] ?? $r['msg'] ?? $r['inquiry'] ?? $r['details'] ?? '') ?></td>
<td><?= $r['created_at'] ?? $r['date'] ?? '' ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php if(empty($rows)) echo "<p>No inquiries yet.</p>"; ?>