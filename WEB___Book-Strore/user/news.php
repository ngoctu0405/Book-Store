<?php
// 1. Chuẩn bị thông tin giao diện
$pageTitle = "Tin Tức - Nhà Sách Online";

// 2. Gói CSS riêng của trang Tin Tức
ob_start();
?>
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
<?php
$extraCss = ob_get_clean();

// 3. Gọi Header (Tự động tải Menu, Thanh tìm kiếm, Database...)
include '../includes/header.php';
?>

<main class="container">
  <section class="featured-news">
    <h1>Tin nổi bật trong ngày</h1>
    <div class="featured-card">
      <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800" alt="Tin nổi bật" />
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

  <div class="news-grid">
    <article class="news-card">
      <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600" alt="Sách mới" />
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
      <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600" alt="Tác giả" />
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
      <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600" alt="Khuyến mãi" />
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
      <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=600" alt="Review" />
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
      <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600" alt="Sự kiện" />
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
      <img src="https://images.unsplash.com/photo-1519682337058-a94d519337bc?w=600" alt="Tips" />
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

<a href="#" id="backToTop" class="back-to-top" title="Lên đầu trang">
  <i class="bi bi-chevron-up">
    <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
  </i>
</a>

<?php
// 5. Gói Script xử lý Nút quay về đầu trang
ob_start();
?>
<script>
  window.onscroll = function() {
    const btn = document.getElementById("backToTop");
    if (btn) {
      if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        btn.style.display = "block";
      } else {
        btn.style.display = "none";
      }
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
  });
</script>
<?php
$extraJs = ob_get_clean();

// 6. Gọi Footer chung
include '../includes/footer.php';
?>