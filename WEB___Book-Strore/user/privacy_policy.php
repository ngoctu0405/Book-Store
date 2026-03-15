<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Chính Sách Bảo Mật - Literary Haven</title>
    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link
      rel="stylesheet"
      href="../bootstrap-5.3.2-dist/css/bootstrap.min.css"
    />
    <style>
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
      .container_1 {
        height: 90rem;
      }

      .policy-container {
        position: relative;
        top: 10rem;
        margin: 10rem auto;
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
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

    <a id="back" href="index.php">&larr; Quay lại trang chủ</a>

    <!-- CHÍNH SÁCH BẢO MẬT -->
    <div class="container_1">
      <main class="policy-container container py-5">
        <header class="policy-header text-center mb-5">
          <h1>CHÍNH SÁCH BẢO MẬT</h1>
          <p class="lead text-muted">
            Literary Haven cam kết bảo vệ quyền riêng tư và bảo mật thông tin cá
            nhân của khách hàng.
          </p>
        </header>

        <section class="policy-section mb-4">
          <h2>1. Mục đích thu thập thông tin</h2>
          <p>Chúng tôi thu thập thông tin cá nhân của khách hàng nhằm:</p>
          <ul>
            <li>
              Hỗ trợ khách hàng trong quá trình mua sắm, đặt hàng và giao hàng.
            </li>
            <li>
              Cung cấp dịch vụ, cập nhật khuyến mãi, tin tức và sản phẩm mới.
            </li>
            <li>
              Liên hệ xác nhận đơn hàng, phản hồi yêu cầu hoặc hỗ trợ kỹ thuật.
            </li>
          </ul>
        </section>

        <section class="policy-section mb-4">
          <h2>2. Phạm vi thu thập thông tin</h2>
          <p>Các thông tin cá nhân được thu thập bao gồm:</p>
          <ul>
            <li>Họ và tên, địa chỉ, số điện thoại, email.</li>
            <li>
              Tài khoản đăng nhập, lịch sử giao dịch và phản hồi của khách hàng.
            </li>
            <li>
              Thông tin thanh toán (nếu khách hàng chọn phương thức online).
            </li>
          </ul>
        </section>

        <section class="policy-section mb-4">
          <h2>3. Thời gian lưu trữ thông tin</h2>
          <p>
            Thông tin cá nhân của khách hàng sẽ được lưu trữ cho đến khi khách
            hàng yêu cầu xóa hoặc khi tài khoản không còn hoạt động quá 12
            tháng.
          </p>
        </section>

        <section class="policy-section mb-4">
          <h2>4. Bảo mật thông tin</h2>
          <p>
            Literary Haven áp dụng các biện pháp bảo mật nghiêm ngặt để đảm bảo
            an toàn cho dữ liệu cá nhân, bao gồm mã hóa, tường lửa và giới hạn
            quyền truy cập của nhân viên.
          </p>
        </section>

        <section class="policy-section mb-4">
          <h2>5. Quyền của khách hàng</h2>
          <p>Khách hàng có quyền:</p>
          <ul>
            <li>Yêu cầu xem, chỉnh sửa hoặc xóa thông tin cá nhân của mình.</li>
            <li>Từ chối nhận thông tin quảng cáo bất kỳ lúc nào.</li>
            <li>
              Gửi phản hồi hoặc khiếu nại về việc lạm dụng thông tin cá nhân.
            </li>
          </ul>
        </section>

        <section class="policy-section mb-4">
          <h2>6. Liên hệ</h2>
          <p>
            Nếu bạn có bất kỳ thắc mắc nào liên quan đến chính sách bảo mật, vui
            lòng liên hệ:
          </p>
          <ul>
            <li>Hotline: <strong>1900 xxxx</strong></li>
            <li>Email: <strong>support@bookstore.vn</strong></li>
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

    <script src="../assets/js/main.js"></script>
  </body>
</html>
