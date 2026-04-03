<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// 1. Lấy từ khóa tìm kiếm từ thanh URL
$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

// 2. Cấu hình phân trang
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$limit = 8; // Số sản phẩm hiển thị trên 1 trang
$offset = ($page - 1) * $limit;

$products = [];
$totalProducts = 0;

if ($keyword !== '') {
    // Thêm dấu % để tìm kiếm tương đối
    $searchParam = '%' . $keyword . '%';

    // Đếm tổng số kết quả (chỉ đếm sách còn hàng qty > 0)
    $countStmt = $conn->prepare("SELECT COUNT(id) as total FROM products WHERE name LIKE ? AND qty > 0");
    $countStmt->bind_param('s', $searchParam);
    $countStmt->execute();
    $countRes = $countStmt->get_result();
    $totalProducts = $countRes->fetch_assoc()['total'];

    // Lấy danh sách sản phẩm cho trang hiện tại
    $stmt = $conn->prepare("
        SELECT p.id, p.name, p.author, p.price, p.image AS img, c.name AS category
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE p.name LIKE ? AND p.qty > 0
        ORDER BY p.id DESC
        LIMIT ? OFFSET ?
    ");
    $stmt->bind_param('sii', $searchParam, $limit, $offset);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $products[] = $row;
    }
}

$totalPages = ceil($totalProducts / $limit);

function fmtPrice($price)
{
    return number_format((int)$price, 0, ',', '.') . '₫';
}

// ==================== CHUẨN BỊ GIAO DIỆN ====================
$pageTitle = "Kết quả tìm kiếm: " . htmlspecialchars($keyword) . " - Literary Haven";

// Gói CSS riêng của trang Tìm kiếm
ob_start();
?>
<style>
    .container {
        margin: 0 auto;
        padding: 2rem 0;
        margin-top: 10rem;
        /* Đẩy nội dung xuống tránh bị menu che */
        max-width: 1400px;
    }

    .search-heading {
        margin-bottom: 2rem;
        font-weight: 700;
        color: #2c3e50;
        padding: 0 1rem;
        font-size: 1.8rem;
    }

    .search-keyword {
        color: #4f9da6;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        padding: 0 1rem;
    }

    .product-card {
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        border: 1px solid #eee;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        width: 100%;
        height: 280px;
        border-radius: 8px;
        margin-bottom: 15px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-image:hover img {
        transform: scale(1.05);
    }

    .product-info {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #2c3e50;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-author,
    .product-category {
        color: #7f8c8d;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .product-price {
        color: #e74c3c;
        font-weight: 700;
        font-size: 1.3rem;
        margin: 10px 0;
    }

    .product-actions {
        display: flex;
        gap: 8px;
        margin-top: auto;
    }

    .btn-view,
    .btn-add-cart {
        flex: 1;
        padding: 10px 0;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #007bff;
        color: #fff;
    }

    .btn-view:hover {
        background: #0056b3;
        transform: translateY(-2px);
        color: #fff;
    }

    .btn-add-cart {
        background: #ff6600;
        color: #fff;
    }

    .btn-add-cart:hover {
        background: #e65c00;
        transform: translateY(-2px);
        color: #fff;
    }

    /* Phân trang */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 3rem;
        margin-bottom: 2rem;
    }

    .page-btn {
        padding: 8px 16px;
        border: 2px solid #4f9da6;
        color: #4f9da6;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .page-btn:hover,
    .page-btn.active {
        background: #4f9da6;
        color: white;
    }

    .empty-search {
        text-align: center;
        padding: 5rem 1rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin: 0 1rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .products-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .container {
            margin-top: 8rem;
        }

        .search-heading {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?php
$extraCss = ob_get_clean();

// Gọi Header chung
include '../includes/header.php';
?>

<main class="container">
    <h2 class="search-heading">
        Kết quả tìm kiếm cho: <span class="search-keyword">"<?= htmlspecialchars($keyword) ?>"</span> (<?= $totalProducts ?> kết quả)
    </h2>

    <?php if ($keyword === ''): ?>
        <div class="empty-search">
            <h3 style="color: #666; margin-bottom: 1rem;">🔍 Vui lòng nhập từ khóa để tìm kiếm.</h3>
            <a href="index.php" class="page-btn">← Về trang chủ</a>
        </div>
    <?php elseif (empty($products)): ?>
        <div class="empty-search">
            <h3 style="color: #666; margin-bottom: 1rem;">😔 Không tìm thấy sách nào phù hợp với từ khóa "<span class="search-keyword"><?= htmlspecialchars($keyword) ?></span>".</h3>
            <p style="color: #888; margin-bottom: 2rem;">Hãy thử lại bằng một từ khóa khác ngắn gọn hơn.</p>
            <a href="index.php" class="page-btn">← Về trang chủ</a>
        </div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
                    </div>
                    <div class="product-info">
                        <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="product-author"><i class="bi bi-person"></i> <?= htmlspecialchars($product['author']) ?></p>
                        <p class="product-category"><i class="bi bi-bookmark"></i> <?= htmlspecialchars($product['category']) ?></p>
                        <p class="product-price"><?= fmtPrice($product['price']) ?></p>

                        <div class="product-actions">
                            <a href="product-detail.php?id=<?= (int)$product['id'] ?>" class="btn-view">Xem chi tiết</a>
                            <button class="btn-add-cart" onclick="addToCart(<?= (int)$product['id'] ?>)">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
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
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php
// Gọi Footer chung
include '../includes/footer.php';
?>