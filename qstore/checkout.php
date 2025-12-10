<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

<header class="navbar">
    <div class="nav-left">
        <button onclick="history.back()" class="menu-btn">←</button>
        <h1 class="logo">Checkout</h1>
    </div>
</header>

<main class="container">
    <h3>Item yang dibeli:</h3>
    <div id="checkoutList"></div>

    <div class="checkout-box">
        <div class="total-label">Total:</div>
        <div id="totalAmount" class="total-amount">$0.00</div>
        <button id="confirmBtn" class="checkout-btn">Konfirmasi</button>
    </div>
</main>

<script src="checkout.js"></script>
</body>
</html>