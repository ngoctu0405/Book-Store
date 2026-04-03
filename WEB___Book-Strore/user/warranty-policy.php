<?php
// 1. Cài đặt các biến thông tin riêng cho trang này
$pageTitle = "Chính Sách Bảo Hành - Literary Haven";

// 2. Gói CSS riêng của trang Chính sách bảo hành
ob_start();
?>
<style>
  body {
    background: #f8f9fa;
    /* Nền xám nhạt để làm nổi bật khung nội dung trắng */
  }

  .container_1 {
    position: relative;
    top: 2rem;
    padding-bottom: 5rem;
  }

  /* Định dạng nút Quay lại */
  #back {
    display: inline-block;
    background: linear-gradient(135deg, #4f9da6 0%, #82c09a 100%);
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 8px;
    transition: 0.3s ease;
    font-weight: 600;
    margin: 6rem 0 0 2rem;
    /* Đẩy xuống tránh bị menu che */
    position: relative;
    z-index: 10;
  }

  #back:hover {
    transform: translateX(-5px);
    box-shadow: 0 4px 10px rgba(79, 157, 166, 0.3);
    color: white;
  }

  section {
    padding: 1rem 0;
  }

  .policy-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 3rem 4rem;
    background: #ffffff;
    color: #333;
    line-height: 1.8;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  }

  .policy-header h1 {
    font-size: 2.2rem;
    font-weight: 800;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
    color: #2c3e50;
  }

  .policy-section h2 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    border-left: 4px solid #4f9da6;
    padding-left: 12px;
  }

  .policy-section ul {
    list-style: disc;
    margin-left: 1.5rem;
  }

  .policy-section p,
  .policy-section li {
    font-size: 1.05rem;
    color: #555;
    margin-bottom: 0.8rem;
  }

  .policy-section li strong {
    color: #2c3e50;
  }

  .policy-container a {
    color: #4f9da6;
    text-decoration: none;
    font-weight: 500;
  }

  .policy-container a:hover {
    text-decoration: underline;
    color: #82c09a;
  }

  /* Responsive cho điện thoại */
  @media (max-width: 768px) {
    .policy-container {
      padding: 2rem 1.5rem;
      margin: 1rem;
      border-radius: 15px;
    }

    .policy-header h1 {
      font-size: 1.6rem;
    }

    #back {
      margin: 7rem 0 0 1rem;
    }
  }
</style>
<?php
$extraCss = ob_get_clean();

// 3. Gọi Header chung (Đã bao gồm Menu, Giỏ hàng, Database...)
include '../includes/header.php';
?>

<a id="back" href="index.php">&larr; Quay lại trang chủ</a>

<div class="container_1">
  <main class="policy-container container">
    <header class="policy-header text-center mb-5">
      <h1>CHÍNH SÁCH BẢO HÀNH</h1>
      <p class="lead text-muted">
        Quy định bảo hành và hỗ trợ sau bán hàng đối với các sản phẩm được mua tại Literary Haven.
      </p>
    </header>

    <section class="policy-section">
      <h2>1. Giới thiệu</h2>
      <p>
        Tại Literary Haven, chúng tôi luôn mong muốn mang đến những sản phẩm chất lượng tốt nhất. Tuy nhiên, nếu sản phẩm bạn nhận được gặp lỗi từ nhà sản xuất hoặc nhà xuất bản, chúng tôi cam kết hỗ trợ bảo hành và đổi mới theo đúng quy định dưới đây.
      </p>
    </section>

    <section class="policy-section">
      <h2>2. Điều kiện bảo hành</h2>
      <p>Sản phẩm được bảo hành hoặc đổi mới miễn phí nếu đáp ứng các điều kiện sau:</p>
      <ul>
        <li>Sản phẩm gặp lỗi kỹ thuật từ nhà xuất bản (như in mờ, thiếu trang, rách trang bên trong, sai nội dung, in ngược).</li>
        <li>Sản phẩm còn nguyên bao bì hoặc tem mác (đối với các mặt hàng có tem niêm phong).</li>
        <li>Thời gian yêu cầu bảo hành không vượt quá <strong>30 ngày</strong> kể từ ngày khách hàng nhận được sản phẩm.</li>
        <li>Có đầy đủ hóa đơn mua hàng hoặc thông tin xác nhận đơn hàng trên hệ thống của Literary Haven.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>3. Các trường hợp từ chối bảo hành</h2>
      <p>Chúng tôi rất tiếc không thể hỗ trợ bảo hành đối với các trường hợp sau:</p>
      <ul>
        <li>Sách bị hỏng do lỗi của người sử dụng (rách, ướt, cháy, dính bẩn, nhàu nát).</li>
        <li>Sản phẩm đã bị can thiệp, chỉnh sửa hoặc đánh dấu ghi chú.</li>
        <li>Sách nằm trong chương trình thanh lý, xả kho, hoặc sách cũ (đã được báo trước về tình trạng).</li>
        <li>Quá thời hạn bảo hành 30 ngày kể từ ngày nhận hàng.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>4. Quy trình bảo hành</h2>
      <ul>
        <li><strong>Bước 1:</strong> Khách hàng liên hệ với Literary Haven qua Hotline hoặc Email, cung cấp thông tin đơn hàng và video/hình ảnh chụp rõ lỗi của sản phẩm.</li>
        <li><strong>Bước 2:</strong> Bộ phận CSKH sẽ tiếp nhận, kiểm tra và xác nhận tình trạng lỗi trong vòng 24 giờ làm việc.</li>
        <li><strong>Bước 3:</strong> Sau khi xác nhận, khách hàng gửi lại sản phẩm lỗi cho chúng tôi (miễn phí vận chuyển đối với trường hợp lỗi từ NSX).</li>
        <li><strong>Bước 4:</strong> Literary Haven sẽ gửi sản phẩm mới hoàn toàn tới địa chỉ của khách hàng trong vòng 2-5 ngày làm việc.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>5. Thời gian xử lý bảo hành</h2>
      <ul>
        <li>Thời gian phản hồi khiếu nại: Tối đa <strong>24 giờ làm việc</strong>.</li>
        <li>Thời gian hoàn tất đổi/bảo hành sản phẩm: Từ <strong>3 - 7 ngày làm việc</strong> tùy thuộc vào khu vực địa lý của khách hàng và tình trạng tồn kho của sản phẩm.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>6. Liên hệ bảo hành</h2>
      <ul>
        <li><strong>Địa chỉ nhận hàng bảo hành:</strong> 123 Nguyễn Văn Linh, Quận 7, TP.HCM</li>
        <li><strong>Hotline hỗ trợ:</strong> 1900 xxxx</li>
        <li><strong>Email khiếu nại/bảo hành:</strong> support@bookstore.vn</li>
        <li><strong>Giờ làm việc:</strong> 8:00 – 22:00 (Từ Thứ Hai đến Chủ Nhật)</li>
      </ul>
    </section>
  </main>
</div>

<a href="#" id="backToTop" class="back-to-top" title="Lên đầu trang">
  <i class="bi bi-chevron-up">
    <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
  </i>
</a>

<?php
// 4. Gói Script xử lý Nút cuộn lên đầu trang
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

// 5. Gọi Footer chung
include '../includes/footer.php';
?>