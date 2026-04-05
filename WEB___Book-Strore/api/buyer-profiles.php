<?php
require_once __DIR__ . '/db.php';
header('Content-Type: application/json; charset=UTF-8');

$method = $_SERVER['REQUEST_METHOD'];
$input  = json_decode(file_get_contents('php://input'), true) ?? [];

if ($method === 'GET') {
    $userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
    if ($userId <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Thiếu userId']);
        exit;
    }

    $stmt = $conn->prepare("SELECT profileIndex, fullName, email, phone, address, ward, district, city, note FROM buyer_info WHERE userId = ? ORDER BY profileIndex ASC");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    $profiles = [];
    while ($row = $res->fetch_assoc()) {
        $profiles[$row['profileIndex']] = $row;
    }
    echo json_encode(['profiles' => $profiles]);
    exit;
}

if ($method === 'POST') {
    $userId = isset($input['userId']) ? intval($input['userId']) : 0;
    if ($userId <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Thiếu userId']);
        exit;
    }

    $profileIndex = isset($input['profileIndex']) ? intval($input['profileIndex']) : 1;
    $profile = isset($input['profile']) && is_array($input['profile']) ? $input['profile'] : [];

    $fullName = trim($profile['name'] ?? '');
    $email    = trim($profile['email'] ?? '');
    $phone    = trim($profile['phone'] ?? '');
    $address  = trim($profile['address'] ?? '');
    $note     = trim($profile['note'] ?? '');

    if ($fullName === '' || $phone === '' || $address === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Thiếu thông tin bắt buộc']);
        exit;
    }

    // Validate SĐT chuẩn VN
    if (!preg_match('/^(0|84)(3|5|7|8|9)[0-9]{8}$/', $phone)) {
        http_response_code(400);
        echo json_encode(['error' => 'Số điện thoại không hợp lệ']);
        exit;
    }

    $now = date('Y-m-d H:i:s');
    $empty = ''; // Bỏ qua ward, district, city vì ta đã gộp chuỗi chuẩn ở Frontend

    $stmt = $conn->prepare("
        INSERT INTO buyer_info (userId, profileIndex, fullName, email, phone, address, ward, district, city, note, createdAt, updatedAt)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            fullName=VALUES(fullName), email=VALUES(email), phone=VALUES(phone), address=VALUES(address), note=VALUES(note), updatedAt=VALUES(updatedAt)
    ");
    $stmt->bind_param('iissssssssss', $userId, $profileIndex, $fullName, $email, $phone, $address, $empty, $empty, $empty, $note, $now, $now);

    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => 'Lỗi lưu DB']);
        exit;
    }
    echo json_encode(['success' => true]);
    exit;
}
