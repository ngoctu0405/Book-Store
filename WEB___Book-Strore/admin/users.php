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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/admin_style.css">
  <style>


    /* Tùy chỉnh select địa chỉ */
    .custom-select-addr {
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      padding: 0.6rem;
      font-size: 0.95rem;
      width: 100%;
      margin-bottom: 10px;
      outline: none;
      transition: border-color 0.3s;
    }
    .custom-select-addr:focus {
      border-color: #007bff;
    }
    .addr-input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      overflow: hidden;
    }
    .addr-input-wrapper i {
      padding: 0 10px;
      color: #7f8c8d;
    }
    .addr-input-wrapper input {
      border: none;
      outline: none;
      padding: 8px;
      flex: 1;
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
                        <button class="btn btn-sm" style="border: 2px solid #ff9800; color: #d39e00; font-weight: 600; border-radius: 6px; background-color: transparent;" onmouseover="this.style.backgroundColor='#ff9800'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#d39e00';" onclick="promptResetPassword(<?= $u['id'] ?>)">Đổi Mật Khẩu</button>

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
    <div class="modal-dialog" style="max-width: 750px;">
      <div class="modal-content shadow-lg border-0">
        <form method="POST" action="users.php">
          <input type="hidden" name="action" value="add_user">

          <div class="modal-header bg-light border-bottom-0 py-2">
            <h5 class="modal-title fw-bold text-dark" style="font-size: 1rem;"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tạo tài khoản khách hàng mới</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" style="font-size: 0.8rem;"></button>
          </div>
          <div class="modal-body p-3">
            <div class="row g-2">
              <!-- Cột 1 & 2: Thông tin cá nhân & Tài khoản -->
              <div class="col-md-6">
                <div class="mb-2">
                  <label class="form-label fw-semibold small">Họ và tên</label>
                  <input type="text" class="form-control form-control-sm" name="fullName" placeholder="Nhập họ tên..." required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-2">
                  <label class="form-label fw-semibold small">Email</label>
                  <input type="email" class="form-control form-control-sm" name="email" placeholder="example@gmail.com..." required />
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-2">
                  <label class="form-label fw-semibold small">Tài khoản</label>
                  <input type="text" class="form-control form-control-sm" name="username" placeholder="Tên đăng nhập..." required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-2">
                  <label class="form-label fw-semibold small">Số điện thoại</label>
                  <input type="tel" class="form-control form-control-sm" name="phone" placeholder="Nhập số điện thoại..." />
                </div>
              </div>

              <div class="col-12">
                <div class="mb-2">
                  <label class="form-label fw-semibold small">Mật khẩu (tối thiểu 6 ký tự)</label>
                  <input type="text" class="form-control form-control-sm" name="password" placeholder="Nhập mật khẩu..." required minlength="6" />
                </div>
              </div>

              <!-- Hàng ngang: Địa chỉ -->
              <div class="col-12">
                <hr class="text-muted opacity-25 my-2">
                <label class="form-label fw-bold text-primary small"><i class="bi bi-geo-alt-fill me-1"></i>Địa chỉ giao hàng *</label>
                <div class="address-selector">
                  <div class="row g-2">
                    <div class="col-md-4">
                      <select id="sel-city" class="custom-select-addr" required>
                        <option value="">Chọn Tỉnh/Thành phố</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <select id="sel-dist" class="custom-select-addr" required disabled>
                        <option value="">Chọn Quận/Huyện</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <select id="sel-ward" class="custom-select-addr" required disabled>
                        <option value="">Chọn Phường/Xã</option>
                      </select>
                    </div>
                  </div>
                  <div class="addr-input-wrapper mt-2">
                    <i class="bi bi-house-door"></i>
                    <input type="text" id="inp-street" placeholder="Số nhà, tên đường, hẻm..." required />
                  </div>
                  <input type="hidden" name="address" id="hidden-full-address">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer bg-light border-top-0 py-2">
            <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Lưu tài khoản</button>
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
    // --- XỬ LÝ ĐỊA CHỈ 4 CẤP ---
    document.addEventListener("DOMContentLoaded", async function() {
      const citySel = document.getElementById('sel-city');
      const distSel = document.getElementById('sel-dist');
      const wardSel = document.getElementById('sel-ward');
      const streetInp = document.getElementById('inp-street');
      const hiddenAddress = document.getElementById('hidden-full-address');

      try {
        const res = await fetch('../assets/data/provinces.json');
        const data = await res.json();

        // Load Tỉnh/Thành
        data.forEach(c => {
          citySel.add(new Option(c.name, c.code));
        });

        // Event: Chọn Tỉnh
        citySel.addEventListener('change', function() {
          distSel.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
          wardSel.innerHTML = '<option value="">Chọn Phường/Xã</option>';
          distSel.disabled = true;
          wardSel.disabled = true;

          if (this.value) {
            const city = data.find(c => c.code == this.value);
            if (city && city.districts) {
              city.districts.forEach(d => distSel.add(new Option(d.name, d.code)));
              distSel.disabled = false;
            }
          }
        });

        // Event: Chọn Huyện
        distSel.addEventListener('change', function() {
          wardSel.innerHTML = '<option value="">Chọn Phường/Xã</option>';
          wardSel.disabled = true;

          if (this.value) {
            const city = data.find(c => c.code == citySel.value);
            const dist = city.districts.find(d => d.code == this.value);
            if (dist && dist.wards) {
              dist.wards.forEach(w => wardSel.add(new Option(w.name, w.code)));
              wardSel.disabled = false;
            }
          }
        });
      } catch (err) {
        console.error("Lỗi tải provinces.json:", err);
      }

      // Trước khi submit, ghép chuỗi địa chỉ
      const userForm = document.querySelector('#addUserModal form');
      userForm.addEventListener('submit', function() {
        const cityTxt = citySel.options[citySel.selectedIndex].text;
        const distTxt = distSel.options[distSel.selectedIndex].text;
        const wardTxt = wardSel.options[wardSel.selectedIndex].text;
        const streetTxt = streetInp.value.trim();

        hiddenAddress.value = `${wardTxt}, ${distTxt}, ${cityTxt} - ${streetTxt}`;
      });
    });

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