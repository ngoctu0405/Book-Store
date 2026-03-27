<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Giỏ Hàng - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <style>
    /* CHỈNH SỬA: Sửa lỗi cú pháp, thêm padding: 0 và box-sizing: border-box */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Custom styles cho cart page */
    .container {
      max-width: 1400px;
      margin: 2rem auto;
      padding: 3rem 2rem;
      position: relative;
      top: 2rem;
    }

    .cart-heading {
      font-size: 2.5rem;
      font-weight: 700;
      background: linear-gradient(135deg, #4f9da6 0%, #82c09a 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-top: 70px;
      margin-bottom: 2rem;
      text-align: center;
      text-shadow: none;
    }

    .cart-layout {
      display: grid;
      /* CHỈNH SỬA: Độ rộng cột tóm tắt là 500px */
      grid-template-columns: 1fr 500px;
      /* CHỈNH SỬA: Thêm đơn vị 'rem' */
      gap: 2rem;
      margin-top: 2rem;
    }

    /* Cart Items Section - Improved */
    .cart-items-section {
      background: white;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(79, 157, 166, 0.12);
      border: 1px solid rgba(130, 192, 154, 0.15);
    }

    .cart-section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      /* CHỈNH SỬA: Thêm đơn vị 'rem' */
      margin-bottom: 1.5rem;
      /* CHỈNH SỬA: Thêm đơn vị 'rem' */
      padding-bottom: 1.2rem;
      border-bottom: 2px solid #f0f0f0;
    }

    .cart-section-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #2c3e50;
      margin: 0;
    }

    .select-all-wrapper {
      display: flex;
      align-items: center;
      gap: 1.2rem;
    }

    .select-all-label {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      margin: 0;
      cursor: pointer;
      font-weight: 600;
      font-size: 1.05rem;
      color: #4f9da6;
      user-select: none;
    }

    .select-all-label input[type="checkbox"] {
      width: 20px;
      height: 20px;
      cursor: pointer;
      accent-color: #4f9da6;
    }

    .btn-clear-all {
      padding: 0.65rem 1.3rem;
      background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    .btn-clear-all:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }

    .btn-clear-all i {
      font-size: 1.1rem;
    }

    .empty-cart {
      text-align: center;
      padding: 5rem 2rem;
    }

    .empty-cart-icon {
      font-size: 6rem;
      margin-bottom: 1.5rem;
      opacity: 0.4;
      display: block;
    }

    .empty-cart h3 {
      font-size: 2rem;
      color: #2c3e50;
      margin-bottom: 1rem;
      font-weight: 700;
    }

    .empty-cart p {
      color: #7f8c8d;
      margin-bottom: 2.5rem;
      font-size: 1.1rem;
    }

    .btn-continue {
      display: inline-block;
      padding: 1.2rem 2.5rem;
      background: linear-gradient(135deg, #4f9da6 0%, #82c09a 100%);
      color: white;
      text-decoration: none;
      border-radius: 16px;
      font-weight: 700;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(79, 157, 166, 0.25);
    }

    .btn-continue:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(79, 157, 166, 0.35);
      color: white;
    }

    /* Cart Item - Improved */
    .cart-item {
      display: grid;
      grid-template-columns: 40px 110px 1fr auto;
      align-items: center;
      gap: 1.5rem;
      padding: 1.5rem;
      background: linear-gradient(145deg, #ffffff 0%, #fafafa 100%);
      border-radius: 16px;
      margin-bottom: 1.5rem;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .cart-item:hover {
      transform: translateX(8px);
      box-shadow: 0 8px 24px rgba(79, 157, 166, 0.15);
      border-color: rgba(130, 192, 154, 0.3);
    }

    .item-select-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .item-select-checkbox {
      width: 22px;
      height: 22px;
      cursor: pointer;
      accent-color: #4f9da6;
    }

    .cart-item-image {
      width: 110px;
      height: 150px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .cart-item-image:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .cart-item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .cart-item-details {
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 0.5rem;
    }

    .cart-item-title {
      font-size: 1.2rem;
      font-weight: 700;
      color: #2c3e50;
      margin: 0 0 0.3rem 0;
      line-height: 1.4;
    }

    .cart-item-author {
      color: #7f8c8d;
      font-size: 0.95rem;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .cart-item-author i {
      color: #4f9da6;
    }

    .cart-item-price {
      font-size: 1.25rem;
      color: #e74c3c;
      font-weight: 700;
      margin: 0.3rem 0 0 0;
    }

    .cart-item-actions {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-end;
      gap: 1rem;
      min-width: 180px;
    }

    .cart-item-total {
      font-size: 1.3rem;
      font-weight: 700;
      color: #2c3e50;
      min-width: 120px;
      text-align: right;
      padding: 0.5rem 0;
    }

    .quantity-controls {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      background: transparent;
    }

    .qty-btn {
      width: 28px;
      height: 28px;
      min-width: 28px;
      border: 2px solid #e0e0e0;
      background: white;
      color: #5a5a5a;
      cursor: pointer;
      font-size: 1.2rem;
      font-weight: 700;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .qty-btn.minus-btn {
      border-color: #ffb3b3;
      color: #ff4d4d;
    }

    .qty-btn.minus-btn:hover:not(:disabled) {
      background: #ff4d4d;
      color: white;
      border-color: #ff4d4d;
      transform: scale(1.05);
      box-shadow: 0 2px 8px rgba(255, 77, 77, 0.3);
    }

    .qty-btn.plus-btn {
      border-color: #b3e0cc;
      color: #27ae60;
    }

    .qty-btn.plus-btn:hover:not(:disabled) {
      background: #27ae60;
      color: white;
      border-color: #27ae60;
      transform: scale(1.05);
      box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
    }

    .qty-btn:active:not(:disabled) {
      transform: scale(0.95);
    }

    .qty-btn:disabled {
      opacity: 0.3;
      cursor: not-allowed;
      background: #f5f5f5;
      border-color: #ddd;
      color: #999;
    }

    .qty-display {
      min-width: 35px;
      text-align: center;
      font-size: 0.95rem;
      font-weight: 700;
      color: #2c3e50;
      border: 2px solid #e8e8e8;
      border-radius: 6px;
      padding: 0.3rem 0.4rem;
      background: #fafafa;
      pointer-events: none;
    }

    .btn-remove {
      background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
      color: white;
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      width: 100%;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(255, 107, 107, 0.2);
    }

    .btn-remove:hover {
      background: linear-gradient(135deg, #ee5a6f 0%, #d63447 100%);
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }

    /* Cart Summary - Improved */
    .cart-summary {
      background: white;
      padding: 2rem;
      /* Tăng padding */
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(79, 157, 166, 0.12);
      border: 1px solid rgba(130, 192, 154, 0.15);
      height: fit-content;
      position: sticky;
      top: 100px;
      /* CHỈNH SỬA: Đặt 100% để nó lấp đầy cột grid 500px */
      width: 100%;
    }

    .summary-title {
      font-size: 1.6rem;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 1.5rem;
      padding-bottom: 1.2rem;
      border-bottom: 2px solid #f0f0f0;
      text-align: center;
    }

    /* CSS MỚI: Định dạng tiêu đề cột chi tiết sản phẩm */
    .summary-header-row {
      display: grid;
      grid-template-columns: 2fr 1fr 1.5fr;
      /* 3 cột thẳng hàng */
      gap: 0.5rem;
      font-weight: 700;
      color: #000000;
      padding: 0 0 0.5rem 0;
      font-size: 1rem;
      border-bottom: 1px solid #f0f0f0;
      margin-bottom: 0.5rem;
      margin-top: 20px;
    }

    .summary-header-row span:nth-child(2) {
      text-align: center;
    }

    .summary-header-row span:last-child {
      text-align: right;
    }

    /* CSS ĐÃ CHỈNH SỬA: Định dạng chi tiết sản phẩm trong tóm tắt */
    .summary-item-detail {
      display: grid;
      /* ĐÃ SỬA: Dùng grid để căn cột */
      grid-template-columns: 2fr 1fr 1.5fr;
      /* Căn chỉnh 3 cột */
      gap: 0.5rem;
      font-size: 1.15rem;
      /* TĂNG: Tăng kích thước font lên 1.15rem */
      color: #333;
      padding: 0.5rem 0;
      /* TĂNG: Tăng padding để dễ đọc hơn */
      align-items: center;
    }

    .summary-item-detail span:first-child {
      /* Tên sản phẩm */
      max-width: 100%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-weight: 500;
      color: #2c3e50;
    }

    .summary-item-detail span:nth-child(2) {
      /* Quantity (Số lượng) */
      font-weight: 600;
      text-align: center;
      color: #4f9da6;
    }

    .summary-item-detail span:last-child {
      /* Total Price (Giá tổng) */
      font-weight: 700;
      color: #e74c3c;
      text-align: right;
      /* Căn phải */
      font-size: 1.05rem;
      /* Tăng độ nổi bật */
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 0;
      font-size: 1.05rem;
      color: #2c3e50;
    }

    .summary-row.temp-total {
      /* ĐIỀU CHỈNH: Padding cho dòng Tạm tính */
      padding-top: 1rem;
      padding-bottom: 1rem;
    }

    .summary-row span:first-child {
      font-weight: 500;
    }

    .summary-row span:last-child {
      font-weight: 700;
    }

    .summary-row.total {
      font-size: 1.6rem;
      font-weight: 700;
      color: #e74c3c;
      border-top: 2px solid #f0f0f0;
      margin-top: 1rem;
      padding-top: 1.5rem;
    }

    .text-success {
      color: #27ae60 !important;
      font-weight: 700 !important;
    }

    /* Custom styles for Payment Method (NEW) */
    .payment-method-section {
      margin-top: 1.5rem;
      padding: 1.5rem;
      border-radius: 12px;
      background: #f0f8ff;
      /* Light blue background */
      border: 1px solid #b3e0ff;
      margin-bottom: 50px;
    }

    .payment-method-section h4 {
      font-size: 1.3rem;
      color: #4f9da6;
      margin-bottom: 1rem;
    }

    .payment-options {
      display: flex;
      flex-direction: column;
      gap: 0.8rem;
    }

    .payment-option {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      font-size: 1.05rem;
      cursor: pointer;
      user-select: none;
      padding: 0.5rem;
      border-radius: 6px;
      transition: background-color 0.2s;
    }

    .payment-option:hover {
      background-color: #e6f7ff;
    }

    .payment-option input[type="radio"] {
      width: 18px;
      height: 18px;
      accent-color: #4f9da6;
    }

    .btn-checkout {
      width: 100%;
      padding: 1.4rem;
      background: linear-gradient(135deg, #ff7f50 0%, #ff6347 100%);
      color: white;
      border: none;
      border-radius: 16px;
      font-size: 1.2rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 2rem;
      text-decoration: none;
      display: block;
      text-align: center;
      box-shadow: 0 6px 20px rgba(255, 99, 71, 0.3);
    }

    .btn-checkout:disabled {
      opacity: 0.5;
      cursor: not-allowed;
      box-shadow: none;
    }

    .btn-checkout:hover:not(:disabled) {
      background: linear-gradient(135deg, #ff6347 0%, #e8533f 100%);
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(255, 99, 71, 0.4);
    }

    @media (max-width: 1024px) {
      .cart-layout {
        grid-template-columns: 1fr;
      }

      .cart-summary {
        position: relative;
        top: 0;
        /* KHÔNG CẦN CHỈNH SỬA WIDTH Ở ĐÂY NỮA VÌ ĐÃ LÀ 100% */
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 0 1rem;
      }

      .cart-heading {
        font-size: 2rem;
        margin-top: 60px;
      }

      .cart-items-section {
        padding: 1.5rem;
      }

      .cart-section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }

      .select-all-wrapper {
        width: 100%;
        justify-content: space-between;
      }

      .cart-item {
        grid-template-columns: 30px 90px 1fr;
        grid-template-areas:
          "checkbox image details"
          "actions actions actions";
        gap: 0.75rem 1rem;
        padding: 1.5rem;
      }

      .item-select-wrapper {
        grid-area: checkbox;
      }

      .cart-item-image {
        grid-area: image;
        width: 90px;
        height: 120px;
      }

      .cart-item-details {
        grid-area: details;
      }

      .cart-item-title {
        font-size: 1.1rem;
      }

      .cart-item-author {
        font-size: 0.85rem;
      }

      .cart-item-price {
        font-size: 1.2rem;
      }

      .cart-item-actions {
        grid-area: actions;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
        min-width: unset;
        gap: 0.75rem;
        border-top: 1px solid #e0e0e0;
        padding-top: 1rem;
      }

      .cart-item-total {
        font-size: 1.1rem;
        text-align: left;
        order: 1;
        min-width: auto;
      }

      .quantity-controls {
        order: 2;
        gap: 0.25rem;
      }

      .qty-btn {
        width: 26px;
        height: 26px;
        min-width: 26px;
        font-size: 1.1rem;
      }

      .qty-display {
        font-size: 0.9rem;
        min-width: 32px;
        padding: 0.25rem 0.35rem;
      }

      .btn-remove {
        order: 3;
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
        width: auto;
      }

      .cart-summary {
        padding: 2rem;
      }

      .summary-title {
        font-size: 1.5rem;
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
        <button class="category-btn">Danh mục ▾</button>

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

  <main class="container">
    <h2 class="cart-heading">🛒 Giỏ Hàng Của Bạn</h2>
    <div id="cartContainer"></div>
  </main>

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

  <div id="loginModal" class="auth-modal">
    <div class="auth-modal-overlay" onclick="closeLoginModal()"></div>
    <div class="auth-modal-content">
      <button class="auth-modal-close" onclick="closeLoginModal()">
        &times;
      </button>
      <div class="auth-modal-header">
        <h2>Đăng Nhập</h2>
        <p>Chào mừng bạn trở lại!</p>
      </div>
      <form id="login-form" class="auth-modal-form">
        <div class="form-group">
          <label for="login-username">Tên tài khoản</label>
          <div class="input-with-icon">
            <span class="input-icon">👤</span>
            <input
              type="text"
              id="login-username"
              placeholder="Nhập tên tài khoản" />
          </div>
          <span id="error-login-username" class="error-msg"></span>
        </div>
        <div class="form-group">
          <label for="login-password">Mật khẩu</label>
          <div class="input-with-icon">
            <span class="input-icon">🔑</span>
            <input
              type="password"
              id="login-password"
              placeholder="Nhập mật khẩu" />
            <span
              class="password-toggle"
              id="toggle-login-password"
              onclick="togglePassword('login-password', 'toggle-login-password')">👁️‍🗨️</span>
          </div>
          <span id="error-login-password" class="error-msg"></span>
        </div>
        <button type="submit" class="btn-auth-submit">Đăng Nhập</button>
      </form>
      <div class="auth-modal-footer">
        Chưa có tài khoản?
        <a href="#" onclick="switchToRegister()">Đăng ký ngay</a>
      </div>
    </div>
  </div>

  <div id="registerModal" class="auth-modal">
    <div class="auth-modal-overlay" onclick="closeRegisterModal()"></div>
    <div class="auth-modal-content">
      <button class="auth-modal-close" onclick="closeRegisterModal()">
        &times;
      </button>
      <div class="auth-modal-header">
        <h2>Đăng Ký</h2>
        <p>Tạo tài khoản mới của bạn</p>
      </div>
      <form
        id="register-form"
        class="auth-modal-form"
        style="max-height: 450px; overflow-y: auto">
        <div class="form-group">
          <label for="reg-fullname">Họ và tên</label>
          <div class="input-with-icon">
            <span class="input-icon">👤</span>
            <input
              type="text"
              id="reg-fullname"
              placeholder="Nhập họ và tên" />
          </div>
          <span id="error-fullname" class="error-msg"></span>
        </div>
        <div class="form-group">
          <label for="reg-username">Tài khoản</label>
          <div class="input-with-icon">
            <span class="input-icon">🔐</span>
            <input
              type="text"
              id="reg-username"
              placeholder="Nhập tài khoản" />
          </div>
          <span id="error-username" class="error-msg"></span>
        </div>
        <div class="form-group">
          <label for="reg-password">Mật khẩu</label>
          <div class="input-with-icon">
            <span class="input-icon">🔑</span>
            <input
              type="password"
              id="reg-password"
              placeholder="Nhập mật khẩu" />
            <span
              class="password-toggle"
              id="toggle-reg-password"
              onclick="togglePassword('reg-password', 'toggle-reg-password')">👁️‍🗨️</span>
          </div>
          <span id="error-password" class="error-msg"></span>
        </div>
        <div class="form-group">
          <label for="reg-confirm-password">Nhập lại mật khẩu</label>
          <div class="input-with-icon">
            <span class="input-icon">🔑</span>
            <input
              type="password"
              id="reg-confirm-password"
              placeholder="Nhập lại mật khẩu" />
            <span
              class="password-toggle"
              id="toggle-reg-confirm"
              onclick="togglePassword('reg-confirm-password', 'toggle-reg-confirm')">👁️‍🗨️</span>
          </div>
          <span id="error-confirm-password" class="error-msg"></span>
        </div>
        <div class="form-group">
          <label for="reg-email">Email</label>
          <div class="input-with-icon">
            <span class="input-icon">📧</span>
            <input type="email" id="reg-email" placeholder="Nhập email" />
          </div>
          <span id="error-email" class="error-msg"></span>
        </div>
        <div class="form-group">
          <label for="reg-phone">Số điện thoại</label>
          <div class="input-with-icon">
            <span class="input-icon">📱</span>
            <input
              type="tel"
              id="reg-phone"
              placeholder="Nhập số điện thoại" />
          </div>
          <span id="error-phone" class="error-msg"></span>
        </div>
        <div class="form-group">
          <label for="reg-address">Địa chỉ</label>
          <div class="input-with-icon">
            <span class="input-icon">📍</span>
            <input type="text" id="reg-address" placeholder="Nhập địa chỉ" />
          </div>
          <span id="error-address" class="error-msg"></span>
        </div>
        <button type="submit" class="btn-auth-submit">Đăng Ký</button>
      </form>
      <div class="auth-modal-footer">
        Đã có tài khoản? <a href="#" onclick="switchToLogin()">Đăng nhập</a>
      </div>
    </div>
  </div>

  <?php include '../includes/auth_modals.php'; ?>

  <div id="addressModal" class="auth-modal">
    <div class="auth-modal-overlay" onclick="closeAddressModal()"></div>
    <div class="auth-modal-content" style="max-width: 600px">
      <button class="auth-modal-close" onclick="closeAddressModal()">
        &times;
      </button>
      <div class="auth-modal-header">
        <h2 style="color: #4f9da6">
          <i class="bi bi-geo-alt-fill"></i> Quản lý Địa chỉ Giao hàng
        </h2>
        <p>Chọn hoặc thêm địa chỉ nhận hàng của bạn</p>
      </div>
      <div id="addressManagementContent"></div>
    </div>
  </div>

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>

  <script>
    function openModal(modalId) {
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.add("show");
        document.body.style.overflow = "hidden";
      }
    }

    function closeModal(modalId) {
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.remove("show");
        document.body.style.overflow = "";
        modal
          .querySelectorAll(".error-msg")
          .forEach((el) => (el.textContent = ""));
        const form = modal.querySelector("form");
        if (form) form.reset();

        // Xóa form sửa địa chỉ nếu đang hiển thị
        const editForm = document.getElementById("editAddressForm");
        if (editForm) editForm.remove();
      }
    }

    function togglePassword(inputId, toggleId) {
      const input = document.getElementById(inputId);
      const toggle = document.getElementById(toggleId);
      if (input.type === "password") {
        input.type = "text";
        if (toggle) toggle.textContent = "🙈";
      } else {
        input.type = "password";
        if (toggle) toggle.textContent = "👁️‍🗨️";
      }
    }

    const formatter = new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
      minimumFractionDigits: 0,
    });

    function getProductData() {
      return (
        JSON.parse(localStorage.getItem("bs_data"))?.products ||
        (typeof SAMPLE !== "undefined" ? SAMPLE.products : []) || []
      );
    }

    function getProductById(productId) {
      return getProductData().find((p) => p.id === productId);
    }

    function getSelectedProductIds() {
      const checkboxes = document.querySelectorAll(
        ".item-select-checkbox:checked"
      );
      return Array.from(checkboxes).map((cb) => parseInt(cb.dataset.id));
    }

    function calculateTotals() {
      const getCartFunc =
        typeof getCart === "function" ?
        getCart :
        () => JSON.parse(localStorage.getItem("bs_cart")) || [];
      const cart = getCartFunc();
      const selectedIds = getSelectedProductIds();

      let subtotal = 0;
      let totalItems = 0;
      let shipping = 30000; // Phí vận chuyển cố định
      let discount = 0;
      const selectedCartData = [];

      cart.forEach((item) => {
        if (selectedIds.includes(item.id)) {
          const product = getProductById(item.id);
          if (product) {
            const itemTotal = product.price * item.qty;
            subtotal += itemTotal;
            totalItems += item.qty;
            selectedCartData.push({
              ...item,
              product: product,
              itemTotal: itemTotal,
            });
          }
        }
      });
      // Nếu tổng tiền là 0 thì phí vận chuyển cũng bằng 0
      if (subtotal === 0) {
        shipping = 0;
      } else if (subtotal >= 500000) {
        // Miễn phí vận chuyển cho đơn hàng từ 500,000 VND trở lên
        shipping = 0;
      }

      const total = subtotal - discount + shipping;

      return {
        subtotal: subtotal,
        totalItems: totalItems,
        shipping: shipping,
        discount: discount,
        total: total,
        selectedCartData: selectedCartData,
      };
    }

    // Khởi tạo phương thức thanh toán mặc định
    let selectedPaymentMethod = "Thanh toán khi nhận hàng";

    function selectPaymentMethod(method) {
      selectedPaymentMethod = method;
      console.log("Payment method selected:", selectedPaymentMethod);
    }

    function renderCartSummary() {
      const summaryElement = document.querySelector(".cart-summary");
      if (!summaryElement) return;

      const {
        subtotal,
        totalItems,
        shipping,
        discount,
        total,
        selectedCartData,
      } = calculateTotals();

      if (totalItems === 0) {
        summaryElement.innerHTML = `
          <h3 class="summary-title">Tóm Tắt Đơn Hàng</h3>
          ${renderShippingAddress()}
          <p style="text-align: center; color: #7f8c8d; margin: 2rem 0;">Vui lòng chọn sản phẩm để thanh toán.</p>
          <button class="btn-checkout" disabled>Thanh Toán (${totalItems} mục)</button>
        `;
        return;
      }

      // --- PHẦN HIỂN THỊ CHI TIẾT SẢN PHẨM TRONG TÓM TẮT ---
      const selectedItemsDetailsHtml = selectedCartData
        .map(
          (item) => `
        <div class="summary-item-detail">
          <span title="${item.product.name}">${item.product.name}</span>
          <span>${item.qty}</span>
          <span>${formatter.format(item.itemTotal)}</span>
        </div>
      `
        )
        .join("");

      const summaryItemsDetailsWrapper = selectedItemsDetailsHtml ?
        `
        <div style="margin-bottom: 1.5rem; padding-bottom: 0.5rem; max-height: 200px; overflow-y: auto;">
          <div class="summary-header-row">
            <span>Sản phẩm</span>
            <span>SL</span>
            <span>Thành tiền</span>
          </div>
          ${selectedItemsDetailsHtml}
        </div>
      ` :
        "";

      // --- PHẦN CHỌN PHƯƠNG THỨC THANH TOÁN (ĐÃ CẬP NHẬT THÊM THANH TOÁN TRỰC TUYẾN) ---
      const paymentMethodsHtml = localStorage.getItem("bs_user") ?
        `
        <div class="payment-method-section">
          <h4><i class="bi bi-credit-card-2-front"></i> Phương thức thanh toán</h4>
          <div class="payment-options">
            <label class="payment-option">
              <input type="radio" name="paymentMethod" value="Thanh toán khi nhận hàng" onchange="selectPaymentMethod('Thanh toán khi nhận hàng')" ${
                selectedPaymentMethod === "Thanh toán khi nhận hàng"
                  ? "checked"
                  : ""
              }> Thanh toán khi nhận hàng (COD)
            </label>
            <label class="payment-option">
              <input type="radio" name="paymentMethod" value="Thanh toán trực tuyến" onchange="selectPaymentMethod('Thanh toán trực tuyến')" ${
                selectedPaymentMethod === "Thanh toán trực tuyến"
                  ? "checked"
                  : ""
              }> Thanh toán trực tuyến (VNPAY/Momo/ZaloPay)
            </label>
            <label class="payment-option">
              <input type="radio" name="paymentMethod" value="Chuyển khoản ngân hàng" onchange="selectPaymentMethod('Chuyển khoản ngân hàng')" ${
                selectedPaymentMethod === "Chuyển khoản ngân hàng"
                  ? "checked"
                  : ""
              }> Chuyển khoản ngân hàng
            </label>
          </div>
        </div>
      ` :
        "";

      // --- PHẦN TỔNG KẾT ĐƠN HÀNG ---
      const summaryHtml = `
        <h3 class="summary-title">Tóm Tắt Đơn Hàng</h3>
        ${renderShippingAddress()}
        ${paymentMethodsHtml}
        ${summaryItemsDetailsWrapper}
        <div class="summary-row temp-total">
          <span>Tạm tính (${totalItems} mục)</span>
          <span>${formatter.format(subtotal)}</span>
        </div>
        <div class="summary-row">
          <span>Phí vận chuyển</span>
          <span class="${shipping > 0 ? "" : "text-success"}">${
          shipping > 0 ? formatter.format(shipping) : "Miễn phí"
        }</span>
        </div>
        
        <div class="summary-row total">
          <span>Tổng cộng</span>
          <span>${formatter.format(total)}</span>
        </div>
        <button class="btn-checkout" onclick="checkout()">Thanh Toán (${totalItems} mục)</button>
      `;

      summaryElement.innerHTML = summaryHtml;

      // Cập nhật lại trạng thái nút "Chọn địa chỉ khác"
      if (document.getElementById("addressList")) {
        document.getElementById("addressList").style.display =
          localStorage.getItem("bs_show_address_list") === "true" ?
          "block" :
          "none";
      }
    }

    function renderCart() {
      const cartContainer = document.getElementById("cartContainer");
      const getCartFunc =
        typeof getCart === "function" ?
        getCart :
        () => JSON.parse(localStorage.getItem("bs_cart")) || [];
      const currentCart = getCartFunc();

      if (currentCart.length === 0) {
        cartContainer.innerHTML = `
          <div class="empty-cart">
            <span class="empty-cart-icon">🛍️</span>
            <h3>Giỏ hàng của bạn đang trống!</h3>
            <p>Hãy thêm sách vào giỏ hàng để bắt đầu mua sắm.</p>
            <a href="category.php" class="btn-continue">Tiếp tục mua sắm</a>
          </div>
        `;
        // Đảm bảo summary cũng trống nếu giỏ hàng trống
        const summaryElement = document.querySelector(".cart-summary");
        if (summaryElement) summaryElement.innerHTML = "";
        return;
      }

      // Mặc định chọn tất cả khi render lần đầu
      const initialChecked = true;
      const itemsHtml = currentCart
        .map((item) => {
          const product = getProductById(item.id);
          if (!product) return "";
          const itemTotal = product.price * item.qty;

          return `
          <div class="cart-item" data-product-id="${item.id}">
            <label class="item-select-wrapper">
              <input type="checkbox" data-id="${
                item.id
              }" class="item-select-checkbox" onchange="handleItemSelection()" ${
              initialChecked ? "checked" : ""
            }>
            </label>
            <div class="cart-item-image">
              <img src="${product.img}" alt="${product.name}">
            </div>
            <div class="cart-item-details">
              <h4 class="cart-item-title">${product.name}</h4>
              <p class="cart-item-author"><i class="bi bi-person"></i> ${
                product.author
              }</p>
              <p class="cart-item-price">${formatter.format(
                product.price
              )} / cuốn</p>
            </div>
            <div class="cart-item-actions">
              <p class="cart-item-total">${formatter.format(itemTotal)}</p>
              <div class="quantity-controls">
                <button class="qty-btn minus-btn" onclick="updateItemQuantity(${
                  item.id
                }, -1)">-</button>
                <span class="qty-display">${item.qty}</span>
                <button class="qty-btn plus-btn" onclick="updateItemQuantity(${
                  item.id
                }, 1)">+</button>
              </div>
              <button class="btn-remove" onclick="removeItem(${item.id})">
                 <i class="bi bi-trash"></i> Xóa
              </button>
            </div>
          </div>
        `;
        })
        .join("");

      const cartContentHtml = `
        <div class="cart-layout">
          <div class="cart-items-section">
            <div class="cart-section-header">
              <h3 class="cart-section-title">Danh sách sản phẩm (${
                currentCart.length
              } mục)</h3>
              <div class="select-all-wrapper">
                <label class="select-all-label">
                  <input type="checkbox" id="selectAllItems" onchange="toggleSelectAll(this.checked)" ${
                    initialChecked ? "checked" : ""
                  }> Chọn tất cả
                </label>
                <button class="btn-clear-all" onclick="clearAllItems()">
                   <i class="bi bi-trash"></i> Xóa tất cả
                </button>
              </div>
            </div>
            <div class="cart-items-list">
              ${itemsHtml}
            </div>
          </div>
          <div class="cart-summary-wrapper">
            <div class="cart-summary">
              </div>
          </div>
        </div>
      `;

      cartContainer.innerHTML = cartContentHtml;

      // Sau khi render cấu trúc, gọi hàm render summary để điền dữ liệu
      renderCartSummary();
    }

    function updateItemQuantity(productId, change) {
      const getCartFunc =
        typeof getCart === "function" ?
        getCart :
        () => JSON.parse(localStorage.getItem("bs_cart")) || [];
      const saveCartFunc =
        typeof saveCart === "function" ?
        saveCart :
        (c) => localStorage.setItem("bs_cart", JSON.stringify(c));
      let cart = getCartFunc();

      const itemIndex = cart.findIndex((item) => item.id === productId);

      if (itemIndex > -1) {
        let currentQty = cart[itemIndex].qty;
        let newQty = currentQty + change;

        if (newQty > 0) {
          cart[itemIndex].qty = newQty;
        } else {
          if (
            confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")
          ) {
            cart.splice(itemIndex, 1);
          } else {
            return;
          }
        }

        saveCartFunc(cart);
        if (typeof updateCartCount === "function") updateCartCount();
        renderCart();
      }
    }

    function removeItem(productId) {
      if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {
        const getCartFunc =
          typeof getCart === "function" ?
          getCart :
          () => JSON.parse(localStorage.getItem("bs_cart")) || [];
        const saveCartFunc =
          typeof saveCart === "function" ?
          saveCart :
          (c) => localStorage.setItem("bs_cart", JSON.stringify(c));
        let cart = getCartFunc();

        cart = cart.filter((item) => item.id !== productId);

        saveCartFunc(cart);
        if (typeof updateCartCount === "function") updateCartCount();
        renderCart();
      }
    }

    function clearAllItems() {
      if (
        confirm("Bạn có chắc chắn muốn xóa TẤT CẢ sản phẩm khỏi giỏ hàng?")
      ) {
        const saveCartFunc =
          typeof saveCart === "function" ?
          saveCart :
          (c) => localStorage.setItem("bs_cart", JSON.stringify(c));
        saveCartFunc([]);
        if (typeof updateCartCount === "function") updateCartCount();
        renderCart();
      }
    }

    function toggleSelectAll(checked) {
      document.querySelectorAll(".item-select-checkbox").forEach((cb) => {
        cb.checked = checked;
      });
      renderCartSummary();
    }

    function handleItemSelection() {
      const allCheckboxes = document.querySelectorAll(
        ".item-select-checkbox"
      );
      const selectedCheckboxes = document.querySelectorAll(
        ".item-select-checkbox:checked"
      );
      const selectAllCheckbox = document.getElementById("selectAllItems");

      if (selectAllCheckbox) {
        selectAllCheckbox.checked =
          allCheckboxes.length > 0 &&
          allCheckboxes.length === selectedCheckboxes.length;
      }
      renderCartSummary();
    }

    // ==================== CHỨC NĂNG QUẢN LÝ ĐỊA CHỈ GIAO HÀNG ====================
    // Lấy danh sách địa chỉ của user
    function getUserAddresses() {
      const user = JSON.parse(localStorage.getItem("bs_user"));
      if (!user) return [];
      const addresses = JSON.parse(
        localStorage.getItem("bs_user_addresses") || "{}"
      );
      return addresses[user.username] || [];
    }

    // Lưu danh sách địa chỉ
    function saveUserAddresses(addresses) {
      const user = JSON.parse(localStorage.getItem("bs_user"));
      if (!user) return;
      const allAddresses = JSON.parse(
        localStorage.getItem("bs_user_addresses") || "{}"
      );
      allAddresses[user.username] = addresses;
      localStorage.setItem("bs_user_addresses", JSON.stringify(allAddresses));
    }

    // Lấy địa chỉ đang được chọn
    function getSelectedAddress() {
      const user = JSON.parse(localStorage.getItem("bs_user"));
      if (!user) return null;
      const allSelected = JSON.parse(
        localStorage.getItem("bs_selected_address") || "{}"
      );
      return allSelected[user.username] || null;
    }

    // Lưu địa chỉ đang được chọn
    function saveSelectedAddress(address) {
      const user = JSON.parse(localStorage.getItem("bs_user"));
      if (!user) return;
      const allSelected = JSON.parse(
        localStorage.getItem("bs_selected_address") || "{}"
      );
      allSelected[user.username] = address;
      localStorage.setItem(
        "bs_selected_address",
        JSON.stringify(allSelected)
      );
    }

    // Khởi tạo địa chỉ mặc định từ thông tin user
    function initDefaultAddress() {
      const user = JSON.parse(localStorage.getItem("bs_user"));
      if (!user) return null;
      let addresses = getUserAddresses();

      // Nếu chưa có địa chỉ nào, tạo địa chỉ mặc định từ thông tin đăng ký
      if (addresses.length === 0) {
        const defaultAddress = {
          id: Date.now(),
          name: user.fullName,
          phone: user.phone,
          address: user.address,
          isDefault: true,
        };
        addresses.push(defaultAddress);
        saveUserAddresses(addresses);
      }

      // Chọn địa chỉ mặc định/đầu tiên
      let selected = getSelectedAddress();
      if (!selected) {
        selected = addresses.find((addr) => addr.isDefault) || addresses[0];
        if (selected) saveSelectedAddress(selected);
      }

      return selected;
    }

    // Render phần địa chỉ giao hàng
    function renderShippingAddress() {
      const user = localStorage.getItem("bs_user");
      if (!user) {
        return `
          <div class="shipping-address-section" style="background: #fff3cd; padding: 1.5rem; border-radius: 12px; border: 1px solid #ffc107; margin-bottom: 1.5rem;">
            <p style="margin: 0; color: #856404; text-align: center;">
              <i class="bi bi-exclamation-triangle"></i> Vui lòng đăng nhập để nhập địa chỉ giao hàng
            </p>
            <button onclick="openLoginModal()" style="width: 100%; margin-top: 1rem; padding: 0.7rem; background: #ffc107; color: #856404; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
              Đăng nhập ngay
            </button>
          </div>
        `;
      }

      const selectedAddress = initDefaultAddress();
      const addresses = getUserAddresses();

      if (!selectedAddress) {
        return `
          <div class="shipping-address-section" style="background: #f8d7da; padding: 1.5rem; border-radius: 12px; border: 1px solid #dc3545; margin-bottom: 1.5rem;">
            <p style="margin: 0; color: #721c24; text-align: center;">
              <i class="bi bi-exclamation-octagon"></i> Không tìm thấy địa chỉ giao hàng. Vui lòng thêm địa chỉ!
            </p>
            <button onclick="openAddressModal()" style="width: 100%; margin-top: 1rem; padding: 0.7rem; background: #dc3545; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
              <i class="bi bi-plus-circle"></i> Thêm địa chỉ mới
            </button>
          </div>
        `;
      }

      return `
        <div class="shipping-address-section" style="background: white; padding: 2rem; border-radius: 16px; border: 2px solid #e3f2fd; margin-bottom: 1.5rem;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 0.8rem; border-bottom: 1px dashed #eee;">
            <h4 style="margin: 0; font-size: 1.25rem; color: #4f9da6;"><i class="bi bi-geo-alt-fill"></i> Địa chỉ giao hàng</h4>
            <button onclick="openAddressModal()" style="background: none; border: none; color: #ff7f50; font-weight: 600; cursor: pointer;">
              Thay đổi
            </button>
          </div>
          <div style="margin-bottom: 1rem;">
            <strong style="color: #2c3e50; font-size: 1.1rem;">${
              selectedAddress.name
            }</strong>
            ${
              selectedAddress.isDefault
                ? '<span style="background: #e3f2fd; color: #4f9da6; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem; margin-left: 0.5rem; font-weight: 600;">Mặc định</span>'
                : ""
            }
          </div>
          <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 0.5rem; color: #555;">
            <i class="bi bi-telephone-fill" style="color: #4f9da6;"></i>
            <span>${selectedAddress.phone}</span>
          </div>
          <div style="display: flex; align-items: start; gap: 0.8rem; color: #555;">
            <i class="bi bi-house-door-fill" style="color: #4f9da6; margin-top: 0.2rem;"></i>
            <span style="line-height: 1.5;">${selectedAddress.address}</span>
          </div>
        </div>
        ${
          addresses.length > 1
            ? `
        <button onclick="toggleAddressList()" class="btn-change-address" style="width: 100%; margin-top: 1rem; padding: 0.7rem; background: white; border: 2px dashed #4f9da6; color: #4f9da6; border-radius: 8px; cursor: pointer; font-weight: 600;">
            <i class="bi bi-arrow-repeat"></i> Chọn địa chỉ khác
          </button>
          <div id="addressList" style="display: none; margin-top: 1rem; max-height: 300px; overflow-y: auto;">
            <h5 style="margin-bottom: 0.5rem; color: #555;">Địa chỉ khác đã lưu:</h5>
            ${addresses
              .filter((addr) => addr.id !== selectedAddress.id)
              .map(
                (addr) => `
              <div class="address-item" style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 0.8rem; cursor: pointer; border: 2px solid transparent; transition: all 0.3s;" onmouseover="this.style.borderColor='#82c09a'" onmouseout="this.style.borderColor='transparent'" onclick="selectAddress(${
                addr.id
              })">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                  <div style="flex: 1;">
                    <strong style="color: #2c3e50;">${addr.name}</strong>
                    ${
                      addr.isDefault
                        ? '<span style="background: #4caf50; color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; margin-left: 0.5rem;">Mặc định</span>'
                        : ""
                    }
                    <div style="color: #666; font-size: 0.9rem; margin-top: 0.3rem;">
                      <i class="bi bi-telephone"></i> ${addr.phone}
                    </div>
                    <div style="color: #666; font-size: 0.9rem; margin-top: 0.3rem;">
                      <i class="bi bi-house-door"></i> ${addr.address}
                    </div>
                  </div>
                  <button style="background: #ff6b6b; color: white; border: none; padding: 0.5rem; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem; margin-left: 1rem;" onclick="event.stopPropagation(); deleteAddress(${
                    addr.id
                  });">Xóa</button>
                </div>
              </div>
            `
              )
              .join("")}
          </div>
          `
            : ""
        }
      `;
    }

    function toggleAddressList() {
      const list = document.getElementById("addressList");
      const isShown = list.style.display === "block";
      list.style.display = isShown ? "none" : "block";
      localStorage.setItem(
        "bs_show_address_list",
        isShown ? "false" : "true"
      );
    }

    function selectAddress(addressId) {
      const addresses = getUserAddresses();
      const address = addresses.find((addr) => addr.id === addressId);
      if (address) {
        saveSelectedAddress(address);
        localStorage.setItem("bs_show_address_list", "false"); // Ẩn danh sách sau khi chọn
        renderCartSummary(); // Chỉ cần render summary để cập nhật địa chỉ
      }
    }

    function renderAddressManagementModal() {
      const addressManagementContent = document.getElementById(
        "addressManagementContent"
      );
      if (!addressManagementContent) return;

      const addresses = getUserAddresses();
      const maxAddresses = 3;
      const canAddMore = addresses.length < maxAddresses;

      addressManagementContent.innerHTML = `
        <button onclick="showAddAddressForm()" style="width: 100%; padding: 0.8rem; background: #4f9da6; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; margin-bottom: 1.5rem;" ${
          !canAddMore
            ? 'disabled style="opacity: 0.6; cursor: not-allowed;"'
            : ""
        }>
          <i class="bi bi-plus-circle"></i> Thêm địa chỉ mới
        </button>
        ${
          !canAddMore
            ? '<p style="color: #dc3545; text-align: center; margin-bottom: 1.5rem;">Bạn đã lưu tối đa 3 địa chỉ</p>'
            : ""
        }
        
        <div id="addAddressForm" style="display: none; background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
          <h4 style="margin-bottom: 1rem;">Thêm địa chỉ mới</h4>
          <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Họ và tên</label>
            <input type="text" id="newAddressName" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>
          <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Số điện thoại</label>
            <input type="tel" id="newAddressPhone" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 6px;">
          </div>
          <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Địa chỉ</label>
            <textarea id="newAddressAddress" rows="3" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 6px;"></textarea>
          </div>
          <div style="display: flex; gap: 0.5rem;">
            <button onclick="saveNewAddress()" style="flex: 1; padding: 0.7rem; background: #4caf50; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
              <i class="bi bi-check-circle"></i> Lưu
            </button>
            <button onclick="hideAddAddressForm()" style="flex: 1; padding: 0.7rem; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
              Hủy
            </button>
          </div>
        </div>

        <div id="addressListManagement">
          <h4 style="margin-bottom: 1rem;">Địa chỉ đã lưu (${
            addresses.length
          }/${maxAddresses})</h4>
          ${addresses
            .map(
              (addr) => `
            <div class="address-card" style="background: white; padding: 1.2rem; border-radius: 10px; margin-bottom: 1rem; border: 2px solid ${
              addr.isDefault ? "#4caf50" : "#e0e0e0"
            };">
              <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.8rem;">
                <div style="flex: 1;">
                  <strong style="font-size: 1.1rem; color: #2c3e50;">${
                    addr.name
                  }</strong>
                  <div style="color: #666; font-size: 0.95rem; margin-top: 0.3rem;"><i class="bi bi-telephone"></i> ${
                    addr.phone
                  }</div>
                  <div style="color: #666; font-size: 0.95rem; margin-top: 0.3rem;"><i class="bi bi-house-door"></i> ${
                    addr.address
                  }</div>
                </div>
                <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                  <button onclick="editAddress(${
                    addr.id
                  })" style="background: #2196f3; color: white; border: none; padding: 0.5rem 0.8rem; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem;">Sửa</button>
                  <button onclick="deleteAddress(${
                    addr.id
                  })" style="background: #ff6b6b; color: white; border: none; padding: 0.5rem 0.8rem; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.85rem;">Xóa</button>
                </div>
              </div>
              <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f0f0; padding-top: 0.8rem;">
                  ${
                    !addr.isDefault
                      ? `
                      <button onclick="setDefaultAddress(${addr.id})" style="background: #f0f0f0; color: #555; border: 1px solid #ccc; padding: 0.4rem 0.8rem; border-radius: 6px; cursor: pointer; font-size: 0.9rem; font-weight: 600;">
                          Đặt làm mặc định
                      </button>`
                      : ""
                  }
                  ${
                    addr.isDefault
                      ? '<span style="color: #4caf50; font-weight: 600;">Đang là địa chỉ mặc định</span>'
                      : ""
                  }
              </div>
            </div>
          `
            )
            .join("")}
        </div>
      `;
    }

    function showAddAddressForm() {
      document.getElementById("editAddressForm")?.remove(); // Xóa form sửa nếu có
      document.getElementById("addAddressForm").style.display = "block";
    }

    function hideAddAddressForm() {
      document.getElementById("addAddressForm").style.display = "none";
      document.getElementById("newAddressName").value = "";
      document.getElementById("newAddressPhone").value = "";
      document.getElementById("newAddressAddress").value = "";
    }

    function saveNewAddress() {
      const name = document.getElementById("newAddressName").value.trim();
      const phone = document.getElementById("newAddressPhone").value.trim();
      const address = document
        .getElementById("newAddressAddress")
        .value.trim();

      if (!name || !phone || !address) {
        alert("Vui lòng điền đầy đủ thông tin!");
        return;
      }

      // Validate số điện thoại (10 chữ số)
      const phoneRegex = /^[0-9]{10}$/;
      if (!phoneRegex.test(phone.replace(/\s/g, ""))) {
        alert("Số điện thoại phải có 10 chữ số!");
        return;
      }

      const addresses = getUserAddresses();
      if (addresses.length >= 3) {
        alert("Bạn chỉ có thể lưu tối đa 3 địa chỉ!");
        return;
      }

      const newAddress = {
        id: Date.now(),
        name,
        phone,
        address,
        isDefault: addresses.length === 0, // Địa chỉ đầu tiên sẽ là mặc định
      };

      addresses.push(newAddress);
      saveUserAddresses(addresses);

      if (addresses.length === 1) {
        saveSelectedAddress(newAddress);
      }

      closeAddressModal();
      // Dùng setTimeout để đảm bảo modal đóng trước khi mở lại và render cart
      setTimeout(() => {
        openAddressModal();
        renderCart();
      }, 100);
    }

    function setDefaultAddress(addressId) {
      const addresses = getUserAddresses();
      addresses.forEach((addr) => {
        addr.isDefault = addr.id === addressId;
      });
      saveUserAddresses(addresses);

      const selectedAddress = addresses.find((addr) => addr.id === addressId);
      saveSelectedAddress(selectedAddress);

      closeAddressModal();
      openAddressModal();
      renderCart();
    }

    function editAddress(addressId) {
      const addresses = getUserAddresses();
      const address = addresses.find((addr) => addr.id === addressId);
      if (!address) return;

      // Ẩn form thêm mới nếu đang mở
      const addForm = document.getElementById("addAddressForm");
      if (addForm) addForm.style.display = "none";

      // Kiểm tra xem form sửa đã tồn tại chưa
      let editForm = document.getElementById("editAddressForm");
      if (!editForm) {
        // Tạo form sửa mới
        editForm = document.createElement("div");
        editForm.id = "editAddressForm";
        editForm.style.cssText =
          "background: #e3f2fd; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; border: 2px solid #2196f3;";
        document.getElementById("addressListManagement").before(editForm);
      }

      editForm.innerHTML = `
        <h4 style="margin-bottom: 1rem; color: #2196f3;"><i class="bi bi-pencil-square"></i> Chỉnh sửa Địa chỉ</h4>
        <div style="margin-bottom: 1rem;">
          <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Họ và tên</label>
          <input type="text" id="editAddressName" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 6px;" value="${address.name}">
        </div>
        <div style="margin-bottom: 1rem;">
          <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Số điện thoại</label>
          <input type="tel" id="editAddressPhone" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 6px;" value="${address.phone}">
        </div>
        <div style="margin-bottom: 1rem;">
          <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Địa chỉ</label>
          <textarea id="editAddressAddress" rows="3" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 6px;">${address.address}</textarea>
        </div>
        <div style="display: flex; gap: 0.5rem;">
          <button onclick="saveEditAddress(${address.id})" style="flex: 1; padding: 0.7rem; background: #2196f3; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
            <i class="bi bi-check-circle"></i> Lưu thay đổi
          </button>
          <button onclick="cancelEditAddress()" style="flex: 1; padding: 0.7rem; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
            Hủy
          </button>
        </div>
      `;
      // Scroll đến form edit
      editForm.scrollIntoView({
        behavior: "smooth",
        block: "center"
      });
    }

    function saveEditAddress(addressId) {
      const name = document.getElementById("editAddressName").value.trim();
      const phone = document.getElementById("editAddressPhone").value.trim();
      const addressText = document
        .getElementById("editAddressAddress")
        .value.trim();

      if (!name || !phone || !addressText) {
        alert("Vui lòng điền đầy đủ thông tin!");
        return;
      }

      // Validate số điện thoại
      const phoneRegex = /^[0-9]{10}$/;
      if (!phoneRegex.test(phone.replace(/\s/g, ""))) {
        alert("Số điện thoại phải có 10 chữ số!");
        return;
      }

      const addresses = getUserAddresses();
      const address = addresses.find((addr) => addr.id === addressId);

      if (address) {
        address.name = name;
        address.phone = phone;
        address.address = addressText;
        saveUserAddresses(addresses);

        // Cập nhật địa chỉ được chọn nếu đang chọn địa chỉ này
        const selected = getSelectedAddress();
        if (selected && selected.id === addressId) {
          saveSelectedAddress(address);
        }

        // Đóng và mở lại modal để refresh
        closeAddressModal();
        setTimeout(() => {
          openAddressModal();
          renderCart(); // Cập nhật lại giỏ hàng
        }, 100);
      }
    }

    function cancelEditAddress() {
      const editForm = document.getElementById("editAddressForm");
      if (editForm) {
        editForm.remove();
      }
    }

    function deleteAddress(addressId) {
      if (!confirm("Bạn có chắc muốn xóa địa chỉ này?")) return;

      let addresses = getUserAddresses();
      const addressToDelete = addresses.find((addr) => addr.id === addressId);

      addresses = addresses.filter((addr) => addr.id !== addressId);
      saveUserAddresses(addresses);

      // Cập nhật địa chỉ được chọn nếu địa chỉ bị xóa đang được chọn
      const selected = getSelectedAddress();
      if (selected && selected.id === addressId) {
        // Nếu địa chỉ bị xóa là địa chỉ đang được chọn, chọn địa chỉ mặc định mới
        const newSelected =
          addresses.find((addr) => addr.isDefault) || addresses[0];
        saveSelectedAddress(newSelected || null);
      }

      // Đảm bảo phải có ít nhất 1 địa chỉ để checkout
      if (addresses.length === 0) {
        initDefaultAddress();
      }

      closeAddressModal();
      if (addresses.length > 0) {
        openAddressModal();
      }
      renderCart();
    }

    // ==================== CHỨC NĂNG THANH TOÁN ====================

    function checkout() {
      const {
        subtotal,
        totalItems,
        selectedCartData
      } = calculateTotals();

      if (totalItems === 0) {
        alert("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
        return;
      }

      const user = localStorage.getItem("bs_user");
      if (!user) {
        alert("Vui lòng Đăng nhập để tiếp tục thanh toán.");
        openLoginModal();
        return;
      }

      const shippingAddress = getSelectedAddress();
      if (!shippingAddress) {
        alert("Vui lòng chọn địa chỉ giao hàng!");
        openAddressModal();
        return;
      }

      // Lấy phương thức thanh toán đã chọn
      const paymentMethod = selectedPaymentMethod;
      if (!paymentMethod) {
        alert("Vui lòng chọn phương thức thanh toán!");
        return;
      }

      const orders = JSON.parse(localStorage.getItem("bs_orders") || "[]");
      const {
        total
      } = calculateTotals();

      const newOrder = {
        id: Date.now(),
        userId: JSON.parse(user).username,
        items: selectedCartData,
        total: total,
        shippingAddress: shippingAddress,
        paymentMethod: paymentMethod,
        date: new Date().toISOString(),
        status: "Chờ xử lý",
      };

      orders.push(newOrder);
      localStorage.setItem("bs_orders", JSON.stringify(orders));

      // ====================================================================
      // THÊM INLINE JS: Trừ số lượng sách còn lại (gọi hàm từ main.js)
      if (typeof updateProductStock === "function") {
        updateProductStock(selectedCartData);
      }
      // ====================================================================

      const selectedIds = selectedCartData.map((item) => item.id);
      const getCartFunc =
        typeof getCart === "function" ?
        getCart :
        () => JSON.parse(localStorage.getItem("bs_cart")) || [];
      const saveCartFunc =
        typeof saveCart === "function" ?
        saveCart :
        (c) => localStorage.setItem("bs_cart", JSON.stringify(c));
      let currentCart = getCartFunc();
      let newCart = currentCart.filter(
        (item) => !selectedIds.includes(item.id)
      );
      saveCartFunc(newCart); // Xóa sản phẩm đã mua khỏi localStorage

      // Cập nhật thông báo alert
      alert(
        `Đơn hàng #${
            newOrder.id
          } (${totalItems} mục) đã được tạo thành công! Tổng tiền: ${formatter.format(
            total
          )}. Phương thức thanh toán: ${paymentMethod}. Địa chỉ giao hàng: ${
            shippingAddress.address
          }. Cảm ơn bạn đã mua sắm!`
      );

      renderCart(); // Làm mới giao diện giỏ hàng
      if (typeof updateCartCount === "function") updateCartCount(); // Cập nhật lại số lượng giỏ hàng trên header
    }
    // ==================== HÀM MỞ/ĐÓNG MODAL ====================

    function openLoginModal() {
      closeRegisterModal();
      closeProfileModal();
      openModal("loginModal");
    }

    function closeLoginModal() {
      closeModal("loginModal");
    }

    function openRegisterModal() {
      closeLoginModal();
      closeProfileModal();
      openModal("registerModal");
    }

    function closeRegisterModal() {
      closeModal("registerModal");
    }

    function switchToRegister() {
      closeLoginModal();
      openRegisterModal();
    }

    function switchToLogin() {
      closeRegisterModal();
      openLoginModal();
    }

    function openProfileModal() {
      closeLoginModal();
      closeRegisterModal();

      const user = JSON.parse(localStorage.getItem("bs_user"));
      if (!user) return; // Should not happen if this function is called correctly

      document.getElementById(
        "profile-fullname"
      ).textContent = `Xin chào, ${user.fullName}!`;
      document.getElementById("profile-name-value").textContent =
        user.fullName;
      document.getElementById("profile-username-value").textContent =
        user.username;
      document.getElementById("profile-email-value").textContent = user.email;
      document.getElementById("profile-phone-value").textContent = user.phone;
      document.getElementById("profile-address-value").textContent =
        user.address;

      openModal("profileModal");
    }

    function closeProfileModal() {
      closeModal("profileModal");
    }

    function handleLogoutModal() {
      localStorage.removeItem("bs_user");
      localStorage.removeItem("bs_login_status");

      // Đóng modal profile
      closeProfileModal();

      // Cập nhật giao diện header
      if (typeof checkLoginStatus === "function") checkLoginStatus();

      // Cập nhật giỏ hàng nếu cần
      renderCart();
    }

    function openAddressModal() {
      if (!localStorage.getItem("bs_user")) {
        alert("Vui lòng đăng nhập để quản lý địa chỉ.");
        openLoginModal();
        return;
      }
      renderAddressManagementModal();
      openModal("addressModal");
    }

    function closeAddressModal() {
      closeModal("addressModal");
    }

    // Khởi tạo
    document.addEventListener("DOMContentLoaded", () => {
      renderCart();
      if (typeof updateCartCount === "function") updateCartCount();
      // Khởi tạo địa chỉ mặc định khi tải trang (nếu đã đăng nhập)
      if (localStorage.getItem("bs_user")) {
        initDefaultAddress();
      }
    });
  </script>
</body>

</html>