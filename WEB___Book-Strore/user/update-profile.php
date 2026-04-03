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
      $successMsg = "Cập nhật thông tin thành công!";
    } else {
      $errorMsg = "Lỗi hệ thống khi cập nhật: " . $conn->error;
    }
  }
}

// 3. Lấy thông tin hiện tại của người dùng để hiển thị ra form
$userCurrentInfo = [];
$stmtInfo = $conn->prepare("SELECT username, fullName, email, phone, address FROM users WHERE id = ?");
$stmtInfo->bind_param('i', $userId);
$stmtInfo->execute();
$resInfo = $stmtInfo->get_result();
if ($resInfo && $resInfo->num_rows > 0) {
  $userCurrentInfo = $resInfo->fetch_assoc();
}

function h($str)
{
  return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// ==================== CHUẨN BỊ GIAO DIỆN ====================
$pageTitle = "Thông tin tài khoản - Literary Haven";

// Gói CSS riêng của trang
ob_start();
?>
<style>
  body {
    background: linear-gradient(135deg, #f5f2e8 0%, #e8d5b7 50%, #7fb3d3 100%);
    color: #2c3e50;
    min-height: 100vh;
  }

  .container {
    position: relative;
    max-width: 1400px;
    margin: 5rem auto;
    margin-top: 8rem;
  }

  .page-heading {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-top: 20px;
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
    display: flex;
    align-items: center;
    border: 2px solid #ddd;
    border-radius: 12px;
    background: #f8f8f8;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .input-with-icon:focus-within {
    border-color: #4f9da6;
    box-shadow: 0 0 0 3px rgba(79, 157, 166, 0.2);
  }

  .input-icon {
    padding: 0.8rem 1rem;
    font-size: 1.2rem;
    color: #7f8c8d;
    background: transparent;
  }

  .input-with-icon input {
    border: none;
    outline: none;
    padding: 0.8rem 1rem 0.8rem 0;
    flex: 1;
    background: transparent;
    font-size: 1rem;
  }

  .input-with-icon input:read-only {
    color: #7f8c8d;
    cursor: not-allowed;
  }

  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
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
  }

  .btn-detail {
    background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
    color: white;
  }

  .btn-detail:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(79, 157, 166, 0.4);
    color: white;
  }

  .btn-reorder {
    background: linear-gradient(135deg, #ff7f50 0%, #ff4500 100%);
    color: white;
  }

  .btn-reorder:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(255, 99, 71, 0.4);
    color: white;
  }

  /* Thêm style cho thẻ alert nếu chưa có */
  .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 12px;
    font-weight: 500;
  }

  .alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
  }

  .alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
  }
</style>
<?php
$extraCss = ob_get_clean();

// Gọi Header chung
include '../includes/header.php';
?>

<main class="container">
  <h2 class="page-heading">
    <i class="bi bi-person-lines-fill"></i> Thông tin tài khoản
  </h2>

  <div class="history-container">
    <?php if ($successMsg): ?>
      <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i> <?= h($successMsg) ?>
      </div>
      <script>
        // Cập nhật lại localStorage nếu sửa thành công (để UI phía trên header tự cập nhật Tên mới)
        let userCache = JSON.parse(localStorage.getItem('bs_user') || '{}');
        userCache.fullName = <?= json_encode($fullName ?? $userCurrentInfo['fullName']) ?>;
        localStorage.setItem('bs_user', JSON.stringify(userCache));
      </script>
    <?php endif; ?>

    <?php if ($errorMsg): ?>
      <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill"></i> <?= h($errorMsg) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="update-profile.php">
      <div class="form-group">
        <label for="username">Tên đăng nhập (Không thể thay đổi)</label>
        <div class="input-with-icon">
          <span class="input-icon"><i class="bi bi-person-badge"></i></span>
          <input type="text" id="username" value="<?= h($userCurrentInfo['username'] ?? '') ?>" readonly />
        </div>
      </div>

      <div class="form-group">
        <label for="fullname">Họ và Tên *</label>
        <div class="input-with-icon">
          <span class="input-icon"><i class="bi bi-person"></i></span>
          <input type="text" id="fullname" name="fullname" value="<?= h($userCurrentInfo['fullName'] ?? '') ?>" placeholder="Nhập họ và tên đầy đủ" required />
        </div>
      </div>

      <div class="form-group">
        <label for="email">Email *</label>
        <div class="input-with-icon">
          <span class="input-icon"><i class="bi bi-envelope"></i></span>
          <input type="email" id="email" name="email" value="<?= h($userCurrentInfo['email'] ?? '') ?>" placeholder="example@email.com" required />
        </div>
      </div>

      <div class="form-group">
        <label for="phone">Số điện thoại *</label>
        <div class="input-with-icon">
          <span class="input-icon"><i class="bi bi-telephone"></i></span>
          <input type="tel" id="phone" name="phone" value="<?= h($userCurrentInfo['phone'] ?? '') ?>" placeholder="Nhập số điện thoại" required />
        </div>
      </div>

      <div class="form-group">
        <label for="address">Địa chỉ giao hàng mặc định *</label>
        <div class="input-with-icon">
          <span class="input-icon"><i class="bi bi-geo-alt"></i></span>
          <input type="text" id="address" name="address" value="<?= h($userCurrentInfo['address'] ?? '') ?>" placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." required />
        </div>
      </div>

      <div class="form-actions">
        <a href="change-password.php" class="btn-action btn-reorder">
          <i class="bi bi-key"></i> Đổi mật khẩu
        </a>
        <button type="submit" class="btn-action btn-detail">
          <i class="bi bi-save"></i> Cập nhật thông tin
        </button>
      </div>
    </form>
  </div>
</main>

<?php
// Gói Script xử lý Form vào $extraJs
ob_start();
?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Validate số điện thoại khi submit form
    const form = document.querySelector('form');
    if (form) {
      form.addEventListener('submit', function(e) {
        const phone = document.getElementById('phone').value.trim();
        if (!/^[0-9]{10,11}$/.test(phone)) {
          e.preventDefault();
          alert('Số điện thoại không hợp lệ. Vui lòng nhập 10-11 chữ số.');
        }
      });
    }
  });
</script>
<?php
$extraJs = ob_get_clean();

// Gọi Footer chung
include '../includes/footer.php';
?>