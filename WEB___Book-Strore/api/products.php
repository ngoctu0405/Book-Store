<?php

require_once __DIR__ . '/db.php';

// Trả về danh sách products giống structure bs_data cũ

$sql = "
    SELECT 
        p.id,
        p.sku,
        p.name,
        p.author,
        p.price,
        p.profitMargin,
        c.name AS category,
        p.subcategory,
        p.description AS `desc`,
        p.image AS img,
        p.qty
    FROM products p
    JOIN categories c ON p.category_id = c.id
";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi truy vấn products']);
    exit;
}

$products = [];
while ($row = $result->fetch_assoc()) {
    // Giữ status mặc định là active nếu qty > 0
    $row['status'] = ($row['qty'] > 0) ? 'active' : 'inactive';
    $products[] = $row;
}

echo json_encode([
    'products' => $products
]);

