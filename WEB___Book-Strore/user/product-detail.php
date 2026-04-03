<?php
require_once __DIR__ . '/../api/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = null;
if ($id > 0) {
  $stmt = $conn->prepare("
        SELECT p.id, p.sku, p.name, p.author, p.price, p.profitMargin,
               c.name AS category, p.subcategory, p.description AS `desc`,
               p.image AS img, p.qty
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE p.id = ? AND (p.qty IS NULL OR p.qty >= 0)
        LIMIT 1
    ");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $res = $stmt->get_result();
  $product = $res->fetch_assoc();
}

function formatPricePhp($price)
{
  return number_format((int) $price, 0, ',', '.') . 'đ';
}

// 1. Chuẩn bị thông tin giao diện
$pageTitle = $product ? htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') . ' - Literary Haven' : 'Chi tiết sản phẩm';

// 2. Gói CSS riêng của trang Chi tiết sản phẩm
ob_start();
?>
<style>
  body {
    background: linear-gradient(135deg, #f5f2e8 0%, #e8d5b7 50%, #7fb3d3 100%);
  }

  .container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 2rem;
    margin-top: 8rem;
    /* Đẩy nội dung xuống để không bị thanh menu che khuất */
  }

  /* Nút quay lại */
  .back-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.5rem;
    background: linear-gradient(135deg, #4f9da6 0%, #7fb3d3 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(79, 157, 166, 0.3);
    margin-bottom: 1rem;
  }

  .back-button:hover {
    background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(79, 157, 166, 0.4);
    color: white;
  }

  .back-button-arrow {
    font-size: 1.2rem;
    font-weight: bold;
  }

  /* Thanh điều hướng Breadcrumb */
  .breadcrumb {
    background: rgba(255, 255, 255, 0.6);
    padding: 1rem 1.5rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    display: flex;
    gap: 10px;
    align-items: center;
    font-size: 0.95rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .breadcrumb a {
    color: #4f9da6;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
  }

  .breadcrumb a:hover {
    color: #82c09a;
  }

  .breadcrumb span {
    color: #7f8c8d;
  }

  /* Bố cục sản phẩm */
  .product-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    background: linear-gradient(145deg, #ffffff 0%, #f5f2e8 100%);
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(79, 157, 166, 0.15);
    border: 1px solid rgba(130, 192, 154, 0.2);
    position: relative;
    overflow: hidden;
  }

  .product-layout:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #4f9da6, #82c09a, #7fb3d3);
  }

  .image-gallery {
    position: sticky;
    top: 140px;
    height: fit-content;
  }

  .main-image {
    width: 100%;
    aspect-ratio: 3/4;
    background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(79, 157, 166, 0.1);
    transition: all 0.3s ease;
  }

  .main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .main-image:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(79, 157, 166, 0.2);
  }

  .product-info {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  .product-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.4;
    margin: 0;
  }

  .badge {
    display: inline-block;
    padding: 6px 16px;
    background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
    color: white;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(130, 192, 154, 0.3);
    width: fit-content;
  }

  .product-price {
    font-size: 2.5rem;
    color: #e74c3c;
    font-weight: 700;
  }

  .shipping-info {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f0f8f7 0%, #e6f4f1 100%);
    border-radius: 12px;
    border: 1px solid rgba(130, 192, 154, 0.2);
  }

  .shipping-row {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 1rem;
    padding: 0.8rem 0;
    border-bottom: 1px solid rgba(130, 192, 154, 0.1);
  }

  .shipping-row:last-child {
    border-bottom: none;
  }

  .shipping-label {
    color: #4f9da6;
    font-weight: 600;
    font-size: 0.95rem;
  }

  .shipping-value {
    color: #2c3e50;
    font-size: 0.95rem;
  }

  /* Chọn số lượng */
  .quantity-selector {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .quantity-controls {
    display: flex;
    align-items: center;
    border: 2px solid #82c09a;
    border-radius: 10px;
    overflow: hidden;
    background: white;
  }

  .qty-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
    color: white;
    cursor: pointer;
    font-size: 1.2rem;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .qty-btn:hover {
    background: linear-gradient(135deg, #7fb3d3 0%, #82c09a 100%);
  }

  .qty-input {
    width: 60px;
    height: 40px;
    border: none;
    text-align: center;
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    outline: none;
  }

  .stock-status {
    color: #7f8c8d;
    font-size: 0.9rem;
  }

  /* Nút hành động */
  .action-buttons {
    display: flex;
    gap: 1rem;
  }

  .btn {
    flex: 1;
    padding: 1rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .btn-add-cart {
    background: linear-gradient(135deg, #ff7f50 0%, #ff4500 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(255, 99, 71, 0.3);
  }

  .btn-add-cart:hover:not(:disabled) {
    background: linear-gradient(135deg, #ff6347 0%, #e63900 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 99, 71, 0.4);
    color: white;
  }

  .btn-buy-now {
    background: linear-gradient(135deg, #4f9da6 0%, #7fb3d3 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(79, 157, 166, 0.3);
  }

  .btn-buy-now:hover:not(:disabled) {
    background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(79, 157, 166, 0.4);
    color: white;
  }

  .btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }

  .guarantee-section {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
    border-radius: 12px;
    border: 1px solid rgba(127, 179, 211, 0.2);
  }

  .guarantee-item {
    display: flex;
    gap: 0.8rem;
    padding: 0.6rem 0;
    font-size: 0.95rem;
    color: #2c3e50;
  }

  .guarantee-icon {
    color: #82c09a;
    font-size: 1.3rem;
    font-weight: 700;
  }

  /* Chi tiết và mô tả */
  .details-section {
    margin-top: 3rem;
    background: linear-gradient(145deg, #ffffff 0%, #f5f2e8 100%);
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(79, 157, 166, 0.15);
    border: 1px solid rgba(130, 192, 154, 0.2);
    position: relative;
    overflow: hidden;
  }

  .details-section:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #4f9da6, #82c09a, #7fb3d3);
  }

  .section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(130, 192, 154, 0.2);
  }

  .info-table {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
  }

  .info-row {
    display: grid;
    grid-template-columns: 180px 1fr;
    padding: 1rem;
    background: rgba(245, 242, 232, 0.4);
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .info-row:hover {
    background: rgba(245, 242, 232, 0.7);
    transform: translateX(5px);
  }

  .info-label {
    color: #4f9da6;
    font-weight: 600;
    font-size: 1rem;
  }

  .info-value {
    color: #2c3e50;
    font-size: 1rem;
  }

  .description-section {
    margin-top: 2rem;
    line-height: 1.8;
  }

  .description-section p {
    margin-bottom: 1rem;
    color: #2c3e50;
    font-size: 1rem;
    white-space: pre-wrap;
  }

  /* Lỗi không tìm thấy */
  .error-container {
    text-align: center;
    padding: 4rem 2rem;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    margin: 3rem auto;
    max-width: 600px;
  }

  .error-container h2 {
    color: #e74c3c;
    font-size: 2rem;
    margin-bottom: 1rem;
  }

  .error-container p {
    color: #2c3e50;
    margin-bottom: 2rem;
    font-size: 1.1rem;
  }

  .error-container a {
    display: inline-block;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #4f9da6 0%, #7fb3d3 100%);
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .error-container a:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 157, 166, 0.3);
    color: white;
  }

  /* Responsive */
  @media (max-width: 1024px) {
    .product-layout {
      grid-template-columns: 1fr;
      gap: 2rem;
    }

    .image-gallery {
      position: relative;
      top: 0;
    }
  }

  @media (max-width: 768px) {
    .action-buttons {
      flex-direction: column;
    }

    .info-row {
      grid-template-columns: 1fr;
      gap: 0.5rem;
    }

    .product-title {
      font-size: 1.5rem;
    }

    .product-price {
      font-size: 2rem;
    }

    .container {
      padding: 0 1rem;
      margin-top: 6rem;
    }

    .product-layout {
      padding: 1.5rem;
    }

    .details-section {
      padding: 1.5rem;
    }
  }
</style>
<?php
$extraCss = ob_get_clean();

// 3. Gọi Header chung (Đã bao gồm <head>, navbar động, database kết nối)
include '../includes/header.php';
?>

<main class="container" id="mainContent">
  <?php
  if (!$product) {
    echo '
    <div class="error-container">
      <h2>❌ Không tìm thấy sản phẩm</h2>
      <p>Sản phẩm bạn đang tìm kiếm không tồn tại hoặc đã bị xóa khỏi hệ thống.</p>
      <a href="index.php">← Quay về trang chủ</a>
    </div>';
  } else {
    $p = $product;
    $name = htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8');
    $author = htmlspecialchars($p['author'] ?? '', ENT_QUOTES, 'UTF-8');
    $sku = htmlspecialchars($p['sku'] ?? '', ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars($p['category'] ?? '', ENT_QUOTES, 'UTF-8');
    $subcategory = htmlspecialchars($p['subcategory'] ?? '', ENT_QUOTES, 'UTF-8');
    $desc = htmlspecialchars($p['desc'] ?? '', ENT_QUOTES, 'UTF-8');

    // Mẹo nhỏ: Tự động sửa đường dẫn ảnh nếu CSDL vô tình lưu là ./images/...
    $img = $p['img'] ?? '';
    if (strpos($img, './') === 0) {
      $img = str_replace('./', '../', $img);
    }
    $img = htmlspecialchars($img, ENT_QUOTES, 'UTF-8');

    $qty = (int) ($p['qty'] ?? 0);
    $price = (int) ($p['price'] ?? 0);
    $priceFmt = formatPricePhp($price);
    $outOfStock = $qty <= 0;

    // Xử lý nút bấm tùy theo tình trạng kho hàng
    $quantityBlock = $outOfStock
      ? '<p class="stock-info" style="margin-top:1rem;color:#e74c3c;font-size:1.2rem;font-weight:700;">💔 HẾT HÀNG</p>
           <div class="action-buttons" style="margin-top: 1rem;">
             <button class="btn btn-add-cart" disabled>🛒 Thêm vào giỏ hàng</button>
             <button class="btn btn-buy-now" disabled>⚡ Mua ngay</button>
           </div>'
      : '<div class="quantity-selector" style="margin-top: 1rem;">
             <span class="shipping-label">Số lượng:</span>
             <div class="quantity-controls">
               <button class="qty-btn" onclick="decreaseQty()">−</button>
               <input type="number" class="qty-input" value="1" id="qty" min="1" max="' . $qty . '" onchange="validateQtyInput()">
               <button class="qty-btn" onclick="increaseQty()">+</button>
             </div>
             <span class="stock-status">Còn hàng (' . $qty . ' quyển)</span>
           </div>
           <div class="action-buttons" style="margin-top: 1.5rem;">
             <button class="btn btn-add-cart" onclick="addToCartDetail(' . (int)$p['id'] . ')">🛒 Thêm vào giỏ hàng</button>
             <button class="btn btn-buy-now" onclick="buyNow(' . (int)$p['id'] . ')">⚡ Mua ngay</button>
           </div>';
  ?>
    <button class="back-button" onclick="goBack()"><span class="back-button-arrow">←</span> Quay Lại</button>

    <div class="breadcrumb">
      <a href="index.php">Literary Haven</a><span>›</span>
      <a href="category.php?category=<?php echo urlencode($category); ?>"><?php echo $category; ?></a>
      <span>›</span><span style="color:#2c3e50; font-weight: 600;"><?php echo $subcategory; ?></span>
    </div>

    <div class="product-layout">
      <div class="image-gallery">
        <div class="main-image"><img src="<?php echo $img; ?>" alt="<?php echo $name; ?>"></div>
      </div>

      <div class="product-info">
        <h1 class="product-title">📚 <?php echo $name; ?></h1>
        <span class="badge"><?php echo $category; ?> - <?php echo $subcategory; ?></span>
        <div class="product-price"><?php echo $priceFmt; ?></div>

        <div class="shipping-info">
          <div class="shipping-row"><span class="shipping-label">Tác giả:</span><span class="shipping-value"><?php echo $author; ?></span></div>
          <div class="shipping-row"><span class="shipping-label">Mã sản phẩm:</span><span class="shipping-value"><?php echo $sku; ?></span></div>
          <div class="shipping-row"><span class="shipping-label">Danh mục:</span><span class="shipping-value"><?php echo $category; ?> › <?php echo $subcategory; ?></span></div>
        </div>

        <?php echo $quantityBlock; ?>

        <div class="guarantee-section" style="margin-top: 1rem;">
          <div class="guarantee-item"><span class="guarantee-icon">✓</span><span>Literary Haven cam kết: nhận sản phẩm như mô tả hoặc nhận tiền hoàn.</span></div>
          <div class="guarantee-item"><span class="guarantee-icon">✓</span><span>Literary Haven - "The Home, All Tomes"</span></div>
        </div>
      </div>
    </div>

    <div class="details-section">
      <h2 class="section-title">📋 Thông tin chi tiết</h2>
      <div class="info-table">
        <div class="info-row"><span class="info-label">Tên sản phẩm</span><span class="info-value"><?php echo $name; ?></span></div>
        <div class="info-row"><span class="info-label">Tác giả</span><span class="info-value"><?php echo $author; ?></span></div>
        <div class="info-row"><span class="info-label">Mã SKU</span><span class="info-value"><?php echo $sku; ?></span></div>
        <div class="info-row"><span class="info-label">Danh mục</span><span class="info-value"><?php echo $category; ?> › <?php echo $subcategory; ?></span></div>
        <div class="info-row"><span class="info-label">Giá bán</span><span class="info-value" style="color: #e74c3c; font-weight: bold;"><?php echo $priceFmt; ?></span></div>
      </div>

      <h2 class="section-title" style="margin-top:3rem;">📝 Mô tả sản phẩm</h2>
      <div class="description-section">
        <p><?php echo $desc; ?></p>
        <p style="font-weight: 600; color: #4f9da6; margin-top: 2rem;">Sản phẩm chính hãng, chất lượng đảm bảo. Giao hàng nhanh chóng trên toàn quốc.</p>
      </div>
    </div>
  <?php } ?>
</main>

<?php
// 4. Gói Script riêng của trang chi tiết sản phẩm
ob_start();
?>
<script>
  // Hàm quay lại trang trước thông minh
  function goBack() {
    if (document.referrer.indexOf(window.location.host) !== -1) {
      window.history.back();
    } else {
      window.location.href = 'category.php';
    }
  }

  // JS phụ trợ cho nút tăng/giảm số lượng
  function decreaseQty() {
    const input = document.getElementById('qty');
    if (input && input.value > 1) {
      input.value = parseInt(input.value) - 1;
    }
  }

  function increaseQty() {
    const input = document.getElementById('qty');
    if (input) {
      const max = parseInt(input.getAttribute('max')) || 99;
      if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
      } else {
        alert('Số lượng trong kho chỉ còn ' + max + ' sản phẩm!');
      }
    }
  }

  function validateQtyInput() {
    const input = document.getElementById('qty');
    if (input) {
      let val = parseInt(input.value);
      const max = parseInt(input.getAttribute('max')) || 99;
      if (isNaN(val) || val < 1) input.value = 1;
      else if (val > max) {
        input.value = max;
        alert('Số lượng trong kho chỉ còn ' + max + ' sản phẩm!');
      }
    }
  }
</script>
<?php
$extraJs = ob_get_clean();

// 5. Gọi Footer chung (Đã bao gồm modals, main.js, bootstrap.js)
include '../includes/footer.php';
?>