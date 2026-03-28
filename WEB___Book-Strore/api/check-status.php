<?php

require_once __DIR__ . '/db.php';
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$userId = isset($input['id']) ? intval($input['id']) : 0;

if ($userId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu user id']);
    exit;
}

$stmt = $conn->prepare("
    SELECT id, status, fullName, username, email, phone, address
    FROM users
    WHERE id = ?
    LIMIT 1
");
$stmt->bind_param('i', $userId);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if (!$user) {
    http_response_code(404);
    echo json_encode(['error' => 'Không tìm thấy tài khoản']);
    exit;
}

echo json_encode(['user' => $user]);
