<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// ===== ĐỌC PARAMS TỪ URL =====
$categoryParam     = isset($_GET['category'])     ? trim($_GET['category'])     : '';
$subcategoryParam  = isset($_GET['subcategory'])  ? trim($_GET['subcategory'])  : '';
$minPriceParam     = isset($_GET['minPrice'])     ? intval($_GET['minPrice'])   : null;
$maxPriceParam     = isset($_GET['maxPrice'])     ? intval($_GET['maxPrice'])   : null;
$searchNameParam   = isset($_GET['searchName'])   ? trim($_GET['searchName'])   : '';
$searchAuthorParam = isset($_GET['searchAuthor']) ? trim($_GET['searchAuthor']) : '';

// ===== BUILD QUERY TÌM KIẾM =====
$query = "
    SELECT p.id, p.sku, p.name, p.author, p.price, p.image AS img, p.qty,
           c.name AS category, p.subcategory
    FROM products p
    JOIN categories c ON p.category_id = c.id
    WHERE (p.qty IS NULL OR p.qty > 0)
";

if (!empty($categoryParam)) {
  $query .= " AND c.name = '" . $conn->real_escape_string($categoryParam) . "'";
}
if (!empty($subcategoryParam)) {
  $query .= " AND p.subcategory = '" . $conn->real_escape_string($subcategoryParam) . "'";
}
if (!empty($searchNameParam)) {
  $query .= " AND p.name LIKE '%" . $conn->real_escape_string($searchNameParam) . "%'";
}
if (!empty($searchAuthorParam)) {
  $query .= " AND p.author LIKE '%" . $conn->real_escape_string($searchAuthorParam) . "%'";
}
if ($minPriceParam !== null) {
  $query .= " AND p.price >= " . intval($minPriceParam);
}
if ($maxPriceParam !== null) {
  $query .= " AND p.price <= " . intval($maxPriceParam);
}
$query .= " ORDER BY p.name ASC";

$categoryProducts = [];
$res = $conn->query($query);
if ($res) {
  while ($row = $res->fetch_assoc()) {
    $categoryProducts[] = $row;
  }
}

// ===== HELPERS =====
function fmtPrice($price)
{
  return number_format((int)$price, 0, ',', '.') . '₫';
}
function h($str)
{
  return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}
function removeParam($key)
{
  $params = $_GET;
  unset($params[$key]);
  return '?' . http_build_query($params);
}

$hasFilter = !empty($categoryParam) || !empty($subcategoryParam) || !empty($searchNameParam) || !empty($searchAuthorParam) || $minPriceParam !== null || $maxPriceParam !== null;

// ==================== CHUẨN BỊ GIAO DIỆN ====================
$pageTitle = "Danh mục sản phẩm - Literary Haven";

// Gói CSS riêng của trang Category vào biến $extraCss
ob_start();
?>
<style>
  .container {
    margin: 5rem auto;
  }

  .advanced-filters {
    display: flex;
    gap: 15px;
    padding: 20px;
    margin: 20px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    align-items: center;
    flex-wrap: wrap;
    border: 1px solid #dee2e6;
  }

  .filter-item {
    position: relative;
    display: inline-block;
  }

  .filter-btn {
    background: #fff;
    color: #2c3e50;
    padding: 12px 20px;
    border: 2px solid #e0e0e0;
    cursor: pointer;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    min-width: 160px;
  }

  .filter-btn:hover {
    background: #f8f9fa;
    border-color: #007bff;
    color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.15);
  }

  .filter-dropdown {
    list-style-type: none;
    padding: 16px 0 8px 0;
    margin: 0;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    background-color: #fff;
    border: 1px solid #e0e0e0;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    min-width: 200px;
    display: none;
    border-radius: 8px;
    overflow: hidden;
    animation: slideDown 0.2s ease;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .filter-item.open .filter-dropdown {
    display: block;
  }

  .filter-dropdown li {
    margin: 0;
    padding: 0;
  }

  .filter-dropdown li a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 22px;
    text-decoration: none;
    color: #495057;
    white-space: nowrap;
    transition: all 0.2s ease;
    font-size: 15px;
    font-weight: 400;
  }

  .filter-dropdown li a:hover,
  .filter-dropdown li a.active-filter {
    background: linear-gradient(90deg, #e3f2fd 0%, #bbdefb 100%);
    color: #1976d2;
    padding-left: 24px;
  }

  .filter-dropdown li a.active-filter {
    font-weight: 600;
  }

  .price-range-dropdown {
    list-style-type: none !important;
    padding: 15px !important;
    min-width: 250px !important;
  }

  .clear-filters-btn {
    margin-left: auto;
    text-decoration: none;
    background-color: #dc3545;
    color: #fff;
    padding: 10px 18px;
    border: 2px solid #dc3545;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 700;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .clear-filters-btn:hover {
    background-color: #c82333;
    color: #fff;
    transform: translateY(-2px);
  }

  .selected-filters {
    padding: 15px 20px;
    margin: 0 0 20px 0;
    background: #fff3cd;
    border-left: 4px solid #ffc107;
    border-radius: 8px;
  }

  .selected-filters h1 {
    font-size: 16px;
    font-weight: 600;
    color: #856404;
    margin: 0 0 8px 0;
  }

  .selected-filters .filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    color: #495057;
    padding: 6px 12px;
    margin: 5px 5px 0 0;
    border-radius: 6px;
    font-size: 13px;
    border: 1px solid #dee2e6;
  }

  .selected-filters .filter-tag .remove-filter {
    text-decoration: none;
    color: #dc3545;
    font-weight: bold;
  }

  .selected-filters .filter-tag .remove-filter:hover {
    color: #bd2130;
  }

  .product-actions {
    display: flex;
    gap: 8px;
    justify-content: center;
    margin-top: 10px;
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
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
  }

  .btn-add-cart {
    background: #ff6600;
    color: #fff;
  }

  .btn-add-cart:hover {
    background: #e65c00;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(255, 102, 0, 0.3);
  }

  @media (max-width: 767px) {
    .advanced-filters {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
      padding: 15px;
    }

    .filter-item,
    .filter-btn,
    .filter-dropdown,
    .clear-filters-btn {
      width: 100%;
      min-width: auto;
    }

    .filter-btn {
      justify-content: space-between;
    }

    .clear-filters-btn {
      justify-content: center;
      margin-left: 0;
    }

    .products-grid {
      grid-template-columns: 1fr;
      gap: 20px;
      padding: 10px;
    }
  }
</style>
<?php
$extraCss = ob_get_clean();

// Gọi header chung (Nó sẽ tự động xử lý kết nối Database, navbar, và tạo ra biến $navCategories chứa toàn bộ danh mục)
include '../includes/header.php';
?>

<main class="container">
  <div class="products-top">
    <a class="breadcrumb-btn" href="category.php">
      <?php if (!empty($categoryParam) && !empty($subcategoryParam)): ?>
        Danh mục sách &gt; <?= h($categoryParam) ?> &gt; <?= h($subcategoryParam) ?>
      <?php elseif (!empty($categoryParam)): ?>
        Danh mục sách &gt; <?= h($categoryParam) ?>
      <?php else: ?>
        Tất cả sách
      <?php endif; ?>
    </a>
  </div>

  <div class="advanced-filters">
    <div class="filter-item">
      <button class="filter-btn">Theo thể loại ▾</button>
      <ul class="filter-dropdown">
        <?php foreach ($navCategories as $catName => $subs): ?>
          <?php foreach ($subs as $sub):
            $params = $_GET;
            $params['category'] = $catName;
            $params['subcategory'] = $sub;
            $isActive = ($categoryParam === $catName && $subcategoryParam === $sub);
          ?>
            <li>
              <a href="?<?= h(http_build_query($params)) ?>" class="<?= $isActive ? 'active-filter' : '' ?>">
                <?= h($catName) ?> / <?= h($sub) ?><?= $isActive ? ' ✓' : '' ?>
              </a>
            </li>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="filter-item">
      <button class="filter-btn">Theo tên sách ▾</button>
      <div class="filter-dropdown price-range-dropdown" style="padding:15px;min-width:250px;">
        <form method="GET" action="category.php">
          <?php if (!empty($categoryParam)):    ?><input type="hidden" name="category" value="<?= h($categoryParam) ?>"><?php endif; ?>
          <?php if (!empty($subcategoryParam)): ?><input type="hidden" name="subcategory" value="<?= h($subcategoryParam) ?>"><?php endif; ?>
          <?php if ($minPriceParam !== null):   ?><input type="hidden" name="minPrice" value="<?= h($minPriceParam) ?>"><?php endif; ?>
          <?php if ($maxPriceParam !== null):   ?><input type="hidden" name="maxPrice" value="<?= h($maxPriceParam) ?>"><?php endif; ?>
          <div style="margin-bottom:10px;">
            <label style="display:block;font-size:14px;margin-bottom:5px;">Nhập tên sách</label>
            <input type="text" name="searchName" value="<?= h($searchNameParam) ?>" placeholder="Ví dụ: Hoàng tử bé" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;" />
          </div>
          <button type="submit" style="width:100%;padding:10px;background:#007bff;color:#fff;border:none;border-radius:4px;cursor:pointer;font-weight:600;">Áp dụng</button>
        </form>
      </div>
    </div>

    <div class="filter-item">
      <button class="filter-btn">Theo tác giả ▾</button>
      <div class="filter-dropdown price-range-dropdown" style="padding:15px;min-width:250px;">
        <form method="GET" action="category.php">
          <?php if (!empty($categoryParam)):    ?><input type="hidden" name="category" value="<?= h($categoryParam) ?>"><?php endif; ?>
          <?php if (!empty($subcategoryParam)): ?><input type="hidden" name="subcategory" value="<?= h($subcategoryParam) ?>"><?php endif; ?>
          <?php if ($minPriceParam !== null):   ?><input type="hidden" name="minPrice" value="<?= h($minPriceParam) ?>"><?php endif; ?>
          <?php if ($maxPriceParam !== null):   ?><input type="hidden" name="maxPrice" value="<?= h($maxPriceParam) ?>"><?php endif; ?>
          <div style="margin-bottom:10px;">
            <label style="display:block;font-size:14px;margin-bottom:5px;">Nhập tên tác giả</label>
            <input type="text" name="searchAuthor" value="<?= h($searchAuthorParam) ?>" placeholder="Ví dụ: Nguyễn Nhật Ánh" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;" />
          </div>
          <button type="submit" style="width:100%;padding:10px;background:#007bff;color:#fff;border:none;border-radius:4px;cursor:pointer;font-weight:600;">Áp dụng</button>
        </form>
      </div>
    </div>

    <div class="filter-item">
      <button class="filter-btn">Theo giá (khoảng) ▾</button>
      <div class="filter-dropdown price-range-dropdown" style="padding:15px;min-width:250px;">
        <form method="GET" action="category.php">
          <?php if (!empty($categoryParam)):     ?><input type="hidden" name="category" value="<?= h($categoryParam) ?>"><?php endif; ?>
          <?php if (!empty($subcategoryParam)):  ?><input type="hidden" name="subcategory" value="<?= h($subcategoryParam) ?>"><?php endif; ?>
          <?php if (!empty($searchNameParam)):   ?><input type="hidden" name="searchName" value="<?= h($searchNameParam) ?>"><?php endif; ?>
          <?php if (!empty($searchAuthorParam)): ?><input type="hidden" name="searchAuthor" value="<?= h($searchAuthorParam) ?>"><?php endif; ?>
          <div style="margin-bottom:10px;">
            <label style="display:block;font-size:14px;margin-bottom:5px;">Giá Tối Thiểu (₫)</label>
            <input type="number" name="minPrice" value="<?= h($minPriceParam ?? '') ?>" placeholder="Ví dụ: 50000" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;" />
          </div>
          <div style="margin-bottom:10px;">
            <label style="display:block;font-size:14px;margin-bottom:5px;">Giá Tối Đa (₫)</label>
            <input type="number" name="maxPrice" value="<?= h($maxPriceParam ?? '') ?>" placeholder="Ví dụ: 200000" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;" />
          </div>
          <button type="submit" style="width:100%;padding:10px;background:#007bff;color:#fff;border:none;border-radius:4px;cursor:pointer;font-weight:600;">Áp dụng</button>
        </form>
      </div>
    </div>

    <a href="category.php" class="clear-filters-btn">Xóa tất cả bộ lọc</a>
  </div>

  <?php if ($hasFilter): ?>
    <div class="selected-filters">
      <h1>Bộ lọc đang áp dụng:</h1>
      <?php if (!empty($categoryParam)): ?>
        <span class="filter-tag">Danh mục: <?= h($categoryParam) ?> <a class="remove-filter" href="<?= h(removeParam('category')) ?>">✕</a></span>
      <?php endif; ?>
      <?php if (!empty($subcategoryParam)): ?>
        <span class="filter-tag">Thể loại: <?= h($subcategoryParam) ?> <a class="remove-filter" href="<?= h(removeParam('subcategory')) ?>">✕</a></span>
      <?php endif; ?>
      <?php if (!empty($searchNameParam)): ?>
        <span class="filter-tag">Tên sách: <?= h($searchNameParam) ?> <a class="remove-filter" href="<?= h(removeParam('searchName')) ?>">✕</a></span>
      <?php endif; ?>
      <?php if (!empty($searchAuthorParam)): ?>
        <span class="filter-tag">Tác giả: <?= h($searchAuthorParam) ?> <a class="remove-filter" href="<?= h(removeParam('searchAuthor')) ?>">✕</a></span>
      <?php endif; ?>
      <?php if ($minPriceParam !== null): ?>
        <span class="filter-tag">Giá từ: <?= fmtPrice($minPriceParam) ?> <a class="remove-filter" href="<?= h(removeParam('minPrice')) ?>">✕</a></span>
      <?php endif; ?>
      <?php if ($maxPriceParam !== null): ?>
        <span class="filter-tag">Giá đến: <?= fmtPrice($maxPriceParam) ?> <a class="remove-filter" href="<?= h(removeParam('maxPrice')) ?>">✕</a></span>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="products-grid">
    <?php if (count($categoryProducts) > 0): ?>
      <?php foreach ($categoryProducts as $product): ?>
        <div class="product-card">
          <div class="product-image">
            <img src="<?= h($product['img']) ?>" alt="<?= h($product['name']) ?>" />
          </div>
          <div class="product-info">
            <h3 class="product-name"><?= h($product['name']) ?></h3>
            <p class="product-author">Tác giả: <?= h($product['author']) ?></p>
            <p class="product-category"><?= h($product['category']) ?> - <?= h($product['subcategory']) ?></p>
            <p class="product-price"><?= fmtPrice($product['price']) ?></p>
            <div class="product-actions">
              <a href="product-detail.php?id=<?= (int)$product['id'] ?>" class="btn-view">Xem chi tiết</a>
              <button class="btn-add-cart" onclick="addToCart(<?= (int)$product['id'] ?>)">Thêm vào giỏ</button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div style="grid-column:1/-1;text-align:center;padding:40px;">
        <p style="font-size:18px;color:#666;">Không tìm thấy sản phẩm phù hợp.</p>
        <a href="category.php" style="color:#007bff;">← Xem tất cả sản phẩm</a>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php
// Gói Javascript riêng của trang Category vào biến $extraJs
ob_start();
?>
<script>
  // Ngăn main.js ghi đè lên menu
  const bookFilter = document.querySelector(".book-filter");
  if (bookFilter) bookFilter.setAttribute("data-php-rendered", "true");

  document.addEventListener("DOMContentLoaded", function() {
    // ===== Toggle nút "Danh mục ▾" =====
    const categoryBtn = document.querySelector(".category-btn");
    const categoryMenu = document.querySelector(".category-menu");

    if (categoryBtn && categoryMenu) {
      categoryBtn.addEventListener("click", function(event) {
        event.stopPropagation();
        categoryMenu.classList.toggle("open");
      });

      document.addEventListener("click", function(event) {
        if (!categoryMenu.contains(event.target)) {
          categoryMenu.classList.remove("open");
        }
      });
    }

    // ===== Mở/đóng dropdown bộ lọc nâng cao =====
    const filterButtons = document.querySelectorAll(".filter-btn");
    const allFilterItems = document.querySelectorAll(".filter-item");

    filterButtons.forEach((button) => {
      button.addEventListener("click", function(event) {
        event.preventDefault();
        event.stopPropagation();
        const parentItem = button.closest(".filter-item");
        if (!parentItem) return;
        const isOpen = parentItem.classList.contains("open");
        allFilterItems.forEach((item) => item.classList.remove("open"));
        if (!isOpen) parentItem.classList.add("open");
      });
    });

    // Đóng dropdown bộ lọc khi click ra ngoài
    document.addEventListener("click", function(event) {
      if (!event.target.closest(".filter-item")) {
        allFilterItems.forEach((item) => item.classList.remove("open"));
      }
    });
  });
</script>
<?php
$extraJs = ob_get_clean();

// Gọi Footer chung
include '../includes/footer.php';
?>