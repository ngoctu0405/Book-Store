<?php
session_start();
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
    echo json_encode(['error' => 'Thiếu thông tin tài khoản hoặc giỏ hàng trống']);
    exit;
}

// Lấy ID sản phẩm để kiểm tra
$productIds = array_column($items, 'id');
$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$types = str_repeat('i', count($productIds));

// KHÓA DÒNG (FOR UPDATE) ĐỂ CHỐNG MUA TRÙNG KHI KHO SẮP HẾT
$stmt = $conn->prepare("SELECT id, price, qty, name FROM products WHERE id IN ($placeholders) FOR UPDATE");
$stmt->bind_param($types, ...$productIds);

$conn->begin_transaction();

try {
    $stmt->execute();
    $res = $stmt->get_result();

    $productsById = [];
    while ($row = $res->fetch_assoc()) {
        $productsById[$row['id']] = $row;
    }

    $cartSubtotal = 0;

    foreach ($items as $it) {
        $pid = (int)$it['id'];
        $qty = (int)$it['qty'];

        if (!isset($productsById[$pid])) {
            throw new Exception("Sản phẩm không tồn tại trong kho.");
        }
        if ($productsById[$pid]['qty'] < $qty) {
            $pName = $productsById[$pid]['name'];
            throw new Exception("Sách '$pName' chỉ còn " . $productsById[$pid]['qty'] . " cuốn, không đủ để thanh toán.");
        }

        $price = (int)$productsById[$pid]['price'];
        $cartSubtotal += $price * $qty;

        // Trừ tồn kho
        $newQty = $productsById[$pid]['qty'] - $qty;
        $upd = $conn->prepare("UPDATE products SET qty = ? WHERE id = ?");
        $upd->bind_param('ii', $newQty, $pid);
        $upd->execute();
    }

    $totalAmount = $cartSubtotal;

    // 1. LẤY THÔNG TIN NGƯỜI MUA TỪ JAVASCRIPT GỬI LÊN
    $buyerInfo = isset($input['buyerInfo']) ? $input['buyerInfo'] : [];
    $bName    = $buyerInfo['name'] ?? '';
    $bPhone   = $buyerInfo['phone'] ?? '';
    $bAddress = $buyerInfo['address'] ?? '';
    $bNote    = $buyerInfo['note'] ?? '';
    $pMethod  = $buyerInfo['paymentMethod'] ?? 'Tiền mặt';

    // 2. TẠO ORDER TỔNG (Lưu thông tin khách hàng vào bảng orders)
    $now = date('Y-m-d H:i:s');
    $status = 'Chờ xác nhận';

    $stmtOrder = $conn->prepare("
        INSERT INTO orders (userId, orderDate, totalAmount, status, buyer_name, buyer_phone, buyer_address, buyer_note, payment_method)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    // isissssss: 1 integer, 1 string, 1 integer, 6 string
    $stmtOrder->bind_param('isissssss', $userId, $now, $totalAmount, $status, $bName, $bPhone, $bAddress, $bNote, $pMethod);
    $stmtOrder->execute();
    $orderId = $stmtOrder->insert_id;

    // 3. TẠO CHI TIẾT ĐƠN HÀNG (Lưu Tên sách, Số lượng, Giá vào bảng order_items)
    $stmtItem = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, product_name, qty, price)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($items as $it) {
        $pid = (int)$it['id'];
        $qty = (int)$it['qty'];
        $price = (int)$productsById[$pid]['price'];
        $pName = $productsById[$pid]['name']; // Lấy tên sách từ CSDL

        // iisii: integer, integer, string, integer, integer
        $stmtItem->bind_param('iisii', $orderId, $pid, $pName, $qty, $price);
        $stmtItem->execute();
    }

    $conn->commit();

    // Xóa giỏ hàng trong Session
    $_SESSION['cart'] = [];

    // ✅ ĐÃ SỬA: Bổ sung thêm 'success' => true để main.js có thể nhận diện và mở Modal
    echo json_encode([
        'success'     => true,
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
