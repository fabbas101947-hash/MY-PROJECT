<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
$pdo = db();

$id = $_GET['id'] ?? 0;

if(isset($_POST['update'])){
  $name = $_POST['name'];
  $price = $_POST['price'];

  try {
    $stmt = $pdo->prepare("UPDATE products SET name=?, price=? WHERE id=?");
    $stmt->execute([$name, $price, $id]);
  } catch(Exception $e){
    $stmt = $pdo->prepare("UPDATE products SET product_name=?, price=? WHERE id=?");
    $stmt->execute([$name, $price, $id]);
  }

  header("Location: index.php");
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$p = $stmt->fetch();
?>
<h2>Update Product#<?= $id ?></h2>
<form method="post">
  <label>Name:</label><br>
  <input type="text" name="name" value="<?= htmlspecialchars($p['name'] ?? $p['product_name']) ?>" required><br><br>
  <label>Price (PKR):</label><br>
  <input type="text" name="price" value="<?= $p['price'] ?>" required><br><br>
  <button type="submit" name="update">Update</button>
</form>