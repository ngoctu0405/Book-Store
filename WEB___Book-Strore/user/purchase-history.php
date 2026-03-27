<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lịch sử mua hàng - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link
    rel="stylesheet"
    href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <style>
    body {
      background: linear-gradient(135deg,
          #f5f2e8 0%,
          #e8d5b7 50%,
          #7fb3d3 100%);
      color: #2c3e50;
      min-height: 100vh;
    }

    .container {
      position: relative;
      max-width: 1400px;
      margin: 5rem auto;
    }

    .page-heading {
      font-size: 2.5rem;
      font-weight: 700;
      color: #2c3e50;
      margin-top: 70px;
      margin-bottom: 2rem;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
    }

    .history-container {
      background: white;
      border-radius: 24px;
      padding: 3rem;
      box-shadow: 0 10px 40px rgba(79, 157, 166, 0.15);
      border: 1px solid rgba(130, 192, 154, 0.2);
      min-height: 400px;
    }

    /* Filter Section */
    .filter-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1.5rem;
      border-bottom: 2px solid #f0f0f0;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .section-title {
      font-size: 1.6rem;
      color: #2c3e50;
      font-weight: 700;
    }

    .order-stats {
      display: flex;
      gap: 1rem;
      font-size: 1.2rem;
      color: #2c3e50;
      font-weight: 600;
    }

    .order-stats strong {
      color: #4f9da6;
      font-size: 1.3rem;
    }

    /* Order Card */
    .order-card {
      background: linear-gradient(145deg, #ffffff 0%, #fafafa 100%);
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 1.5rem;
      border: 2px solid transparent;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .order-card:hover {
      transform: translateX(8px);
      box-shadow: 0 8px 24px rgba(79, 157, 166, 0.15);
      border-color: rgba(79, 157, 166, 0.3);
    }

    .order-header {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #f0f0f0;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .order-id-wrapper {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .order-id {
      font-size: 1.4rem;
      font-weight: 700;
      color: #2c3e50;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .order-id span {
      color: #4f9da6;
    }

    .order-date {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: #7f8c8d;
      font-size: 0.95rem;
    }

    /* Order Items Preview */
    .order-items-preview {
      background: rgba(79, 157, 166, 0.05);
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .preview-item {
      display: grid;
      grid-template-columns: 80px 1fr auto;
      align-items: center;
      gap: 1.5rem;
      padding: 1rem 0;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .preview-item:last-child {
      border-bottom: none;
    }

    .preview-image {
      width: 80px;
      height: 100px;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .preview-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .preview-info {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
    }

    .preview-name {
      font-weight: 700;
      color: #2c3e50;
      font-size: 1.1rem;
    }

    .preview-author {
      font-size: 0.9rem;
      color: #7f8c8d;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .preview-price-info {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 0.4rem;
    }

    .preview-quantity {
      font-size: 0.95rem;
      color: #666;
      font-weight: 600;
    }

    .preview-total {
      font-weight: 700;
      color: #e74c3c;
      font-size: 1.2rem;
    }

    .more-items-notice {
      text-align: center;
      color: #7f8c8d;
      font-style: italic;
      padding-top: 1rem;
      font-size: 0.95rem;
    }

    /* Order Footer */
    .order-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1.5rem;
      border-top: 2px solid #f0f0f0;
      flex-wrap: wrap;
      gap: 1.5rem;
    }

    .order-total {
      font-size: 1.6rem;
      font-weight: 700;
      color: #4f9da6;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .order-actions {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .btn-action {
      padding: 0.8rem 1.5rem;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
      display: flex;
      align-items: center;
      gap: 0.6rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-detail {
      background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
      color: white;
    }

    .btn-detail:hover {
      transform: scale(1.05);
      box-shadow: 0 5px 15px rgba(79, 157, 166, 0.4);
    }

    .btn-reorder {
      background: linear-gradient(135deg, #ff7f50 0%, #ff4500 100%);
      color: white;
    }

    .btn-reorder:hover {
      transform: scale(1.05);
      box-shadow: 0 5px 15px rgba(255, 99, 71, 0.4);
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 5rem 2rem;
    }

    .empty-state-icon {
      font-size: 6rem;
      margin-bottom: 1.5rem;
      opacity: 0.4;
    }

    .empty-state h3 {
      color: #2c3e50;
      font-size: 2rem;
      margin-bottom: 1rem;
      font-weight: 700;
    }

    .empty-state p {
      color: #7f8c8d;
      font-size: 1.1rem;
      margin-bottom: 2.5rem;
    }

    .btn-continue {
      display: inline-block;
      padding: 1.2rem 2.5rem;
      background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
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

    /* Modal Styles */
    .order-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      z-index: 1000;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .order-modal.active {
      display: flex;
    }

    .modal-content {
      background: white;
      border-radius: 24px;
      padding: 3rem;
      max-width: 900px;
      width: 100%;
      max-height: 85vh;
      overflow-y: auto;
      position: relative;
      animation: slideIn 0.3s ease;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    @keyframes slideIn {
      from {
        transform: translateY(-50px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .modal-close {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      font-size: 2rem;
      cursor: pointer;
      color: #666;
      transition: all 0.3s;
      background: none;
      border: none;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }

    .modal-close:hover {
      color: #333;
      background: #f0f0f0;
      transform: rotate(90deg);
    }

    .modal-header {
      margin-bottom: 2rem;
      padding-bottom: 1.5rem;
      border-bottom: 2px solid #f0f0f0;
    }

    .modal-header h2 {
      color: #4f9da6;
      font-size: 2rem;
      margin-bottom: 0.5rem;
      font-weight: 700;
    }

    .modal-order-info {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
      margin-bottom: 2rem;
      padding: 1.5rem;
      background: linear-gradient(135deg, #f0f8f7 0%, #e6f4f1 100%);
      border-radius: 12px;
    }

    .info-item {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
    }

    .info-label {
      font-size: 0.85rem;
      color: #7f8c8d;
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .info-value {
      font-size: 1.15rem;
      color: #2c3e50;
      font-weight: 600;
    }

    .modal-items-section {
      margin-top: 2rem;
    }

    .modal-items-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .modal-items-header {
      display: grid;
      grid-template-columns: 100px 2fr 1fr 1.5fr;
      gap: 1rem;
      padding: 1rem;
      background: #f8f9fa;
      border-radius: 8px;
      font-weight: 700;
      color: #7f8c8d;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    .modal-items-header span:nth-child(3),
    .modal-items-header span:nth-child(4) {
      text-align: right;
    }

    .modal-item {
      display: grid;
      grid-template-columns: 100px 2fr 1fr 1.5fr;
      gap: 1rem;
      padding: 1.5rem 1rem;
      border-bottom: 1px solid #e9ecef;
      align-items: center;
    }

    .modal-item:last-child {
      border-bottom: none;
    }

    .modal-item-image {
      width: 100px;
      height: 130px;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modal-item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .modal-item-info {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .modal-item-name {
      font-weight: 700;
      color: #2c3e50;
      font-size: 1.1rem;
      line-height: 1.4;
    }

    .modal-item-author {
      color: #7f8c8d;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .modal-item-price {
      color: #666;
      font-size: 0.95rem;
      margin-top: 0.3rem;
    }

    .modal-item-quantity {
      text-align: right;
      font-weight: 600;
      color: #4f9da6;
      font-size: 1.1rem;
    }

    .modal-item-total {
      text-align: right;
      font-weight: 700;
      color: #e74c3c;
      font-size: 1.3rem;
    }

    .modal-summary {
      margin-top: 2rem;
      padding: 1.5rem;
      background: linear-gradient(135deg, #f0f8f7 0%, #e6f4f1 100%);
      border-radius: 12px;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.8rem 0;
      font-size: 1.1rem;
    }

    .summary-row.subtotal {
      color: #2c3e50;
      font-weight: 600;
    }

    .summary-row.shipping {
      color: #2c3e50;
      font-weight: 600;
    }

    .summary-row.shipping .text-success {
      color: #27ae60 !important;
      font-weight: 700;
    }

    .summary-row.total {
      font-size: 1.6rem;
      font-weight: 700;
      color: #4f9da6;
      border-top: 2px solid #ddd;
      margin-top: 1rem;
      padding-top: 1.5rem;
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
    <h2 class="page-heading">
      <span>📦</span>
      Lịch sử mua hàng
    </h2>

    <div class="history-container">
      <div class="filter-section">
        <div class="section-title">Thông tin chi tiết</div>
        <div class="order-stats">
          <span>Tổng đơn hàng: <strong id="totalOrders">0</strong></span>
        </div>
      </div>

      <div id="orderList"></div>
    </div>
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

  <div id="orderModal" class="order-modal">
    <div class="modal-content">
      <button class="modal-close" onclick="closeOrderModal()">&times;</button>
      <div id="modalBody"></div>
    </div>
  </div>

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
          <label for="login-username">Tài khoản</label>
          <div class="input-with-icon">
            <span class="input-icon">👤</span>
            <input
              type="text"
              id="login-username"
              placeholder="Nhập tài khoản" />
          </div>
          <span id="error-login-username" class="error-msg"></span>
        </div>

        <div class="form-group">
          <label for="login-password">Mật khẩu</label>
          <div class="input-with-icon">
            <span class="input-icon">🔐</span>
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
          <label for="reg-username">Tên tài khoản</label>
          <div class="input-with-icon">
            <span class="input-icon">🔑</span>
            <input
              type="text"
              id="reg-username"
              placeholder="Nhập tên tài khoản" />
          </div>
          <span id="error-username" class="error-msg"></span>
        </div>

        <div class="form-group">
          <label for="reg-password">Mật khẩu</label>
          <div class="input-with-icon">
            <span class="input-icon">🔐</span>
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
            <span class="input-icon">🔐</span>
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

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>

  <script>
    const formatter = new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
      minimumFractionDigits: 0,
    });

    let allOrders = [];

    function getProductById(productId) {
      const data = JSON.parse(localStorage.getItem("bs_data"));
      if (!data || !data.products) return null;
      return data.products.find((p) => p.id === productId);
    }

    function formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString("vi-VN", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });
    }

    function renderOrders() {
      const orderList = document.getElementById("orderList");
      if (!orderList) return;

      const orders = JSON.parse(localStorage.getItem("bs_orders") || "[]");

      orders.sort((a, b) => new Date(b.date) - new Date(a.date));
      allOrders = orders;

      document.getElementById("totalOrders").textContent = orders.length;

      if (orders.length === 0) {
        orderList.innerHTML = `
          <div class="empty-state">
            <div class="empty-state-icon">🔭</div>
            <h3>Chưa có đơn hàng nào</h3>
            <p>Hãy bắt đầu mua sắm ngay!</p>
            <a href="index.php" class="btn-continue">Tiếp tục mua sắm</a>
          </div>
        `;
        return;
      }

      const ordersHtml = orders
        .map((order) => {
          const itemsPreview = order.items.slice(0, 3);
          const moreItems =
            order.items.length > 3 ? order.items.length - 3 : 0;

          return `
          <div class="order-card">
            <div class="order-header">
              <div class="order-id-wrapper">
                <div class="order-id">Đơn hàng: <span>#${order.id}</span></div>
                <div class="order-date">
                  <i class="bi bi-calendar"></i>
                  ${formatDate(order.date)}
                </div>
              </div>
            </div>

            <div class="order-items-preview">
              ${itemsPreview
                .map((item) => {
                  const product = getProductById(item.id);
                  if (!product) return "";
                  return `
                  <div class="preview-item">
                    <div class="preview-image">
                      <img src="${product.img}" alt="${product.name}">
                    </div>
                    <div class="preview-info">
                      <div class="preview-name">${product.name}</div>
                      <div class="preview-author"><i class="bi bi-person"></i> ${
                        product.author
                      }</div>
                    </div>
                    <div class="preview-price-info">
                      <div class="preview-quantity">x${item.qty}</div>
                      <div class="preview-total">${formatter.format(
                        product.price * item.qty
                      )}</div>
                    </div>
                  </div>
                `;
                })
                .join("")}
              ${
                moreItems > 0
                  ? `
                <div class="more-items-notice">
                  và ${moreItems} sản phẩm khác...
                </div>
              `
                  : ""
              }
            </div>

            <div class="order-footer">
              <div class="order-total">
                <i class="bi bi-cash-coin"></i>
                Tổng cộng: ${formatter.format(order.total)}
              </div>
              <div class="order-actions">
                <button class="btn-action btn-detail" onclick='showOrderDetail(${JSON.stringify(
                  order
                ).replace(/'/g, "&#39;")})'>
                  <i class="bi bi-eye"></i> Xem chi tiết
                </button>
                <button class="btn-action btn-reorder" onclick="reorder(${
                  order.id
                })">
                  <i class="bi bi-arrow-repeat"></i> Mua lại
                </button>
              </div>
            </div>
          </div>
        `;
        })
        .join("");

      orderList.innerHTML = ordersHtml;
    }

    function showOrderDetail(order) {
      const modal = document.getElementById("orderModal");
      const modalBody = document.getElementById("modalBody");

      const SHIPPING_THRESHOLD = 500000;
      const STANDARD_SHIPPING_FEE = 30000;

      let calculatedSubtotal = 0;

      order.items.forEach((item) => {
        const product = getProductById(item.id);
        if (product) {
          calculatedSubtotal += product.price * item.qty;
        }
      });

      const shippingFee =
        calculatedSubtotal >= SHIPPING_THRESHOLD ? 0 : STANDARD_SHIPPING_FEE;

      const itemsHtml = order.items
        .map((item) => {
          const product = getProductById(item.id);
          if (!product) return "";
          return `
          <div class="modal-item">
            <div class="modal-item-image">
              <img src="${product.img}" alt="${product.name}">
            </div>
            <div class="modal-item-info">
              <div class="modal-item-name">${product.name}</div>
              <div class="modal-item-author"><i class="bi bi-person"></i> ${
                product.author
              }</div>
              <div class="modal-item-price">Đơn giá: ${formatter.format(
                product.price
              )}</div>
            </div>
            <div class="modal-item-quantity">x${item.qty}</div>
            <div class="modal-item-total">${formatter.format(
              product.price * item.qty
            )}</div>
          </div>
        `;
        })
        .join("");

      const shippingAddress = order.shippingAddress || null;

      modalBody.innerHTML = `
        <div class="modal-header">
          <h2>Chi tiết đơn hàng #${order.id}</h2>
        </div>

        <div class="modal-order-info">
          <div class="info-item">
            <div class="info-label">Mã đơn hàng</div>
            <div class="info-value">#${order.id}</div>
          </div>
          <div class="info-item">
            <div class="info-label">Ngày đặt</div>
            <div class="info-value">${formatDate(order.date)}</div>
          </div>
          <div class="info-item">
            <div class="info-label">Phương thức TT</div>
            <div class="info-value">${order.paymentMethod || "Không rõ"}</div>
          </div>
          <div class="info-item">
            <div class="info-label">Tổng tiền</div>
            <div class="info-value" style="color: #4f9da6;">${formatter.format(
              order.total
            )}</div>
          </div>
        </div>

        ${
          shippingAddress
            ? `
          <div class="shipping-address-info" style="background: linear-gradient(135deg, #fff8e1 0%, #ffe6cc 100%); padding: 1.5rem; border-radius: 12px; margin: 2rem 0; border-left: 4px solid #ff9800;">
            <h3 style="margin: 0 0 1rem 0; color: #2c3e50; font-size: 1.3rem; display: flex; align-items: center; gap: 0.5rem;">
              <i class="bi bi-geo-alt-fill" style="color: #ff9800;"></i> Thông tin giao hàng
            </h3>
            <div style="display: grid; gap: 0.8rem;">
              <div style="display: flex; align-items: center; gap: 0.8rem;">
                <i class="bi bi-person-fill" style="color: #ff9800; font-size: 1.1rem;"></i>
                <div>
                  <span style="font-weight: 600; color: #666; font-size: 0.9rem; display: block;">Người nhận:</span>
                  <strong style="font-size: 1.1rem; color: #2c3e50;">${shippingAddress.name}</strong>
                </div>
              </div>
              <div style="display: flex; align-items: center; gap: 0.8rem;">
                <i class="bi bi-telephone-fill" style="color: #ff9800; font-size: 1.1rem;"></i>
                <div>
                  <span style="font-weight: 600; color: #666; font-size: 0.9rem; display: block;">Số điện thoại:</span>
                  <strong style="font-size: 1.1rem; color: #2c3e50;">${shippingAddress.phone}</strong>
                </div>
              </div>
              <div style="display: flex; align-items: start; gap: 0.8rem;">
                <i class="bi bi-house-door-fill" style="color: #ff9800; font-size: 1.1rem; margin-top: 0.2rem;"></i>
                <div>
                  <span style="font-weight: 600; color: #666; font-size: 0.9rem; display: block;">Địa chỉ giao hàng:</span>
                  <strong style="font-size: 1.05rem; color: #2c3e50; line-height: 1.5;">${shippingAddress.address}</strong>
                </div>
              </div>
            </div>
          </div>
        `
            : `
          <div class="shipping-address-info" style="background: #fff3cd; padding: 1.5rem; border-radius: 12px; margin: 2rem 0; border-left: 4px solid #ffc107;">
            <p style="margin: 0; color: #856404; display: flex; align-items: center; gap: 0.5rem;">
              <i class="bi bi-exclamation-triangle"></i> 
              <span>Đơn hàng này chưa có thông tin địa chỉ giao hàng</span>
            </p>
          </div>
        `
        }

        <div class="modal-items-section">
          <h3 class="modal-items-title"><i class="bi bi-box-seam"></i> Danh sách sản phẩm</h3>
          <div class="modal-items-header">
            <span>Hình ảnh</span>
            <span>Sản phẩm</span>
            <span>Số lượng</span>
            <span>Thành tiền</span>
          </div>
          ${itemsHtml}
        </div>

        <div class="modal-summary">
          <div class="summary-row subtotal">
            <span>Tạm tính:</span>
            <span>${formatter.format(calculatedSubtotal)}</span>
          </div>
          <div class="summary-row shipping">
            <span>Phí vận chuyển:</span>
            <span class="${shippingFee === 0 ? "text-success" : ""}">
              ${
                shippingFee === 0 ? "Miễn phí ✓" : formatter.format(shippingFee)
              }
            </span>
          </div>
          <div class="summary-row total">
            <span>Tổng cộng:</span>
            <span>${formatter.format(order.total)}</span>
          </div>
        </div>
      `;

      modal.classList.add("active");
    }

    function closeOrderModal() {
      document.getElementById("orderModal").classList.remove("active");
    }

    function reorder(orderId) {
      const order = allOrders.find((o) => o.id === orderId);
      if (!order) {
        alert("Không tìm thấy đơn hàng!");
        return;
      }

      if (
        confirm(
          `Bạn có muốn mua lại ${order.items.length} sản phẩm từ đơn hàng #${orderId}?`
        )
      ) {
        const cart = JSON.parse(localStorage.getItem("bs_cart") || "[]");

        order.items.forEach((item) => {
          const existingItem = cart.find((c) => c.id === item.id);
          if (existingItem) {
            existingItem.qty += item.qty;
          } else {
            cart.push({
              id: item.id,
              qty: item.qty
            });
          }
        });

        localStorage.setItem("bs_cart", JSON.stringify(cart));

        if (typeof updateCartCount === "function") {
          updateCartCount();
        }

        alert("✅ Đã thêm tất cả sản phẩm vào giỏ hàng!");
        window.location.href = "cart.php";
      }
    }

    document
      .getElementById("orderModal")
      .addEventListener("click", function(e) {
        if (e.target === this) {
          closeOrderModal();
        }
      });

    document.addEventListener("DOMContentLoaded", function() {
      const user = localStorage.getItem("bs_user");
      if (!user) {
        alert("Vui lòng đăng nhập để xem lịch sử mua hàng!");
        window.location.href = "index.php";
        return;
      }

      renderOrders();

      if (typeof updateCartCount === "function") updateCartCount();
      if (typeof updateAuthUI === "function") updateAuthUI();
      if (typeof loadSearchQuery === "function") loadSearchQuery();
    });
  </script>
</body>

</html>