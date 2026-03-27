<?php
require_once __DIR__ . '/../api/db.php';

$indexProducts = [];
$res = $conn->query("
  SELECT p.id, p.sku, p.name, p.author, p.price, p.image AS img, p.qty,
         c.name AS category, p.subcategory
  FROM products p
  JOIN categories c ON p.category_id = c.id
  WHERE (p.qty IS NULL OR p.qty > 0)
  ORDER BY p.id DESC
  LIMIT 8
");
if ($res) {
  while ($row = $res->fetch_assoc()) {
    $indexProducts[] = $row;
  }
}

function fmtPrice($price)
{
  return number_format((int) $price, 0, ',', '.') . '₫';
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Nhà Sách Online</title>

  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <!-- CSS chính -->
  <link rel="stylesheet" href="../assets/css/style.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />

  <style>
    .container {
      margin: 0 auto;
      padding: 2rem 0;
      padding-top: 10rem;
    }

    /* ================= Banner ================= */
    .all-books a {
      border-radius: 3rem;
    }

    /* ================= About us ================= */
    .intro-title {
      font-family: "Times New Roman", Times, serif;
      font-size: 3rem;
    }

    .intro-title span {
      font-family: "Times New Roman", Times, serif;
    }


    /* ========================================================= */
    /* 4. Phần CTA */
    /* ========================================================= */
    .cta {
      display: flex;
      align-items: center;
      justify-content: space-between;

      padding: 4rem 3rem;
      margin: 2rem auto;
      max-width: 1400px;

      background: linear-gradient(135deg, #88b3da, #ffffff);
      border-radius: 4rem;
    }

    /* Nội dung ở giữa */
    .cta-content {
      text-align: center;
      max-width: 520px;
      margin: 0 auto;
    }

    /* Tiêu đề */
    .cta h2 {
      font-size: 42px;
      color: #1f3c88;
      margin-bottom: 1rem;
    }

    /* Mô tả */
    .cta p {
      font-size: 30px;
      color: #555;
      margin-bottom: 2.2rem;
    }

    /* Nút */
    .cta-buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    /* Ảnh 2 bên */
    .cta-img {
      width: 320px;
      max-width: 100%;
    }

    /* Button chung */
    .btn {
      padding: 14px 28px;
      border-radius: 30px;
      font-size: 16px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    /* Button phụ */
    .btn-secondary {
      background-color: #00a8a8;
      color: #fff;
    }

    .btn-secondary:hover {
      background-color: #008b8b;
    }

    /* 📱 Responsive */
    @media (max-width: 992px) {
      .cta {
        padding: 3rem 2rem;
      }

      .cta-img {
        width: 180px;
      }
    }

    @media (max-width: 768px) {
      .cta {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
      }

      .cta-img {
        width: 160px;
      }
    }



    /* ========================================================= */
    /* 7. GIỎ HÀNG & THANH LỌC */
    /* ========================================================= */
    .products-top {
      display: flex;
      align-items: center;
      gap: 20px;
      margin: 20px 0 3rem 0;
      flex-wrap: wrap;
    }

    .cart-heading {
      display: inline-block;
      background: linear-gradient(135deg, #82c09a 0%, #7fb3d3 100%);
      padding: 10px 20px;
      color: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(250, 248, 248, 0.007);
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    /* Responsive cho thiết bị di động (dưới 768px) */
    @media (max-width: 767px) {
      .container {
        height: 100%;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
      }

      /* Thêm các quy tắc này để căn giữa nội dung footer trên di động */
      .footer-section {
        text-align: center;
      }

      .footer-section .social-links {
        justify-content: center;
      }

      .footer-section.contact-info p {
        justify-content: center;
        /* Căn giữa cho các dòng liên hệ */
      }

      /* About us */
      .col-md-6 {
        position: relative;
        top: 2rem;
      }

      .py-5 {
        padding: 15rem 0;
        height: 60rem;
      }

      .col-md-6-nd {
        position: relative;
        top: 10rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }

      .hot_sale_selection {
        height: 120rem;
      }

      .col-12 {
        margin: 1rem 9rem;
      }
    }

    /* Responsive cho thiết bị di động (trên 769px) */
    @media (min-width: 768px) {
      .search-center {
        margin: 0 150px;
      }

      .navbar .menu li a {
        width: 8rem;
      }

      .category-btn {
        width: 9rem;
      }
    }

    .col-6 {
      text-align: center;
    }

    .text-secondary {
      font-size: 20px;
    }
  </style>

  <!-- Nút back to top -->
  <script>
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
    document
      .getElementById("backToTop")
      .addEventListener("click", function() {
        window.scrollTo({
          top: 0,
          behavior: "smooth"
        });
      });

    // Ghi đè bootrap
    document.addEventListener("DOMContentLoaded", () => {
      const carousels = document.querySelectorAll(".carousel");

      carousels.forEach((carousel) => {
        const slides = Array.from(
          carousel.querySelectorAll(".carousel-item")
        );
        const prevBtn = carousel.querySelector(".carousel-control-prev");
        const nextBtn = carousel.querySelector(".carousel-control-next");

        if (!slides.length) return;

        let index = slides.findIndex((s) => s.classList.contains("active"));
        if (index === -1) index = 0;
        // đảm bảo chỉ 1 active ban đầu
        slides.forEach((s, i) =>
          i === index ?
          s.classList.add("active") :
          s.classList.remove("active")
        );

        let isAnimating = false;

        function cleanupClasses(current, next) {
          // dọn mọi lớp tạm thời, chỉ giữ active cho next
          slides.forEach((s) =>
            s.classList.remove(
              "slide-left-enter",
              "slide-right-enter",
              "slide-left-leave",
              "slide-right-leave"
            )
          );
          current.classList.remove("active");
          next.classList.add("active");
        }

        function showSlide(newIndex, direction) {
          if (isAnimating || newIndex === index) return;
          isAnimating = true;

          const current = slides[index];
          const next = slides[newIndex];

          // trước hết dọn lớp có thể còn sót (an toàn)
          slides.forEach((s) =>
            s.classList.remove(
              "slide-left-enter",
              "slide-right-enter",
              "slide-left-leave",
              "slide-right-leave"
            )
          );

          // gán lớp leave/enter tương ứng
          current.classList.add(
            direction === "left" ? "slide-left-leave" : "slide-right-leave"
          );
          next.classList.add(
            direction === "left" ? "slide-left-enter" : "slide-right-enter"
          );

          // force reflow để đảm bảo transition kích hoạt (an toàn trên nhiều trình duyệt)
          // eslint-disable-next-line no-unused-expressions
          next.offsetWidth;

          // lắng nghe transitionend trên phần tử "next" (hoặc current) và chỉ chạy 1 lần
          const onEnd = (e) => {
            // một số trình duyệt sẽ fire nhiều lần (opacity, transform...), nên kiểm tra target là next
            if (e.target !== next) return;
            // cleanup và cập nhật index
            cleanupClasses(current, next);
            index = newIndex;
            isAnimating = false;
          };

          next.addEventListener("transitionend", onEnd, {
            once: true
          });

          // Fallback: nếu transitionend không fire (ví dụ CSS bị ghi đè), đặt timeout đảm bảo unlock
          const fallback = setTimeout(() => {
            if (isAnimating) {
              cleanupClasses(current, next);
              index = newIndex;
              isAnimating = false;
            }
          }, 600); // bằng với thời lượng transition trong CSS (ví dụ 450ms), đặt cao hơn tí

          // đảm bảo clear fallback khi onEnd chạy
          next.addEventListener(
            "transitionend",
            () => clearTimeout(fallback), {
              once: true
            }
          );
        }

        prevBtn &&
          prevBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const newIndex = (index - 1 + slides.length) % slides.length;
            showSlide(newIndex, "left");
          });

        nextBtn &&
          nextBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const newIndex = (index + 1) % slides.length;
            showSlide(newIndex, "right");
          });
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

  <!-- Banner -->
  <main class="container">
    <div class="banner-center">
      <section class="banner">
        <div class="banner-content">
          <h1>Literary Haven xin chào!</h1>
          <h2>"The Home, All Tomes"</h2>
          <p>Hàng ngàn tựa sách hay đang chờ bạn</p>
          <div class="all-books">
            <a href="category.php" data-category="all" class="active">Tất cả Sách</a>
          </div>
        </div>
      </section>
    </div>

    <!-- Phần about us -->
    <section class="about-section py-5">
      <div class="about-us-index">
        <div class="row align-items-center">

          <div class="col-md-6 mb-4 mb-md-0">
            <div class="image-stack position-relative">
              <a href="./about.php">
                <img
                  src="../images/library1.jpg"
                  class="img-fluid img-1"
                  alt="Ảnh 1" />
                <img
                  src="../images/library2.jpg"
                  class="img-fluid img-2"
                  alt="Ảnh 2" />
                <img
                  src="../images/library3.jpg"
                  class="img-fluid img-3"
                  alt="Ảnh 3" />
              </a>
            </div>
          </div>

          <div class="col-md-6 col-md-6-nd">
            <h2 class="intro-title">
              Giới thiệu <span>Literary Haven!</span>
            </h2>
            <p class="text-secondary">
              Literary Haven được biết đến là một trong những thương hiệu hàng
              đầu về dòng sách quản trị kinh doanh, phát triển kỹ năng, tài
              chính, đầu tư... với các cuốn sách hướng dẫn khởi nghiệp, các
              bài học, phương pháp và kinh nghiệm quản trị của các chuyên gia,
              và các tập đoàn nổi tiếng trên thế giới.
            </p>
            <p class="text-secondary">
              Sau nhiều năm hình thành và phát triển, Literary Haven đã từng
              bước khẳng định tên tuổi của mình, đặc biệt đối với các thế hệ
              doanh nhân, nhà quản lý và những người trẻ luôn khát khao xây
              dựng sự nghiệp thành công.
            </p>
            <a
              href="./about.php"
              class="btn btn-warning text-white rounded-pill px-4 py-2">
              XEM THÊM →
            </a>
          </div>

        </div>
      </div>
    </section>

    <!-- Phần Kêu gọi -->
    <section class="cta">
      <img src="../images/cta1.png" alt="Đọc sách" class="cta-img left">

      <div class="cta-content">
        <h2>🎯 Sẵn sàng bắt đầu hành trình đọc sách?</h2>
        <p>Khám phá kho tàng tri thức cùng chúng tôi!</p>

        <div class="cta-buttons">
          <a href="category.php" class="btn btn-secondary">Xem thể loại</a>
        </div>
      </div>

      <img src="../images/cta2.png" alt="Học tập" class="cta-img right">
    </section>

  </main>

  <!-- Nút quay lên đầu trang -->
  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
    </i>
  </a>
  <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
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
  </div>

  <div class="footer-bottom">
    <p>&copy; 2025 Book Store. All rights reserved. | Designed with ❤️</p>
  </div>
</footer>

<?php include '../includes/auth_modals.php'; ?>

<script src="../assets/js/main.js"></script>
<script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

</html>