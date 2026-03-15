<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cập nhật thông tin cá nhân - Literary Haven</title>
    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link
      rel="stylesheet"
      href="../bootstrap-5.3.2-dist/css/bootstrap.min.css"
    />
    <style>
      /* BẮT ĐẦU CSS GỐC TỪ purchase-history.php */
      body {
        background: linear-gradient(
          135deg,
          #f5f2e8 0%,
          #e8d5b7 50%,
          #7fb3d3 100%
        );
        color: #2c3e50;
        min-height: 100vh;
      }

      .container {
        position: relative;
        top: 7rem;
        max-width: 1400px;
        height: 70rem;
        margin: 4rem auto;
        padding: 0 2rem;
      }

      .page-heading {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
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

      /* Các phần CSS Order History khác được giữ nguyên ... */

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
      /* KẾT THÚC CSS GỐC */

      /* BẮT ĐẦU CSS BỔ SUNG & SỬA LỖI CHO FORM CẬP NHẬT */
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

      .input-with-icon input[readonly],
      .input-with-icon input[disabled] {
        background: #eee;
        cursor: not-allowed;
        color: #666;
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

      /* KẾT THÚC CSS BỔ SUNG & SỬA LỖI */
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
            alt="Literary Haven"
          />
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
              <a href="category.php?category=Văn học" data-category="Văn học"
                >Văn học ▸</a
              >
              <ul class="dropdown-content">
                <li>
                  <a
                    href="category.php?category=Văn học&subcategory=Tiểu thuyết"
                    >Tiểu thuyết</a
                  >
                </li>
                <li>
                  <a
                    href="category.php?category=Văn học&subcategory=Truyện ngắn"
                    >Truyện ngắn</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Văn học&subcategory=Thơ"
                    >Thơ</a
                  >
                </li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="category.php?category=Kinh tế">Kinh tế ▸</a>
              <ul class="dropdown-content">
                <li>
                  <a href="category.php?category=Kinh tế&subcategory=Quản trị"
                    >Quản trị</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Kinh tế&subcategory=Tài chính"
                    >Tài chính</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Kinh tế&subcategory=Marketing"
                    >Marketing</a
                  >
                </li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="category.php?category=Thiếu nhi">Thiếu nhi ▸</a>
              <ul class="dropdown-content">
                <li>
                  <a
                    href="category.php?category=Thiếu nhi&subcategory=Truyện tranh"
                    >Truyện tranh</a
                  >
                </li>
                <li>
                  <a
                    href="category.php?category=Thiếu nhi&subcategory=Giáo dục"
                    >Giáo dục</a
                  >
                </li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="category.php?category=Giáo khoa">Giáo khoa ▸</a>
              <ul class="dropdown-content">
                <li>
                  <a href="category.php?category=Giáo khoa&subcategory=Cấp 1"
                    >Cấp 1</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Giáo khoa&subcategory=Cấp 2"
                    >Cấp 2</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Giáo khoa&subcategory=Cấp 3"
                    >Cấp 3</a
                  >
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
          autocomplete="off"
        />
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
        <i class="bi bi-gear-fill"></i> Cập nhật thông tin cá nhân
      </h2>
      <div class="history-container" id="updateProfileContainer">
        <form id="update-profile-form">
          <div class="form-group">
            <label for="update-fullname">Họ và tên</label>
            <div class="input-with-icon">
              <span class="input-icon"><i class="bi bi-person-fill"></i></span>
              <input
                type="text"
                id="update-fullname"
                placeholder="Nhập họ và tên"
                required
              />
            </div>
            <span id="error-update-fullname" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="update-username">Tài khoản (Không thể thay đổi)</label>
            <div class="input-with-icon">
              <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
              <input
                type="text"
                id="update-username"
                placeholder="Tên tài khoản"
                readonly
                disabled
              />
            </div>
          </div>

          <div class="form-group">
            <label for="update-email">Email</label>
            <div class="input-with-icon">
              <span class="input-icon"
                ><i class="bi bi-envelope-fill"></i
              ></span>
              <input
                type="email"
                id="update-email"
                placeholder="Nhập email"
                required
              />
            </div>
            <span id="error-update-email" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="update-phone">Số điện thoại</label>
            <div class="input-with-icon">
              <span class="input-icon"
                ><i class="bi bi-telephone-fill"></i
              ></span>
              <input
                type="tel"
                id="update-phone"
                placeholder="Nhập số điện thoại"
                required
              />
            </div>
            <span id="error-update-phone" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="update-address">Địa chỉ giao hàng</label>
            <div class="input-with-icon">
              <span class="input-icon"><i class="bi bi-house-fill"></i></span>
              <input
                type="text"
                id="update-address"
                placeholder="Nhập địa chỉ"
                required
              />
            </div>
            <span id="error-update-address" class="error-msg"></span>
          </div>

          <div class="form-actions">
            <a href="profile.php" class="btn-action btn-reorder">
              <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            <button type="submit" class="btn-action btn-detail">
              <i class="bi bi-save"></i> Cập nhật thông tin
            </button>
          </div>
        </form>
        <p class="mt-4" style="text-align: center; color: #7f8c8d">
          Bạn muốn đổi mật khẩu?
          <a
            href="change-password.php"
            style="color: #4f9da6; font-weight: 600"
            >Đổi mật khẩu tại đây</a
          >
        </p>
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

    <!-- Modal Đăng Nhập -->
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
                placeholder="Nhập tài khoản"
              />
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
                placeholder="Nhập mật khẩu"
              />
              <span
                class="password-toggle"
                id="toggle-login-password"
                onclick="togglePassword('login-password', 'toggle-login-password')"
                >👁️‍🗨️</span
              >
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

    <!-- Modal Đăng Ký -->
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
          style="max-height: 450px; overflow-y: auto"
        >
          <div class="form-group">
            <label for="reg-fullname">Họ và tên</label>
            <div class="input-with-icon">
              <span class="input-icon">👤</span>
              <input
                type="text"
                id="reg-fullname"
                placeholder="Nhập họ và tên"
              />
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
                placeholder="Nhập tên tài khoản"
              />
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
                placeholder="Nhập mật khẩu"
              />
              <span
                class="password-toggle"
                id="toggle-reg-password"
                onclick="togglePassword('reg-password', 'toggle-reg-password')"
                >👁️‍🗨️</span
              >
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
                placeholder="Nhập lại mật khẩu"
              />
              <span
                class="password-toggle"
                id="toggle-reg-confirm"
                onclick="togglePassword('reg-confirm-password', 'toggle-reg-confirm')"
                >👁️‍🗨️</span
              >
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
                placeholder="Nhập số điện thoại"
              />
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

    <!-- Modal Profile (Hiển thị khi đã đăng nhập) -->
    <div id="profileModal" class="auth-modal">
      <div class="auth-modal-overlay" onclick="closeProfileModal()"></div>
      <div class="auth-modal-content">
        <button class="auth-modal-close" onclick="closeProfileModal()">
          &times;
        </button>

        <div class="auth-modal-header">
          <div class="profile-avatar-small">👤</div>
          <h2 id="profile-fullname">Xin chào!</h2>
          <p>Thông tin tài khoản của bạn</p>
        </div>

        <div class="profile-info-modal">
          <div class="info-row">
            <span class="info-label">👤 Họ và tên:</span>
            <span class="info-value" id="profile-name-value"></span>
          </div>
          <div class="info-row">
            <span class="info-label">🔐 Tài khoản:</span>
            <span class="info-value" id="profile-username-value"></span>
          </div>
          <div class="info-row">
            <span class="info-label">📧 Email:</span>
            <span class="info-value" id="profile-email-value"></span>
          </div>
          <div class="info-row">
            <span class="info-label">📱 Số điện thoại:</span>
            <span class="info-value" id="profile-phone-value"></span>
          </div>
          <div class="info-row">
            <span class="info-label">📍 Địa chỉ:</span>
            <span class="info-value" id="profile-address-value"></span>
          </div>
        </div>

        <button class="btn-logout-modal" onclick="handleLogoutModal()">
          Đăng xuất
        </button>
      </div>
    </div>

    <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
      function getCurrentUser() {
        try {
          const user = localStorage.getItem("bs_user");
          if (!user) {
            alert("Vui lòng đăng nhập để cập nhật thông tin!");
            window.location.href = "index.php";
            return null;
          }
          return JSON.parse(user);
        } catch (e) {
          console.error("Lỗi khi đọc user từ localStorage:", e);
          return null;
        }
      }

      function saveUser(user) {
        localStorage.setItem("bs_user", JSON.stringify(user));
      }

      function validateEmail(email) {
        const re =
          /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
      }

      function validatePhone(phone) {
        return phone.length >= 10 && phone.length <= 11 && /^\d+$/.test(phone);
      }

      function clearFormErrors() {
        document
          .querySelectorAll(".error-msg")
          .forEach((el) => (el.textContent = ""));
      }

      function initUpdateProfile() {
        const user = getCurrentUser();
        if (!user) return;

        document.getElementById("update-fullname").value = user.fullName || "";
        document.getElementById("update-username").value = user.username || "";
        document.getElementById("update-email").value = user.email || "";
        document.getElementById("update-phone").value = user.phone || "";
        document.getElementById("update-address").value = user.address || "";
      }

      function handleUpdateProfile(event) {
        event.preventDefault();
        clearFormErrors();
        let hasError = false;

        const user = getCurrentUser();
        if (!user) return;

        const fullName = document
          .getElementById("update-fullname")
          .value.trim();
        const email = document.getElementById("update-email").value.trim();
        const phone = document.getElementById("update-phone").value.trim();
        const address = document.getElementById("update-address").value.trim();

        // Kiểm tra validation
        if (!fullName) {
          document.getElementById("error-update-fullname").textContent =
            "Vui lòng nhập họ tên";
          hasError = true;
        }
        if (!email) {
          document.getElementById("error-update-email").textContent =
            "Vui lòng nhập email";
          hasError = true;
        } else if (!validateEmail(email)) {
          document.getElementById("error-update-email").textContent =
            "Email không hợp lệ";
          hasError = true;
        }
        if (!phone) {
          document.getElementById("error-update-phone").textContent =
            "Vui lòng nhập số điện thoại";
          hasError = true;
        } else if (!validatePhone(phone)) {
          document.getElementById("error-update-phone").textContent =
            "Số điện thoại không hợp lệ (10-11 chữ số)";
          hasError = true;
        }
        if (!address) {
          document.getElementById("error-update-address").textContent =
            "Vui lòng nhập địa chỉ";
          hasError = true;
        }

        if (hasError) return;

        // Cập nhật dữ liệu người dùng
        user.fullName = fullName;
        user.email = email;
        user.phone = phone;
        user.address = address;

        saveUser(user);

        const users = JSON.parse(localStorage.getItem("bs_users")) || [];
        const index = users.findIndex((u) => u.username === user.username);
        if (index !== -1) {
          const oldUser = users[index];
          users[index] = {
            ...oldUser, // giữ lại các thuộc tính cũ
            ...user,
          };
          // cập nhật lại user trong danh sách
          localStorage.setItem("bs_users", JSON.stringify(users));
        }

        alert("✅ Cập nhật thông tin cá nhân thành công!");
        // Đã sửa để chuyển hướng đến index.php
        window.location.href = "index.php";
      }

      document.addEventListener("DOMContentLoaded", function () {
        initUpdateProfile();
        const updateForm = document.getElementById("update-profile-form");
        if (updateForm) {
          updateForm.addEventListener("submit", handleUpdateProfile);
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
