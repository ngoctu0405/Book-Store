<?php
// 1. Cài đặt các biến thông tin riêng cho trang này
$pageTitle = "Hướng Dẫn Mua Hàng - Literary Haven"; // Đã sửa lại tiêu đề cho đúng với nội dung

// 2. Gói CSS riêng của trang Hướng dẫn mua hàng
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

  table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  th,
  td {
    border: 1px solid #e9ecef;
    padding: 1rem;
    text-align: left;
  }

  th {
    background-color: #f0f8f7;
    color: #2c3e50;
    font-weight: 700;
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
      <h1>HƯỚNG DẪN MUA HÀNG</h1>
      <p class="lead text-muted">
        Các bước và lưu ý để khách hàng mua sách nhanh chóng và thuận tiện
        tại Literary Haven.
      </p>
    </header>

    <section class="policy-section">
      <h2>1. Giới thiệu</h2>
      <p>
        Hướng dẫn mua hàng tại Literary Haven được xây dựng nhằm giúp khách
        hàng dễ dàng tìm kiếm, đặt mua và thanh toán sản phẩm một cách nhanh
        chóng, an toàn và thuận tiện. Chúng tôi luôn mong muốn mang lại trải
        nghiệm mua sắm tốt nhất cho bạn.
      </p>
    </section>

    <section class="policy-section">
      <h2>2. Các hình thức mua hàng</h2>
      <ul>
        <li>Mua trực tiếp tại cửa hàng Literary Haven.</li>
        <li>
          Mua online qua website chính thức
          <a href="index.php">www.c03.nhahodau.net</a>.
        </li>
        <li>Đặt hàng qua hotline hoặc fanpage của cửa hàng.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>3. Quy trình mua hàng online</h2>
      <ul>
        <li>
          <strong>Bước 1:</strong> Truy cập website của
          <a href="index.php">Literary Haven</a>.
        </li>
        <li>
          <strong>Bước 2:</strong> Tìm kiếm sản phẩm bạn muốn mua bằng thanh
          tìm kiếm hoặc danh mục sách.
        </li>
        <li>
          <strong>Bước 3:</strong> Chọn sách và bấm “Thêm vào giỏ hàng”.
        </li>
        <li>
          <strong>Bước 4:</strong> Kiểm tra giỏ hàng, điều chỉnh số lượng
          nếu cần.
        </li>
        <li>
          <strong>Bước 5:</strong> Nhấn “Thanh toán” và điền đầy đủ thông
          tin giao hàng, phương thức thanh toán.
        </li>
        <li>
          <strong>Bước 6:</strong> Xác nhận đơn hàng. Hệ thống sẽ gửi email
          xác nhận đơn hàng thành công.
        </li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>4. Phương thức thanh toán</h2>
      <table>
        <tr>
          <th>Phương thức</th>
          <th>Mô tả</th>
        </tr>
        <tr>
          <td>Thanh toán khi nhận hàng (COD)</td>
          <td>
            Khách hàng thanh toán tiền mặt cho nhân viên giao hàng khi nhận
            sản phẩm.
          </td>
        </tr>
        <tr>
          <td>Chuyển khoản ngân hàng</td>
          <td>
            Khách hàng chuyển khoản trước qua tài khoản ngân hàng của
            Literary Haven.
          </td>
        </tr>
        <tr>
          <td>Thanh toán qua ví điện tử</td>
          <td>
            Hỗ trợ Momo, ZaloPay, VNPay, hoặc các ví điện tử phổ biến khác.
          </td>
        </tr>
      </table>
    </section>

    <section class="policy-section">
      <h2>5. Thời gian xử lý và giao hàng</h2>
      <ul>
        <li>
          Đơn hàng được xử lý trong vòng <strong>24 giờ</strong> kể từ khi
          xác nhận.
        </li>
        <li>Thời gian giao hàng nội thành: 1–2 ngày làm việc.</li>
        <li>Giao hàng toàn quốc: 2–5 ngày làm việc (tùy khu vực).</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>6. Mẹo giúp đặt hàng nhanh chóng</h2>
      <ul>
        <li>
          Đăng ký tài khoản để lưu thông tin giao hàng cho những lần mua
          sau.
        </li>
        <li>Kiểm tra kỹ giỏ hàng trước khi thanh toán để tránh sai sót.</li>
        <li>
          Giữ lại thông báo đơn hàng để tiện tra cứu khi cần hỗ trợ.
        </li>
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