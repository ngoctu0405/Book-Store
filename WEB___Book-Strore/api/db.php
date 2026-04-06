<?php

$host = 'localhost';
$user = 'root';
$pass = 'Ngotrungtoan06@';
$db   = 'bookstore';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Không kết nối được database']);
    exit;
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

$conn->query("SET time_zone = '+07:00'");

$conn->set_charset('utf8mb4');
