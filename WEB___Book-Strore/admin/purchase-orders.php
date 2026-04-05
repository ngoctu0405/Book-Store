<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// Bảo vệ trang Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: index.php");
  exit;
}

// Xử lý thông báo flash
$message = $_SESSION['flash_msg'] ?? '';
unset($_SESSION['flash_msg']);

// --- XỬ LÝ BỘ LỌC (FILTER) ---
$whereConditions = [];
$params = [];
$types = "";

$po_id      = $_GET['po_id'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date   = $_GET['end_date'] ?? '';
$status     = $_GET['status'] ?? '';

if ($po_id !== '') {
  $whereConditions[] = "g.id = ?";
  $params[] = (int)$po_id;
  $types .= "i";
}
if ($start_date !== '') {
  $whereConditions[] = "DATE(g.createdAt) >= ?";
  $params[] = $start_date;
  $types .= "s";
}
if ($end_date !== '') {
  $whereConditions[] = "DATE(g.createdAt) <= ?";
  $params[] = $end_date;
  $types .= "s";
}
if ($status !== '') {
  $whereConditions[] = "g.status = ?";
  $params[] = $status;
  $types .= "s";
}

$whereSql = "";
if (count($whereConditions) > 0) {
  $whereSql = "WHERE " . implode(" AND ", $whereConditions);
}

// Lấy danh sách phiếu nhập + đếm tổng số lượng sản phẩm từ bảng chi tiết
$sql = "SELECT g.id, g.createdAt, g.totalAmount, g.status, IFNULL(SUM(gi.qty), 0) as totalItems
        FROM goods_receipt g
        LEFT JOIN goodsReceipts_items gi ON g.id = gi.goods_receipt_id
        $whereSql
        GROUP BY g.id
        ORDER BY g.id DESC";

$stmt = $conn->prepare($sql);
if ($types) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$purchases = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Nhập hàng - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/admin_style.css" />
  <style>
    /* Style responsive */
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

      .btn-sm {
        padding: 3px 6px;
        font-size: 10px;
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
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Quản lý Nhập hàng</h1>
        <a href="purchase-edit.php" class="btn btn-primary">Thêm phiếu nhập</a>
      </div>

      <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
      <?php endif; ?>

      <div class="card mb-4">
        <div class="card-body">
          <form method="GET" action="purchase-orders.php" class="row g-3 align-items-end">
            <div class="col-md-3">
              <label class="form-label">Mã phiếu nhập</label>
              <input type="text" name="po_id" class="form-control" placeholder="Nhập mã phiếu..." value="<?= htmlspecialchars($po_id) ?>" />
            </div>
            <div class="col-md-3">
              <label class="form-label">Từ ngày</label>
              <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($start_date) ?>" />
            </div>
            <div class="col-md-3">
              <label class="form-label">Đến ngày</label>
              <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($end_date) ?>" />
            </div>
            <div class="col-md-2">
              <label class="form-label">Trạng thái</label>
              <select name="status" class="form-select">
                <option value="" <?= $status === '' ? 'selected' : '' ?>>Tất cả</option>
                <option value="chưa hoàn thành" <?= $status === 'chưa hoàn thành' ? 'selected' : '' ?>>Chưa hoàn thành</option>
                <option value="hoàn thành" <?= $status === 'hoàn thành' ? 'selected' : '' ?>>Đã hoàn thành</option>
              </select>
            </div>
            <div class="col-md-1">
              <button type="submit" class="btn btn-primary w-100">Lọc</button>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="h5 mb-0">Danh sách phiếu nhập</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>Mã Phiếu</th>
                  <th>Ngày tạo</th>
                  <th>Tổng SP</th>
                  <th>Tổng tiền nhập</th>
                  <th>Trạng thái</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($purchases)): ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted">Không tìm thấy phiếu nhập nào.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($purchases as $p):
                    $isCompleted = ($p['status'] === 'hoàn thành');
                    $statusClass = $isCompleted ? 'delivered' : 'pending';
                    $statusText  = $isCompleted ? 'Đã hoàn thành' : 'Chưa hoàn thành';
                  ?>
                    <tr>
                      <td><strong>#<?= $p['id'] ?></strong></td>
                      <td><?= date('d/m/Y H:i', strtotime($p['createdAt'])) ?></td>
                      <td><?= $p['totalItems'] ?></td>
                      <td class="text-danger fw-bold"><?= number_format($p['totalAmount']) ?>đ</td>
                      <td><span class="status <?= $statusClass ?>"><?= $statusText ?></span></td>
                      <td>
                        <a href="purchase-edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">
                          <?= $isCompleted ? 'Xem chi tiết' : 'Chỉnh sửa' ?>
                        </a>
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
  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up"><img class="go-up" src="../images/muiten.svg" alt="Up" /></i>
  </a>
</body>

</html>