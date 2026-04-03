<?php
// 1. Cài đặt các biến thông tin riêng cho trang này
$pageTitle = "Chính Sách Thanh Toán - Literary Haven";

// 2. Gói CSS riêng của trang Chính sách thanh toán
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

  /* Khung làm nổi bật thông tin ngân hàng */
  .bank-info {
    background: linear-gradient(135deg, #f0f8f7 0%, #e6f4f1 100%);
    padding: 1.5rem;
    border-radius: 12px;
    margin: 1.5rem 0;
    border: 1px solid rgba(79, 157, 166, 0.2);
  }

  .bank-info p {
    margin-bottom: 0.5rem;
    color: #2c3e50;
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
      <h1>CHÍNH SÁCH THANH TOÁN</h1>
      <p class="lead text-muted">
        Hướng dẫn chi tiết các phương thức thanh toán đang được áp dụng tại Literary Haven.
      </p>
    </header>

    <section class="policy-section">
      <h2>1. Thanh toán bằng tiền mặt khi nhận hàng (COD)</h2>
      <p>Khách hàng thanh toán trực tiếp cho nhân viên giao hàng khi nhận được sản phẩm.</p>
      <ul>
        <li><strong>Phạm vi áp dụng:</strong> Toàn quốc.</li>
        <li><strong>Lưu ý:</strong> Vui lòng kiểm tra kỹ sản phẩm trước khi thanh toán. Đối với các đơn hàng có giá trị lớn (trên 2.000.000 VNĐ), chúng tôi có thể yêu cầu đặt cọc trước một phần.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>2. Thanh toán bằng hình thức chuyển khoản</h2>
      <p>Khách hàng có thể thanh toán bằng cách chuyển khoản trực tiếp vào tài khoản ngân hàng của chúng tôi.</p>

      <div class="bank-info">
        <p><strong>Ngân hàng:</strong> VietinBank (Ngân hàng TMCP Công Thương Việt Nam)</p>
        <p><strong>Số tài khoản:</strong> 0368988328</p>
        <p><strong>Chủ tài khoản:</strong> Lê Phú Hiếu</p>
        <p><strong>Nội dung chuyển khoản:</strong> Thanh toán đơn hàng [Mã Đơn Hàng] - [Số điện thoại]</p>
      </div>

      <ul>
        <li><strong>Thời gian xử lý:</strong> Sau khi nhận được thanh toán, chúng tôi sẽ xác nhận và tiến hành giao hàng trong vòng 24 giờ làm việc.</li>
        <li><strong>Lưu ý:</strong> Vui lòng chụp lại màn hình giao dịch để đối chiếu khi cần thiết.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>3. Thanh toán trực tuyến (VNPay/MoMo)</h2>
      <p>Chúng tôi hỗ trợ thanh toán nhanh chóng và an toàn qua các cổng thanh toán điện tử phổ biến như VNPay và Ví MoMo.</p>
      <ul>
        <li>Thanh toán trực tiếp trên website qua mã QR hoặc ứng dụng tương ứng.</li>
        <li>Miễn phí phí giao dịch đối với mọi đơn hàng thanh toán qua VNPay/MoMo.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>4. Chính sách hoàn tiền</h2>
      <p>Trong trường hợp sản phẩm hết hàng hoặc khách hàng hủy đơn hàng (áp dụng trước khi giao hàng), số tiền đã thanh toán sẽ được hoàn lại theo quy định:</p>
      <ul>
        <li><strong>Ví điện tử / Thẻ ATM nội địa:</strong> Hoàn tiền trong 3 - 5 ngày làm việc.</li>
        <li><strong>Chuyển khoản trực tiếp:</strong> Hoàn tiền trong 1 - 3 ngày làm việc.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>5. Bảo mật thanh toán</h2>
      <p>Chúng tôi cam kết bảo mật tuyệt đối thông tin thanh toán của khách hàng. Mọi giao dịch trực tuyến đều được mã hóa và thực hiện qua các đối tác cung cấp dịch vụ cổng thanh toán uy tín, tuân thủ các tiêu chuẩn bảo mật quốc tế.</p>
    </section>

    <section class="policy-section">
      <h2>6. Liên hệ hỗ trợ thanh toán</h2>
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