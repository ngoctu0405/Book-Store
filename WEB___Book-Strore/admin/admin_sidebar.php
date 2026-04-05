<?php
// 1. Lấy tên của file hiện tại đang chạy để làm sáng menu
$currentPage = basename($_SERVER['PHP_SELF']);

// 2. Gọi database và lấy tên admin (Chỉ viết 1 lần ở đây, dùng cho mọi trang)
require_once __DIR__ . '/../api/db.php';
$adminName = 'Quản trị viên'; // Tên mặc định

if (isset($_SESSION['admin_id'])) {
    $adminId = (int)$_SESSION['admin_id'];
    $stmt = $conn->prepare("SELECT fullName, username FROM users WHERE id = ?");
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Ưu tiên hiển thị Tên đầy đủ, nếu trống thì hiện Tên đăng nhập
        $adminName = !empty($row['fullName']) ? $row['fullName'] : $row['username'];
    }
    $stmt->close();
}
?>

<style>
    .sidebar-header::after {
        display: none !important;
        content: "" !important;
    }
</style>

<aside class="sidebar d-flex flex-column vh-100">
    <div class="sidebar-header" style="padding-bottom: 20px;">
        Literary Haven
        <div style="font-size: 14px; font-weight: 400; margin-top: 8px; color: #cfd8dc; text-transform: none;">
            👋 Xin chào, <span style="color: #fff; font-weight: bold;"><?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    </div>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= ($currentPage == 'dashboard.php') ? 'active' : '' ?>">
                <span class="nav-icon">◈</span>
                <span>Bảng điều khiển</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="users.php" class="nav-link <?= ($currentPage == 'users.php') ? 'active' : '' ?>">
                <span class="nav-icon">◉</span>
                <span>Khách hàng</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="categories.php" class="nav-link <?= ($currentPage == 'categories.php') ? 'active' : '' ?>">
                <span class="nav-icon">◫</span>
                <span>Loại sản phẩm</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="products.php" class="nav-link <?= ($currentPage == 'products.php') ? 'active' : '' ?>">
                <span class="nav-icon">◪</span>
                <span>Sản phẩm</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="purchase-orders.php" class="nav-link <?= ($currentPage == 'purchase-orders.php') ? 'active' : '' ?>">
                <span class="nav-icon">◩</span>
                <span>Nhập hàng</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="pricing.php" class="nav-link <?= ($currentPage == 'pricing.php') ? 'active' : '' ?>">
                <span class="nav-icon">◎</span>
                <span>Quản lý giá</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="orders.php" class="nav-link <?= ($currentPage == 'orders.php') ? 'active' : '' ?>">
                <span class="nav-icon">◧</span>
                <span>Đơn hàng</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="inventory.php" class="nav-link <?= ($currentPage == 'inventory.php') ? 'active' : '' ?>">
                <span class="nav-icon">◨</span>
                <span>Tồn kho</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="reports.php" class="nav-link <?= ($currentPage == 'reports.php') ? 'active' : '' ?>">
                <span class="nav-icon">◔</span>
                <span>Báo cáo</span>
            </a>
        </li>
    </ul>

    <div class="mt-auto p-3">
        <a href="logout.php" class="logout-link">
            <span>◀</span>
            <span>Đăng xuất</span>
        </a>
    </div>
</aside>