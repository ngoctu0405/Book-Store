<?php
// Tự động khởi tạo session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Kết nối Database
require_once __DIR__ . '/../api/db.php';

// ==================== LẤY MENU TỪ BẢNG CATEGORIES VÀ PRODUCTS ====================
$navCategories = [];
$catRes = $conn->query("SELECT id, name FROM categories WHERE status = 'active' ORDER BY id ASC");
if ($catRes && $catRes->num_rows > 0) {
    while ($catRow = $catRes->fetch_assoc()) {
        $catId = $catRow['id'];
        $catName = $catRow['name'];
        $navCategories[$catName] = [];

        $subSql = "SELECT DISTINCT subcategory FROM products WHERE category_id = $catId AND subcategory IS NOT NULL AND subcategory != ''";
        $subRes = $conn->query($subSql);
        if ($subRes) {
            while ($subRow = $subRes->fetch_assoc()) {
                $navCategories[$catName][] = $subRow['subcategory'];
            }
        }
    }
}
// =================================================================================
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($pageTitle) ? $pageTitle : 'Literary Haven' ?></title>

    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>" />
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />

    <?= isset($extraCss) ? $extraCss : '' ?>
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
                    <?php foreach ($navCategories as $catName => $subcategories): ?>
                        <li class="dropdown">
                            <a href="category.php?category=<?= urlencode($catName) ?>" data-category="<?= htmlspecialchars($catName, ENT_QUOTES) ?>">
                                <?= htmlspecialchars($catName) ?> ▸
                            </a>
                            <?php if (!empty($subcategories)): ?>
                                <ul class="dropdown-content">
                                    <?php foreach ($subcategories as $sub): ?>
                                        <li>
                                            <a href="category.php?category=<?= urlencode($catName) ?>&subcategory=<?= urlencode($sub) ?>">
                                                <?= htmlspecialchars($sub) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <li><a href="news.php">Tin tức</a></li>
        </ul>
    </nav>

    <div class="nav_2">
        <div class="search-center">
            <input id="topSearch" class="search-input" type="text" placeholder="Nhập tên cuốn sách bạn đang tìm ..." autocomplete="off" />
            <button class="search-btn" type="button" onclick="handleTopSearch()">Tìm kiếm</button>
        </div>
        <div class="cart-float" id="cartFloat">
            <button id="cartBtnFloat" class="btn">
                <span class="cart-icon">🛒</span>
                <span id="cart-count" class="cart-count">0</span>
            </button>
        </div>
    </div>