<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// NGƯỜI BẢO VỆ: Nếu chưa đăng nhập, lập tức "đá" về trang index.php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: index.php");
  exit;
}

// Hàm hỗ trợ in HTML an toàn
function h($str)
{
  return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// Hàm định dạng tiền tệ
function formatCurrency($amount)
{
  return number_format((float)$amount, 0, ',', '.') . '₫';
}

// ==================== 1. LẤY THỐNG KÊ TỔNG QUAN ====================
// Giả lập Lượt truy cập và Bình luận (Vì DB hiện tại chưa có bảng Tracking & Comments)
$visitors = "1,504";
$comments = "284";

// Lấy Doanh số (Số đơn) và Doanh thu (Tổng tiền) từ những đơn hàng thành công
$salesCount = 0;
$totalRevenue = 0;
$statSql = "SELECT COUNT(id) as total_orders, SUM(totalAmount) as total_revenue 
            FROM orders 
            WHERE status IN ('Đã xác nhận', 'Đã giao thành công', 'Đã xử lý')";
$resStat = $conn->query($statSql);
if ($resStat && $row = $resStat->fetch_assoc()) {
  $salesCount = (int)$row['total_orders'];
  $totalRevenue = (float)$row['total_revenue'];
}

// Làm gọn số tiền lớn (Ví dụ: 36,300,000 -> 36.3M)
$displayRevenue = formatCurrency($totalRevenue);
if ($totalRevenue >= 1000000) {
  $displayRevenue = round($totalRevenue / 1000000, 1) . 'M₫';
}

// ==================== 2. TỒN KHO THẤP (< 20) ====================
$lowStockProducts = [];
$lowStockSql = "SELECT sku, name, qty FROM products WHERE qty < 20 AND status = 'active' ORDER BY qty ASC LIMIT 5";
$resLowStock = $conn->query($lowStockSql);
if ($resLowStock) {
  $lowStockProducts = $resLowStock->fetch_all(MYSQLI_ASSOC);
}

// ==================== 3. SẢN PHẨM 0% LỢI NHUẬN ====================
$zeroProfitProducts = [];
$zeroProfitSql = "SELECT sku, name, costPrice, price FROM products WHERE profitMargin = 0 AND status = 'active' LIMIT 5";
$resZeroProfit = $conn->query($zeroProfitSql);
if ($resZeroProfit) {
  $zeroProfitProducts = $resZeroProfit->fetch_all(MYSQLI_ASSOC);
}

// ==================== 4. ĐƠN HÀNG GẦN ĐÂY NHẤT ====================
$recentOrders = [];
$recentOrdersSql = "SELECT id, buyer_name, orderDate, totalAmount, status FROM orders ORDER BY id DESC LIMIT 5";
$resRecentOrders = $conn->query($recentOrdersSql);
if ($resRecentOrders) {
  $recentOrders = $resRecentOrders->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bảng điều khiển Admin - Literary Haven</title>
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

  <?php include 'admin_sidebar.php'; ?>

  <main class="main-content">
    <div class="page-content p-4">

      <h1 class="mb-4">Bảng điều khiển</h1>

      <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
          <div class="card stat-card">
            <div class="card-body">
              <div>
                <h2><?= $visitors ?></h2>
                <span>Lượt truy cập</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card stat-card dark">
            <div class="card-body">
              <div>
                <h2><?= number_format($salesCount) ?></h2>
                <span>Doanh số (Đơn hoàn thành)</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card stat-card">
            <div class="card-body">
              <div>
                <h2><?= $comments ?></h2>
                <span>Bình luận</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card stat-card">
            <div class="card-body">
              <div>
                <h2 title="<?= formatCurrency($totalRevenue) ?>"><?= $displayRevenue ?></h2>
                <span>Doanh thu</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-lg-6">
          <div class="card h-100 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="h5 mb-0">Tồn kho thấp (Dưới 20)</h3>
              <a href="inventory.php" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3">Sản phẩm</th>
                      <th class="text-center pe-3">Còn lại</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($lowStockProducts)): ?>
                      <tr>
                        <td colspan="2" class="text-center py-3 text-success fw-bold">Không có sản phẩm nào sắp hết hàng.</td>
                      </tr>
                    <?php else: ?>
                      <?php foreach ($lowStockProducts as $p): ?>
                        <tr>
                          <td class="ps-3">
                            <?= h($p['name']) ?> <br>
                            <span class="text-muted small">Mã: <?= h($p['sku']) ?></span>
                          </td>
                          <td class="text-center text-danger fw-bold fs-5 pe-3"><?= $p['qty'] ?></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card h-100 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="h5 mb-0">Sản phẩm 0% lợi nhuận</h3>
              <a href="pricing.php" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3">Sản phẩm</th>
                      <th class="text-end">Giá vốn</th>
                      <th class="text-end pe-3">Giá bán</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($zeroProfitProducts)): ?>
                      <tr>
                        <td colspan="3" class="text-center py-3 text-success fw-bold">Mọi sản phẩm đều đang có lợi nhuận.</td>
                      </tr>
                    <?php else: ?>
                      <?php foreach ($zeroProfitProducts as $p): ?>
                        <tr>
                          <td class="ps-3">
                            <?= h($p['name']) ?> <br>
                            <span class="text-muted small">Mã: <?= h($p['sku']) ?></span>
                          </td>
                          <td class="text-end text-danger fw-bold"><?= formatCurrency($p['costPrice']) ?></td>
                          <td class="text-end text-primary fw-bold pe-3"><?= formatCurrency($p['price']) ?></td>
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

      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="h5 mb-0">Đơn hàng gần đây</h3>
          <a href="orders.php" class="btn btn-sm btn-primary">Xem tất cả</a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-3">Mã ĐH</th>
                  <th>Khách hàng</th>
                  <th>Ngày đặt</th>
                  <th class="text-end">Tổng tiền</th>
                  <th class="pe-3">Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($recentOrders)): ?>
                  <tr>
                    <td colspan="5" class="text-center py-4">Chưa có đơn hàng nào được đặt.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($recentOrders as $o):
                    $statusClass = 'pending';
                    $st = $o['status'];
                    if ($st === 'Đã xác nhận' || $st === 'Đã xử lý') $statusClass = 'processed';
                    if ($st === 'Đã giao thành công' || $st === 'Đã giao') $statusClass = 'delivered';
                    if ($st === 'Đã hủy') $statusClass = 'cancelled';
                  ?>
                    <tr>
                      <td class="ps-3 fw-bold text-primary">#<?= $o['id'] ?></td>
                      <td class="fw-bold"><?= h($o['buyer_name']) ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($o['orderDate'])) ?></td>
                      <td class="text-end text-danger fw-bold"><?= formatCurrency($o['totalAmount']) ?></td>
                      <td class="pe-3"><span class="status <?= $statusClass ?>"><?= h($st) ?></span></td>
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