<?php
// 1. Cài đặt các biến thông tin riêng cho trang này
$pageTitle = "Chính Sách Vận Chuyển - Literary Haven";

// 2. Gói CSS riêng của trang Chính sách vận chuyển
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
      <h1>CHÍNH SÁCH VẬN CHUYỂN</h1>
      <p class="lead text-muted">
        Quy định về giao hàng, vận chuyển và nhận sách tại Literary Haven.
      </p>
    </header>

    <section class="policy-section">
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

    <section class="policy-section">
      <h2>2. Khu vực giao hàng và phí vận chuyển</h2>
      <ul>
        <li>
          <strong>Khu vực trung tâm TP.HCM:</strong> Quận 1, 3, 4, 5, 6, 7, 8, 10, 11. Phí: 25.000 VNĐ/đơn. Thời gian: 4–24 giờ.
        </li>
        <li>
          <strong>Khu vực ngoại thành:</strong> Bình Tân, Tân Phú, Thủ Đức, Tân Bình, Q12 và các khu vực khác. Phí: 35.000 VNĐ/đơn. Thời gian: 1–3 ngày.
        </li>
        <li>
          <strong>Đơn hàng gấp/hỏa tốc:</strong> Phí theo đơn vị vận chuyển. Liên hệ để tư vấn.
        </li>
        <li>
          <strong>Đơn hàng đi tỉnh:</strong> Liên hệ chăm sóc khách hàng để được báo giá và thời gian dự kiến.
        </li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>3. Thời gian xử lý và giao hàng</h2>
      <ul>
        <li>Mọi đơn hàng sẽ được kiểm tra, xác nhận và đóng gói trong vòng 24 giờ kể từ khi thanh toán thành công.</li>
        <li>Thời gian giao hàng nội thành: 4–24 giờ, tùy khu vực.</li>
        <li>Thời gian giao hàng các tỉnh: 2–5 ngày, tùy khoảng cách và đơn vị vận chuyển.</li>
        <li>Đơn hàng hỏa tốc: Thời gian giao hàng được thông báo khi khách hàng lựa chọn dịch vụ.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>4. Phương thức giao hàng</h2>
      <ul>
        <li><strong>Giao tận nơi:</strong> Nhân viên giao hàng sẽ mang sách đến địa chỉ khách hàng cung cấp.</li>
        <li><strong>Nhận tại cửa hàng:</strong> Khách hàng có thể đến trực tiếp cửa hàng Literary Haven để nhận sách.</li>
        <li><strong>Giao hàng hỏa tốc:</strong> Đảm bảo giao nhanh trong ngày hoặc theo yêu cầu.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>5. Kiểm tra và nhận hàng</h2>
      <ul>
        <li>Khi nhận sách, khách hàng nên kiểm tra số lượng, tựa sách và tình trạng sách trước khi ký nhận.</li>
        <li>Nếu phát hiện lỗi in, thiếu trang hoặc hư hỏng trong quá trình vận chuyển, khách hàng có quyền từ chối nhận hàng và liên hệ Literary Haven để được xử lý.</li>
        <li><strong>Lưu ý:</strong> kiểm tra kỹ trước khi nhận giúp tránh nhầm lẫn và đảm bảo quyền lợi của khách hàng.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>6. Chính sách trả hàng và hoàn tiền</h2>
      <ul>
        <li><strong>Trả hàng:</strong> Trong vòng 3 ngày kể từ khi nhận nếu sản phẩm sai, thiếu hoặc hư hỏng.</li>
        <li><strong>Hoàn tiền:</strong> Thực hiện theo phương thức thanh toán ban đầu hoặc theo thỏa thuận.</li>
        <li><strong>Ví dụ:</strong> Nếu khách đặt sách làm quà nhưng nhận sách bị rách, có thể từ chối nhận hoặc trả lại để được hoàn tiền ngay.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>7. Liên hệ</h2>
      <ul>
        <li><strong>Địa chỉ:</strong> 123 Nguyễn Văn Linh, Quận 7, TP.HCM</li>
        <li><strong>Hotline:</strong> 1900 xxxx</li>
        <li><strong>Email:</strong> support@bookstore.vn</li>
        <li><strong>Giờ làm việc:</strong> 8:00 – 22:00</li>
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