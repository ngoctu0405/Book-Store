<?php
// 1. Cài đặt các biến thông tin riêng cho trang này
$pageTitle = "Điều Khoản Sử Dụng - Literary Haven";

// 2. Gói CSS riêng của trang Điều khoản
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
      <h1>ĐIỀU KHOẢN SỬ DỤNG</h1>
      <p class="lead text-muted">
        Quy định về việc truy cập, sử dụng và tương tác với dịch vụ của
        Literary Haven.
      </p>
    </header>

    <section class="policy-section mb-4">
      <h2>1. Chấp nhận điều khoản</h2>
      <p>
        Khi truy cập và sử dụng trang web Literary Haven, bạn đồng ý tuân
        thủ tất cả các điều khoản, điều kiện và quy định được nêu trong
        trang này. Nếu bạn không đồng ý, vui lòng ngừng sử dụng dịch vụ.
      </p>
    </section>

    <section class="policy-section mb-4">
      <h2>2. Quyền và nghĩa vụ của người dùng</h2>
      <ul>
        <li>
          Người dùng có quyền truy cập, tìm kiếm và mua sản phẩm hợp pháp
          trên trang web.
        </li>
        <li>
          Không được thực hiện các hành vi gây ảnh hưởng đến hệ thống, nội
          dung hoặc uy tín của Literary Haven.
        </li>
        <li>
          Người dùng chịu trách nhiệm về thông tin cá nhân và hành vi của
          mình khi sử dụng dịch vụ.
        </li>
      </ul>
    </section>

    <section class="policy-section mb-4">
      <h2>3. Quyền và nghĩa vụ của Literary Haven</h2>
      <ul>
        <li>
          Literary Haven có quyền thay đổi, tạm ngừng hoặc chấm dứt dịch vụ
          mà không cần thông báo trước.
        </li>
        <li>
          Chúng tôi cam kết bảo mật thông tin cá nhân của khách hàng theo
          <a href="privacy_policy.php">Chính sách bảo mật</a>.
        </li>
        <li>
          Literary Haven không chịu trách nhiệm về thiệt hại phát sinh do
          việc người dùng sử dụng sai mục đích.
        </li>
      </ul>
    </section>

    <section class="policy-section mb-4">
      <h2>4. Sở hữu trí tuệ</h2>
      <p>
        Tất cả nội dung, hình ảnh, logo, mã nguồn và tài liệu trên trang web
        Literary Haven đều thuộc quyền sở hữu của chúng tôi hoặc các đối tác
        hợp pháp. Nghiêm cấm sao chép, sử dụng hoặc phân phối mà không có sự
        cho phép bằng văn bản.
      </p>
    </section>

    <section class="policy-section mb-4">
      <h2>5. Thay đổi điều khoản</h2>
      <p>
        Literary Haven có thể cập nhật hoặc điều chỉnh các điều khoản sử
        dụng này bất kỳ lúc nào. Các thay đổi sẽ được đăng tải trên trang
        này và có hiệu lực ngay khi được công bố.
      </p>
    </section>

    <section class="policy-section mb-4">
      <h2>6. Liên hệ</h2>
      <p>
        Mọi thắc mắc liên quan đến Điều khoản sử dụng, vui lòng liên hệ:
      </p>
      <ul>
        <li>Email: <strong>support@bookstore.vn</strong></li>
        <li>Hotline: <strong>1900 xxxx</strong></li>
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