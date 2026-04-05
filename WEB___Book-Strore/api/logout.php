<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

// CHỈ "nhổ" đúng thông tin đăng nhập của Khách hàng, giữ nguyên Admin
unset($_SESSION['user_id']);
unset($_SESSION['user_username']);
unset($_SESSION['user_fullName']);

// Xóa luôn giỏ hàng trong session để khách sau không thấy đồ của khách trước
unset($_SESSION['cart']);

// Trả về JSON cho main.js biết là đã xong
echo json_encode(['success' => true]);
