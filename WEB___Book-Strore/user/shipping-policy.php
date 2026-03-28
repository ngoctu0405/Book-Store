<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Chính Sách Vận Chuyển - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link
    rel="stylesheet"
    href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <style>
    .container_1 {
      position: relative;
      margin: 10rem auto;
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
      top: 3.5rem;
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
  </style>

  <!-- Nút back to top -->
  <script>
    // Khi cuộn xuống 300px thì hiện nút
    window.onscroll = function() {
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
      .addEventListener("click", function() {
        window.scrollTo({
          top: 0,
          behavior: "smooth"
        });
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

  <a id="back" href="index.php">&larr; Quay lại trang chủ</a>

  <!-- CHÍNH SÁCH VẬN CHUYỂN -->
  <div class="container_1">
    <main class="policy-container container py-5">
      <header class="policy-header text-center mb-5">
        <h1>CHÍNH SÁCH VẬN CHUYỂN</h1>
        <p class="lead text-muted">
          Quy định về giao hàng, vận chuyển và nhận sách tại Literary Haven.
        </p>
      </header>

      <section class="policy-section mb-4">
        <h2>1. Giới thiệu</h2>
        <p>
          Tại Literary Haven, chúng tôi hiểu rằng việc nhận sách đúng thời
          gian và trong tình trạng hoàn hảo là vô cùng quan trọng đối với mọi
          độc giả. Do đó, chúng tôi cam kết cung cấp dịch vụ nhanh chóng, an
          toàn và uy tín, đảm bảo mọi đơn hàng được xử lý kỹ lưỡng trước khi
          xuất kho. Mọi đơn hàng, dù nhỏ hay lớn, đều được đóng gói cẩn thận
          với các vật liệu bảo vệ sách, tránh hư hỏng trong quá trình vận
          chuyển.
        </p>
      </section>

      <section class="policy-section mb-4">
        <h2>2. Khu vực giao hàng và phí vận chuyển</h2>
        <ul>
          <li>
            Khu vực trung tâm TP.HCM: Quận 1, 3, 4, 5, 6, 7, 8, 10, 11. Phí:
            25.000 VNĐ/đơn. Thời gian: 4–24 giờ.
          </li>
          <li>
            Khu vực ngoại thành: Bình Tân, Tân Phú, Thủ Đức, Tân Bình, Q12 và
            các khu vực khác. Phí: 35.000 VNĐ/đơn. Thời gian: 1–3 ngày.
          </li>
          <li>
            Đơn hàng gấp/hỏa tốc: Phí theo đơn vị vận chuyển. Liên hệ để tư
            vấn.
          </li>
          <li>
            Đơn hàng đi tỉnh: Liên hệ chăm sóc khách hàng để được báo giá và
            thời gian dự kiến.
          </li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>3. Thời gian xử lý và giao hàng</h2>
        <ul>
          <li>
            Mọi đơn hàng sẽ được kiểm tra, xác nhận và đóng gói trong vòng 24
            giờ kể từ khi thanh toán thành công.
          </li>
          <li>Thời gian giao hàng nội thành: 4–24 giờ, tùy khu vực.</li>
          <li>
            Thời gian giao hàng các tỉnh: 2–5 ngày, tùy khoảng cách và đơn vị
            vận chuyển.
          </li>
          <li>
            Đơn hàng hỏa tốc: Thời gian giao hàng được thông báo khi khách
            hàng lựa chọn dịch vụ.
          </li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>4. Phương thức giao hàng</h2>
        <ul>
          <li>
            Giao tận nơi: Nhân viên giao hàng sẽ mang sách đến địa chỉ khách
            hàng cung cấp.
          </li>
          <li>
            Nhận tại cửa hàng: Khách hàng có thể đến trực tiếp cửa hàng
            Literary Haven để nhận sách.
          </li>
          <li>
            Giao hàng hỏa tốc: Đảm bảo giao nhanh trong ngày hoặc theo yêu
            cầu.
          </li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>5. Kiểm tra và nhận hàng</h2>
        <ul>
          <li>
            Khi nhận sách, khách hàng nên kiểm tra số lượng, tựa sách và tình
            trạng sách trước khi ký nhận.
          </li>
          <li>
            Nếu phát hiện lỗi in, thiếu trang hoặc hư hỏng trong quá trình vận
            chuyển, khách hàng có quyền từ chối nhận hàng và liên hệ Literary
            Haven để được xử lý.
          </li>
          <li>
            Lưu ý: kiểm tra kỹ trước khi nhận giúp tránh nhầm lẫn và đảm bảo
            quyền lợi của khách hàng.
          </li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>6. Chính sách trả hàng và hoàn tiền</h2>
        <ul>
          <li>
            Trả hàng: Trong vòng 3 ngày kể từ khi nhận nếu sản phẩm sai, thiếu
            hoặc hư hỏng.
          </li>
          <li>
            Hoàn tiền: Thực hiện theo phương thức thanh toán ban đầu hoặc theo
            thỏa thuận.
          </li>
          <li>
            Ví dụ: Nếu khách đặt sách làm quà nhưng nhận sách bị rách, có thể
            từ chối nhận hoặc trả lại để được hoàn tiền ngay.
          </li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>7. Liên hệ</h2>
        <ul>
          <li>Địa chỉ: 123 Nguyễn Văn Linh, Quận 7, TP.HCM</li>
          <li>Hotline: 1900 xxxx</li>
          <li>Email: support@bookstore.vn</li>
          <li>Giờ làm việc: 8:00 – 22:00</li>
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

  <?php include '../includes/auth_modals.php'; ?>
  <script src="../assets/js/main.js?v=2"></script>
  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
    </i>
  </a>
</body>

</html>
