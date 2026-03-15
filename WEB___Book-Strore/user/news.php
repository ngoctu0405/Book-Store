<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Tin Tức - Nhà Sách Online</title>
    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link
      rel="stylesheet"
      href="../bootstrap-5.3.2-dist/css/bootstrap.min.css"
    />
    <style>
      .container {
        position: relative;
        margin: 5rem auto;
      }

      /* News responsive */
      @media (max-width: 767px) {
        .featured-card {
          grid-template-columns: 1fr;
        }

        .news-grid {
          grid-template-columns: 1fr;
          gap: 1.5rem;
        }

        .news-card {
          height: auto;
          max-width: 100%;
        }

        .featured-content h2 {
          font-size: 1.5rem;
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
      <!-- Featured News -->
      <section class="featured-news">
        <h1>Tin nổi bật trong ngày</h1>
        <div class="featured-card">
          <img
            src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800"
            alt="Tin nổi bật"
          />
          <div class="featured-content">
            <div class="news-meta">
              <span class="news-category">📚 Nổi bật</span>
              <span class="news-date">📅 01/11/2025</span>
            </div>
            <h2>Literary Haven khai trương showroom mới tại TP.HCM</h2>
            <p>
              Với diện tích hơn 500m², showroom mới của chúng tôi mang đến không
              gian đọc sách hiện đại và thoải mái nhất. Đây là nơi lý tưởng để
              bạn khám phá hàng ngàn đầu sách từ khắp nơi trên thế giới.
            </p>
            <a href="news-detail.php?id=9" class="read-more">Xem chi tiết →</a>
          </div>
        </div>
      </section>

      <!-- News Grid -->
      <div class="news-grid">
        <article class="news-card">
          <img
            src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600"
            alt="Sách mới"
          />
          <div class="news-content">
            <div class="news-meta">
              <span class="news-category">📖 Sách mới</span>
              <span class="news-date">📅 08/10/2025</span>
            </div>
            <h3>Top 10 cuốn sách bán chạy nhất tháng 10</h3>
            <p>
              Cùng khám phá những cuốn sách được độc giả yêu thích nhất trong
              tháng này, từ văn học đến kinh tế và phát triển bản thân.
            </p>
            <a href="news-detail.php?id=10" class="read-more">Đọc thêm →</a>
          </div>
        </article>

        <article class="news-card">
          <img
            src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600"
            alt="Tác giả"
          />
          <div class="news-content">
            <div class="news-meta">
              <span class="news-category">✍️ Tác giả</span>
              <span class="news-date">📅 05/10/2025</span>
            </div>
            <h3>Gặp gỡ tác giả Nguyễn Nhật Ánh</h3>
            <p>
              Sự kiện gặp gỡ và ký tặng sách với tác giả Nguyễn Nhật Ánh sẽ diễn
              ra vào ngày 15/10 tại showroom của chúng tôi.
            </p>
            <a href="news-detail.php?id=11" class="read-more">Đọc thêm →</a>
          </div>
        </article>

        <article class="news-card">
          <img
            src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600"
            alt="Khuyến mãi"
          />
          <div class="news-content">
            <div class="news-meta">
              <span class="news-category">🎁 Khuyến mãi</span>
              <span class="news-date">📅 03/10/2025</span>
            </div>
            <h3>Giảm giá 30% toàn bộ sách kinh tế</h3>
            <p>
              Chương trình khuyến mãi đặc biệt dành cho các đầu sách về kinh tế,
              kinh doanh và quản trị. Áp dụng từ 05/10 đến 20/10.
            </p>
            <a href="news-detail.php?id=12" class="read-more">Đọc thêm →</a>
          </div>
        </article>

        <article class="news-card">
          <img
            src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=600"
            alt="Review"
          />
          <div class="news-content">
            <div class="news-meta">
              <span class="news-category">⭐ Review</span>
              <span class="news-date">📅 01/10/2025</span>
            </div>
            <h3>Review: "Đắc Nhân Tâm" - Cuốn sách không bao giờ cũ</h3>
            <p>
              Tại sao "Đắc Nhân Tâm" vẫn là cuốn sách được yêu thích sau nhiều
              thập kỷ? Cùng chúng tôi khám phá những giá trị vượt thời gian.
            </p>
            <a href="news-detail.php?id=13" class="read-more">Đọc thêm →</a>
          </div>
        </article>

        <article class="news-card">
          <img
            src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600"
            alt="Sự kiện"
          />
          <div class="news-content">
            <div class="news-meta">
              <span class="news-category">🎪 Sự kiện</span>
              <span class="news-date">📅 28/09/2025</span>
            </div>
            <h3>Hội sách mùa thu 2025</h3>
            <p>
              Tham gia Hội sách mùa thu với hàng trăm gian hàng sách, nhiều hoạt
              động văn hóa hấp dẫn và các chương trình giảm giá đặc biệt.
            </p>
            <a href="news-detail.php?id=14" class="read-more">Đọc thêm →</a>
          </div>
        </article>

        <article class="news-card">
          <img
            src="https://images.unsplash.com/photo-1519682337058-a94d519337bc?w=600"
            alt="Tips"
          />
          <div class="news-content">
            <div class="news-meta">
              <span class="news-category">💡 Mẹo hay</span>
              <span class="news-date">📅 25/09/2025</span>
            </div>
            <h3>5 cách giúp bạn đọc nhiều sách hơn</h3>
            <p>
              Khám phá những mẹo đơn giản nhưng hiệu quả để biến việc đọc sách
              thành thói quen hàng ngày của bạn.
            </p>
            <a href="news-detail.php?id=15" class="read-more">Đọc thêm →</a>
          </div>
        </article>
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
    <!-- Nút quay lên đầu trang -->
    <a href="#" class="back-to-top" title="Lên đầu trang">
      <i class="bi bi-chevron-up">
        <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
      </i>
    </a>
  </body>
  <script src="../assets/js/main.js"></script>
  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</html>
