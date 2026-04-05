<?php
session_start();

// CHỈ xóa thông tin phiên làm việc của Admin
unset($_SESSION['admin_id']);
unset($_SESSION['admin_logged_in']);

// Chuyển hướng về trang đăng nhập
header("Location: index.php");
exit;
