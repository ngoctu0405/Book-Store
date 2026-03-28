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
    href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />

  <style>
    .container_1 {
      position: relative;
      top: 5rem;
      height: 120rem;
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
      top: 5.5rem;
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

  <!-- CHÍNH SÁCH ĐỔI TRẢ HÀNG -->
  <div class="container_1">
    <main class="policy-container container py-5">
      <header class="policy-header text-center mb-5">
        <h1>CHÍNH SÁCH ĐỔI TRẢ HÀNG</h1>
        <p class="lead text-muted">
          Quy định về đổi, trả và hoàn tiền cho khách hàng tại Literary Haven.
        </p>
      </header>

      <section class="policy-section mb-4">
        <h2>1. Giới thiệu và mục đích</h2>
        <p>
          Chính sách đổi trả hàng của Literary Haven được xây dựng nhằm đảm
          bảo quyền lợi tối đa cho khách hàng. Chúng tôi cam kết hỗ trợ đổi
          hàng hoặc hoàn tiền trong các trường hợp sản phẩm lỗi, giao nhầm
          hoặc khách hàng thay đổi quyết định, đồng thời hướng dẫn rõ ràng quy
          trình thực hiện để khách hàng dễ dàng thực hiện.
        </p>
      </section>

      <section class="policy-section mb-4">
        <h2>2. Thời gian hỗ trợ đổi trả</h2>
        <ul>
          <li>Hỗ trợ trong 30 ngày kể từ ngày nhận hàng.</li>
          <li>
            Không áp dụng cho các sản phẩm hạn chế, sách giảm giá, sách cũ,
            hoặc sách đặt riêng.
          </li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>3. Điều kiện đổi trả</h2>
        <table>
          <tr>
            <th>Lý do</th>
            <th>Điều kiện</th>
          </tr>
          <tr>
            <td>Sách lỗi kỹ thuật</td>
            <td>Thiếu trang, mờ, sai nội dung, nhòe mực, đảo trang</td>
          </tr>
          <tr>
            <td>Giao nhầm/sai tựa/sai số lượng</td>
            <td>Sách chưa sử dụng, còn nguyên tem, bao bì</td>
          </tr>
          <tr>
            <td>Khách đổi ý</td>
            <td>Sách nguyên mới, chưa bọc, chưa ghi chú, chưa sử dụng</td>
          </tr>
          <tr>
            <td>Hư hỏng trong vận chuyển</td>
            <td>Cần có video mở kiện và hình ảnh sản phẩm</td>
          </tr>
        </table>
      </section>

      <section class="policy-section mb-4">
        <h2>4. Danh mục không áp dụng đổi trả</h2>
        <ul>
          <li>Sách giảm giá, sách thanh lý, sách cũ, sách đặt riêng.</li>
          <li>Báo, tạp chí, băng đĩa, sản phẩm điện tử đi kèm.</li>
          <li>Sản phẩm đã bọc bookcare hoặc dán nhãn cá nhân hóa.</li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>5. Quy trình đổi trả chi tiết</h2>
        <ul>
          <li>
            <strong>Bước 1:</strong> Liên hệ hotline hoặc email để thông báo
            về nhu cầu đổi trả.
          </li>
          <li>
            <strong>Bước 2:</strong> Cung cấp thông tin đơn hàng, hình ảnh
            hoặc video sản phẩm lỗi.
          </li>
          <li>
            <strong>Bước 3:</strong> Gửi trả hàng qua vận chuyển hoặc mang
            trực tiếp đến cửa hàng.
          </li>
          <li>
            <strong>Bước 4:</strong> Literary Haven xác nhận và thực hiện đổi
            hàng hoặc hoàn tiền theo đúng thỏa thuận.
          </li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>6. Ví dụ minh họa</h2>
        <ul>
          <li>
            Nếu khách nhận sách bị nhòe mực hoặc thiếu trang, khách hàng có
            thể gửi hình ảnh minh chứng, và chúng tôi sẽ gửi sách mới trong
            vòng 1–2 ngày.
          </li>
          <li>
            Khách đổi ý mua một cuốn sách nhưng chưa mở ra có thể gửi trả và
            chọn cuốn khác hoặc nhận hoàn tiền.
          </li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>7. Lưu ý và mẹo thực hiện</h2>
        <ul>
          <li>
            Kiểm tra sách kỹ lưỡng ngay khi nhận hàng để kịp thời phát hiện
            lỗi.
          </li>
          <li>
            Giữ nguyên bao bì, tem và sách ở trạng thái nguyên vẹn trước khi
            gửi trả.
          </li>
          <li>
            Thực hiện theo quy trình hướng dẫn để được hỗ trợ nhanh chóng và
            thuận tiện.
          </li>
        </ul>
      </section>

      <section class="policy-section mb-4">
        <h2>8. Liên hệ đổi trả</h2>
        <ul>
          <li>
            <strong>Địa chỉ:</strong> 123 Nguyễn Văn Linh, Quận 7, TP.HCM
          </li>
          <li><strong>Hotline:</strong> 1900 xxxx</li>
          <li><strong>Email:</strong> support@bookstore.vn</li>
          <li><strong>Giờ làm việc:</strong> 8:00 – 22:00</li>
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
  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
    </i>
  </a>
  <script src="../assets/js/main.js?v=2"></script>
  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>