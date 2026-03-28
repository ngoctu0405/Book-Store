<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Câu hỏi thường gặp | Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <!-- CSS chính -->
  <link rel="stylesheet" href="../assets/css/style.css" />
  <!-- Bootstrap -->
  <link
    rel="stylesheet"
    href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />

  <style>
    .container {
      position: relative;
      top: 2rem;
      max-width: 800px;
      margin: 200px auto;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .faq-item {
      border-bottom: 1px solid #ddd;
      padding: 15px 0;
    }

    .faq-question {
      cursor: pointer;
      position: relative;
      font-weight: bold;
      color: #444;
    }

    .faq-question::after {
      content: "+";
      position: absolute;
      right: 0;
      font-size: 22px;
      transition: transform 0.3s;
    }

    .faq-question.active::after {
      content: "-";
    }

    .faq-answer {
      display: none;
      margin-top: 10px;
      color: #555;
      line-height: 1.6;
      animation: fadeIn 0.3s ease-in-out;
    }

    .faq-answer div {
      margin-bottom: 8px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>
  <a id="top"></a>

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

  <div class="container">
    <h1>Câu hỏi thường gặp (FAQ)</h1>

    <div class="faq-item">
      <div class="faq-question">
        1. Tôi có cần tạo tài khoản để mua hàng không?
      </div>
      <div class="faq-answer">
        <div>
          Có, bạn cần tạo tài khoản để có thể đặt hàng trên Literary Haven.
        </div>
        <div>
          Việc tạo tài khoản giúp chúng tôi xác minh thông tin người mua, đảm
          bảo an toàn cho giao dịch và giúp bạn dễ dàng theo dõi lịch sử mua
          hàng.
        </div>
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        2. Cửa hàng có hỗ trợ đổi trả hàng không?
      </div>
      <div class="faq-answer">
        <div>
          Có. Bạn có thể đổi hoặc trả sản phẩm trong vòng 7 ngày kể từ khi
          nhận hàng nếu sản phẩm bị lỗi, hư hỏng hoặc không đúng mô tả.
        </div>
        <div>
          Để yêu cầu đổi trả, vui lòng liên hệ bộ phận hỗ trợ khách hàng qua
          email hoặc hotline, cung cấp mã đơn hàng và lý do đổi trả. Sau khi
          được xác nhận, bạn có thể gửi lại sản phẩm để được hoàn tiền hoặc
          đổi mới.
        </div>
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        3. Tôi có thể thanh toán bằng ví điện tử không?
      </div>
      <div class="faq-answer">
        <div>
          Tính năng thanh toán bằng ví điện tử hiện đang được cập nhật và sẽ
          sớm ra mắt trong thời gian tới.
        </div>
        <div>
          Hiện tại, cửa hàng chỉ hỗ trợ hình thức thanh toán trực tiếp khi
          nhận hàng (COD) hoặc chuyển khoản ngân hàng.
        </div>
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">4. Thời gian giao hàng mất bao lâu?</div>
      <div class="faq-answer">
        <div>
          Đơn hàng của bạn sẽ được xử lý trong vòng 24 giờ kể từ khi xác nhận
          thành công.
        </div>
        <div>
          Thời gian giao hàng nội thành thường từ 1–2 ngày làm việc, còn giao
          hàng toàn quốc từ 2–5 ngày tùy khu vực.
        </div>
        <div>
          Lưu ý: Thời gian giao hàng có thể thay đổi trong dịp lễ, Tết hoặc
          khi số lượng đơn tăng cao.
        </div>
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        5. Làm sao để tôi theo dõi đơn hàng của mình?
      </div>
      <div class="faq-answer">
        <div>
          Sau khi đặt hàng thành công, bạn sẽ nhận được email xác nhận cùng mã
          đơn hàng.
        </div>
        <div>
          Bạn có thể truy cập trang “Theo dõi đơn hàng” trên website và nhập
          mã đơn để xem trạng thái giao hàng.
        </div>
        <div>
          Nếu có vấn đề phát sinh, hãy liên hệ ngay với bộ phận chăm sóc khách
          hàng để được hỗ trợ kịp thời.
        </div>
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        6. Tôi có thể hủy đơn hàng sau khi đã đặt không?
      </div>
      <div class="faq-answer">
        <div>
          Bạn có thể hủy đơn hàng trong vòng 6 giờ kể từ khi đặt nếu đơn chưa
          được xử lý.
        </div>
        <div>
          Để hủy đơn, vui lòng đăng nhập tài khoản, vào mục “Đơn hàng của tôi”
          và chọn “Hủy đơn”. Sau khi đơn hàng được xử lý, yêu cầu hủy sẽ không
          thể thực hiện.
        </div>
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        7. Tôi có thể đặt hàng trước những cuốn sách sắp phát hành không?
      </div>
      <div class="faq-answer">
        <div>
          Có. Literary Haven cho phép bạn đặt trước các tựa sách sắp ra mắt để
          đảm bảo có hàng khi phát hành chính thức.
        </div>
        <div>
          Thông tin về ngày phát hành và ưu đãi đặc biệt cho các đơn hàng đặt
          trước sẽ được hiển thị rõ trên trang sản phẩm.
        </div>
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        8. Cửa hàng có chính sách giảm giá cho khách hàng thân thiết không?
      </div>
      <div class="faq-answer">
        <div>
          Có. Chúng tôi đang triển khai chương trình thành viên với nhiều ưu
          đãi hấp dẫn như giảm giá trực tiếp, mã khuyến mãi và tích điểm đổi
          quà.
        </div>
        <div>
          Khách hàng có tài khoản và thường xuyên mua sắm sẽ được cập nhật tự
          động vào chương trình này.
        </div>
      </div>
    </div>
  </div>

  <script>
    const questions = document.querySelectorAll(".faq-question");
    questions.forEach((q) => {
      q.addEventListener("click", () => {
        q.classList.toggle("active");
        const answer = q.nextElementSibling;
        answer.style.display =
          answer.style.display === "block" ? "none" : "block";
      });
    });
  </script>
  <!-- Nút quay lên đầu trang -->
  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
    </i>
  </a>
</body>
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
<!-- JS -->
<script src="../assets/js/main.js?v=2"></script>
<script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

</html>
