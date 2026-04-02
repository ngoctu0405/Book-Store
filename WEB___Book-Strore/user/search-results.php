<?php
session_start();
// Lưu ý: Đảm bảo đường dẫn này trỏ đúng vào file db.php của bạn
require_once __DIR__ . '/../api/db.php';

// Lấy từ khóa tìm kiếm từ thanh URL (ví dụ: ?q=dac+nhan+tam)
$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

// Cấu hình phân trang
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$limit = 8; // Số sản phẩm hiển thị trên 1 trang
$offset = ($page - 1) * $limit;

$products = [];
$totalProducts = 0;

if ($keyword !== '') {
    // Thêm dấu % để tìm kiếm tương đối (chứa từ khóa ở bất kỳ đâu trong tên)
    $searchParam = '%' . $keyword . '%';

    // 1. Đếm tổng số kết quả (chỉ đếm sách còn hàng qty > 0)
    $countStmt = $conn->prepare("SELECT COUNT(id) as total FROM products WHERE name LIKE ? AND qty > 0");
    $countStmt->bind_param('s', $searchParam);
    $countStmt->execute();
    $countRes = $countStmt->get_result();
    $totalProducts = $countRes->fetch_assoc()['total'];

    // 2. Lấy danh sách sản phẩm cho trang hiện tại
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? AND qty > 0 LIMIT ? OFFSET ?");
    $stmt->bind_param('sii', $searchParam, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Tính tổng số trang
$totalPages = ceil($totalProducts / $limit);

// Hàm định dạng tiền tệ
function fmtPrice($value)
{
    return number_format((int)$value, 0, ',', '.') . '₫';
}
?>
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kết quả tìm kiếm - Literary Haven</title>
    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css" />
    <style>
        .container {
            position: relative;
            margin: 5rem auto;
        }

        body {
            padding-top: 130px !important;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-attachment: fixed;
        }

        main {
            flex: 1;
        }

        /* Chỉnh lại nút phân trang thành thẻ <a> để nhấp được qua link PHP */
        .pagination-wrap a.page-btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination-wrap a.page-btn:hover,
        .pagination-wrap a.page-btn.active {
            background: #4f9da6;
            color: white;
            border-color: #4f9da6;
        }
    </style>
</head>

<body>
    <header class="topbar">
        <div class="logo">
            <a href="index.php">
                <img class="Logo" src="../images/Logo_removebg.png" alt="Logo" />
                <img class="Word" src="../images/Logo_word_removebg.png" alt="Literary Haven" />
            </a>
        </div>
        <div class="auth-cart">
            <div id="authArea">
                <button class="btn-auth" onclick="openLoginModal()">Đăng nhập</button>
                <button class="btn-auth btn-signup" onclick="openRegisterModal()">Đăng ký</button>
            </div>
        </div>
    </header>

    <nav class="navbar" id="mainNav">
        <ul class="menu" id="mainMenu">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="about.php">Giới thiệu</a></li>
            <div class="category-menu">
                <button class="category-btn">Danh mục ▾</button>
                <ul class="book-filter">
                </ul>
            </div>
            <li><a href="news.php">Tin tức</a></li>
        </ul>
    </nav>

    <div class="nav_2">
        <div class="search-center">
            <input id="topSearch" class="search-input" type="text" placeholder="Nhập tên cuốn sách bạn đang tìm ..." autocomplete="off" value="<?= htmlspecialchars($keyword) ?>" />
            <button class="search-btn" type="button" onclick="handleTopSearch()">Tìm kiếm</button>
        </div>
        <div class="cart-float" id="cartFloat">
            <button id="cartBtnFloat" class="btn" onclick="window.location.href='cart.php'">
                <span class="cart-icon">🛒</span>
                <span id="cart-count" class="cart-count">0</span>
            </button>
        </div>
    </div>

    <main class="container">
        <?php if ($keyword !== ''): ?>
            <h2 style="margin-bottom: 0.5rem;">Kết quả tìm kiếm cho: <span style="color: #4f9da6;">"<?= htmlspecialchars($keyword) ?>"</span></h2>
            <p style="color: #7f8c8d; margin-bottom: 2rem;">Tìm thấy <?= $totalProducts ?> sản phẩm phù hợp.</p>
        <?php else: ?>
            <h2>Vui lòng nhập từ khóa để tìm kiếm.</h2>
        <?php endif; ?>

        <?php if (empty($products) && $keyword !== ''): ?>
            <div style="text-align: center; padding: 5rem 0;">
                <h1 style="font-size: 5rem; opacity: 0.2; margin-bottom: 1rem;">🔍</h1>
                <h3 style="color: #2c3e50;">Không tìm thấy sản phẩm nào!</h3>
                <p style="color: #7f8c8d;">Thử thay đổi từ khóa hoặc tìm kiếm với các từ ngắn gọn hơn.</p>
            </div>
        <?php else: ?>
            <div class='products-grid'>
                <?php foreach ($products as $p): ?>
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                        <div class="product-info">
                            <h3><?= htmlspecialchars($p['name']) ?></h3>
                            <p class="product-author">Tác giả: <?= htmlspecialchars($p['author'] ?? 'Đang cập nhật') ?></p>
                            <div class="price"><?= fmtPrice($p['price']) ?></div>
                            <div class="button-row">
                                <a class="btn btn-small" href="product-detail.php?id=<?= $p['id'] ?>">Xem</a>
                                <button class="btn btn-cart" onclick="addToCart(<?= $p['id'] ?>, 1)">Thêm vào giỏ</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div id="pagination" class="pagination" style="margin-top: 3rem; text-align: center;">
                    <div class="pagination-wrap">
                        <?php if ($page > 1): ?>
                            <a href="search-results.php?q=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>" class="page-btn">« Trước</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="search-results.php?q=<?= urlencode($keyword) ?>&page=<?= $i ?>" class="page-btn <?= ($i === $page) ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="search-results.php?q=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>" class="page-btn">Sau »</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Book Store. All rights reserved. | Designed with ❤️</p>
        </div>
    </footer>

    <?php include '../includes/auth_modals.php'; ?>

    <script src="../assets/js/main.js?v=3"></script>
    <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>