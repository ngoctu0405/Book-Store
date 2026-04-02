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

// 2. Xử lý đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Dùng trim() để loại bỏ khoảng trắng thừa nếu người dùng lỡ bấm phím cách
  $oldPass = trim($_POST['old_password'] ?? '');
  $newPass = trim($_POST['new_password'] ?? '');
  $confirmPass = trim($_POST['confirm_password'] ?? '');

  if (empty($oldPass) || empty($newPass) || empty($confirmPass)) {
    $errorMsg = "Vui lòng nhập đầy đủ các trường.";
  } elseif (strlen($newPass) < 6) {
    $errorMsg = "Mật khẩu mới phải có ít nhất 6 ký tự.";
  } elseif ($newPass !== $confirmPass) {
    $errorMsg = "Mật khẩu xác nhận không khớp.";
  } elseif ($newPass === $oldPass) {
    $errorMsg = "Mật khẩu mới không được trùng với mật khẩu cũ.";
  } else {
    // Lấy mật khẩu (đã hash) từ DB ra để đối chiếu
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
      $user = $res->fetch_assoc();

      if (!password_verify($oldPass, $user['password'])) {
        $errorMsg = "Mật khẩu cũ không chính xác.";
      } else {
        // MÃ HÓA mật khẩu mới trước khi lưu xuống Database
        $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);

        // Cập nhật mật khẩu mới
        $stmtUpd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmtUpd->bind_param('si', $hashedNewPass, $userId);

        if ($stmtUpd->execute()) {
          $successMsg = "Đổi mật khẩu thành công! Bạn sẽ được đăng xuất để đăng nhập lại.";

          session_unset();
          session_destroy();
        } else {
          $errorMsg = "Lỗi hệ thống khi cập nhật: " . $conn->error;
        }
      }
    } else {
      $errorMsg = "Không tìm thấy tài khoản.";
    }
  }
}

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
  <title>Đổi mật khẩu - Literary Haven</title>
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
      height: auto;
      min-height: 50rem;
    }

    .page-heading {
      font-size: 2.5rem;
      font-weight: 700;
      color: #2c3e50;
      margin-top: 5rem;
      margin-bottom: 2rem;
      text-align: center;
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
      min-height: 400px;
      max-width: 600px;
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

    /* CSS FIX LỖI ICON BỊ ĐÈ */
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

    .password-toggle {
      cursor: pointer;
      user-select: none;
      padding: 0.8rem 1rem;
      font-size: 1.2rem;
      color: #7f8c8d;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* HẾT CSS FIX */

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
      justify-content: center;
      text-decoration: none;
    }

    .btn-detail {
      background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
      color: white;
    }

    .btn-detail:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(79, 157, 166, 0.4);
      color: white;
    }

    .btn-reorder {
      background: linear-gradient(135deg, #ff7f50 0%, #ff4500 100%);
      color: white;
    }

    .btn-reorder:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(255, 99, 71, 0.4);
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
    <h2 class="page-heading"><i class="bi bi-key-fill"></i> Đổi mật khẩu</h2>
    <div class="history-container">

      <?php if ($successMsg): ?>
        <div class="alert alert-success text-center" style="border-radius: 12px; font-weight: 500;">
          <?= h($successMsg) ?>
        </div>
        <script>
          // Xóa JS cache và đẩy về trang chủ sau khi đổi pass thành công
          localStorage.removeItem('bs_user');
          setTimeout(function() {
            window.location.href = 'index.php?require_login=true';
          }, 2500);
        </script>
      <?php endif; ?>

      <?php if ($errorMsg): ?>
        <div class="alert alert-danger" style="border-radius: 12px; font-weight: 500;">
          <?= h($errorMsg) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="change-password.php" <?= $successMsg ? 'style="display:none;"' : '' ?>>
        <div class="form-group">
          <label for="old-password">Mật khẩu cũ</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
            <input type="password" id="old-password" name="old_password" placeholder="Nhập mật khẩu cũ" required />
            <span class="password-toggle" id="toggle-old-password" onclick="togglePassword('old-password', 'toggle-old-password')">👁️‍🗨️</span>
          </div>
        </div>

        <div class="form-group">
          <label for="new-password">Mật khẩu mới</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-shield-lock-fill"></i></span>
            <input type="password" id="new-password" name="new_password" placeholder="Nhập mật khẩu mới" required />
            <span class="password-toggle" id="toggle-new-password" onclick="togglePassword('new-password', 'toggle-new-password')">👁️‍🗨️</span>
          </div>
        </div>

        <div class="form-group">
          <label for="confirm-password">Xác nhận mật khẩu mới</label>
          <div class="input-with-icon">
            <span class="input-icon"><i class="bi bi-shield-check-fill"></i></span>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required />
            <span class="password-toggle" id="toggle-confirm-password" onclick="togglePassword('confirm-password', 'toggle-confirm-password')">👁️‍🗨️</span>
          </div>
        </div>

        <div class="form-actions">
          <a href="update-profile.php" class="btn-action btn-reorder">
            <i class="bi bi-arrow-left"></i> Quay lại
          </a>
          <button type="submit" class="btn-action btn-detail">
            <i class="bi bi-save"></i> Đổi mật khẩu
          </button>
        </div>
      </form>
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

  <script>
    // Hàm ẩn/hiện mật khẩu
    function togglePassword(inputId, toggleId) {
      const input = document.getElementById(inputId);
      const toggle = document.getElementById(toggleId);

      if (input.type === "password") {
        input.type = "text";
        toggle.textContent = "🙈";
      } else {
        input.type = "password";
        toggle.textContent = "👁️‍🗨️";
      }
    }
  </script>
</body>

</html>