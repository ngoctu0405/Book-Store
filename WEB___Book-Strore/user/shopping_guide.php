<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <title>Chính Sách Thanh Toán - Literary Haven</title>
    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link
      rel="stylesheet"
      href="../bootstrap-5.3.2-dist/css/bootstrap.min.css"
    />

    <style>
      .container_1 {
        position: relative;
        margin: 9rem auto;
      }
      section {
        padding: 1rem 1rem;
      }
      .mb-4 {
        padding: 0;
        margin: 0 !important;
      }
      .py-5 {
        background-color: #fff;
      }
      .policy-container {
        position: relative;
        top: 2.5rem;
        max-width: 900px;
        color: #333;
        line-height: 1.7;
        border-radius: 3rem;
      }

      .policy-header h1 {
        font-size: 2rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        color: #2c3e50;
      }

      .policy-section h2 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #34495e;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
      }

      .policy-section ul {
        list-style: disc;
        margin-left: 1.5rem;
      }

      .policy-section p,
      .policy-section li {
        font-size: 1rem;
        color: #555;
      }

      .policy-section li strong {
        color: #222;
      }

      .policy-container a {
        color: #007bff;
        text-decoration: none;
      }

      .policy-container a:hover {
        text-decoration: underline;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
      }

      th,
      td {
        border: 1px solid #ccc;
        padding: 0.75rem;
        text-align: left;
      }

      th {
        background-color: #f5f5f5;
      }
      /* Nút quay lại */
      #back {
        display: inline-block;
        margin-top: 35px;
        background: #007bff;
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 6px;
        transition: 0.25s ease;
      }

      #back:hover {
        background: #0056b3;
        color: #fff;
      }
    </style>
    <!-- Nút back to top -->
    <script>
      // Khi cuộn xuống 300px thì hiện nút
      window.onscroll = function () {
        const btn = document.getElementById("backToTop");
        if (
          document.body.scrollTop > 300 ||
          document.documentElement.scrollTop > 300
        ) {
          btn.style.display = "block";
        } else {
          btn.style.display = "none";
        }
      };

      // Khi click thì cuộn lên đầu trang
      document
        .getElementById("backToTop")
        .addEventListener("click", function () {
          window.scrollTo({ top: 0, behavior: "smooth" });
        });
    </script>
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

    <a id="back" href="index.php">&larr; Quay lại trang chủ</a>

    <!-- CHÍNH SÁCH ĐỔI TRẢ HÀNG -->
    <div class="container_1">
      <main class="policy-container container py-5">
        <header class="policy-header text-center mb-5">
          <h1>HƯỚNG DẪN MUA HÀNG</h1>
          <p class="lead text-muted">
            Các bước và lưu ý để khách hàng mua sách nhanh chóng và thuận tiện
            tại Literary Haven.
          </p>
        </header>

        <section class="policy-section mb-4">
          <h2>1. Giới thiệu</h2>
          <p>
            Hướng dẫn mua hàng tại Literary Haven được xây dựng nhằm giúp khách
            hàng dễ dàng tìm kiếm, đặt mua và thanh toán sản phẩm một cách nhanh
            chóng, an toàn và thuận tiện. Chúng tôi luôn mong muốn mang lại trải
            nghiệm mua sắm tốt nhất cho bạn.
          </p>
        </section>

        <section class="policy-section mb-4">
          <h2>2. Các hình thức mua hàng</h2>
          <ul>
            <li>Mua trực tiếp tại cửa hàng Literary Haven.</li>
            <li>
              Mua online qua website chính thức
              <a href="index.php">www.c03.nhahodau.net</a>.
            </li>
            <li>Đặt hàng qua hotline hoặc fanpage của cửa hàng.</li>
          </ul>
        </section>

        <section class="policy-section mb-4">
          <h2>3. Quy trình mua hàng online</h2>
          <ul>
            <li>
              <strong>Bước 1:</strong> Truy cập website của
              <a href="index.php">Literary Haven</a>.
            </li>
            <li>
              <strong>Bước 2:</strong> Tìm kiếm sản phẩm bạn muốn mua bằng thanh
              tìm kiếm hoặc danh mục sách.
            </li>
            <li>
              <strong>Bước 3:</strong> Chọn sách và bấm “Thêm vào giỏ hàng”.
            </li>
            <li>
              <strong>Bước 4:</strong> Kiểm tra giỏ hàng, điều chỉnh số lượng
              nếu cần.
            </li>
            <li>
              <strong>Bước 5:</strong> Nhấn “Thanh toán” và điền đầy đủ thông
              tin giao hàng, phương thức thanh toán.
            </li>
            <li>
              <strong>Bước 6:</strong> Xác nhận đơn hàng. Hệ thống sẽ gửi email
              xác nhận đơn hàng thành công.
            </li>
          </ul>
        </section>

        <section class="policy-section mb-4">
          <h2>4. Phương thức thanh toán</h2>
          <table>
            <tr>
              <th>Phương thức</th>
              <th>Mô tả</th>
            </tr>
            <tr>
              <td>Thanh toán khi nhận hàng (COD)</td>
              <td>
                Khách hàng thanh toán tiền mặt cho nhân viên giao hàng khi nhận
                sản phẩm.
              </td>
            </tr>
            <tr>
              <td>Chuyển khoản ngân hàng</td>
              <td>
                Khách hàng chuyển khoản trước qua tài khoản ngân hàng của
                Literary Haven.
              </td>
            </tr>
            <tr>
              <td>Thanh toán qua ví điện tử</td>
              <td>
                Hỗ trợ Momo, ZaloPay, ShopeePay, hoặc các ví phổ biến khác.
              </td>
            </tr>
          </table>
        </section>

        <section class="policy-section mb-4">
          <h2>5. Thời gian xử lý và giao hàng</h2>
          <ul>
            <li>
              Đơn hàng được xử lý trong vòng <strong>24 giờ</strong> kể từ khi
              xác nhận.
            </li>
            <li>Thời gian giao hàng nội thành: 1–2 ngày làm việc.</li>
            <li>Giao hàng toàn quốc: 2–5 ngày làm việc (tùy khu vực).</li>
          </ul>
        </section>

        <section class="policy-section mb-4">
          <h2>6. Mẹo giúp đặt hàng nhanh chóng</h2>
          <ul>
            <li>
              Đăng ký tài khoản để lưu thông tin giao hàng cho những lần mua
              sau.
            </li>
            <li>Kiểm tra kỹ giỏ hàng trước khi thanh toán để tránh sai sót.</li>
            <li>
              Giữ lại email xác nhận đơn hàng để tiện tra cứu khi cần hỗ trợ.
            </li>
          </ul>
        </section>
      </main>
    </div>

    <!-- FOOTER -->
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
            <label for="login-username">Tên tài khoản</label>
            <div class="input-with-icon">
              <span class="input-icon">👤</span>
              <input
                type="text"
                id="login-username"
                placeholder="Nhập tên tài khoản"
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
            <label for="reg-username">Tài khoản</label>
            <div class="input-with-icon">
              <span class="input-icon">🔑</span>
              <input
                type="text"
                id="reg-username"
                placeholder="Nhập tài khoản"
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
    <script src="assets/js/main.js"></script>
    <a href="#" class="back-to-top" title="Lên đầu trang">
      <i class="bi bi-chevron-up">
        <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
      </i>
    </a>
  </body>
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
            <input type="text" id="reg-fullname" placeholder="Nhập họ và tên" />
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
            <input type="tel" id="reg-phone" placeholder="Nhập số điện thoại" />
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
  <script src="../assets/js/main.js"></script>
  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</html>
