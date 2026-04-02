<?php
session_start();
// Nhớ kiểm tra lại đường dẫn file db.php cho chuẩn với thư mục của bạn nhé
require_once __DIR__ . '/../api/db.php';

// XỬ LÝ CÁC HÀNH ĐỘNG TỪ FORM (THÊM, SỬA, ẨN/HIỆN)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'add') {
    $name = trim($_POST['name'] ?? '');
    if ($name) {
      $stmt = $conn->prepare("INSERT INTO categories (name, status) VALUES (?, 'active')");
      $stmt->bind_param('s', $name);
      $stmt->execute();
    }
  } elseif ($action === 'edit') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    if ($id && $name) {
      $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
      $stmt->bind_param('si', $name, $id);
      $stmt->execute();
    }
  } elseif ($action === 'toggle') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id) {
      // Lấy trạng thái hiện tại
      $stmt = $conn->prepare("SELECT status FROM categories WHERE id = ?");
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $res = $stmt->get_result()->fetch_assoc();

      if ($res) {
        // Đảo ngược trạng thái
        $newStatus = ($res['status'] === 'active') ? 'hidden' : 'active';
        $updateStmt = $conn->prepare("UPDATE categories SET status = ? WHERE id = ?");
        $updateStmt->bind_param('si', $newStatus, $id);
        $updateStmt->execute();
      }
    }
  }

  // Refresh lại trang để tránh bị gửi lại form khi F5
  header("Location: categories.php");
  exit;
}

// LẤY DANH SÁCH TỪ DATABASE ĐỂ HIỂN THỊ
$categories = [];
$res = $conn->query("SELECT * FROM categories ORDER BY id ASC");
if ($res) {
  while ($row = $res->fetch_assoc()) {
    // Đảm bảo những danh mục cũ chưa có status sẽ mặc định là active
    if (empty($row['status'])) {
      $row['status'] = 'active';
    }
    $categories[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Loại Sản phẩm</title>

  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/admin_style.css">
  <style>
    /* BẢO LƯU CSS CŨ CỦA BẠN */
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

      .page-content h1 {
        font-size: 20px;
        margin-bottom: 15px;
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

      .profit-input {
        width: 50px;
        padding: 4px 2px;
        font-size: 12px;
      }

      .btn-sm {
        padding: 3px 6px;
        font-size: 10px;
      }

      .table tbody td span.small {
        display: none;
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

  <aside class="sidebar d-flex flex-column vh-100">
    <div class="sidebar-header">Literary Haven</div>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item"><a href="dashboard.php" class="nav-link"><span class="nav-icon">◈</span><span>Bảng điều khiển</span></a></li>
      <li class="nav-item"><a href="users.php" class="nav-link"><span class="nav-icon">◉</span><span>Khách hàng</span></a></li>
      <li class="nav-item"><a href="categories.php" class="nav-link active"><span class="nav-icon">◫</span><span>Loại sản phẩm</span></a></li>
      <li class="nav-item"><a href="products.php" class="nav-link"><span class="nav-icon">◪</span><span>Sản phẩm</span></a></li>
      <li class="nav-item"><a href="purchase-orders.php" class="nav-link"><span class="nav-icon">◩</span><span>Nhập hàng</span></a></li>
      <li class="nav-item"><a href="pricing.php" class="nav-link"><span class="nav-icon">◎</span><span>Quản lý giá</span></a></li>
      <li class="nav-item"><a href="orders.php" class="nav-link"><span class="nav-icon">◧</span><span>Đơn hàng</span></a></li>
      <li class="nav-item"><a href="inventory.php" class="nav-link"><span class="nav-icon">◨</span><span>Tồn kho</span></a></li>
      <li class="nav-item"><a href="reports.php" class="nav-link"><span class="nav-icon">◔</span><span>Báo cáo</span></a></li>
    </ul>
    <div class="mt-auto p-3">
      <a href="index.php" class="logout-link"><span>◀</span><span>Đăng xuất</span></a>
    </div>
  </aside>

  <main class="main-content">
    <div class="page-content p-4">
      <h1 class="mb-4">Quản lý Loại Sản phẩm</h1>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="form-container p-4">
            <h3 class="h5 mb-3" id="category-form-title">Thêm loại mới</h3>
            <form method="POST" action="categories.php" id="categoryForm">
              <input type="hidden" name="action" id="form-action" value="add">
              <input type="hidden" name="id" id="form-id" value="">

              <div class="mb-3">
                <label for="category-name" class="form-label">Tên loại sản phẩm</label>
                <input type="text" class="form-control" id="category-name" name="name" required />
              </div>
              <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="resetForm()">Hủy</button>
                <button type="submit" class="btn btn-primary ms-2" id="submit-btn">Lưu</button>
              </div>
            </form>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h3 class="h5 mb-0">Danh sách loại sản phẩm</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Tên loại</th>
                      <th>Trạng thái</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($categories)): ?>
                      <tr>
                        <td colspan="3" class="text-center">Chưa có danh mục nào.</td>
                      </tr>
                    <?php else: ?>
                      <?php foreach ($categories as $cat): ?>
                        <?php
                        $isActive = ($cat['status'] === 'active');
                        $statusClass = $isActive ? "delivered" : "pending";
                        $statusText = $isActive ? "Đang hiển thị" : "Đã ẩn";
                        ?>
                        <tr>
                          <td><?= htmlspecialchars($cat['name']) ?></td>
                          <td><span class="status <?= $statusClass ?>"><?= $statusText ?></span></td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary"
                              onclick="editCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>')">Sửa</button>

                            <form method="POST" action="categories.php" style="display:inline-block; margin:0;">
                              <input type="hidden" name="action" value="toggle">
                              <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                              <?php if ($isActive): ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">Ẩn</button>
                              <?php else: ?>
                                <button type="submit" class="btn btn-sm btn-outline-success">Hiện</button>
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
      </div>
    </div>
  </main>

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // JS nhẹ nhàng để chuyển đổi giữa Thêm và Sửa ngay trên Form HTML
    function editCategory(id, name) {
      document.getElementById('form-action').value = 'edit';
      document.getElementById('form-id').value = id;
      document.getElementById('category-name').value = name;

      document.getElementById('category-form-title').textContent = 'Sửa loại sản phẩm';
      document.getElementById('submit-btn').textContent = 'Cập nhật';
    }

    function resetForm() {
      document.getElementById('form-action').value = 'add';
      document.getElementById('form-id').value = '';
      document.getElementById('category-name').value = '';

      document.getElementById('category-form-title').textContent = 'Thêm loại mới';
      document.getElementById('submit-btn').textContent = 'Lưu';
    }
  </script>

  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
    </i>
  </a>
</body>

</html>