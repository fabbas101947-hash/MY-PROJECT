<?php
require_once '../config/database.php';

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    try{
        $pdo = db();
        
        // check if email already exists
        $check = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $check->execute(['email' => $email]);
        
        if($check->fetch()){
            header("Location: ../customerlogin/login.html?error=email_exists");
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashed]);

        header("Location: ../customerlogin/login.html?success=account_created");
        exit();

    } catch(PDOException $e){
        echo "DB Error: " . $e->getMessage();
    }
}
?>