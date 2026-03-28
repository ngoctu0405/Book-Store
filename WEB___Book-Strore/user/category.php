<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Nhà Sách Online</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link
    rel="stylesheet"
    href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />

  <style>
    .container {
      margin: 5rem auto;
    }

    /* Container chính cho bộ lọc nâng cao */
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

    /* Item chứa mỗi bộ lọc */
    .filter-item {
      position: relative;
      display: inline-block;
    }

    /* Nút bộ lọc */
    .filter-btn {
      background: #ffffff;
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

    .filter-btn:active {
      transform: translateY(0);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Dropdown menu */
    .filter-dropdown {
      list-style-type: none;
      padding: 16px 0 8px 0;
      margin: 0;
      position: absolute;
      top: 100%;
      left: 0;
      z-index: 1000;
      background-color: #ffffff;
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

    /* Item trong dropdown */
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

    .filter-dropdown li a:hover {
      background: linear-gradient(90deg, #e3f2fd 0%, #bbdefb 100%);
      color: #1976d2;
      padding-left: 24px;
    }

    .filter-dropdown li:first-child a {
      border-radius: 8px 8px 0 0;
    }

    .filter-dropdown li:last-child a {
      border-radius: 0 0 8px 8px;
    }

    /* Bổ sung CSS cho lọc khoảng giá */
    .price-range-dropdown {
      list-style-type: none !important;
      padding: 15px !important;
      min-width: 250px !important;
      transition: none !important;
    }

    .price-range-dropdown input[type="number"] {
      box-sizing: border-box;
    }

    /* Nút xóa tìm kiếm nâng cao */
    .clear-filters-btn {
      margin-left: auto;
      text-decoration: none;
      color: black;
      padding: 10px 18px;
      border: 2px solid #dc3545;
      color: rgb(255, 255, 255);
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 700;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      box-shadow: 0 2px 4px rgba(10, 9, 10, 0.1);
    }

    .clear-filters-btn:hover {
      background-color: #c82333;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(15, 0, 2, 0.3);
    }

    .clear-filters-btn:active {
      transform: translateY(0);
      box-shadow: 0 2px 4px rgba(7, 0, 1, 0.1);
    }

    .clear-filters-btn.active-clear {
      background-color: #dc3545;
      color: #000000;
      border-color: #dc3545;
      font-weight: 900;
    }

    /* Phần hiển thị bộ lọc đã chọn */
    .selected-filters {
      padding: 15px 20px;
      margin: 0 0 20px 0;
      background: #fff3cd;
      border-left: 4px solid #ffc107;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .selected-filters h1 {
      font-size: 16px;
      font-weight: 600;
      color: #856404;
      margin: 0;
      padding: 0;
    }

    .selected-filters .filter-tag {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #ffffff;
      color: #495057;
      padding: 6px 12px;
      margin: 5px 5px 0 0;
      border-radius: 6px;
      font-size: 13px;
      border: 1px solid #dee2e6;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .selected-filters .filter-tag .remove-filter {
      cursor: pointer;
      color: #dc3545;
      font-weight: bold;
      transition: color 0.2s;
    }

    .selected-filters .filter-tag .remove-filter:hover {
      color: #bd2130;
    }

    /* Responsive */
    @media (max-width: 767px) {
      .advanced-filters {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
        padding: 15px;
      }

      .filter-item {
        width: 100%;
      }

      .filter-btn {
        width: 100%;
        justify-content: space-between;
      }

      .filter-dropdown {
        width: 100%;
        min-width: auto;
      }

      .clear-filters-btn {
        width: 100%;
        justify-content: center;
        margin-left: 0;
      }

      .products-grid {
        grid-template-columns: 1fr;
        gap: 20px;
        padding: 10px;
      }

      .product-card {
        min-height: auto;
      }

      /* Footer */
      .footer-section {
        text-align: center;
      }

      .footer-section .social-links {
        justify-content: center;
      }

      .footer-section.contact-info p {
        justify-content: center;
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
    <div class="products-top">
      <button
        class="breadcrumb-btn"
        id="breadcrumb-category"
        onclick="window.location.href='category.php'">
        Tất cả sách
      </button>
    </div>

    <div class="advanced-filters">
      <div class="filter-item">
        <button class="filter-btn">Theo thể loại ▾</button>
        <ul class="filter-dropdown" id="subcategory-dropdown"></ul>
      </div>

      <div class="filter-item">
        <button class="filter-btn" id="name-search-btn">
          Theo tên sách ▾
        </button>
        <div
          class="filter-dropdown price-range-dropdown"
          style="padding: 15px; min-width: 250px">
          <div style="margin-bottom: 10px">
            <label
              for="search-name"
              style="display: block; font-size: 14px; margin-bottom: 5px">Nhập tên sách</label>
            <input
              type="text"
              id="search-name"
              placeholder="Ví dụ: Hoàng tử bé"
              style="
                  width: 100%;
                  padding: 8px;
                  border: 1px solid #ccc;
                  border-radius: 4px;
                " />
          </div>
          <button
            id="apply-name-search"
            style="
                width: 100%;
                padding: 10px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-top: 10px;
                font-weight: 600;
              ">
            Áp dụng
          </button>
        </div>
      </div>

      <div class="filter-item">
        <button class="filter-btn" id="author-search-btn">
          Theo tác giả ▾
        </button>
        <div
          class="filter-dropdown price-range-dropdown"
          style="padding: 15px; min-width: 250px">
          <div style="margin-bottom: 10px">
            <label
              for="search-author"
              style="display: block; font-size: 14px; margin-bottom: 5px">Nhập tên tác giả</label>
            <input
              type="text"
              id="search-author"
              placeholder="Ví dụ: Nguyễn Nhật Ánh"
              style="
                  width: 100%;
                  padding: 8px;
                  border: 1px solid #ccc;
                  border-radius: 4px;
                " />
          </div>
          <button
            id="apply-author-search"
            style="
                width: 100%;
                padding: 10px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-top: 10px;
                font-weight: 600;
              ">
            Áp dụng
          </button>
        </div>
      </div>

      <div class="filter-item">
        <button class="filter-btn" id="price-filter-btn">
          Theo giá (khoảng) ▾
        </button>
        <div
          class="filter-dropdown price-range-dropdown"
          style="padding: 15px; min-width: 250px">
          <div style="margin-bottom: 10px">
            <label
              for="min-price"
              style="display: block; font-size: 14px; margin-bottom: 5px">Giá Tối Thiểu (₫)</label>
            <input
              type="text"
              id="min-price"
              placeholder="Ví dụ: 50.000"
              style="
                  width: 100%;
                  padding: 8px;
                  border: 1px solid #ccc;
                  border-radius: 4px;
                " />
          </div>
          <div style="margin-bottom: 10px">
            <label
              for="max-price"
              style="display: block; font-size: 14px; margin-bottom: 5px">Giá Tối Đa (₫)</label>
            <input
              type="text"
              id="max-price"
              placeholder="Ví dụ: 200.000"
              style="
                  width: 100%;
                  padding: 8px;
                  border: 1px solid #ccc;
                  border-radius: 4px;
                " />
          </div>
          <button
            id="apply-price-filter"
            style="
                width: 100%;
                padding: 10px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-top: 10px;
                font-weight: 600;
              ">
            Áp dụng
          </button>
        </div>
      </div>
      <a href="./category.php" class="clear-filters-btn">Xóa tất cả tìm kiếm nâng cao</a>
    </div>

    <div class="selected-filters" id="selectedFilters">
      <h1>Tìm kiếm nâng cao:</h1>
    </div>

    <div id="product-list" class="products-grid"></div>

    <div id="pagination" class="pagination"></div>
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
            <span class="input-icon">🔒</span>
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
            <span class="input-icon">🔑</span>
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
            <span class="input-icon">🔒</span>
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
            <span class="input-icon">🔒</span>
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

  <script src="../assets/js/main.js?v=2"></script>
  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
    </i>
  </a>

  <script>
    // Biến toàn cục để lưu trạng thái filter
    let categoryFilters = {
      searchName: "", // ĐÃ THAY ĐỔI: Tìm kiếm theo tên (từ khóa)
      searchAuthor: "", // ĐÃ THAY ĐỔI: Tìm kiếm theo tác giả (từ khóa)
      minPrice: null,
      maxPrice: null,
      category: null,
      subcategory: null,
      filterSubcategory: null, // THÊM MỚI: Lọc theo subcategory từ dropdown
    };

    // Khởi tạo trang category
    function initCategoryPage() {
      console.log("Initializing category page...");

      // Đọc URL params
      const urlParams = new URLSearchParams(window.location.search);
      categoryFilters.category = urlParams.get("category");
      categoryFilters.subcategory = urlParams.get("subcategory");

      console.log("URL Filters:", categoryFilters);

      // Cập nhật breadcrumb
      updateCategoryBreadcrumb();

      // Setup event listeners
      setupCategoryFilterListeners();

      // ✅ Populate subcategory dropdown
      populateSubcategoryDropdown();

      // Load và hiển thị sản phẩm
      applyCategoryFilters();

      // Cập nhật UI
      updateSelectedFilters();
      updateClearButton();
    }

    // Cập nhật breadcrumb
    function updateCategoryBreadcrumb() {
      const breadcrumbBtn = document.getElementById("breadcrumb-category");
      if (!breadcrumbBtn) return;

      if (!categoryFilters.category) {
        breadcrumbBtn.textContent = "Tất cả sách";
      } else if (categoryFilters.subcategory) {
        breadcrumbBtn.textContent = `Danh mục sách > ${categoryFilters.category} > ${categoryFilters.subcategory}`;
      } else {
        breadcrumbBtn.textContent = `Danh mục sách > ${categoryFilters.category}`;
      }
    }

    // ✅ THÊM MỚI: Hàm lấy dữ liệu Category từ Local Storage
    // HÀM NÀY CẦN PHẢI ĐƯỢC ĐỊNH NGHĨA TRONG main.js CÙNG VỚI HẰNG SỐ CATEGORIES_STORAGE_KEY
    function getCategoriesFromStorage() {
      // Lưu ý: Cần đảm bảo hằng số CATEGORIES_STORAGE_KEY được định nghĩa trong main.js
      const storedData = localStorage.getItem("admin_categories_data");
      let categories;
      try {
        // Trả về dữ liệu đã lưu nếu tồn tại, ngược lại trả về mảng rỗng
        categories = storedData ? JSON.parse(storedData) : [];
      } catch (e) {
        console.error(
          "Lỗi khi phân tích dữ liệu categories từ localStorage:",
          e
        );
        return [];
      }
      return categories;
    }

    // ✅ CẬP NHẬT: Populate subcategory dropdown dựa trên dữ liệu từ Local Storage
    function populateSubcategoryDropdown() {
      const subcategoryDropdown = document.getElementById(
        "subcategory-dropdown"
      );
      if (!subcategoryDropdown) {
        console.error("Subcategory dropdown not found!");
        return;
      }

      // Lấy dữ liệu category từ Local Storage
      const allCategories = getCategoriesFromStorage();
      // Lọc ra các category đang 'active'
      const activeCategories = allCategories.filter(
        (cat) => cat.status === "active"
      );

      // Tập hợp tất cả subcategory duy nhất từ các category đang active
      const allSubcategories = [];
      activeCategories.forEach((cat) => {
        cat.subcategories.forEach((sub) => {
          // Chỉ thêm vào nếu subcategory chưa có trong danh sách
          if (!allSubcategories.includes(sub)) {
            allSubcategories.push(sub);
          }
        });
      });

      // Sắp xếp các subcategory
      allSubcategories.sort((a, b) => a.localeCompare(b, "vi"));

      console.log("Found subcategories for filter:", allSubcategories);

      // Tạo HTML cho dropdown
      let html =
        '<li><a href="#" data-subcategory="">✨ Tất cả thể loại</a></li>';

      allSubcategories.forEach((sub) => {
        let displayName = sub;
        // Thêm prefix "GK " cho các cấp học (giữ nguyên logic gốc)
        if (sub === "Cấp 1" || sub === "Cấp 2" || sub === "Cấp 3") {
          displayName = "GK " + sub;
        }
        html += `<li><a href="#" data-subcategory="${sub}">📚 ${displayName}</a></li>`;
      });

      subcategoryDropdown.innerHTML = html;

      // Gán sự kiện click cho các link (giữ nguyên logic gốc)
      subcategoryDropdown.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", (e) => {
          e.preventDefault();
          const selectedSub = link.getAttribute("data-subcategory");
          categoryFilters.filterSubcategory = selectedSub || null;

          console.log(
            "Subcategory filter selected:",
            categoryFilters.filterSubcategory
          );

          applyCategoryFilters();
          updateSelectedFilters();
          updateClearButton();
        });
      });

      console.log(
        "Subcategory dropdown populated successfully from Local Storage data"
      );
    }

    // Setup event listeners
    // Setup event listeners
    function setupCategoryFilterListeners() {
      console.log("Setting up filter listeners...");

      // === BẮT ĐẦU THÊM MỚI: LOGIC CLICK ĐỂ MỞ FILTER DROPDOWN ===
      const filterButtons = document.querySelectorAll(".filter-btn");
      const allFilterItems = document.querySelectorAll(".filter-item");

      filterButtons.forEach((button) => {
        button.addEventListener("click", function(event) {
          event.stopPropagation(); // Ngăn sự kiện lan ra document

          const parentItem = button.closest(".filter-item");
          // Kiểm tra xem nó đã mở hay chưa
          const wasOpen = parentItem.classList.contains("open");

          // 1. Đóng tất cả các dropdown khác
          allFilterItems.forEach((item) => {
            item.classList.remove("open");
          });

          // 2. Nếu nó chưa mở, thì mở nó ra
          if (!wasOpen) {
            parentItem.classList.add("open");
          }
          // (Nếu nó đã mở, bước 1 đã đóng nó rồi, tạo hiệu ứng toggle)
        });
      });

      // Thêm sự kiện click bên ngoài để đóng
      document.addEventListener("click", function(event) {
        const clickedInsideItem = event.target.closest(".filter-item");
        // Tìm các nút "Áp dụng"
        const applyButton = event.target.closest(
          "#apply-name-search, #apply-author-search, #apply-price-filter"
        );

        // Nếu click BÊN NGOÀI filter-item, đóng tất cả
        if (!clickedInsideItem) {
          allFilterItems.forEach((item) => {
            item.classList.remove("open");
          });
        }

        // Nếu click vào nút "Áp dụng" BÊN TRONG, cũng đóng tất cả
        if (applyButton) {
          allFilterItems.forEach((item) => {
            item.classList.remove("open");
          });
        }
      });
      // === KẾT THÚC THÊM MỚI ===

      // LỌC THEO TÊN SÁCH (TÌM KIẾM TỪ KHÓA)
      const applyNameSearchBtn = document.getElementById("apply-name-search");
      const searchNameInput = document.getElementById("search-name");

      const applyNameSearch = () => {
        if (!searchNameInput) return;
        categoryFilters.searchName = searchNameInput.value.trim();
        applyCategoryFilters();
        updateSelectedFilters();
        updateClearButton();
      };

      if (applyNameSearchBtn) {
        applyNameSearchBtn.addEventListener("click", applyNameSearch);
      }
      if (searchNameInput) {
        searchNameInput.addEventListener("keypress", (e) => {
          if (e.key === "Enter") {
            e.preventDefault();
            applyNameSearch();
          }
        });
      }

      // LỌC THEO TÁC GIẢ (TÌM KIẾM TỪ KHÓA)
      const applyAuthorSearchBtn = document.getElementById(
        "apply-author-search"
      );
      const searchAuthorInput = document.getElementById("search-author");

      const applyAuthorSearch = () => {
        if (!searchAuthorInput) return;
        categoryFilters.searchAuthor = searchAuthorInput.value.trim();
        applyCategoryFilters();
        updateSelectedFilters();
        updateClearButton();
      };

      if (applyAuthorSearchBtn) {
        applyAuthorSearchBtn.addEventListener("click", applyAuthorSearch);
      }
      if (searchAuthorInput) {
        searchAuthorInput.addEventListener("keypress", (e) => {
          if (e.key === "Enter") {
            e.preventDefault();
            applyAuthorSearch();
          }
        });
      }

      // Lọc theo khoảng giá
      const applyPriceBtn = document.getElementById("apply-price-filter");
      if (applyPriceBtn) {
        console.log("Price filter button found");
        applyPriceBtn.addEventListener("click", () => {
          console.log("Apply price filter clicked");
          applyPriceFilter();
        });
      } else {
        console.error("Price filter button NOT found");
      }

      // Format input giá với dấu chấm ngăn cách
      const minPriceInput = document.getElementById("min-price");
      const maxPriceInput = document.getElementById("max-price");

      if (minPriceInput) {
        minPriceInput.addEventListener("input", (e) => {
          formatPriceInputWithDots(e.target);
        });
        minPriceInput.addEventListener("keypress", (e) => {
          if (e.key === "Enter") {
            e.preventDefault();
            applyPriceFilter();
          }
        });
      }

      if (maxPriceInput) {
        maxPriceInput.addEventListener("input", (e) => {});
        maxPriceInput.addEventListener("keypress", (e) => {
          if (e.key === "Enter") {
            e.preventDefault();
            applyPriceFilter();
          }
        });
      }
    }

    // Áp dụng lọc theo giá
    function applyPriceFilter() {
      const minInput = document.getElementById("min-price");
      const maxInput = document.getElementById("max-price");

      if (!minInput || !maxInput) {
        console.error("Price inputs not found!");
        return;
      }

      const minVal = minInput.value.replace(/\./g, "").trim();
      const maxVal = maxInput.value.replace(/\./g, "").trim();

      console.log("Price filter values:", {
        minVal,
        maxVal
      });

      if (minVal && maxVal && parseInt(minVal) > parseInt(maxVal)) {
        alert("Giá tối thiểu không thể lớn hơn giá tối đa!");
        return;
      }

      categoryFilters.minPrice = minVal ? parseInt(minVal) : null;
      categoryFilters.maxPrice = maxVal ? parseInt(maxVal) : null;

      console.log("Updated price filters:", categoryFilters);

      applyCategoryFilters();
      updateSelectedFilters();
      updateClearButton();
    }

    // Áp dụng tất cả filters
    function applyCategoryFilters() {
      console.log("Applying filters:", categoryFilters);

      // GIẢ ĐỊNH getVisibleProducts() ĐƯỢC ĐỊNH NGHĨA TRONG main.js
      let products = getVisibleProducts(); // Đã lọc category ẩn, status='active', và qty > 0 từ main.js
      console.log("Total products before filter:", products.length);

      // Lọc theo category từ URL
      if (categoryFilters.category) {
        products = products.filter(
          (p) => p.category === categoryFilters.category
        );
        console.log("After category filter:", products.length);
      }

      // Lọc theo subcategory từ URL
      if (categoryFilters.subcategory) {
        products = products.filter(
          (p) => p.subcategory === categoryFilters.subcategory
        );
        console.log("After URL subcategory filter:", products.length);
      }

      // ✅ THÊM MỚI: Lọc theo subcategory từ dropdown (nếu không có subcategory từ URL)
      if (!categoryFilters.subcategory && categoryFilters.filterSubcategory) {
        products = products.filter(
          (p) => p.subcategory === categoryFilters.filterSubcategory
        );
        console.log("After dropdown subcategory filter:", products.length);
      }

      // Lọc theo giá
      if (categoryFilters.minPrice !== null) {
        products = products.filter(
          (p) => p.price >= categoryFilters.minPrice
        );
        console.log("After min price filter:", products.length);
      }

      if (categoryFilters.maxPrice !== null) {
        products = products.filter(
          (p) => p.price <= categoryFilters.maxPrice
        );
        console.log("After max price filter:", products.length);
      }

      // Sắp xếp
      // LỌC THEO TÊN SÁCH (TÌM KIẾM TỪ KHÓA)
      const searchNameKeyword = categoryFilters.searchName.toLowerCase();
      if (searchNameKeyword) {
        products = products.filter((p) =>
          p.name.toLowerCase().includes(searchNameKeyword)
        );
        console.log("After name search filter:", products.length);
      }

      // LỌC THEO TÁC GIẢ (TÌM KIẾM TỪ KHÓA)
      const searchAuthorKeyword = categoryFilters.searchAuthor.toLowerCase();
      if (searchAuthorKeyword) {
        products = products.filter((p) =>
          (p.author || "").toLowerCase().includes(searchAuthorKeyword)
        );
        console.log("After author search filter:", products.length);
      }

      // LƯU Ý: Loại bỏ logic SẮP XẾP vì yêu cầu chuyển thành TÌM KIẾM.
      // Cần thêm một logic sắp xếp mặc định (ví dụ: theo tên A-Z) nếu không có bộ lọc nào được áp dụng.
      // Sắp xếp mặc định theo Tên (A-Z) để đảm bảo thứ tự hiển thị ổn định
      products.sort((a, b) => {
        return a.name.localeCompare(b.name, "vi");
      });
      console.log("Sorted by name (default A-Z) after search.");

      console.log("Final products count:", products.length);

      // HÀM NÀY CŨNG CẦN ĐƯỢC ĐỊNH NGHĨA TRONG main.js HOẶC KHÁC
      currentList = products;
      renderProductList(1);
    }

    // Hiển thị filter tags
    function updateSelectedFilters() {
      const container = document.getElementById("selectedFilters");
      if (!container) return;

      let html = "<h1>Tìm kiếm nâng cao: </h1>";
      let hasFilter = false;

      // Tên (Tìm kiếm)
      if (categoryFilters.searchName) {
        hasFilter = true;
        html += `<span class="filter-tag">
      Tên sách: ${categoryFilters.searchName}
      <span class="remove-filter" onclick="removeCategoryFilter('searchName')">✕</span>
    </span>`;
      }

      // Tác giả (Tìm kiếm)
      if (categoryFilters.searchAuthor) {
        hasFilter = true;
        html += `<span class="filter-tag">
      Tác giả: ${categoryFilters.searchAuthor}
      <span class="remove-filter" onclick="removeCategoryFilter('searchAuthor')">✕</span>
    </span>`;
      }

      // ✅ THÊM MỚI: Hiển thị tag cho subcategory filter
      if (categoryFilters.filterSubcategory) {
        hasFilter = true;
        html += `<span class="filter-tag">
      Thể loại: ${categoryFilters.filterSubcategory}
      <span class="remove-filter" onclick="removeCategoryFilter('filterSubcategory')">✕</span>
    </span>`;
      }

      // Giá
      if (
        categoryFilters.minPrice !== null ||
        categoryFilters.maxPrice !== null
      ) {
        hasFilter = true;
        let priceText = "Giá: ";
        if (
          categoryFilters.minPrice !== null &&
          categoryFilters.maxPrice !== null
        ) {
          priceText += `${categoryFilters.minPrice.toLocaleString(
              "vi-VN"
            )}₫ - ${categoryFilters.maxPrice.toLocaleString("vi-VN")}₫`;
        } else if (categoryFilters.minPrice !== null) {
          priceText += `Từ ${categoryFilters.minPrice.toLocaleString(
              "vi-VN"
            )}₫`;
        } else {
          priceText += `Đến ${categoryFilters.maxPrice.toLocaleString(
              "vi-VN"
            )}₫`;
        }
        html += `<span class="filter-tag">
      ${priceText}
      <span class="remove-filter" onclick="removeCategoryFilter('price')">✕</span>
    </span>`;
      }

      container.innerHTML = html;
      container.style.display = hasFilter ? "block" : "none";
    }

    // Xóa một filter
    function removeCategoryFilter(filterType) {
      console.log("Removing filter:", filterType);

      switch (filterType) {
        case "searchName": // ĐÃ THAY ĐỔI
          categoryFilters.searchName = "";
          const nameInput = document.getElementById("search-name");
          if (nameInput) nameInput.value = "";
          break;
        case "searchAuthor": // ĐÃ THAY ĐỔI
          categoryFilters.searchAuthor = "";
          const authorInput = document.getElementById("search-author");
          if (authorInput) authorInput.value = "";
          break;
        case "filterSubcategory":
          categoryFilters.filterSubcategory = null;
          break;
        case "price":
          categoryFilters.minPrice = null;
          categoryFilters.maxPrice = null;
          const minInput = document.getElementById("min-price");
          const maxInput = document.getElementById("max-price");
          if (minInput) minInput.value = "";
          if (maxInput) maxInput.value = "";
          break;
      }

      applyCategoryFilters();
      updateSelectedFilters();
      updateClearButton();
    }

    // Cập nhật nút Clear
    function updateClearButton() {
      const clearBtn = document.querySelector(".clear-filters-btn");
      if (!clearBtn) return;

      const hasActiveFilter =
        categoryFilters.searchName || // ĐÃ THAY ĐỔI
        categoryFilters.searchAuthor || // ĐÃ THAY ĐỔI
        categoryFilters.filterSubcategory ||
        categoryFilters.minPrice !== null ||
        categoryFilters.maxPrice !== null;

      if (hasActiveFilter) {
        clearBtn.classList.add("active-clear");
      } else {
        clearBtn.classList.remove("active-clear");
      }
    }

    // Override renderProductList để hiển thị tác giả
    // GIẢ ĐỊNH perPage, currentPage, và currentList ĐƯỢC KHỞI TẠO VÀ SỬ DỤNG TRONG main.js
    function renderProductList(page = 1) {
      const wrap = document.getElementById("product-list");
      if (!wrap) return;

      currentPage = page;
      const all = currentList;
      const start = (page - 1) * perPage;
      const list = all.slice(start, start + perPage);

      wrap.innerHTML = list
        .map(
          (it) => `
    <div class="product-card">
      <img src="${it.img}" alt="${it.name}">
      <div class="product-info">
        <h3>${it.name}</h3>
        <p class="product-author">Tác giả: ${it.author || "Đang cập nhật"}</p>
        <div class="price">${(it.price || 0).toLocaleString("vi-VN")}₫</div>
        <div class="button-row">
          <a class="btn btn-small" href="product-detail.php?id=${
            it.id
          }">Xem</a>
          <button class="btn btn-cart" onclick="addToCart(${
            it.id
          }, 1)">Thêm vào giỏ</button>
        </div>
      </div>
    </div>
    `
        )
        .join("");

      // HÀM NÀY CŨNG CẦN ĐƯỢC ĐỊNH NGHĨA TRONG main.js HOẶC KHÁC
      renderPagination(Math.ceil(all.length / perPage));

      // ⭐ THÊM ĐOẠN NÀY ĐỂ CUỘN TRANG SAU KHI PHÂN TRANG
      window.scrollTo({
        top: 0,
        behavior: "smooth", // Cuộn mượt mà
      });
    }

    // Khởi tạo khi DOM ready
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", initCategoryPage);
    } else {
      initCategoryPage();
    }
  </script>
</body>

</html>
