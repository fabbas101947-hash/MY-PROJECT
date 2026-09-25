<?php
session_start();

require_once '../config/database.php';

if (!isset($_SESSION['admins'])) {
    header("Location: login.php");
    exit();
}

$pdo = db();

try {
    $rows = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
} catch (Exception $e) {
    $rows = [];
    $error = $e->getMessage();
}
?>

<h2>Users</h2>

<a href="index.php">Back to Dashboard</a>
<hr>

<?php if (isset($error)): ?>
    <p style="color:red;">
        Error: <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
    </tr>

    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['id'] ?? '') ?></td>

            <td>
                <?= htmlspecialchars(
                    $r['name'] ?? 
                    $r['username'] ?? 
                    'N/A'
                ) ?>
            </td>

            <td>
                <?= htmlspecialchars($r['email'] ?? '') ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php if (empty($rows) && !isset($error)): ?>
    <p>No users yet. Add users in phpMyAdmin.</p>
<?php endif; ?>