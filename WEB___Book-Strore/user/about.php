<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Giới thiệu - Literary Haven</title>
    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link
      rel="stylesheet"
      href="../bootstrap-5.3.2-dist/css/bootstrap.min.css"
    />
    <style>
      main {
        position: relative;
        top: 5rem;
        height: 96rem;
      }

      /* About us responsive */
      @media (max-width: 767px) {
        main {
          height: auto;
        }

        /* About us */
        .col-md-6 {
          position: relative;
          top: 2rem;
        }
        .py-5 {
          padding: 15rem 0;
          height: 100%;
        }
        .contact-section {
          display: block;
        }
        .col-md-6-nd {
          position: relative;
          top: 10rem;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
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
      footer {
        margin-top: 4rem;
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
    <main>
      <!-- Phần giới thiệu -->
      <section class="intro-section text-center py-5">
        <h1 class="fw-bold">
          Literary Haven –
          <span class="text-danger">Thế Giới Sách Dành Cho Mọi Độc Giả</span>
        </h1>
        <p class="mt-3 px-5">
          Literary Haven không chỉ là một cửa hàng sách thông thường, mà còn là
          điểm đến lý tưởng dành cho những ai đam mê tri thức và yêu thích việc
          khám phá qua từng trang sách. Được thành lập với sứ mệnh mang đến cho
          độc giả những cuốn sách chất lượng nhất cùng dịch vụ tuyệt vời,
          Literary Haven đã và đang trở thành một trong những địa chỉ mua sách
          uy tín nhất tại Việt Nam.
        </p>
      </section>

      <!-- Phần tầm nhìn - sứ mệnh -->
      <section class="vision-mission py-5" style="background-color: #fff6f2">
        <div
          class="container d-flex flex-wrap align-items-center justify-content-between"
        >
          <div class="col-md-6 mb-4 mb-md-0 text-center">
            <img
              src="../images/Vision.jpg"
              alt="Hình minh họa Literary Haven"
              class="img-fluid rounded shadow"
            />
          </div>
          <div class="col-md-5">
            <h2 class="fw-bold mb-3">Tầm Nhìn - Sứ Mệnh</h2>
            <h5 class="text-danger fw-semibold">Sứ Mệnh</h5>
            <p>
              Literary Haven được thành lập với mong muốn trở thành cầu nối giữa
              tri thức và độc giả, mang đến những cuốn sách chất lượng cao từ
              các nhà xuất bản uy tín trong và ngoài nước, cùng trải nghiệm mua
              sắm tiện lợi, an toàn và thú vị.
            </p>
            <h5 class="text-danger fw-semibold mt-4">Tầm Nhìn</h5>
            <p>
              Hướng đến việc trở thành hệ thống bán lẻ sách hàng đầu tại Việt
              Nam, không chỉ là nơi mua sách, mà còn là không gian văn hóa gắn
              kết cộng đồng yêu sách, truyền cảm hứng đọc và học hỏi suốt đời.
            </p>
          </div>
        </div>
      </section>

      <!-- Phần liên hệ -->
      <section class="contact-section py-5" style="background-color: #ffe5d2">
        <div
          class="container d-flex flex-wrap align-items-center justify-content-between"
        >
          <div class="col-md-5">
            <h2 class="fw-bold mb-3">Thông Tin Liên Hệ</h2>
            <p>
              Với sự tận tâm trong từng cuốn sách và dịch vụ khách hàng chuyên
              nghiệp, Literary Haven mong muốn trở thành người bạn đồng hành
              trong hành trình khám phá tri thức.
            </p>
            <ul class="list-unstyled mt-3">
              <li><strong>📞 Hotline:</strong> 1900 6750</li>
              <li><strong>✉️ Email:</strong> support@bookstore.vn</li>
              <li>
                <strong>📍 Địa chỉ:</strong> 123 Nguyễn Văn Linh, Q7, TP. Hồ Chí
                Minh
              </li>
              <li>
                <strong>🌐 Website:</strong>
                <a href="https://c03.nhahodau.net/" target="_blank">
                  c03.nhahodau.net
                </a>
              </li>
            </ul>
          </div>
          <div class="col-md-6 text-center">
            <img
              src="../images/Contact.webp"
              alt="Liên hệ Literary Haven"
              class="img-fluid rounded shadow"
            />
          </div>
        </div>
      </section>
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
    <!-- Nút quay lên đầu trang -->
    <a href="#" class="back-to-top" title="Lên đầu trang">
      <i class="bi bi-chevron-up">
        <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
      </i>
    </a>
    <script src="../assets/js/main.js"></script>
    <script src="../bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
  </body>
</html>
