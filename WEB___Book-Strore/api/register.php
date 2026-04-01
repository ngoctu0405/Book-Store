<?php
require_once __DIR__ . '/db.php';
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$fullName = isset($input['fullName']) ? trim($input['fullName']) : '';
$username = isset($input['username']) ? trim($input['username']) : '';
$password = isset($input['password']) ? trim($input['password']) : '';
$email = isset($input['email']) ? trim($input['email']) : '';
$phone = isset($input['phone']) ? trim($input['phone']) : '';
$address = isset($input['address']) ? trim($input['address']) : '';

if ($fullName === '' || $username === '' || $password === '' || $email === '' || $phone === '' || $address === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu thông tin bắt buộc']);
    exit;
}

// Kiểm tra trùng username
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$res = $stmt->get_result();
if ($res->fetch_assoc()) {
    http_response_code(409);
    echo json_encode(['error' => 'Tài khoản đã tồn tại']);
    exit;
}

// Chèn user mới
$status = 'active';
$now = date('Y-m-d H:i:s');
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
    INSERT INTO users (status, fullName, username, password, email, phone, address, createdAt)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
    'ssssssss',
    $status,
    $fullName,
    $username,
    $hashedPassword,
    $email,
    $phone,
    $address,
    $now
);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Không thể tạo tài khoản']);
    exit;
}

$newId = $stmt->insert_id;

// Không set session ở đây — người dùng cần đăng nhập thủ công
echo json_encode([
    'user' => [
        'id' => $newId,
        'status' => $status,
        'fullName' => $fullName,
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'createdAt' => $now,
    ]
]);