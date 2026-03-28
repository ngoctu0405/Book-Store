<?php

require_once __DIR__ . '/db.php';
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$userId = isset($input['userId']) ? (int)$input['userId'] : 0;
$items  = isset($input['items']) && is_array($input['items']) ? $input['items'] : [];

if ($userId <= 0 || empty($items)) {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu userId hoặc items']);
    exit;
}

// Tính tổng tiền và kiểm tra tồn kho
$productIds = array_column($items, 'id');
$placeholders = implode(',', array_fill(0, count($productIds), '?'));

$types = str_repeat('i', count($productIds));
$stmt = $conn->prepare("SELECT id, price, qty FROM products WHERE id IN ($placeholders) FOR UPDATE");
$stmt->bind_param($types, ...$productIds);

$conn->begin_transaction();

try {
    $stmt->execute();
    $res = $stmt->get_result();

    $productsById = [];
    while ($row = $res->fetch_assoc()) {
        $productsById[$row['id']] = $row;
    }

    $totalAmount = 0;

    foreach ($items as $it) {
        $pid = (int)$it['id'];
        $qty = (int)$it['qty'];

        if (!isset($productsById[$pid])) {
            throw new Exception("Sản phẩm không tồn tại: $pid");
        }
        if ($productsById[$pid]['qty'] < $qty) {
            throw new Exception("Sản phẩm ID $pid không đủ tồn kho");
        }

        $price = (int)$productsById[$pid]['price'];
        $totalAmount += $price * $qty;

        // Trừ tồn kho
        $newQty = $productsById[$pid]['qty'] - $qty;
        $upd = $conn->prepare("UPDATE products SET qty = ? WHERE id = ?");
        $upd->bind_param('ii', $newQty, $pid);
        $upd->execute();
    }

    // Tạo order
    $now = date('Y-m-d H:i:s');
    $status = 'completed';

    $stmtOrder = $conn->prepare("
        INSERT INTO orders (userId, orderDate, totalAmount, status)
        VALUES (?, ?, ?, ?)
    ");
    $stmtOrder->bind_param('isis', $userId, $now, $totalAmount, $status);
    $stmtOrder->execute();
    $orderId = $stmtOrder->insert_id;

    // Tạo order_items
    $stmtItem = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, qty, price)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($items as $it) {
        $pid = (int)$it['id'];
        $qty = (int)$it['qty'];
        $price = (int)$productsById[$pid]['price'];
        $stmtItem->bind_param('iiii', $orderId, $pid, $qty, $price);
        $stmtItem->execute();
    }

    $conn->commit();

    echo json_encode([
        'orderId'     => $orderId,
        'totalAmount' => $totalAmount,
        'status'      => $status,
        'orderDate'   => $now
    ]);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
