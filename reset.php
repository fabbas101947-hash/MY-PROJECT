<?php
require "config/database.php";
$pdo = db();

// This will set password to admin123
$hash = password_hash("admin123", PASSWORD_DEFAULT);

$pdo->prepare("UPDATE admins SET password = ? WHERE username = 'admins'")->execute([$hash]);

echo "Password reset done! ✅<br>";
echo "Now try login with:<br>";
echo "Username: <b>admins</b><br>";
echo "Password: <b>admin123</b><br>";
echo "<a href='/admin/'>Go to Login</a>";
?>