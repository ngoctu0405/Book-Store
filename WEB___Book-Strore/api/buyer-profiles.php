<?php
require_once __DIR__ . '/db.php';
header('Content-Type: application/json; charset=UTF-8');

$method = $_SERVER['REQUEST_METHOD'];
$input  = json_decode(file_get_contents('php://input'), true) ?? [];

// GET — lấy tất cả profile của user
if ($method === 'GET') {
    $userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
    if ($userId <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Thiếu userId']);
        exit;
    }

    $stmt = $conn->prepare("
        SELECT profileIndex, fullName, email, phone, address, ward, district, city, note
        FROM buyer_info
        WHERE userId = ?
        ORDER BY profileIndex ASC
    ");
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

// POST — lưu hoặc cập nhật 1 profile
if ($method === 'POST') {
    $userId = isset($input['userId']) ? intval($input['userId']) : 0;
    if ($userId <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Thiếu userId']);
        exit;
    }

    $profileIndex = isset($input['profileIndex']) ? intval($input['profileIndex']) : 1;
    if ($profileIndex < 1 || $profileIndex > 3) {
        http_response_code(400);
        echo json_encode(['error' => 'profileIndex phải từ 1 đến 3']);
        exit;
    }

    $profile = isset($input['profile']) && is_array($input['profile']) ? $input['profile'] : [];
    $fullName = trim($profile['name'] ?? '');
    $email    = trim($profile['email'] ?? '');
    $phone    = trim($profile['phone'] ?? '');
    $address  = trim($profile['address'] ?? '');
    $ward     = trim($profile['ward'] ?? '');
    $district = trim($profile['district'] ?? '');
    $city     = trim($profile['city'] ?? '');
    $note     = trim($profile['note'] ?? '');

    if ($fullName === '' || $phone === '' || $address === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Thiếu thông tin bắt buộc (họ tên, điện thoại, địa chỉ)']);
        exit;
    }

    $now = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("
        INSERT INTO buyer_info (userId, profileIndex, fullName, email, phone, address, ward, district, city, note, createdAt, updatedAt)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            fullName  = VALUES(fullName),
            email     = VALUES(email),
            phone     = VALUES(phone),
            address   = VALUES(address),
            ward      = VALUES(ward),
            district  = VALUES(district),
            city      = VALUES(city),
            note      = VALUES(note),
            updatedAt = VALUES(updatedAt)
    ");
    $stmt->bind_param(
        'iissssssssss',
        $userId,
        $profileIndex,
        $fullName,
        $email,
        $phone,
        $address,
        $ward,
        $district,
        $city,
        $note,
        $now,
        $now
    );

    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => 'Không thể lưu thông tin: ' . $stmt->error]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => "Đã lưu mẫu $profileIndex"]);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
