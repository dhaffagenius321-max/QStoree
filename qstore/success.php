<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sukses</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

<header class="navbar">
    <div class="nav-left">
        <h1 class="logo">MyStore</h1>
    </div>
</header>

<main class="container success-box">
    <h2>Pembelian Berhasil</h2>
    <p>Terima kasih! Pesanan Anda telah diproses.</p>

    <button onclick="window.location.href='home.php'" class="checkout-btn">
        Kembali ke Home
    </button>
</main>

</body>
</html>
