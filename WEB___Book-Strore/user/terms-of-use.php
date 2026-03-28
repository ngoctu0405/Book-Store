<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Điều Khoản Sử Dụng - Literary Haven</title>
     <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
    <style>
      .container_1 {
        position: relative;
        margin: 7rem auto;
      }

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
      .policy-container {
        position: relative;
        top: 5rem;
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
          <button
            class="category-btn"
            
          >
            Danh mục ▾
          </button>

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

    <!-- PHẦN ĐIỀU KHOẢN SỬ DỤNG -->
    <div class="container_1">
      <main class="policy-container container py-5">
        <header class="policy-header text-center mb-5">
          <h1>ĐIỀU KHOẢN SỬ DỤNG</h1>
          <p class="lead text-muted">
            Quy định về việc truy cập, sử dụng và tương tác với dịch vụ của
            Literary Haven.
          </p>
        </header>

        <section class="policy-section mb-4">
          <h2>1. Chấp nhận điều khoản</h2>
          <p>
            Khi truy cập và sử dụng trang web Literary Haven, bạn đồng ý tuân
            thủ tất cả các điều khoản, điều kiện và quy định được nêu trong
            trang này. Nếu bạn không đồng ý, vui lòng ngừng sử dụng dịch vụ.
          </p>
        </section>

        <section class="policy-section mb-4">
          <h2>2. Quyền và nghĩa vụ của người dùng</h2>
          <ul>
            <li>
              Người dùng có quyền truy cập, tìm kiếm và mua sản phẩm hợp pháp
              trên trang web.
            </li>
            <li>
              Không được thực hiện các hành vi gây ảnh hưởng đến hệ thống, nội
              dung hoặc uy tín của Literary Haven.
            </li>
            <li>
              Người dùng chịu trách nhiệm về thông tin cá nhân và hành vi của
              mình khi sử dụng dịch vụ.
            </li>
          </ul>
        </section>

        <section class="policy-section mb-4">
          <h2>3. Quyền và nghĩa vụ của Literary Haven</h2>
          <ul>
            <li>
              Literary Haven có quyền thay đổi, tạm ngừng hoặc chấm dứt dịch vụ
              mà không cần thông báo trước.
            </li>
            <li>
              Chúng tôi cam kết bảo mật thông tin cá nhân của khách hàng theo
              <a href="privacy-policy.php">Chính sách bảo mật</a>.
            </li>
            <li>
              Literary Haven không chịu trách nhiệm về thiệt hại phát sinh do
              việc người dùng sử dụng sai mục đích.
            </li>
          </ul>
        </section>

        <section class="policy-section mb-4">
          <h2>4. Sở hữu trí tuệ</h2>
          <p>
            Tất cả nội dung, hình ảnh, logo, mã nguồn và tài liệu trên trang web
            Literary Haven đều thuộc quyền sở hữu của chúng tôi hoặc các đối tác
            hợp pháp. Nghiêm cấm sao chép, sử dụng hoặc phân phối mà không có sự
            cho phép bằng văn bản.
          </p>
        </section>

        <section class="policy-section mb-4">
          <h2>5. Thay đổi điều khoản</h2>
          <p>
            Literary Haven có thể cập nhật hoặc điều chỉnh các điều khoản sử
            dụng này bất kỳ lúc nào. Các thay đổi sẽ được đăng tải trên trang
            này và có hiệu lực ngay khi được công bố.
          </p>
        </section>

        <section class="policy-section mb-4">
          <h2>6. Liên hệ</h2>
          <p>
            Mọi thắc mắc liên quan đến Điều khoản sử dụng, vui lòng liên hệ:
          </p>
          <ul>
            <li>Email: <strong>support@bookstore.vn</strong></li>
            <li>Hotline: <strong>1900 xxxx</strong></li>
          </ul>
        </section>
      </main>
    </div>

    <!-- FOOTER GIỮ NGUYÊN -->
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
      <div class="footer-bottom">
        <p>&copy; 2025 Book Store. All rights reserved. | Designed with ❤️</p>
      </div>
    </footer>

    <script src="../assets/js/main.js?v=2"></script>
    <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
