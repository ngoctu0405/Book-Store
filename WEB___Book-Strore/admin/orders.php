<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// Bảo vệ trang Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: index.php");
  exit;
}

// --- XỬ LÝ LỌC VÀ SẮP XẾP ---
$start_date = $_GET['start_date'] ?? '';
$end_date   = $_GET['end_date'] ?? '';
$status     = $_GET['status'] ?? '';
$address    = $_GET['address'] ?? '';
$sort       = $_GET['sort'] ?? 'newest';

$whereConditions = [];
$params = [];
$types = "";

if ($start_date) {
  $whereConditions[] = "DATE(orderDate) >= ?";
  $params[] = $start_date;
  $types .= "s";
}
if ($end_date) {
  $whereConditions[] = "DATE(orderDate) <= ?";
  $params[] = $end_date;
  $types .= "s";
}
if ($status) {
  $whereConditions[] = "status = ?";
  $params[] = $status;
  $types .= "s";
}
if ($address) {
  $whereConditions[] = "buyer_address LIKE ?";
  $params[] = "%$address%";
  $types .= "s";
}

$whereSql = $whereConditions ? "WHERE " . implode(" AND ", $whereConditions) : "";

// Xử lý sắp xếp theo yêu cầu (Đã bỏ Tổng tiền)
$orderSql = "ORDER BY id DESC"; // Mặc định mới nhất
switch ($sort) {
  case 'oldest':
    $orderSql = "ORDER BY id ASC";
    break;
  case 'address_asc':
    // Gom nhóm chuẩn xác nhờ format: "Phường X, Quận Y, Tỉnh Z - Số nhà"
    $orderSql = "ORDER BY buyer_address ASC, id DESC";
    break;
  case 'address_desc':
    $orderSql = "ORDER BY buyer_address DESC, id DESC";
    break;
  case 'newest':
  default:
    $orderSql = "ORDER BY id DESC";
    break;
}

// Truy vấn lấy đơn hàng
$sql = "SELECT id, buyer_name, orderDate, totalAmount, status, buyer_address FROM orders $whereSql $orderSql";
$stmt = $conn->prepare($sql);
if ($types) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Đơn hàng - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/admin_style.css">
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
        min-width: 800px;
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
      <h1 class="mb-4">Quản lý Đơn hàng</h1>

      <div class="card mb-4">
        <div class="card-body">
          <form method="GET" action="orders.php" class="row g-3 align-items-end">
            <div class="col-md-2">
              <label class="form-label">Từ ngày</label>
              <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($start_date) ?>" />
            </div>
            <div class="col-md-2">
              <label class="form-label">Đến ngày</label>
              <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($end_date) ?>" />
            </div>
            <div class="col-md-3">
              <label class="form-label">Tìm theo Quận/Phường</label>
              <input type="text" name="address" class="form-control" placeholder="VD: Phường Bến Nghé..." value="<?= htmlspecialchars($address) ?>" />
            </div>
            <div class="col-md-2">
              <label class="form-label">Tình trạng</label>
              <select name="status" class="form-select">
                <option value="" <?= $status === '' ? 'selected' : '' ?>>Tất cả</option>
                <option value="Chờ xác nhận" <?= $status === 'Chờ xác nhận' ? 'selected' : '' ?>>Chờ xác nhận</option>
                <option value="Đã xác nhận" <?= $status === 'Đã xác nhận' ? 'selected' : '' ?>>Đã xác nhận</option>
                <option value="Đã giao thành công" <?= $status === 'Đã giao thành công' ? 'selected' : '' ?>>Đã giao thành công</option>
                <option value="Đã hủy" <?= $status === 'Đã hủy' ? 'selected' : '' ?>>Đã hủy</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label">Sắp xếp</label>
              <select name="sort" class="form-select">
                <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>Cũ nhất</option>
                <option value="address_asc" <?= $sort === 'address_asc' ? 'selected' : '' ?>>Phường/Xã (A - Z)</option>
                <option value="address_desc" <?= $sort === 'address_desc' ? 'selected' : '' ?>>Phường/Xã (Z - A)</option>
              </select>
            </div>
            <div class="col-md-1">
              <button type="submit" class="btn btn-primary w-100">Lọc</button>
            </div>
          </form>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-header">
          <h3 class="h5 mb-0">Danh sách đơn hàng</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>Mã ĐH</th>
                  <th>Khách hàng</th>
                  <th>Địa chỉ giao hàng</th>
                  <th>Ngày đặt</th>
                  <th>Tổng tiền</th>
                  <th>Tình trạng</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($orders)): ?>
                  <tr>
                    <td colspan="7" class="text-center text-muted">Không tìm thấy đơn hàng nào.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($orders as $order):
                    // Gắn CSS class dựa theo trạng thái
                    $statusClass = 'pending';
                    if ($order['status'] === 'Đã xác nhận') $statusClass = 'processed';
                    if ($order['status'] === 'Đã giao thành công') $statusClass = 'delivered';
                    if ($order['status'] === 'Đã hủy') $statusClass = 'cancelled';
                  ?>
                    <tr>
                      <td><strong>#<?= $order['id'] ?></strong></td>
                      <td><?= htmlspecialchars($order['buyer_name']) ?></td>
                      <td><small><?= htmlspecialchars($order['buyer_address']) ?></small></td>
                      <td><?= date('d/m/Y H:i', strtotime($order['orderDate'])) ?></td>
                      <td class="text-danger fw-bold"><?= number_format($order['totalAmount']) ?>đ</td>
                      <td><span class="status <?= $statusClass ?>"><?= htmlspecialchars($order['status']) ?></span></td>
                      <td>
                        <a href="order-detail.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">Xem</a>
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
    <i class="bi bi-chevron-up"><img class="go-up" src="../images/muiten.svg" alt="Lên đầu trang" /></i>
  </a>
</body>

</html>