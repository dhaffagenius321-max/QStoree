<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: seller_dashboard.php");
    exit;
}

if (isset($_GET['confirm_order'])) {
    $id = $_GET['confirm_order'];
    $stmt = $pdo->prepare("UPDATE orders SET status = 'confirmed' WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: seller_dashboard.php");
    exit;
}

$orders = $pdo->query("SELECT o.*, u.username FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="home.css">
    <style>
        .dashboard-container { max-width: 1000px; margin: 20px auto; padding: 20px; }
        .section { margin-bottom: 40px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #eee; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        .btn-small { padding: 5px 10px; font-size: 0.8em; cursor: pointer; text-decoration: none; color: white; border-radius: 4px; }
        .btn-confirm { background: green; }
        .btn-delete { background: red; }
        .btn-add { background: blue; display: inline-block; padding: 10px 20px; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 10px; }
        .status-pending { color: orange; font-weight: bold; }
        .status-confirmed { color: green; font-weight: bold; }
        .logout { background-color: #dc3545; color: white !important; margin: 20px; padding: 10px; text-align: center; border-radius: 5px; display: block; text-decoration: none; }
        .logout:hover { background-color: #c82333; }
    </style>
</head>
<body>

<div id="sidebar" class="sidebar">
    <div class="sidebar-header">Menu</div>

    <a href="logout.php" class="sidebar-item logout">Logout</a>
</div>

<div id="overlay" class="overlay"></div>

<header class="navbar">
    <div class="nav-left">
        <button id="menuToggle" class="menu-btn">☰</button>
        <h1 class="logo">QStore Seller</h1>
    </div>
    <div class="nav-right">
        </div>
</header>

<div class="dashboard-container">
    
    <div class="section">
        <h2>Pesanan Masuk</h2>
        <?php if (count($orders) == 0): ?>
            <p>Belum ada pesanan.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pembeli</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                    <tr>
                        <td>#<?= $o['id'] ?></td>
                        <td><?= htmlspecialchars($o['username']) ?></td>
                        <td>$<?= $o['total_amount'] ?></td>
                        <td>
                            <span class="status-<?= $o['status'] ?>"><?= strtoupper($o['status']) ?></span>
                        </td>
                        <td>
                            <?php if ($o['status'] === 'pending'): ?>
                                <a href="?confirm_order=<?= $o['id'] ?>" class="btn-small btn-confirm">Konfirmasi Kirim</a>
                            <?php else: ?>
                                <span>Selesai</span>
                            <?php endif; ?>
                            </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Kelola Barang</h2>
        <a href="product_form.php" class="btn-add">+ Tambah Barang Baru</a>
        
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><img src="<?= $p['img'] ?>" width="50"></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td>$<?= $p['price'] ?></td>
                    <td>
                        <a href="product_form.php?edit=<?= $p['id'] ?>" style="color:blue;">Edit</a> | 
                        <a href="?delete_product=<?= $p['id'] ?>" onclick="return confirm('Hapus barang ini?')" style="color:red;">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");
    const menuToggle = document.getElementById("menuToggle");

    menuToggle.addEventListener("click", () => {
        sidebar.classList.add("open");
        overlay.classList.add("show");
    });

    overlay.addEventListener("click", () => {
        sidebar.classList.remove("open");
        overlay.classList.remove("show");
    });
</script>

</body>
</html>