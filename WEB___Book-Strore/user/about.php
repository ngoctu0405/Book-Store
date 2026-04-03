<?php
// 1. Khai báo tiêu đề và các đoạn CSS riêng biệt cho trang Giới thiệu
$pageTitle = "Giới thiệu - Literary Haven";
$extraCss = "
<style>
  main {
    position: relative;
    top: 5rem;
    padding-bottom: 5rem; /* Đã thay height: 96rem thành padding để trang tự động co giãn êm ái hơn */
  }

  /* About us responsive */
  @media (max-width: 767px) {
    main {
      height: auto;
    }

    /* About us */
    .col-md-6 {
      position: relative;
      top: 2rem;
    }

    .py-5 {
      padding: 15rem 0;
      height: 100%;
    }

    .contact-section {
      display: block;
    }

    .col-md-6-nd {
      position: relative;
      top: 10rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
  }
</style>
";

// 2. Tự động gọi Header (Thanh điều hướng, Menu động từ Database, form tìm kiếm...)
include '../includes/header.php';
?>

<main>
  <section class="intro-section text-center py-5">
    <h1 class="fw-bold">
      Literary Haven –
      <span class="text-danger">Thế Giới Sách Dành Cho Mọi Độc Giả</span>
    </h1>
    <p class="mt-3 px-5">
      Literary Haven không chỉ là một cửa hàng sách thông thường, mà còn là
      điểm đến lý tưởng dành cho những ai đam mê tri thức và yêu thích việc
      khám phá qua từng trang sách. Được thành lập với sứ mệnh mang đến cho
      độc giả những cuốn sách chất lượng nhất cùng dịch vụ tuyệt vời,
      Literary Haven đã và đang trở thành một trong những địa chỉ mua sách
      uy tín nhất tại Việt Nam.
    </p>
  </section>

  <section class="vision-mission py-5" style="background-color: #fff6f2">
    <div
      class="container d-flex flex-wrap align-items-center justify-content-between">
      <div class="col-md-6 mb-4 mb-md-0 text-center">
        <img
          src="../images/Vision.jpg"
          alt="Hình minh họa Literary Haven"
          class="img-fluid rounded shadow" />
      </div>
      <div class="col-md-5">
        <h2 class="fw-bold mb-3">Tầm Nhìn - Sứ Mệnh</h2>
        <h5 class="text-danger fw-semibold">Sứ Mệnh</h5>
        <p>
          Literary Haven được thành lập với mong muốn trở thành cầu nối giữa
          tri thức và độc giả, mang đến những cuốn sách chất lượng cao từ
          các nhà xuất bản uy tín trong và ngoài nước, cùng trải nghiệm mua
          sắm tiện lợi, an toàn và thú vị.
        </p>
        <h5 class="text-danger fw-semibold mt-4">Tầm Nhìn</h5>
        <p>
          Hướng đến việc trở thành hệ thống bán lẻ sách hàng đầu tại Việt
          Nam, không chỉ là nơi mua sách, mà còn là không gian văn hóa gắn
          kết cộng đồng yêu sách, truyền cảm hứng đọc và học hỏi suốt đời.
        </p>
      </div>
    </div>
  </section>

  <section class="contact-section py-5" style="background-color: #ffe5d2">
    <div
      class="container d-flex flex-wrap align-items-center justify-content-between">
      <div class="col-md-5">
        <h2 class="fw-bold mb-3">Thông Tin Liên Hệ</h2>
        <p>
          Với sự tận tâm trong từng cuốn sách và dịch vụ khách hàng chuyên
          nghiệp, Literary Haven mong muốn trở thành người bạn đồng hành
          trong hành trình khám phá tri thức.
        </p>
        <ul class="list-unstyled mt-3">
          <li><strong>📞 Hotline:</strong> 1900 6750</li>
          <li><strong>✉️ Email:</strong> support@bookstore.vn</li>
          <li>
            <strong>📍 Địa chỉ:</strong> 123 Nguyễn Văn Linh, Q7, TP. Hồ Chí
            Minh
          </li>
          <li>
            <strong>🌐 Website:</strong>
            <a href="https://c03.nhahodau.net/" target="_blank">
              c03.nhahodau.net
            </a>
          </li>
        </ul>
      </div>
      <div class="col-md-6 text-center">
        <img
          src="../images/Contact.webp"
          alt="Liên hệ Literary Haven"
          class="img-fluid rounded shadow" />
      </div>
    </div>
  </section>
</main>

<?php
// 4. Tự động gọi Footer (Chân trang, form đăng nhập, Javascript chung, nút cuộn lên đầu trang...)
include '../includes/footer.php';
?>