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
    <title>Cart</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

<header class="navbar">
    <div class="nav-left">
        <button onclick="window.location.href='home.php'" class="menu-btn">←</button>
        <h1 class="logo">Cart</h1>
    </div>
</header>

<main class="container">
    <div id="cartList"></div>

    <div class="checkout-box">
        <div class="total-label">Total:</div>
        <div id="totalAmount" class="total-amount">$0.00</div>
        <button id="checkoutBtn" class="checkout-btn">Checkout</button>
    </div>
</main>

<script src="cart.js"></script>
</body>
</html>