<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// 1. Kiểm tra đăng nhập
if (empty($_SESSION['user_id'])) {
  header("Location: index.php?require_login=true");
  exit;
}

$userId = (int)$_SESSION['user_id'];
$successMsg = '';
$errorMsg = '';

// 2. Xử lý khi người dùng bấm nút Cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullName = trim($_POST['fullname'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $phone    = trim($_POST['phone'] ?? '');
  $address  = trim($_POST['address'] ?? '');

  // Xác thực dữ liệu cơ bản
  if (empty($fullName) || empty($email) || empty($phone) || empty($address)) {
    $errorMsg = "Vui lòng nhập đầy đủ các thông tin bắt buộc.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMsg = "Email không hợp lệ.";
  } elseif (!preg_match('/^[0-9]{10,11}$/', $phone)) {
    $errorMsg = "Số điện thoại không hợp lệ (phải từ 10-11 số).";
  } else {
    // Cập nhật vào CSDL
    $stmt = $conn->prepare("UPDATE users SET fullName = ?, email = ?, phone = ?, address = ? WHERE id = ?");
    $stmt->bind_param('ssssi', $fullName, $email, $phone, $address, $userId);

    if ($stmt->execute()) {
      $successMsg = "Cập nhật thông tin cá nhân thành công!";
      // Tùy chọn: Chuyển hướng về trang chủ sau vài giây
      // header("refresh:2;url=index.php"); 
    } else {
      $errorMsg = "Lỗi hệ thống, không thể cập nhật: " . $conn->error;
    }
  }
}

// 3. Lấy thông tin user từ CSDL để hiển thị ra Form
$stmt = $conn->prepare("SELECT fullName, username, email, phone, address FROM users WHERE id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$userResult = $stmt->get_result();

if ($userResult->num_rows === 0) {
  // Nếu lỗi không tìm thấy user, đá về trang chủ
  header("Location: index.php");
  exit;
}
$userData = $userResult->fetch_assoc();

function h($str)
{
  return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cập nhật thông tin cá nhân - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <style>
    body {
      background: linear-gradient(135deg, #f5f2e8 0%, #e8d5b7 50%, #7fb3d3 100%);
      color: #2c3e50;
      min-height: 100vh;
    }

    .container {
      position: relative;
      max-width: 1400px;
      margin: 4rem auto;
      padding: 0 2rem;
    }

    .page-heading {
      font-size: 2.5rem;
      font-weight: 700;
      color: #2c3e50;
      text-align: center;
      margin-top: 5rem;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
    }

    .history-container {
      background: white;
      border-radius: 24px;
      padding: 3rem;
      box-shadow: 0 10px 40px rgba(79, 157, 166, 0.15);
      border: 1px solid rgba(130, 192, 154, 0.2);
      max-width: 800px;
      margin: 0 auto;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #2c3e50;
    }

    .input-with-icon {
      display: flex !important;
      align-items: center;
      border: 2px solid #ddd;
      border-radius: 12px;
      background: #f8f8f8;
      transition: all 0.3s ease;
      width: 100%;
      box-sizing: border-box;
      overflow: hidden;
      position: relative;
    }

    .input-with-icon:focus-within {
      border-color: #4f9da6;
      box-shadow: 0 0 0 3px rgba(79, 157, 166, 0.2);
    }

    .input-icon {
      position: static !important;
      padding: 0.8rem 1rem;
      font-size: 1.2rem;
      color: #7f8c8d;
      flex-shrink: 0;
      display: flex !important;
      align-items: center;
      justify-content: center;
    }

    .input-with-icon input {
      position: static !important;
      border: none !important;
      outline: none;
      padding: 0.8rem 1rem 0.8rem 0 !important;
      flex: 1 !important;
      background: transparent !important;
      font-size: 1rem;
      min-width: 0;
      width: auto !important;
      box-sizing: border-box;
      margin: 0 !important;
    }

    .input-with-icon input[readonly],
    .input-with-icon input[disabled] {
      background: #eee;
      cursor: not-allowed;
      color: #666;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 2rem;
    }

    .btn-action {
      padding: 0.8rem 1.5rem;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
      display: flex;
      align-items: center;
      gap: 0.6rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      text-decoration: none;
      justify-content: center;
    }

    .btn-reorder {
      background: linear-gradient(135deg, #ff7f50 0%, #ff4500 100%);
      color: white;
    }

    .btn-detail {
      background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
      color: white;
    }

    .btn-action:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      color: white;
    }
  </style>
</head>

<body>
  <header class="topbar">
    <div class="logo">
      <a href="index.php">
        <img class="Logo" src="../images/Logo_removebg.png" alt="Logo" />
        <img class="Word" src="../images/Logo_word_removebg.png" alt="Literary Haven" />
      </a>
    </div>
    <div class="auth-cart">
      <div id="authArea">
        <button class="btn-auth" onclick="openLoginModal()">Đăng nhập</button>
        <button class="btn-auth btn-signup" onclick="openRegisterModal()">Đăng ký</button>
      </div>
    </div>
  </header>

  <nav class="navbar" id="mainNav">
    <ul class="menu" id="mainMenu">
      <li><a href="index.php">Trang chủ</a></li>
      <li><a href="about.php">Giới thiệu</a></li>
      <div class="category-menu">
        <button class="category-btn">Danh mục ▾</button>
        <ul class="book-filter">
        </ul>
      </div>
      <li><a href="news.php">Tin tức</a></li>
    </ul>
  </nav>

  <div class="nav_2">
    <div class="search-center">
      <input id="topSearch" class="search-input" type="text" placeholder="Nhập tên cuốn sách bạn đang tìm ..." autocomplete="off" />
      <button class="search-btn" type="button">Tìm kiếm</button>
    </div>
    <div class="cart-float" id="cartFloat">
      <button id="cartBtnFloat" class="btn" onclick="goToCart(event)">
        <span class="cart-icon">🛒</span>
        <span id="cart-count" class="cart-count">0</span>
      </button>
    </div>
  </div>

  <main class="container">
    <h2 class="page-heading">
      <i class="bi bi-gear-fill"></i> Cập nhật thông tin cá nhân
    </h2>
    <div class="history-container" id="updateProfileContainer">

      <?php if ($successMsg): ?>
        <div class="alert alert-success text-center" style="border-radius: 12px; font-weight: 500;">
          <?= h($successMsg) ?>
        </div>
      <?php endif; ?>

      <?php if ($errorMsg): ?>
        <div class="alert alert-danger" style="border-radius: 12px; font-weight: 500;">
          <?= h($errorMsg) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="update-profile.php">
        <div class="form-group">
          <label>Họ và tên</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-person-fill"></i></span>
            <input type="text" name="fullname" value="<?= h($userData['fullName']) ?>" required />
          </div>
        </div>

        <div class="form-group">
          <label>Tài khoản (Không thể thay đổi)</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
            <input type="text" value="<?= h($userData['username']) ?>" readonly disabled />
          </div>
        </div>

        <div class="form-group">
          <label>Email</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" name="email" value="<?= h($userData['email']) ?>" required />
          </div>
        </div>

        <div class="form-group">
          <label>Số điện thoại</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-telephone-fill"></i></span>
            <input type="tel" name="phone" value="<?= h($userData['phone']) ?>" required />
          </div>
        </div>

        <div class="form-group">
          <label>Địa chỉ giao hàng mặc định</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-house-fill"></i></span>
            <input type="text" name="address" value="<?= h($userData['address']) ?>" required />
          </div>
        </div>

        <div class="form-actions">
          <a href="index.php" class="btn-action btn-reorder">
            <i class="bi bi-arrow-left"></i> Về trang chủ
          </a>
          <button type="submit" class="btn-action btn-detail">
            <i class="bi bi-save"></i> Lưu thông tin
          </button>
        </div>
      </form>

      <p class="mt-4" style="text-align: center; color: #7f8c8d">
        Bạn muốn đổi mật khẩu?
        <a href="change-password.php" style="color: #4f9da6; font-weight: 600">Đổi mật khẩu tại đây</a>
      </p>
    </div>
  </main>

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h3>Về Chúng tôi</h3>
        <ul>
          <li><a href="about.php">Giới thiệu</a></li>
          <li><a href="./news.php">Tin tức</a></li>
          <li><a href="./privacy_policy.php">Chính sách bảo mật</a></li>
          <li><a href="./terms-of-use.php">Điều khoản sử dụng</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Hỗ trợ khách hàng</h3>
        <ul>
          <li><a href="./shopping_guide.php">Hướng dẫn mua hàng</a></li>
          <li><a href="./exchange-policy.php">Chính sách đổi trả</a></li>
          <li><a href="./warranty-policy.php">Chính sách bảo hành</a></li>
          <li><a href="./frequently-asked-questions.php">Câu hỏi thường gặp</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Chính sách</h3>
        <ul>
          <li><a href="./payment-policy.php">Chính sách thanh toán</a></li>
          <li><a href="./shipping-policy.php">Chính sách vận chuyển</a></li>
          <li><a href="./warranty-policy.php">Chính sách bảo hành</a></li>
          <li><a href="./exchange-policy.php">Chính sách đổi trả</a></li>
        </ul>
      </div>
      <div class="footer-section contact-info">
        <h3>Liên hệ</h3>
        <p>📍 123 Nguyễn Văn Linh, Q7, TP.HCM</p>
        <p>📞 Hotline: 1900 xxxx</p>
        <p>✉️ Email: support@bookstore.vn</p>
        <p>🕐 Giờ làm việc: 8:00 - 22:00</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Book Store. All rights reserved. | Designed with ❤️</p>
    </div>
  </footer>

  <?php include '../includes/auth_modals.php'; ?>

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js?v=2"></script>
</body>

</html>