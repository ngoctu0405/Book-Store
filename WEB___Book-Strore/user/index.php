<?php
// Chuẩn bị giao diện
$pageTitle = "Nhà Sách Online - Literary Haven";

// Gói CSS riêng của trang chủ
ob_start();
?>
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
  /* Phần CTA */
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

  .cta-content {
    text-align: center;
    max-width: 520px;
    margin: 0 auto;
  }

  .cta h2 {
    font-size: 42px;
    color: #1f3c88;
    margin-bottom: 1rem;
  }

  .cta p {
    font-size: 30px;
    color: #555;
    margin-bottom: 2.2rem;
  }

  .cta-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
  }

  .cta-img {
    width: 320px;
    max-width: 100%;
  }

  .btn {
    padding: 14px 28px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .btn-secondary {
    background-color: #00a8a8;
    color: #fff;
  }

  .btn-secondary:hover {
    background-color: #008b8b;
  }

  /* Responsive CTA */
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
  /* GIỎ HÀNG & THANH LỌC */
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

  /* Responsive Mobile (dưới 768px) */
  @media (max-width: 767px) {
    .container {
      height: 100%;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .footer-section {
      text-align: center;
    }

    .footer-section .social-links {
      justify-content: center;
    }

    .footer-section.contact-info p {
      justify-content: center;
    }

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

  /* Responsive Tablet/Desktop (trên 769px) */
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
<?php
$extraCss = ob_get_clean();

// Gọi header chung (Bao gồm kết nối DB, Navbar tự động...)
include '../includes/header.php';
?>

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

  <section class="about-section py-5">
    <div class="about-us-index">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <div class="image-stack position-relative">
            <a href="./about.php">
              <img src="../images/library1.jpg" class="img-fluid img-1" alt="Ảnh 1" />
              <img src="../images/library2.jpg" class="img-fluid img-2" alt="Ảnh 2" />
              <img src="../images/library3.jpg" class="img-fluid img-3" alt="Ảnh 3" />
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
          <a href="./about.php" class="btn btn-warning text-white rounded-pill px-4 py-2">
            XEM THÊM →
          </a>
        </div>
      </div>
    </div>
  </section>

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

<a href="#" id="backToTop" class="back-to-top" title="Lên đầu trang">
  <i class="bi bi-chevron-up">
    <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
  </i>
</a>

<?php
// Gói Script xử lý Nút quay về đầu trang và Carousel vào $extraJs
ob_start();
?>
<script>
  window.onscroll = function() {
    const btn = document.getElementById("backToTop");
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
      btn.style.display = "block";
    } else {
      btn.style.display = "none";
    }
  };

  document.addEventListener("DOMContentLoaded", () => {
    const backBtn = document.getElementById("backToTop");
    if (backBtn) {
      backBtn.addEventListener("click", function(e) {
        e.preventDefault();
        window.scrollTo({
          top: 0,
          behavior: "smooth"
        });
      });
    }

    // Ghi đè bootstrap Carousel
    const carousels = document.querySelectorAll(".carousel");
    carousels.forEach((carousel) => {
      const slides = Array.from(carousel.querySelectorAll(".carousel-item"));
      const prevBtn = carousel.querySelector(".carousel-control-prev");
      const nextBtn = carousel.querySelector(".carousel-control-next");

      if (!slides.length) return;

      let index = slides.findIndex((s) => s.classList.contains("active"));
      if (index === -1) index = 0;
      slides.forEach((s, i) => i === index ? s.classList.add("active") : s.classList.remove("active"));

      let isAnimating = false;

      function cleanupClasses(current, next) {
        slides.forEach((s) => s.classList.remove("slide-left-enter", "slide-right-enter", "slide-left-leave", "slide-right-leave"));
        current.classList.remove("active");
        next.classList.add("active");
      }

      function showSlide(newIndex, direction) {
        if (isAnimating || newIndex === index) return;
        isAnimating = true;

        const current = slides[index];
        const next = slides[newIndex];

        slides.forEach((s) => s.classList.remove("slide-left-enter", "slide-right-enter", "slide-left-leave", "slide-right-leave"));
        current.classList.add(direction === "left" ? "slide-left-leave" : "slide-right-leave");
        next.classList.add(direction === "left" ? "slide-left-enter" : "slide-right-enter");

        next.offsetWidth;

        const onEnd = (e) => {
          if (e.target !== next) return;
          cleanupClasses(current, next);
          index = newIndex;
          isAnimating = false;
        };

        next.addEventListener("transitionend", onEnd, {
          once: true
        });

        const fallback = setTimeout(() => {
          if (isAnimating) {
            cleanupClasses(current, next);
            index = newIndex;
            isAnimating = false;
          }
        }, 600);

        next.addEventListener("transitionend", () => clearTimeout(fallback), {
          once: true
        });
      }

      prevBtn && prevBtn.addEventListener("click", (e) => {
        e.preventDefault();
        showSlide((index - 1 + slides.length) % slides.length, "left");
      });

      nextBtn && nextBtn.addEventListener("click", (e) => {
        e.preventDefault();
        showSlide((index + 1) % slides.length, "right");
      });
    });
  });
</script>
<?php
$extraJs = ob_get_clean();

// Gọi footer chung
include '../includes/footer.php';
?>