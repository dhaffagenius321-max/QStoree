<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'seller') {
            header("Location: seller_dashboard.php");
        } else {
            header("Location: home.php");
        }
        exit;
    } else {
        $message = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="card">
    <h2>Masuk</h2>
    
    <form method="POST" action="">
        <label>Username
            <input name="username" type="text" autocomplete="username" required />
        </label>
        <label>Password
            <input name="password" type="password" autocomplete="current-password" required />
        </label>
        <button type="submit" id="btnLogin">Masuk</button>
    </form>

    <div class="flex">
        <a href="register.php" class="link">Daftar akun</a>
    </div>

    <?php if($message): ?>
        <div style="color: red; font-size: 0.9em; margin-top: 10px; text-align: center;">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>