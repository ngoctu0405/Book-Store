<?php
session_start();
require_once __DIR__ . '/db.php';
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// ✅ Lấy userId từ session — không tin client
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

// Fallback: nếu session chưa có thì đọc từ body (hỗ trợ trường hợp cũ)
if ($userId <= 0) {
    $input = json_decode(file_get_contents('php://input'), true);
    $userId = isset($input['id']) ? intval($input['id']) : 0;
}

if ($userId <= 0) {
    http_response_code(401);
    echo json_encode(['error' => 'Chưa đăng nhập']);
    exit;
}

$stmt = $conn->prepare("
    SELECT id, status, fullName, username, email, phone, address
    FROM users WHERE id = ? LIMIT 1
");
$stmt->bind_param('i', $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    http_response_code(404);
    echo json_encode(['error' => 'Không tìm thấy tài khoản']);
    exit;
}

// Nếu bị khóa → xóa session luôn
if ($user['status'] === 'locked') {
    session_destroy();
}

// ✅ Đồng bộ lại session với dữ liệu mới nhất từ DB
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_username'] = $user['username'];
$_SESSION['user_fullName'] = $user['fullName'];

echo json_encode(['user' => $user]);