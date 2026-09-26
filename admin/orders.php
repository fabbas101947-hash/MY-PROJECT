<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admins'])) {
    header("Location: login.php");
    exit();
}

$pdo = db();

// Delete order
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$id]);
    header("Location: orders.php");
    exit();
}

// Update status
if (isset($_POST['update_status'])) {
    $id = intval($_POST['order_id']);
    $status = $_POST['status'];
    $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?")->execute([$status, $id]);
    header("Location: orders.php");
    exit();
}

try {
    $rows = $pdo->query("SELECT * FROM orders ORDER BY id DESC")->fetchAll();
} catch (Exception $e) {
    $rows = [];
    $error = $e->getMessage();
}

// Function to get items for an order
function getOrderItems($pdo, $order_id){
    try {
        $stmt = $pdo->prepare("
            SELECT oi.*, p.name as product_name 
            FROM order_items oi 
            LEFT JOIN products p ON p.id = oi.product_id 
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$order_id]);
        return $stmt->fetchAll();
    } catch(Exception $e){ return []; }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Orders - Admin</title>
<style>
body{font-family:Arial;padding:20px;background:#f9f5f0}
table{width:100%;border-collapse:collapse;background:white;margin-bottom:20px}
th{background:#4a1a1e;color:white;padding:12px;text-align:left}
td{padding:10px;border-bottom:1px solid #ddd;vertical-align:top}
a{color:#4a1a1e;font-weight:bold;text-decoration:none}
.del{color:red}
.badge{padding:4px 8px;border-radius:4px;color:white;font-size:12px}
.pending{background:orange} .completed{background:green} .cancelled{background:red}
.items{font-size:13px;background:#fff8e7;padding:8px;margin-top:5px;border-radius:5px}
select{padding:5px}
button{padding:5px 10px;background:#4a1a1e;color:white;border:none;cursor:pointer;border-radius:4px}
</style>
</head>
<body>

<h2>Customer Orders</h2>
<a href="index.php">← Back to Dashboard</a> | <a href="inquiries.php">View Inquiries</a>
<hr>

<?php if(isset($error)): ?>
<p style="color:red">Error: <?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Total</th>
    <th>Status</th>
    <th>Date</th>
    <th>Items</th>
    <th>Action</th>
</tr>

<?php foreach($rows as $r): 
    $items = getOrderItems($pdo, $r['id']);
?>
<tr>
    <td>#<?= $r['id'] ?></td>
    <td>
        <?= htmlspecialchars($r['customer_name'] ?? $r['name'] ?? $r['user_id'] ?? 'Guest') ?><br>
        <small><?= htmlspecialchars($r['phone'] ?? $r['email'] ?? '') ?></small><br>
        <small><?= htmlspecialchars($r['address'] ?? '') ?></small>
    </td>
    <td>Rs. <?= htmlspecialchars($r['total'] ?? $r['total_amount'] ?? '0') ?></td>
    <td>
        <span class="badge <?= strtolower($r['status'] ?? 'pending') ?>"><?= $r['status'] ?? 'Pending' ?></span>
        <form method="POST" style="margin-top:8px">
            <input type="hidden" name="order_id" value="<?= $r['id'] ?>">
            <select name="status">
                <option value="Pending" <?= ($r['status']=='Pending')?'selected':'' ?>>Pending</option>
                <option value="Completed" <?= ($r['status']=='Completed')?'selected':'' ?>>Completed</option>
                <option value="Cancelled" <?= ($r['status']=='Cancelled')?'selected':'' ?>>Cancelled</option>
            </select>
            <button type="submit" name="update_status">Update</button>
        </form>
    </td>
    <td><?= $r['created_at'] ?? $r['order_date'] ?? '' ?></td>
    <td>
        <?php if(empty($items)): ?>
            <small>No items found</small>
        <?php else: foreach($items as $it): ?>
            <div class="items">
                <?= htmlspecialchars($it['product_name'] ?? 'Product #'.$it['product_id']) ?> 
                x <?= $it['quantity'] ?> = Rs.<?= $it['price'] ?? '' ?>
            </div>
        <?php endforeach; endif; ?>
    </td>
    <td><a class="del" href="?delete=<?= $r['id'] ?>" onclick="return confirm('Delete this order?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>

<?php if(empty($rows)) echo "<p>No orders yet. Your orders table has 0 rows right now.</p>"; ?>

</body>
</html>