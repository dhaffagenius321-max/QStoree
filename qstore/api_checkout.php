<?php
session_start();
require 'db.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Silakan login']);
    exit;
}

if ($input) {
    $userId = $_SESSION['user_id'];
    $cart = $input['cart'];
    $total = $input['total'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$userId, $total]);
        $orderId = $pdo->lastInsertId();

        $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, qty, price) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($cart as $item) {
            $stmtItem->execute([$orderId, $item['id'], $item['name'], $item['qty'], $item['price']]);
        }

        $pdo->commit();
        echo json_encode(['status' => 'success']);

    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>