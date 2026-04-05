<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// 1. NGƯỜI BẢO VỆ: Nếu chưa đăng nhập, "đá" về trang index.php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: index.php");
  exit;
}

// KHỞI TẠO BIẾN THÔNG BÁO
$message = $_SESSION['flash_msg'] ?? '';
$error = $_SESSION['flash_err'] ?? '';
unset($_SESSION['flash_msg'], $_SESSION['flash_err']);

// 2. XỬ LÝ CÁC HÀNH ĐỘNG (THÊM, KHÓA, ĐỔI MẬT KHẨU) BẰNG PHP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  // --- XỬ LÝ THÊM USER ---
  if ($action === 'add_user') {
    $fullName = trim($_POST['fullName'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');

    if (strlen($password) < 6) {
      $_SESSION['flash_err'] = "Mật khẩu phải có ít nhất 6 ký tự.";
    } else {
      $stmtCheck = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
      $stmtCheck->bind_param("ss", $username, $email);
      $stmtCheck->execute();
      if ($stmtCheck->get_result()->num_rows > 0) {
        $_SESSION['flash_err'] = "Tên đăng nhập hoặc Email này đã tồn tại trong hệ thống.";
      } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user'; // Mặc định khách hàng là user
        $status = 'active';

        $stmtInsert = $conn->prepare("INSERT INTO users (fullName, username, password, email, phone, address, status, role, createdAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmtInsert->bind_param("ssssssss", $fullName, $username, $hashedPassword, $email, $phone, $address, $status, $role);

        if ($stmtInsert->execute()) {
          $_SESSION['flash_msg'] = "Thêm khách hàng thành công!";
        } else {
          $_SESSION['flash_err'] = "Có lỗi xảy ra khi lưu vào Database.";
        }
      }
    }
  }
  // --- XỬ LÝ KHÓA / MỞ KHÓA TÀI KHOẢN ---
  elseif ($action === 'toggle_status') {
    $userId = (int)$_POST['user_id'];

    if ($userId === (int)$_SESSION['admin_id']) {
      $_SESSION['flash_err'] = "Bạn không thể tự khóa tài khoản của chính mình!";
    } else {
      $stmtGet = $conn->prepare("SELECT status FROM users WHERE id = ?");
      $stmtGet->bind_param("i", $userId);
      $stmtGet->execute();
      $res = $stmtGet->get_result();
      if ($res && $res->num_rows > 0) {
        $currentStatus = $res->fetch_assoc()['status'];
        $newStatus = ($currentStatus === 'active') ? 'locked' : 'active';

        $stmtUpd = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmtUpd->bind_param("si", $newStatus, $userId);
        if ($stmtUpd->execute()) {
          $_SESSION['flash_msg'] = "Cập nhật trạng thái tài khoản thành công!";
        }
      }
    }
  }
  // --- XỬ LÝ RESET MẬT KHẨU ---
  elseif ($action === 'reset_password') {
    $userId = (int)$_POST['user_id'];
    $newPassword = $_POST['new_password'] ?? '';

    if (strlen($newPassword) >= 6) {
      $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
      $stmtUpd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
      $stmtUpd->bind_param("si", $hashed, $userId);
      if ($stmtUpd->execute()) {
        $_SESSION['flash_msg'] = "Đã thay đổi mật khẩu thành công!";
      }
    } else {
      $_SESSION['flash_err'] = "Mật khẩu mới quá ngắn. Thao tác bị hủy.";
    }
  }

  header("Location: users.php");
  exit;
}

// 3. LẤY DANH SÁCH TÀI KHOẢN TỪ DATABASE (CHỈ LẤY USER)
$users = [];
// SỬA Ở ĐÂY: Thêm điều kiện WHERE role = 'user'
$res = $conn->query("SELECT * FROM users WHERE role = 'user' ORDER BY id DESC");
if ($res) {
  while ($row = $res->fetch_assoc()) {
    $users[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Khách hàng - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/admin_style.css">
  <style>
    /* Responsive cho thiết bị di động (max-width: 768px) */
    @media (max-width: 768px) {
      body {
        display: flex !important;
        flex-direction: column !important;
        overflow-x: hidden;
      }

      .sidebar {
        width: 100% !important;
        height: auto !important;
        flex-shrink: 0;
        display: flex !important;
        overflow-x: auto;
        white-space: nowrap;
      }

      .main-content {
        width: 100%;
        min-width: auto;
      }

      .page-content {
        padding: 15px !important;
      }

      .table-responsive {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }

      .table {
        min-width: 600px;
      }

      .table thead th,
      .table tbody td {
        padding: 8px 6px;
        font-size: 12px;
      }
    }

    @media (min-width: 769px) {
      body {
        display: flex !important;
        flex-direction: row !important;
        overflow-x: hidden;
      }

      .sidebar {
        width: 250px !important;
        height: 100vh !important;
        display: flex !important;
      }

      .main-content {
        width: 100%;
      }
    }
  </style>
</head>

<body>

  <?php include 'admin_sidebar.php'; ?>

  <main class="main-content">
    <div class="page-content p-4">
      <h1 class="mb-4">Quản lý Khách hàng</h1>

      <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($error) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="h5 mb-0">Danh sách tài khoản</h3>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            + Thêm khách hàng
          </button>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Tên khách hàng</th>
                  <th>Email</th>
                  <th>Trạng thái</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($users)): ?>
                  <tr>
                    <td colspan="4" class="text-center">Chưa có khách hàng nào đăng ký</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($users as $u): ?>
                    <?php
                    $isActive = ($u['status'] === 'active');
                    $statusClass = $isActive ? "delivered" : "pending";
                    $statusText = $isActive ? "Hoạt động" : "Đã khóa";
                    ?>
                    <tr>
                      <td><?= htmlspecialchars($u['fullName'] ?: '(Chưa cập nhật)') ?>
                        <br><small class="text-muted">@<?= htmlspecialchars($u['username']) ?></small>
                      </td>
                      <td><?= htmlspecialchars($u['email']) ?></td>
                      <td><span class="status <?= $statusClass ?>"><?= $statusText ?></span></td>
                      <td>
                        <button class="btn btn-sm btn-outline-warning" onclick="promptResetPassword(<?= $u['id'] ?>)">Đổi MK</button>

                        <form method="POST" action="users.php" style="display:inline-block; margin:0;">
                          <input type="hidden" name="action" value="toggle_status">
                          <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                          <?php if ($isActive): ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Khóa</button>
                          <?php else: ?>
                            <button type="submit" class="btn btn-sm btn-outline-success">Mở khóa</button>
                          <?php endif; ?>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="users.php">
          <input type="hidden" name="action" value="add_user">

          <div class="modal-header">
            <h5 class="modal-title">Tạo tài khoản khách hàng mới</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Họ và tên</label>
              <input type="text" class="form-control" name="fullName" required />
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Tài khoản</label>
                <input type="text" class="form-control" name="username" required />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Mật khẩu (tối thiểu 6 ký tự)</label>
                <input type="text" class="form-control" name="password" required minlength="6" />
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Số điện thoại</label>
              <input type="tel" class="form-control" name="phone" />
            </div>
            <div class="mb-3">
              <label class="form-label">Địa chỉ</label>
              <input type="text" class="form-control" name="address" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary">Lưu tài khoản</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <form id="resetPassForm" method="POST" style="display:none;">
    <input type="hidden" name="action" value="reset_password">
    <input type="hidden" name="user_id" id="reset_user_id">
    <input type="hidden" name="new_password" id="reset_new_password">
  </form>

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Hàm gọi hộp thoại nhập mật khẩu và đẩy vào form PHP ẩn
    function promptResetPassword(userId) {
      const pwd = prompt("Nhập mật khẩu mới cho khách hàng này (ít nhất 6 ký tự):");
      if (pwd !== null) { // Nếu không bấm Hủy
        if (pwd.trim().length < 6) {
          alert("Mật khẩu quá ngắn, vui lòng thử lại!");
        } else {
          document.getElementById('reset_user_id').value = userId;
          document.getElementById('reset_new_password').value = pwd;
          document.getElementById('resetPassForm').submit();
        }
      }
    }
  </script>

  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
    </i>
  </a>
</body>

</html>