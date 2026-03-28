<?php

require_once __DIR__ . '/db.php';
header('Content-Type: application/json; charset=UTF-8');

$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$subcategory = isset($_GET['subcategory']) ? trim($_GET['subcategory']) : '';
$author = isset($_GET['author']) ? trim($_GET['author']) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$minPrice = isset($_GET['minPrice']) ? trim($_GET['minPrice']) : '';
$maxPrice = isset($_GET['maxPrice']) ? trim($_GET['maxPrice']) : '';
$minQty = isset($_GET['minQty']) ? trim($_GET['minQty']) : '';

$conditions = [];
$params = [];
$types = '';

if ($category !== '') {
    $conditions[] = 'c.name = ?';
    $params[] = $category;
    $types .= 's';
}

if ($subcategory !== '') {
    $conditions[] = 'p.subcategory = ?';
    $params[] = $subcategory;
    $types .= 's';
}

if ($author !== '') {
    $conditions[] = 'p.author LIKE ?';
    $params[] = '%' . $author . '%';
    $types .= 's';
}

if ($search !== '') {
    $conditions[] = '(p.name LIKE ? OR p.author LIKE ? OR p.description LIKE ? OR p.sku LIKE ? OR c.name LIKE ?)';
    $searchParam = '%' . $search . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'sssss';
}

if ($minPrice !== '' && is_numeric($minPrice)) {
    $conditions[] = 'p.price >= ?';
    $params[] = (float)$minPrice;
    $types .= 'd';
}

if ($maxPrice !== '' && is_numeric($maxPrice)) {
    $conditions[] = 'p.price <= ?';
    $params[] = (float)$maxPrice;
    $types .= 'd';
}

if ($minQty !== '' && is_numeric($minQty)) {
    $conditions[] = 'p.qty >= ?';
    $params[] = (int)$minQty;
    $types .= 'i';
}

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

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi chuẩn bị truy vấn products']);
    exit;
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi thực thi truy vấn products']);
    exit;
}

$result = $stmt->get_result();
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi lấy kết quả products']);
    exit;
}

$products = [];
while ($row = $result->fetch_assoc()) {
    $row['status'] = ($row['qty'] > 0) ? 'active' : 'inactive';
    $products[] = $row;
}

echo json_encode([
    'products' => $products
]);
