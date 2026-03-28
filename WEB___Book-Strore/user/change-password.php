<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đổi mật khẩu - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link
    rel="stylesheet"
    href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <style>
    /* BẮT ĐẦU CSS GỐC TỪ update-profile.php */
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
      top: 6rem;
      max-width: 1400px;
      margin: 4rem auto;
      padding: 0 2rem;
      height: 50rem;
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
      max-width: 600px;
      /* Giới hạn chiều rộng cho form đổi mật khẩu */
      margin: 0 auto;
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
      justify-content: center;
      text-decoration: none;
    }

    .btn-detail {
      background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
      color: white;
    }

    .btn-detail:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(79, 157, 166, 0.4);
    }

    .btn-reorder {
      background: linear-gradient(135deg, #ff7f50 0%, #ff4500 100%);
      color: white;
    }

    .btn-reorder:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(255, 99, 71, 0.4);
    }

    /* CSS BỔ SUNG & SỬA LỖI CHO FORM CẬP NHẬT (Áp dụng cho Đổi mật khẩu) */
    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #2c3e50;
    }

    .input-with-icon {
      display: flex;
      align-items: center;
      border: 2px solid #ddd;
      border-radius: 12px;
      background: #f8f8f8;
      transition: all 0.3s ease;
      width: 100%;
      box-sizing: border-box;
      overflow: hidden;
    }

    .input-with-icon:focus-within {
      border-color: #4f9da6;
      box-shadow: 0 0 0 3px rgba(79, 157, 166, 0.2);
    }

    .input-icon {
      padding: 0.8rem 1rem;
      font-size: 1.2rem;
      color: #7f8c8d;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .input-with-icon input {
      border: none;
      outline: none;
      padding: 0.8rem 1rem;
      flex-grow: 1;
      background: transparent;
      font-size: 1rem;
      min-width: 0;
      box-sizing: border-box;
    }

    .password-toggle {
      cursor: pointer;
      user-select: none;
      padding: 0.8rem 1rem;
      font-size: 1.2rem;
      color: #7f8c8d;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .error-msg {
      color: #e74c3c;
      font-size: 0.9rem;
      margin-top: 0.5rem;
      display: block;
      height: 1.5em;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 2rem;
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
    <h2 class="page-heading"><i class="bi bi-key-fill"></i> Đổi mật khẩu</h2>
    <div class="history-container">
      <form id="change-password-form">
        <div class="form-group">
          <label for="old-password">Mật khẩu cũ</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
            <input
              type="password"
              id="old-password"
              placeholder="Nhập mật khẩu cũ"
              required />
            <span
              class="password-toggle"
              id="toggle-old-password"
              onclick="togglePassword('old-password', 'toggle-old-password')">👁️‍🗨️</span>
          </div>
          <span id="error-old-password" class="error-msg"></span>
        </div>

        <div class="form-group">
          <label for="new-password">Mật khẩu mới</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-shield-lock-fill"></i></span>
            <input
              type="password"
              id="new-password"
              placeholder="Nhập mật khẩu mới"
              required />
            <span
              class="password-toggle"
              id="toggle-new-password"
              onclick="togglePassword('new-password', 'toggle-new-password')">👁️‍🗨️</span>
          </div>
          <span id="error-new-password" class="error-msg"></span>
        </div>

        <div class="form-group">
          <label for="confirm-password">Xác nhận mật khẩu mới</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-shield-check-fill"></i></span>
            <input
              type="password"
              id="confirm-password"
              placeholder="Nhập lại mật khẩu mới"
              required />
            <span
              class="password-toggle"
              id="toggle-confirm-password"
              onclick="togglePassword('confirm-password', 'toggle-confirm-password')">👁️‍🗨️</span>
          </div>
          <span id="error-confirm-password" class="error-msg"></span>
        </div>

        <div class="form-actions">
          <a href="update-profile.php" class="btn-action btn-reorder">
            <i class="bi bi-arrow-left"></i> Quay lại
          </a>
          <button type="submit" class="btn-action btn-detail">
            <i class="bi bi-save"></i> Đổi mật khẩu
          </button>
        </div>
      </form>
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
  <script src="../assets/js/main.js?v=2"></script>

  <script>
    // Hàm này được thêm vào để đảm bảo chức năng ẩn/hiện mật khẩu hoạt động
    function togglePassword(inputId, toggleId) {
      const input = document.getElementById(inputId);
      const toggle = document.getElementById(toggleId);

      if (input.type === "password") {
        input.type = "text";
        // Dùng '🙈' hoặc biểu tượng bạn muốn cho trạng thái "đã hiển thị"
        toggle.textContent = "🙈";
      } else {
        input.type = "password";
        // Dùng '👁️‍🗨️' hoặc biểu tượng bạn muốn cho trạng thái "đã ẩn"
        toggle.textContent = "👁️‍🗨️";
      }
    }

    function getCurrentUser() {
      try {
        const user = localStorage.getItem("bs_user");
        if (!user) {
          // Đã bỏ alert, chỉ chuyển hướng về trang chủ
          window.location.href = "index.php";
          return null;
        }
        return JSON.parse(user);
      } catch (e) {
        console.error("Lỗi khi đọc user từ localStorage:", e);
        window.location.href = "index.php"; // Chuyển hướng nếu lỗi
        return null;
      }
    }

    function saveUser(user) {
      localStorage.setItem("bs_user", JSON.stringify(user));
    }

    function clearFormErrors() {
      document
        .querySelectorAll(".error-msg")
        .forEach((el) => (el.textContent = ""));
    }

    function handleChangePassword(event) {
      event.preventDefault();
      clearFormErrors();
      let hasError = false;

      // Vẫn phải kiểm tra đăng nhập tại đây để bảo mật trước khi xử lý form
      const user = getCurrentUser();
      if (!user) return; // Nếu chưa đăng nhập, đã chuyển hướng trong getCurrentUser()

      const oldPassword = document
        .getElementById("old-password")
        .value.trim();
      const newPassword = document
        .getElementById("new-password")
        .value.trim();
      const confirmPassword = document
        .getElementById("confirm-password")
        .value.trim();

      // 1. Kiểm tra Mật khẩu cũ
      if (oldPassword !== user.password) {
        document.getElementById("error-old-password").textContent =
          "Mật khẩu cũ không đúng.";
        hasError = true;
      }

      // 2. Kiểm tra Mật khẩu mới
      if (newPassword.length < 6) {
        document.getElementById("error-new-password").textContent =
          "Mật khẩu mới phải có ít nhất 6 ký tự.";
        hasError = true;
      }

      // 3. Kiểm tra Xác nhận mật khẩu
      if (newPassword !== confirmPassword) {
        document.getElementById("error-confirm-password").textContent =
          "Mật khẩu xác nhận không khớp.";
        hasError = true;
      }

      // 4. Kiểm tra Mật khẩu mới có trùng Mật khẩu cũ
      if (newPassword === oldPassword && !hasError) {
        document.getElementById("error-new-password").textContent =
          "Mật khẩu mới không được trùng mật khẩu cũ.";
        hasError = true;
      }

      if (hasError) return;

      // Cập nhật mật khẩu
      user.password = newPassword;
      saveUser(user);

      const allUsers = JSON.parse(localStorage.getItem("bs_users") || "[]");
      const userIndexInAllUsers = allUsers.findIndex(
        (u) => u.username === user.username
      );

      if (userIndexInAllUsers !== -1) {
        // Cập nhật thuộc tính password của user trong mảng
        allUsers[userIndexInAllUsers].password = newPassword;
        // Lưu lại TOÀN BỘ mảng users gốc
        localStorage.setItem("bs_users", JSON.stringify(allUsers));
      } else {
        console.error(
          "Lỗi: Không tìm thấy người dùng trong danh sách bs_users để cập nhật."
        );
        // Bạn có thể xử lý lỗi này nếu cần
      }
      alert(
        "✅ Đổi mật khẩu thành công! Vui lòng đăng nhập lại với mật khẩu mới."
      );

      // Xóa thông tin đăng nhập và chuyển hướng về trang chủ
      localStorage.removeItem("bs_user");
      localStorage.removeItem("isLoggedIn");
      window.location.href = "index.php";
    }

    document.addEventListener("DOMContentLoaded", function() {
      // Không gọi getCurrentUser() ở đây theo yêu cầu

      const changePassForm = document.getElementById("change-password-form");
      if (changePassForm) {
        changePassForm.addEventListener("submit", handleChangePassword);
      }

      // Đảm bảo các hàm UI từ main.js được gọi nếu có
      if (typeof updateCartCount === "function") updateCartCount();
      if (typeof updateAuthUI === "function") updateAuthUI();
      if (typeof loadSearchQuery === "function") loadSearchQuery();
    });

    function closeOrderModal() {
      document.getElementById("orderModal").classList.remove("active");
    }
  </script>
</body>

</html>