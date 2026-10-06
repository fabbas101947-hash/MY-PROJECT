<?php
ini_set('display_errors', 1); error_reporting(E_ALL);
session_start();
require_once '../config/database.php'; // your PDO file

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    try{
        $pdo = db();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if($row && password_verify($password, $row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['name'] ?? $row['username'] ?? '';
            
            // Remember me
            if(isset($_POST['remember'])){
                setcookie("user_email", $email, time() + (86400 * 30), "/");
            }
                    // --- LOG THE LOGIN ---
        $ip = $_SERVER['REMOTE_ADDR'];
        $stmt_log = $pdo->prepare("INSERT INTO login_logs (user_id, email, ip_address) VALUES (:uid, :email, :ip)");
        $stmt_log->execute(['uid' => $row['id'], 'email' => $email, 'ip' => $ip]);
        // --- END LOG ---

            header("Location: ../index.html"); // customer homepage
            exit();
        } else {
            header("Location: login.html?error=invalid");
            exit();
        }
    } catch(PDOException $e){
        echo "DB Error: " . $e->getMessage();
    }
} else {
    header("Location: login.html");
    exit();
}
?>