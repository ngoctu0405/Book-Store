<?php

require_once __DIR__ . '/db.php';
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$username = isset($input['username']) ? trim($input['username']) : '';
$password = isset($input['password']) ? trim($input['password']) : '';

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu username hoặc password']);
    exit;
}

$stmt = $conn->prepare("
    SELECT id, status, fullName, username, password, email, phone, address, createdAt
    FROM users
    WHERE username = ?
    LIMIT 1
");
$stmt->bind_param('s', $username);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if (!$user) {
    http_response_code(401);
    echo json_encode(['error' => 'Tài khoản không tồn tại']);
    exit;
}

if (!password_verify($password, $user['password'])) {
    // Fallback: kiểm tra plain text cho tài khoản cũ chưa hash
    if ($user['password'] !== $password) {
        http_response_code(401);
        echo json_encode(['error' => 'Mật khẩu không chính xác']);
        exit;
    }
}

if ($user['status'] === 'locked') {
    http_response_code(403);
    echo json_encode(['error' => 'Tài khoản đã bị khóa']);
    exit;
}

// Ẩn password khi trả về client
unset($user['password']);

echo json_encode([
    'user' => $user
]);
