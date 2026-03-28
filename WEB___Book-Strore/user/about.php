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
    href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
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
        class="container d-flex flex-wrap align-items-center justify-content-between">
        <div class="col-md-6 mb-4 mb-md-0 text-center">
          <img
            src="../images/Vision.jpg"
            alt="Hình minh họa Literary Haven"
            class="img-fluid rounded shadow" />
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
        class="container d-flex flex-wrap align-items-center justify-content-between">
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
            class="img-fluid rounded shadow" />
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
  <?php include '../includes/auth_modals.php'; ?>
  <!-- Nút quay lên đầu trang -->
  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
    </i>
  </a>
  <script src="../assets/js/main.js?v=2"></script>
  <script src="../bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
</body>

</html>
