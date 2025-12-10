<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT id, name, description AS `desc`, price, img FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as &$p) {
    $p['price'] = (float)$p['price'];
}
unset($p);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>

<div id="sidebar" class="sidebar">
    <div class="sidebar-header">Menu</div>
    <a href="logout.php" class="sidebar-item logout" style="display:block; text-align:center; text-decoration:none;">Logout</a>
</div>

<div id="overlay" class="overlay"></div>

<header class="navbar">
    <div class="nav-left">
        <button id="menuToggle" class="menu-btn">☰</button>
        <h1 class="logo">QStore</h1>
    </div>

    <div class="nav-right">
        <div class="cart-wrapper">
            <div class="cart-icon" id="openCart">🛒</div>
            <span id="cartCount" class="cart-count">0</span>
        </div>
    </div>
</header>

<main class="container">
    <h2 class="section-title">Products</h2>
    <div id="productList" class="grid">
        </div>
</main>

<script>
    const products = <?= json_encode($products) ?>;
</script>

<script src="home_modified.js"></script> 
</body>
</html>