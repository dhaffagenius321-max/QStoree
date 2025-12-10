<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') { 
    header("Location: login.php"); 
    exit; 
}

$id = ""; 
$name = ""; 
$desc = ""; 
$price = ""; 
$img = "";
$isEdit = false;

if (isset($_GET['edit'])) {
    $isEdit = true;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $data = $stmt->fetch();
    if ($data) {
        $id = $data['id']; 
        $name = $data['name']; 
        $desc = $data['description'];
        $price = $data['price']; 
        $img = $data['img'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    if (empty($name) || empty($desc) || $price === "") {
        echo "<script>
                alert('Gagal: Nama, Deskripsi, dan Harga wajib diisi!');
                window.history.back();
              </script>";
        exit;
    }

    if ($price < 0) {
        echo "<script>
                alert('Harga tidak boleh kurang dari 0 (negatif)!');
                window.history.back();
              </script>";
        exit;
    }

    $isFileUploaded = (isset($_FILES['img_file']) && $_FILES['img_file']['error'] !== 4);
    if (!$isEdit && !$isFileUploaded) {
        echo "<script>
                alert('Gagal: Foto produk wajib diupload untuk barang baru!');
                window.history.back();
              </script>";
        exit;
    }
    
    $finalImage = $_POST['old_img'];

    if ($isFileUploaded) {
        if ($_FILES['img_file']['error'] === 0) {
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $fileName = $_FILES['img_file']['name'];
            $fileTmp = $_FILES['img_file']['tmp_name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowedExt)) {
            $newFileName = uniqid('prod_') . '.' . $fileExt;
            $uploadDest = 'uploads/' . $newFileName;

            if (move_uploaded_file($fileTmp, $uploadDest)) {
                $finalImage = $uploadDest;
            }
        } else {
            echo "<script>alert('Format file tidak valid! Gunakan JPG, PNG, atau GIF.'); window.history.back();</script>";
            exit;
            }
        } else {
            echo "<script>alert('Terjadi kesalahan saat upload gambar.'); window.history.back();</script>";
            exit;
        }
    }

    if (isset($_POST['id']) && $_POST['id'] != "") {
        $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, img=? WHERE id=?");
        $stmt->execute([$name, $desc, $price, $finalImage, $_POST['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, img) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $desc, $price, $finalImage]);
    }

    header("Location: seller_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Produk</title>
    <link rel="stylesheet" href="home.css">
    <style>
        .form-container { max-width: 500px; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea, input[type="file"] {
            width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;
        }
        .preview-img { display: block; margin-bottom: 10px; max-width: 100px; border: 1px solid #ddd; padding: 3px; }
    </style>
</head>
<body>
    
<header class="navbar">
    <div class="nav-left"><h1 class="logo">Seller Panel</h1></div>
</header>

<div class="form-container">
    <h2><?= $isEdit ? "Edit Produk" : "Tambah Produk Baru" ?></h2>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>">
        
        <input type="hidden" name="old_img" value="<?= htmlspecialchars($img) ?>">

        <label>Nama Produk:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>

        <label>Deskripsi:</label>
        <textarea name="description" rows="4" required><?= htmlspecialchars($desc) ?></textarea>

        <label>Harga ($):</label>
        <input type="number" step="0.01" min="0" name="price" value="<?= htmlspecialchars($price) ?>" required>

        <label>Gambar Produk:</label>
        <?php if ($img): ?>
            <img src="<?= htmlspecialchars($img) ?>" class="preview-img">
            <small style="display:block; margin-bottom:10px; color:#666;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
        <?php endif; ?>
        
        <input type="file" name="img_file" accept="image/*" <?= $isEdit ? '' : 'required' ?>>

        <div style="margin-top: 20px;">
            <button type="submit" class="checkout-btn">Simpan</button>
            <a href="seller_dashboard.php" style="margin-left: 10px; text-decoration: none; color: #555;">Batal</a>
        </div>
    </form>
</div>

</body>
</html>