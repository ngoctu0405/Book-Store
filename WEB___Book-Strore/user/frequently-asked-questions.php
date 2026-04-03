<?php
// 1. Cài đặt các biến thông tin riêng cho trang này
$pageTitle = "Câu hỏi thường gặp - Literary Haven";

// 2. Gói CSS riêng của trang FAQ
ob_start();
?>
<style>
  body {
    background: #f8f9fa;
    /* Nền xám nhạt để làm nổi khung trắng */
  }

  .container {
    position: relative;
    max-width: 900px;
    margin: 8rem auto 5rem auto;
    /* Căn chỉnh khoảng cách đẩy xuống khỏi Menu */
    padding: 40px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
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
    margin-bottom: 2rem;
  }

  #back:hover {
    transform: translateX(-5px);
    box-shadow: 0 4px 10px rgba(79, 157, 166, 0.3);
    color: white;
  }

  h1 {
    text-align: center;
    margin-bottom: 40px;
    color: #2c3e50;
    font-weight: 800;
    font-size: 2.2rem;
  }

  /* CSS cho khối câu hỏi/trả lời */
  .faq-item {
    border-bottom: 1px solid #eee;
    padding: 20px 0;
  }

  .faq-item:last-child {
    border-bottom: none;
  }

  .faq-question {
    font-size: 1.15rem;
    font-weight: 700;
    color: #2c3e50;
    cursor: pointer;
    position: relative;
    padding-right: 30px;
    transition: color 0.3s ease;
  }

  .faq-question:hover {
    color: #4f9da6;
  }

  .faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease, margin-top 0.4s ease;
    color: #555;
    line-height: 1.6;
    font-size: 1.05rem;
  }

  .faq-question::after {
    content: "+";
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.5rem;
    font-weight: normal;
    color: #4f9da6;
    transition: transform 0.3s ease;
  }

  /* Trạng thái khi mở câu hỏi */
  .faq-item.active .faq-answer {
    max-height: 300px;
    margin-top: 15px;
  }

  .faq-item.active .faq-question::after {
    content: "−";
    transform: translateY(-50%) rotate(180deg);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .container {
      margin: 6rem 1rem 3rem 1rem;
      padding: 25px;
    }

    h1 {
      font-size: 1.8rem;
      margin-bottom: 30px;
    }
  }
</style>
<?php
$extraCss = ob_get_clean();

// 3. Gọi Header chung (Đã bao gồm Menu, Giỏ hàng, Database...)
include '../includes/header.php';
?>

<main class="container">
  <a id="back" href="index.php">&larr; Quay lại trang chủ</a>

  <h1>CÂU HỎI THƯỜNG GẶP (FAQ)</h1>

  <div class="faq-item">
    <div class="faq-question">1. Làm thế nào để đặt hàng trên website?</div>
    <div class="faq-answer">
      Bạn chỉ cần tìm kiếm sách, thêm vào giỏ hàng, điền thông tin giao hàng
      và chọn phương thức thanh toán. Hệ thống sẽ xác nhận đơn hàng qua email
      hoặc SMS.
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question">2. Thời gian giao hàng mất bao lâu?</div>
    <div class="faq-answer">
      Thời gian giao hàng thường từ 2 - 5 ngày làm việc tùy thuộc vào địa chỉ
      của bạn. Các thành phố lớn sẽ nhận được hàng nhanh hơn.
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question">3. Tôi có thể đổi/trả sách không?</div>
    <div class="faq-answer">
      Có, chúng tôi hỗ trợ đổi trả trong vòng 7 ngày kể từ khi nhận hàng nếu
      sách bị lỗi kỹ thuật, hỏng hóc do quá trình vận chuyển. Bạn vui lòng
      giữ nguyên hóa đơn và tình trạng sách.
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question">4. Phí vận chuyển được tính như thế nào?</div>
    <div class="faq-answer">
      Phí vận chuyển phụ thuộc vào khoảng cách và phương thức giao hàng bạn
      chọn. Miễn phí vận chuyển cho đơn hàng từ 300.000 VNĐ.
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question">5. Nếu tôi nhận được sách không đúng như đã đặt, tôi nên làm gì?</div>
    <div class="faq-answer">
      Xin vui lòng liên hệ ngay với bộ phận chăm sóc khách hàng của chúng tôi
      qua hotline hoặc email. Chúng tôi sẽ hướng dẫn bạn quy trình đổi/trả.
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question">6. Các phương thức thanh toán khả dụng?</div>
    <div class="faq-answer">
      Chúng tôi chấp nhận thanh toán khi nhận hàng (COD), chuyển khoản ngân
      hàng, và thanh toán qua ví điện tử (MoMo, ZaloPay).
    </div>
  </div>
</main>

<a href="#" id="backToTop" class="back-to-top" title="Lên đầu trang">
  <i class="bi bi-chevron-up">
    <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
  </i>
</a>

<?php
// 4. Gói Script xử lý FAQ và nút cuộn lên
ob_start();
?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Logic ẩn hiện (Accordion) cho phần Câu hỏi
    const faqQuestions = document.querySelectorAll(".faq-question");

    faqQuestions.forEach((question) => {
      question.addEventListener("click", () => {
        const currentItem = question.parentElement;

        // Đóng tất cả các mục khác trước khi mở mục mới
        document.querySelectorAll(".faq-item").forEach((item) => {
          if (item !== currentItem) {
            item.classList.remove("active");
          }
        });

        // Đảo ngược trạng thái mở/đóng của mục đang click
        currentItem.classList.toggle("active");
      });
    });

    // Logic nút cuộn lên đầu trang
    const backBtn = document.getElementById("backToTop");
    if (backBtn) {
      window.addEventListener("scroll", function() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
          backBtn.style.display = "block";
        } else {
          backBtn.style.display = "none";
        }
      });

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