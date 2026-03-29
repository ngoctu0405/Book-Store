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
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product ? htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') . ' - Literary Haven' : 'Chi tiết sản phẩm'; ?></title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css?v=1">
  <link rel="stylesheet" href="../assets/css/style.css?v=5">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: linear-gradient(135deg, #f5f2e8 0%, #e8d5b7 50%, #7fb3d3 100%);
      color: #2c3e50;
      min-height: 100vh;
    }

    /* 
        .topbar {
            background: linear-gradient(90deg, #ffffff 0%, #7fb3d3 100%);
            padding: 0 2rem;
            box-shadow: 0 4px 20px rgba(79, 157, 166, 0.3);
            position: fixed;
            top: 0;
            z-index: 100;
            border-bottom: 2px solid #82c09a;
            height: 120px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        } */

    .logo {
      display: flex;
      align-items: center;
      font-size: 2rem;
      font-weight: 800;
      color: #4f9da6;
      text-decoration: none;
    }

    .logo span:first-child {
      font-size: 2.5rem;
      margin-right: 0.5rem;
    }

    .search-center {
      flex: 1;
      /* max-width: 900px; */
      margin: 0 3rem;
    }

    /* .search-input {
            width: 100%;
            padding: 0.8rem 1.5rem;
            border: 2px solid rgba(130, 192, 154, 0.3);
            border-radius: 12px;
            background: rgba(245, 242, 232, 0.9);
            color: #2c3e50;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        } */

    /* .search-input:focus {
            outline: none;
            border-color: #4f9da6;
            background: #fff;
            box-shadow: 0 0 20px rgba(79, 157, 166, 0.2);
        } */

    .auth-cart {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .btn-auth {
      background: linear-gradient(135deg, #4f9da6 0%, #7fb3d3 100%);
      color: white;
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-auth:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(79, 157, 166, 0.3);
    }

    .navbar {
      background: #fff;
      padding: 0.8rem 2rem;
      border-bottom: 1px solid #eef2f6;
      display: flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .menu {
      list-style: none;
      display: flex;
      gap: 2rem;
      margin: 0;
      padding: 0;
    }

    .cart-float {
      position: absolute;
      right: 2rem;
    }

    .btn-cart-float {
      background: linear-gradient(135deg, #ff7f50 0%, #ff4500 100%);
      color: white;
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: 50px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.6rem;
      box-shadow: 0 4px 12px rgba(255, 99, 71, 0.3);
      font-size: 1.1rem;
    }

    .btn-cart-float:hover {
      background: linear-gradient(135deg, #ff6347 0%, #e63900 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(255, 99, 71, 0.4);
    }

    .cart-icon {
      font-size: 1.5rem;
      line-height: 1;
    }

    .cart-count {
      background: white;
      color: #ff4500;
      padding: 0.3rem 0.6rem;
      border-radius: 50%;
      font-size: 1rem;
      font-weight: 800;
      min-width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .menu a {
      display: inline-block;
      padding: 0.7rem 1.3rem;
      border-radius: 10px;
      background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .menu a:hover {
      background: linear-gradient(135deg, #7fb3d3 0%, #82c09a 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .container {
      max-width: 1400px;
      margin: 2rem auto;
      padding: 0 2rem;
    }

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
    }

    .back-button-arrow {
      font-size: 1.2rem;
      font-weight: bold;
    }

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
    }

    .stock-status {
      color: #7f8c8d;
      font-size: 0.9rem;
    }

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

    .btn-add-cart:hover {
      background: linear-gradient(135deg, #ff6347 0%, #e63900 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(255, 99, 71, 0.4);
    }

    .btn-buy-now {
      background: linear-gradient(135deg, #4f9da6 0%, #7fb3d3 100%);
      color: white;
      box-shadow: 0 4px 12px rgba(79, 157, 166, 0.3);
    }

    .btn-buy-now:hover {
      background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(79, 157, 166, 0.4);
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
    }

    .footer {
      background: linear-gradient(90deg, #4f9da6 0%, #7fb3d3 100%);
      text-align: center;
      padding: 2rem;
      margin-top: 4rem;
      border-top: 3px solid #82c09a;
      color: #fff;
      font-weight: 500;
      font-size: 1rem;
    }

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
    }

    @media (max-width: 1024px) {
      .product-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .image-gallery {
        position: relative;
        top: 0;
      }

      .topbar {
        height: auto;
        flex-direction: column;
        padding: 1rem;
        gap: 1rem;
      }

      .search-center {
        max-width: 100%;
        margin: 0;
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
    }
  </style>
</head>

<body>
  <!-- HEADER -->
  <header class="topbar">
    <div class="logo">
      <a href="index.php">
        <img class="Logo" src="../images/Logo_removebg.png" alt="Logo" />
        <img
          class="Word"
          src="../images/Logo_word_removebg.png"
          alt="Literary Haven" />
      </a>
    </div>

    <div class="auth-cart">
      <div id="authArea">
        <button class="btn-auth" onclick="openLoginModal()">Đăng nhập</button>
        <button class="btn-auth btn-signup" onclick="openRegisterModal()">
          Đăng ký
        </button>
      </div>
    </div>
  </header>

  <!-- NAV -->
  <nav class="navbar" id="mainNav">
    <ul class="menu" id="mainMenu">
      <li><a href="index.php">Trang chủ</a></li>
      <li><a href="about.php">Giới thiệu</a></li>
      <div class="category-menu">
        <button
          class="category-btn">
          Danh mục ▾
        </button>

        <ul class="book-filter">
          <li class="dropdown">
            <a href="category.php?category=Văn học" data-category="Văn học">Văn học ▸</a>
            <ul class="dropdown-content">
              <li>
                <a
                  href="category.php?category=Văn học&subcategory=Tiểu thuyết">Tiểu thuyết</a>
              </li>
              <li>
                <a
                  href="category.php?category=Văn học&subcategory=Truyện ngắn">Truyện ngắn</a>
              </li>
              <li>
                <a href="category.php?category=Văn học&subcategory=Thơ">Thơ</a>
              </li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="category.php?category=Kinh tế">Kinh tế ▸</a>
            <ul class="dropdown-content">
              <li>
                <a href="category.php?category=Kinh tế&subcategory=Quản trị">Quản trị</a>
              </li>
              <li>
                <a href="category.php?category=Kinh tế&subcategory=Tài chính">Tài chính</a>
              </li>
              <li>
                <a href="category.php?category=Kinh tế&subcategory=Marketing">Marketing</a>
              </li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="category.php?category=Thiếu nhi">Thiếu nhi ▸</a>
            <ul class="dropdown-content">
              <li>
                <a
                  href="category.php?category=Thiếu nhi&subcategory=Truyện tranh">Truyện tranh</a>
              </li>
              <li>
                <a
                  href="category.php?category=Thiếu nhi&subcategory=Giáo dục">Giáo dục</a>
              </li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="category.php?category=Giáo khoa">Giáo khoa ▸</a>
            <ul class="dropdown-content">
              <li>
                <a href="category.php?category=Giáo khoa&subcategory=Cấp 1">Cấp 1</a>
              </li>
              <li>
                <a href="category.php?category=Giáo khoa&subcategory=Cấp 2">Cấp 2</a>
              </li>
              <li>
                <a href="category.php?category=Giáo khoa&subcategory=Cấp 3">Cấp 3</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <li><a href="news.php">Tin tức</a></li>
    </ul>
  </nav>

  <!-- Tìm kiếm và giỏ hàng -->
  <div class="nav_2">
    <div class="search-center">
      <input
        id="topSearch"
        class="search-input"
        type="text"
        placeholder="Nhập tên cuốn sách bạn đang tìm ..."
        autocomplete="off" />
      <button class="search-btn" type="button">Tìm kiếm</button>
    </div>
    <div class="cart-float" id="cartFloat">
      <button id="cartBtnFloat" class="btn">
        <span class="cart-icon">🛒</span>
        <span id="cart-count" class="cart-count">0</span>
      </button>
    </div>
  </div>

  <div class="container" id="mainContent" data-rendered-by="php">
    <?php
    if (!$product) {
      echo '
    <div class="error-container">
      <h2>❌ Không tìm thấy sản phẩm</h2>
      <p>Sản phẩm bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
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
      $img = htmlspecialchars($p['img'] ?? '', ENT_QUOTES, 'UTF-8');
      $qty = (int) ($p['qty'] ?? 0);
      $price = (int) ($p['price'] ?? 0);
      $priceFmt = formatPricePhp($price);
      $outOfStock = $qty <= 0;

      $quantityBlock = $outOfStock
        ? '<p class="stock-info" style="margin-top:1rem;color:#e74c3c;font-size:1.2rem;font-weight:700;">💔 HẾT HÀNG</p>
           <div class="action-buttons">
             <button class="btn btn-add-cart" disabled>🛒 Thêm vào giỏ hàng</button>
             <button class="btn btn-buy-now" disabled>⚡ Mua ngay</button>
           </div>'
        : '<div class="quantity-selector">
             <span class="shipping-label">Số lượng:</span>
             <div class="quantity-controls">
               <button class="qty-btn" onclick="decreaseQty()">−</button>
               <input type="number" class="qty-input" value="1" id="qty" min="1" max="' . $qty . '" onchange="validateQtyInput()">
               <button class="qty-btn" onclick="increaseQty()">+</button>
             </div>
             <span class="stock-status">Còn hàng</span>
           </div>
           <div class="action-buttons">
             <button class="btn btn-add-cart" onclick="addToCartDetail(' . (int)$p['id'] . ')">🛒 Thêm vào giỏ hàng</button>
             <button class="btn btn-buy-now" onclick="buyNow(' . (int)$p['id'] . ')">⚡ Mua ngay</button>
           </div>';
    ?>
      <button class="back-button" onclick="goBack()"><span class="back-button-arrow">←</span> Quay Lại</button>
      <div class="breadcrumb">
        <a href="index.php">Literary Haven</a><span>›</span>
        <a href="category.php?category=<?php echo urlencode($category); ?>"><?php echo $category; ?></a>
        <span>›</span><span style="color:#2c3e50;"><?php echo $subcategory; ?></span>
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
            <div class="shipping-row"><span class="shipping-label">Số lượng sách:</span><span class="shipping-value"><?php echo $qty; ?> quyển</span></div>
          </div>
          <?php echo $quantityBlock; ?>
          <div class="guarantee-section">
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
          <div class="info-row"><span class="info-label">Giá bán</span><span class="info-value"><?php echo $priceFmt; ?></span></div>
        </div>
        <h2 class="section-title" style="margin-top:3rem;">📝 Mô tả sản phẩm</h2>
        <div class="description-section">
          <p><?php echo $desc; ?></p>
          <p>Sản phẩm chính hãng, chất lượng đảm bảo. Giao hàng nhanh chóng trên toàn quốc.</p>
        </div>
      </div>
    <?php } ?>
  </div>

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h3>Về Chúng tôi</h3>
        <ul>
          <li><a href="about.php">Giới thiệu</a></li>
          <li><a href="./news.php">Tin tức</a></li>
          <li><a href="./privacy_policy.php">Chính sách bảo mật</a></li>
          <li><a href="./terms-of-use.php">Điều khoản sử dụng</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h3>Hỗ trợ khách hàng</h3>
        <ul>
          <li><a href="./shopping_guide.php">Hướng dẫn mua hàng</a></li>
          <li><a href="./exchange-policy.php">Chính sách đổi trả</a></li>
          <li><a href="./warranty-policy.php">Chính sách bảo hành</a></li>
          <li>
            <a href="./frequently-asked-questions.php">Câu hỏi thường gặp</a>
          </li>
        </ul>
      </div>

      <div class="footer-section">
        <h3>Chính sách</h3>
        <ul>
          <li><a href="./payment-policy.php">Chính sách thanh toán</a></li>
          <li><a href="./shipping-policy.php">Chính sách vận chuyển</a></li>
          <li><a href="./warranty-policy.php">Chính sách bảo hành</a></li>
          <li><a href="./exchange-policy.php">Chính sách đổi trả</a></li>
        </ul>
      </div>

      <div class="footer-section contact-info">
        <h3>Liên hệ</h3>
        <p>📍 123 Nguyễn Văn Linh, Q7, TP.HCM</p>
        <p>📞 Hotline: 1900 xxxx</p>
        <p>✉️ Email: support@bookstore.vn</p>
        <p>🕐 Giờ làm việc: 8:00 - 22:00</p>

      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Book Store. All rights reserved. | Designed with ❤️</p>
    </div>
  </footer>

  <?php include '../includes/auth_modals.php'; ?>
  <script src="../assets/js/main.js?v=2"></script>
  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>