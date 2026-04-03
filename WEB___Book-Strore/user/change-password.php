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
  // Dùng trim() để loại bỏ khoảng trắng thừa
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
    // Lấy mật khẩu từ DB ra để đối chiếu
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
      $user = $res->fetch_assoc();

      if (!password_verify($oldPass, $user['password'])) {
        $errorMsg = "Mật khẩu cũ không chính xác.";
      } else {
        // MÃ HÓA mật khẩu mới trước khi lưu
        $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);

        // Cập nhật mật khẩu mới
        $stmtUpd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmtUpd->bind_param('si', $hashedNewPass, $userId);

        if ($stmtUpd->execute()) {
          $successMsg = "Đổi mật khẩu thành công! Bạn sẽ được đăng xuất để đăng nhập lại.";
          // Xóa session
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

// ==================== CHUẨN BỊ GIAO DIỆN ====================
$pageTitle = "Đổi mật khẩu - Literary Haven";

// Gói CSS riêng của trang Đổi mật khẩu
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
<?php
$extraCss = ob_get_clean();

// Gọi header chung
include '../includes/header.php';
?>

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

<?php
// Gói Javascript riêng của trang Đổi mật khẩu
ob_start();
?>
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
<?php
$extraJs = ob_get_clean();

// Gọi footer chung
include '../includes/footer.php';
?>