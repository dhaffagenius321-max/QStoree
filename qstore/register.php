<?php
require 'db.php';
$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $dob      = $_POST['dob'];

    if (strlen($password) < 8) {
        $message = "Password minimal 8 karakter.";
        $status = "error";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() > 0) {
            $message = "Username sudah digunakan.";
            $status = "error";
        } else {
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO users (username, password, dob) VALUES (?, ?, ?)");
            if ($insert->execute([$username, $hashedPass, $dob])) {
                $message = "Akun berhasil dibuat. Silakan login.";
                $status = "success";
            } else {
                $message = "Terjadi kesalahan.";
                $status = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="card">
    <h2>Daftar Akun</h2>

    <form method="POST" action="">
        <label>Username
            <input name="username" type="text" required />
        </label>
        <label>Password (minimal 8 karakter)
            <input name="password" type="password" required />
        </label>
        <label>Tanggal Lahir
            <input name="dob" type="date" required />
        </label>
        <button type="submit">Daftar</button>
    </form>

    <a href="login.php" class="link">Sudah punya akun?</a>

    <?php if($message): ?>
        <div style="color: <?= $status == 'success' ? 'green' : 'red' ?>; font-size: 0.9em; margin-top: 10px; text-align: center;">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>