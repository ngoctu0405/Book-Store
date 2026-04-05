<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// ĐÂY LÀ HÀM CÒN THIẾU GÂY RA LỖI TRẮNG TRANG
function h($str)
{
  return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// Bảo vệ trang Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: index.php");
  exit;
}

$msg = '';

// ==================== XỬ LÝ HÀNH ĐỘNG (NHẬP THÊM / KHÓA BÁN) ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  $product_id = (int)($_POST['product_id'] ?? 0);

  if ($action === 'add_stock' && $product_id > 0) {
    $add_qty = (int)($_POST['add_qty'] ?? 0);
    if ($add_qty > 0) {
      $stmt = $conn->prepare("UPDATE products SET qty = qty + ?, status = IF(status='inactive', 'active', status) WHERE id = ?");
      $stmt->bind_param('ii', $add_qty, $product_id);
      if ($stmt->execute()) {
        $_SESSION['msg'] = "✅ Đã nhập thêm $add_qty sản phẩm thành công!";
      } else {
        $_SESSION['error'] = "❌ Lỗi khi nhập hàng: " . $conn->error;
      }
    }
  } elseif ($action === 'toggle_status' && $product_id > 0) {
    $new_status = $_POST['new_status'] ?? 'active';
    $stmt = $conn->prepare("UPDATE products SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $new_status, $product_id);
    if ($stmt->execute()) {
      $_SESSION['msg'] = "✅ Đã thay đổi trạng thái sản phẩm!";
    }
  }

  $query_string = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
  header("Location: inventory.php" . $query_string);
  exit;
}

if (isset($_SESSION['msg'])) {
  $msg = "<div class='alert alert-success'>" . $_SESSION['msg'] . "</div>";
  unset($_SESSION['msg']);
}
if (isset($_SESSION['error'])) {
  $msg = "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
  unset($_SESSION['error']);
}

// ==================== XỬ LÝ LỌC DỮ LIỆU (GET) ====================
$search   = $_GET['search'] ?? '';
$category_id = $_GET['category_id'] ?? '';
$status   = $_GET['status'] ?? '';

$whereConditions = ["1=1"];
$params = [];
$types = "";

if ($search !== '') {
  $whereConditions[] = "(p.name LIKE ? OR p.sku LIKE ? OR p.author LIKE ?)";
  $searchParam = "%$search%";
  $params = array_merge($params, [$searchParam, $searchParam, $searchParam]);
  $types .= "sss";
}

if ($category_id !== '') {
  $whereConditions[] = "p.category_id = ?";
  $params[] = $category_id;
  $types .= "i";
}

if ($status !== '') {
  if ($status === 'out') {
    $whereConditions[] = "p.qty <= 0 AND p.status != 'inactive'";
  } elseif ($status === 'low') {
    $whereConditions[] = "p.qty > 0 AND p.qty < 20 AND p.status != 'inactive'";
  } elseif ($status === 'normal') {
    $whereConditions[] = "p.qty >= 20 AND p.status != 'inactive'";
  } elseif ($status === 'inactive') {
    $whereConditions[] = "p.status = 'inactive'";
  }
}

$whereSql = "WHERE " . implode(" AND ", $whereConditions);

$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        $whereSql 
        ORDER BY p.id DESC";

$stmt = $conn->prepare($sql);
if ($types) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Lấy danh sách danh mục từ bảng categories
$catRes = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
$allCategories = [];
if ($catRes) {
  while ($row = $catRes->fetch_assoc()) {
    $allCategories[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Tồn kho - Literary Haven Admin</title>

  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/admin_style.css" />
  <style>
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
        min-width: 700px;
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

    .input-qty {
      width: 70px;
      padding: 5px;
      margin-right: 5px;
      border: 1px solid #ced4da;
      border-radius: 4px;
      text-align: center;
    }

    .btn-action-small {
      padding: 5px 10px;
      margin: 2px;
      font-size: 12px;
      border-radius: 6px;
    }

    .form-inline-action {
      display: inline-flex;
      align-items: center;
    }
  </style>
</head>

<body>
  <?php include 'admin_sidebar.php'; ?>

  <main class="main-content">
    <div class="page-content p-4">
      <h1 class="mb-4">Quản Lý Tồn Kho Sản Phẩm</h1>

      <?= $msg ?>

      <div class="card mb-3 shadow-sm">
        <div class="card-body">
          <form method="GET" action="inventory.php" class="row g-3">
            <div class="col-md-3">
              <label class="form-label">Tìm kiếm</label>
              <input type="text" name="search" class="form-control" placeholder="Tên sách, mã SKU, tác giả..." value="<?= h($search) ?>" />
            </div>
            <div class="col-md-2">
              <label class="form-label">Lọc theo loại</label>
              <select class="form-select" name="category_id">
                <option value="">Tất cả loại</option>
                <?php foreach ($allCategories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= $category_id == $cat['id'] ? 'selected' : '' ?>><?= h($cat['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label">Trạng thái tồn kho</label>
              <select class="form-select" name="status">
                <option value="">Tất cả</option>
                <option value="normal" <?= $status === 'normal' ? 'selected' : '' ?>>Bình thường</option>
                <option value="low" <?= $status === 'low' ? 'selected' : '' ?>>Sắp hết (< 20)</option>
                <option value="out" <?= $status === 'out' ? 'selected' : '' ?>>Hết hàng (0)</option>
                <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Dừng bán / Khóa</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label d-block">&nbsp;</label>
              <button type="submit" class="btn btn-primary w-100"><span>🔍</span> Tra cứu</button>
            </div>
            <div class="col-md-2">
              <label class="form-label d-block">&nbsp;</label>
              <a href="inventory.php" class="btn btn-secondary w-100"><span>↺</span> Đặt lại</a>
            </div>
          </form>
        </div>
      </div>

      <div class="card card-inventory shadow-sm">
        <div class="card-header card-header-inventory bg-dark text-white">Tồn Kho Hiện Tại (<?= count($products) ?> sản phẩm)</div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th scope="col" class="ps-3">Mã SP</th>
                  <th scope="col">Tên Sách</th>
                  <th scope="col" class="text-center">Loại</th>
                  <th scope="col" class="text-center">SL Còn</th>
                  <th scope="col" class="text-center">Trạng Thái</th>
                  <th scope="col" class="text-center" style="min-width: 250px;">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($products)): ?>
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Không tìm thấy dữ liệu tồn kho.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($products as $p):
                    $qty = (int)$p['qty'];
                    $pStatus = $p['status'];
                    $rowClass = '';
                    $statusBadge = '';
                    $qtyClass = '';

                    // Logic xét trạng thái
                    if ($pStatus === 'inactive') {
                      $rowClass = 'table-secondary';
                      $statusBadge = '<span class="badge bg-secondary">KHÓA/DỪNG BÁN</span>';
                    } elseif ($qty <= 0) {
                      $rowClass = 'table-danger';
                      $qtyClass = 'text-danger fw-bold';
                      $statusBadge = '<span class="badge bg-danger">HẾT HÀNG</span>';
                    } elseif ($qty < 20) {
                      $rowClass = 'table-warning';
                      $qtyClass = 'text-danger fw-bold';
                      $statusBadge = '<span class="badge bg-warning text-dark">SẮP HẾT!</span>';
                    } else {
                      $statusBadge = '<span class="badge bg-success">Bình thường</span>';
                    }
                  ?>
                    <tr class="<?= $rowClass ?>">
                      <td class="ps-3 fw-bold"><?= h($p['sku'] ?? 'N/A') ?></td>
                      <td>
                        <?= h($p['name']) ?>
                        <div class="small text-muted"><i class="bi bi-person"></i> <?= h($p['author'] ?? '') ?></div>
                      </td>
                      <td class="text-center"><?= h($p['category_name'] ?? 'Chưa PL') ?></td>
                      <td class="text-center <?= $qtyClass ?> fs-5"><?= $qty ?></td>
                      <td class="text-center"><?= $statusBadge ?></td>
                      <td class="text-center">
                        <?php if ($pStatus === 'inactive'): ?>
                          <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="action" value="toggle_status">
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="new_status" value="active">
                            <button class="btn btn-success btn-action-small" type="submit" onclick="return confirm('Bạn muốn mở BÁN LẠI sách này?')">Bán Lại</button>
                          </form>
                        <?php else: ?>
                          <form method="POST" class="form-inline-action">
                            <input type="hidden" name="action" value="add_stock">
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                            <input type="number" name="add_qty" class="input-qty" value="10" min="1" required>
                            <button class="btn btn-primary btn-action-small" type="submit">Nhập Thêm</button>
                          </form>

                          <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="action" value="toggle_status">
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="new_status" value="inactive">
                            <button class="btn btn-danger btn-action-small ms-1" type="submit" onclick="return confirm('Bạn chắc chắn muốn DỪNG BÁN sách này?')">Dừng Bán</button>
                          </form>
                        <?php endif; ?>
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

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>