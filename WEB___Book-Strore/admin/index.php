<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// Nếu Admin đã đăng nhập từ trước, chuyển hướng thẳng vào trong
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
  // Lưu ý: Đổi "dashboard.php" thành trang mặc định của Admin của bạn (vd: products.php)
  header("Location: dashboard.php");
  exit;
}

$errorMsg = '';

// Xử lý khi người dùng ấn nút Đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if (empty($username) || empty($password)) {
    $errorMsg = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";
  } else {
    // Truy vấn lấy thông tin từ DB (Giả định admin nằm trong bảng 'users' có role = 'admin')
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ? LIMIT 1");

    if ($stmt) {
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $res = $stmt->get_result();

      if ($res && $res->num_rows > 0) {
        $user = $res->fetch_assoc();

        // Dùng password_verify để so sánh mật khẩu nhập vào với mã Hash trong DB
        if (password_verify($password, $user['password'])) {

          // Kiểm tra quyền (Nếu DB chưa có cột role, bạn có thể xóa vòng if này)
          if (isset($user['role']) && $user['role'] === 'admin') {

            // Khởi tạo phiên làm việc (Session) cho Admin
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_logged_in'] = true;

            // Đăng nhập thành công -> Chuyển hướng vào trang quản lý
            header("Location: dashboard.php");
            exit;
          } else {
            $errorMsg = "Tài khoản này không có quyền truy cập trang quản trị.";
          }
        } else {
          $errorMsg = "Mật khẩu không chính xác.";
        }
      } else {
        $errorMsg = "Tên đăng nhập không tồn tại.";
      }
      $stmt->close();
    } else {
      $errorMsg = "Lỗi kết nối cơ sở dữ liệu.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đăng nhập Admin</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <style>
    body {
      background: linear-gradient(135deg, #7fb3d3 0%, #82c09a 100%);
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      width: 100%;
      max-width: 420px;
      border: none;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      background: white;
      border-radius: 12px;
    }

    .login-card-title {
      color: #3a3a8d;
      font-weight: 700;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .error-message {
      color: #721c24;
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 1rem;
      font-size: 0.95rem;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container login-container">
    <div class="card login-card">
      <h3 class="login-card-title">Đăng nhập Quản trị</h3>

      <?php if ($errorMsg !== ''): ?>
        <div class="error-message">
          <?= htmlspecialchars($errorMsg) ?>
        </div>
      <?php endif; ?>

      <form id="adminLoginForm" method="POST" action="index.php">
        <div class="mb-3">
          <label for="username" class="form-label fw-bold">Tên đăng nhập</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" required />
        </div>
        <div class="mb-4">
          <label for="password" class="form-label fw-bold">Mật khẩu</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required />
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-bold" style="background-color: #3a3a8d; border: none; padding: 12px;">
          Đăng Nhập
        </button>
      </form>
    </div>
  </div>
</body>

</html>