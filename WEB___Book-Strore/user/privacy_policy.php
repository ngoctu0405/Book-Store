<?php
// 1. Cài đặt các biến thông tin riêng cho trang này
$pageTitle = "Chính Sách Bảo Mật - Literary Haven";

// 2. Gói CSS riêng của trang Chính sách bảo mật
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
  <main class="policy-container container py-5">
    <header class="policy-header text-center mb-5">
      <h1>CHÍNH SÁCH BẢO MẬT</h1>
      <p class="lead text-muted">
        Literary Haven cam kết bảo vệ quyền riêng tư và bảo mật thông tin cá
        nhân của khách hàng.
      </p>
    </header>

    <section class="policy-section mb-4">
      <h2>1. Mục đích thu thập thông tin</h2>
      <p>Chúng tôi thu thập thông tin cá nhân của khách hàng nhằm:</p>
      <ul>
        <li>Hỗ trợ khách hàng trong quá trình mua sắm, đặt hàng và giao hàng.</li>
        <li>Cung cấp dịch vụ, cập nhật khuyến mãi, tin tức và sản phẩm mới.</li>
        <li>Liên hệ xác nhận đơn hàng, phản hồi yêu cầu hoặc hỗ trợ kỹ thuật.</li>
      </ul>
    </section>

    <section class="policy-section mb-4">
      <h2>2. Phạm vi thu thập thông tin</h2>
      <p>Các thông tin cá nhân được thu thập bao gồm:</p>
      <ul>
        <li>Họ và tên, địa chỉ, số điện thoại, email.</li>
        <li>Tài khoản đăng nhập, lịch sử giao dịch và phản hồi của khách hàng.</li>
        <li>Thông tin thanh toán (nếu khách hàng chọn phương thức online).</li>
      </ul>
    </section>

    <section class="policy-section mb-4">
      <h2>3. Thời gian lưu trữ thông tin</h2>
      <p>
        Thông tin cá nhân của khách hàng sẽ được lưu trữ cho đến khi khách
        hàng yêu cầu xóa hoặc khi tài khoản không còn hoạt động quá 12 tháng.
      </p>
    </section>

    <section class="policy-section mb-4">
      <h2>4. Bảo mật thông tin</h2>
      <p>
        Literary Haven áp dụng các biện pháp bảo mật nghiêm ngặt để đảm bảo
        an toàn cho dữ liệu cá nhân, bao gồm mã hóa, tường lửa và giới hạn
        quyền truy cập của nhân viên.
      </p>
    </section>

    <section class="policy-section mb-4">
      <h2>5. Quyền của khách hàng</h2>
      <p>Khách hàng có quyền:</p>
      <ul>
        <li>Yêu cầu xem, chỉnh sửa hoặc xóa thông tin cá nhân của mình.</li>
        <li>Từ chối nhận thông tin quảng cáo bất kỳ lúc nào.</li>
        <li>Gửi phản hồi hoặc khiếu nại về việc lạm dụng thông tin cá nhân.</li>
      </ul>
    </section>

    <section class="policy-section mb-4">
      <h2>6. Liên hệ</h2>
      <p>
        Nếu bạn có bất kỳ thắc mắc nào liên quan đến chính sách bảo mật, vui
        lòng liên hệ:
      </p>
      <ul>
        <li>Hotline: <strong>1900 xxxx</strong></li>
        <li>Email: <strong>support@bookstore.vn</strong></li>
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