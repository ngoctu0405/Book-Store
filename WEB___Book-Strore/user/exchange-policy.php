<?php
// 1. Cài đặt các biến thông tin riêng cho trang này
$pageTitle = "Chính Sách Đổi Trả Hàng - Literary Haven"; // Đã sửa lại tiêu đề cho đúng nội dung

// 2. Gói CSS riêng của trang Chính sách
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
      <h1>CHÍNH SÁCH ĐỔI TRẢ HÀNG</h1>
      <p class="lead text-muted">
        Quy định về đổi, trả và hoàn tiền cho khách hàng tại Literary Haven.
      </p>
    </header>

    <section class="policy-section">
      <h2>1. Giới thiệu và mục đích</h2>
      <p>
        Chính sách đổi trả hàng của Literary Haven được xây dựng nhằm đảm
        bảo quyền lợi tối đa cho khách hàng. Chúng tôi cam kết hỗ trợ đổi
        hàng hoặc hoàn tiền trong các trường hợp sản phẩm lỗi, giao nhầm
        hoặc khách hàng thay đổi quyết định, đồng thời hướng dẫn rõ ràng quy
        trình thực hiện để khách hàng dễ dàng thực hiện.
      </p>
    </section>

    <section class="policy-section">
      <h2>2. Thời gian hỗ trợ đổi trả</h2>
      <ul>
        <li>Hỗ trợ trong <strong>30 ngày</strong> kể từ ngày nhận hàng.</li>
        <li>
          Không áp dụng cho các sản phẩm hạn chế, sách giảm giá, sách cũ,
          hoặc sách đặt riêng.
        </li>
      </ul>
    </section>

    <section class="policy-section">
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

    <section class="policy-section">
      <h2>4. Danh mục không áp dụng đổi trả</h2>
      <ul>
        <li>Sách giảm giá, sách thanh lý, sách cũ, sách đặt riêng.</li>
        <li>Báo, tạp chí, băng đĩa, sản phẩm điện tử đi kèm.</li>
        <li>Sản phẩm đã bọc bookcare hoặc dán nhãn cá nhân hóa.</li>
      </ul>
    </section>

    <section class="policy-section">
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

    <section class="policy-section">
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

    <section class="policy-section">
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