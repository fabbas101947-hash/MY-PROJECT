<?php
session_start();
require_once '../config/database.php';

if(!isset($_SESSION['admins'])){
    header("Location: login.php");
    exit();
}

$admin_name = $_SESSION['admins'];
$pdo = db();

// Safe counts - if table doesn't exist, show 0
try { $total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(); } catch(Exception $e){ $total_products = 0; }
try { $new_inquiries = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status = 'new'")->fetchColumn(); } catch(Exception $e){ $new_inquiries = 0; }
try { $total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(); } catch(Exception $e){ $total_users = 0; }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - INQUIRE STORE</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f4f6f9; }
        .navbar { background: #2c3e50; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 20px; }
        .navbar a { color: white; text-decoration: none; background: #e74c3c; padding: 8px 15px; border-radius: 5px; }
        .main-content { flex: 1; padding: 30px; }
        .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .card h4 { color: #7f8c8d; font-size: 14px; }
        .card h2 { color: #2c3e50; font-size: 28px; margin-top: 10px; }
        .container { display: flex; }
        .sidebar { width: 250px; background: white; height: 100vh; padding: 20px; box-shadow: 2px 0 5px rgba(0,0,0,0.1); }
        .sidebar a { display: block; padding: 10px; color: #333; text-decoration: none; border-radius: 5px; margin-bottom: 5px; }
        .sidebar a:hover { background: #3498db; color: white; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>INQUIRE STORE - Admin Panel</h1>
        <div>Welcome, <b><?php echo htmlspecialchars($admin_name); ?></b> | <a href="logout.php">Logout</a></div>
    </div>
    <div class="container">
        <div class="sidebar">
            <h3>Menu</h3>
            <a href="index.php">📊 Dashboard</a>
            <a href="product.php">📦 Products</a>
            <a href="inquiry.php">📩 Inquiries</a>
            <a href="user.php">👤 Users</a>
            <a href="../index.html" target="_blank">🌐 View Website</a>
        </div>
        <div class="main-content">
            <h2>Dashboard</h2><br>
            <div class="cards">
                <div class="card"><h4>Total Products</h4><h2><?php echo $total_products; ?></h2></div>
                <div class="card"><h4>New Inquiries</h4><h2><?php echo $new_inquiries; ?></h2></div>
                <div class="card"><h4>Total Users</h4><h2><?php echo $total_users; ?></h2></div>
            </div>
            <br><br>
            <div class="card"><h3>Recent Activity</h3><p>Dashboard working! Now you can add products page.</p></div>
        </div>
    </div>
</body>
</html>