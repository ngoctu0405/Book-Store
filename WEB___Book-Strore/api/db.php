<?php

$host = 'localhost';
$user = 'root';
$pass = 'Gjfjgfjgcgj123456789@';
$db   = 'bookstore';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Không kết nối được database']);
    exit;
}

$conn->set_charset('utf8mb4');
