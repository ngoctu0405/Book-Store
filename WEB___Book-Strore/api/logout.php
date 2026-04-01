<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

// Xóa toàn bộ session
$_SESSION = [];
session_destroy();

echo json_encode(['success' => true]);