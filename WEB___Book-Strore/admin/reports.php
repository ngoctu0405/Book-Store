<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// Bảo vệ trang Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: index.php");
  exit;
}

function h($str)
{
  return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// ==================== NHẬN THAM SỐ LỌC ====================
// Mặc định 30 ngày gần nhất
$start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
$end_date   = $_GET['end_date'] ?? date('Y-m-d');

// NGƯỜI DÙNG TỰ ĐỊNH NGHĨA NGƯỠNG "SẮP HẾT HÀNG" (Mặc định: 20)
$threshold  = isset($_GET['threshold']) ? (int)$_GET['threshold'] : 20;

// Chuẩn hóa thời gian để quét hết ngày
$start_date_full = $start_date . ' 00:00:00';
$end_date_full   = $end_date . ' 23:59:59';

// ==================== 1. CẢNH BÁO TỒN KHO ====================
// 1.1 Sản phẩm hết hàng (qty <= 0)
$outOfStock = [];
$resOut = $conn->query("SELECT id, sku, name, qty FROM products WHERE qty <= 0 AND status != 'inactive'");
if ($resOut) $outOfStock = $resOut->fetch_all(MYSQLI_ASSOC);

// 1.2 Sản phẩm sắp hết (0 < qty <= threshold)
$lowStock = [];
$stmtLow = $conn->prepare("SELECT id, sku, name, qty FROM products WHERE qty > 0 AND qty <= ? AND status != 'inactive'");
if ($stmtLow) {
  $stmtLow->bind_param('i', $threshold);
  $stmtLow->execute();
  $lowStock = $stmtLow->get_result()->fetch_all(MYSQLI_ASSOC);
}

// ==================== 2. THU THẬP DỮ LIỆU NHẬP/XUẤT ====================

// Lấy tất cả sản phẩm
$products = [];
$resProd = $conn->query("SELECT id, sku, name, qty FROM products ORDER BY name ASC");
if ($resProd) $products = $resProd->fetch_all(MYSQLI_ASSOC);

// Lấy tổng số lượng XUẤT (Bán ra) theo từng sản phẩm từ bảng order_items
$exports = [];
$exportSql = "SELECT od.product_id, 
                     SUM(IF(o.orderDate >= '$start_date_full' AND o.orderDate <= '$end_date_full', od.qty, 0)) AS export_in_period,
                     SUM(IF(o.orderDate > '$end_date_full', od.qty, 0)) AS export_after_period
              FROM order_items od
              JOIN orders o ON od.order_id = o.id
              WHERE o.status IN ('Đã xác nhận', 'Đã giao thành công', 'Đã xử lý')
              GROUP BY od.product_id";
$resExport = $conn->query($exportSql);
if ($resExport) {
  while ($row = $resExport->fetch_assoc()) {
    $exports[$row['product_id']] = $row;
  }
}

// Lấy tổng số lượng NHẬP theo từng sản phẩm từ bảng goodsReceipts_items
$imports = [];
$importSql = "SELECT pod.product_id, 
                     SUM(IF(po.createdAt >= '$start_date_full' AND po.createdAt <= '$end_date_full', pod.qty, 0)) AS import_in_period,
                     SUM(IF(po.createdAt > '$end_date_full', pod.qty, 0)) AS import_after_period
              FROM goodsReceipts_items pod
              JOIN goods_receipt po ON pod.goods_receipt_id = po.id
              WHERE po.status IN ('completed', 'hoàn thành', 'đã hoàn thành')
              GROUP BY pod.product_id";
$resImport = $conn->query($importSql);
if ($resImport) {
  while ($row = $resImport->fetch_assoc()) {
    $imports[$row['product_id']] = $row;
  }
}

// ==================== 3. TÍNH TOÁN NHẬP - XUẤT - TỒN ====================
$reportData = [];
$totalInitial = 0;
$totalImport = 0;
$totalExport = 0;
$totalFinal = 0;

foreach ($products as $p) {
  $pid = $p['id'];
  $current_qty = (int)$p['qty'];

  $exp_in = isset($exports[$pid]) ? (int)$exports[$pid]['export_in_period'] : 0;
  $exp_after = isset($exports[$pid]) ? (int)$exports[$pid]['export_after_period'] : 0;

  $imp_in = isset($imports[$pid]) ? (int)$imports[$pid]['import_in_period'] : 0;
  $imp_after = isset($imports[$pid]) ? (int)$imports[$pid]['import_after_period'] : 0;

  // Tính tồn đầu kỳ từ tồn hiện tại bằng cách loại bỏ các phát sinh sau kỳ
  $initial_stock = $current_qty - $imp_after + $exp_after;
  $initial_stock = max(0, $initial_stock);

  // Tồn cuối kỳ = Tồn đầu kỳ + Nhập trong kỳ - Xuất trong kỳ
  $final_stock = $initial_stock + $imp_in - $exp_in;
  $final_stock = max(0, $final_stock);

  $reportData[] = [
    'sku' => $p['sku'],
    'name' => $p['name'],
    'initial' => $initial_stock,
    'import' => $imp_in,
    'export' => $exp_in,
    'final' => $final_stock
  ];

  $totalInitial += $initial_stock;
  $totalImport += $imp_in;
  $totalExport += $exp_in;
  $totalFinal += $final_stock;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Báo Cáo Tồn Kho - Literary Haven Admin</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/admin_style.css" />

  <style>
    .report-card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      margin-bottom: 2rem;
    }

    .report-header {
      background-color: #4f9da6;
      color: white;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
      padding: 1rem 1.5rem;
      font-size: 1.25rem;
      font-weight: 600;
    }

    .filter-section {
      background-color: #f8f9fa;
      padding: 1.5rem;
      border-radius: 8px;
      margin-bottom: 2rem;
      border: 1px solid #e9ecef;
    }

    .table th,
    .table td {
      vertical-align: middle;
      font-size: 0.95rem;
    }

    .table th {
      font-weight: 600;
      color: #343a40;
      background-color: #f8f9fa;
    }

    .total-row {
      font-weight: 800;
      background-color: #f1f3f5 !important;
      font-size: 1.15rem;
      border-top: 2px solid #4f9da6;
    }

    .total-row td {
      padding: 1.25rem 0.5rem !important;
      color: #2c3e50;
    }

    .total-label {
      letter-spacing: 1px;
      color: #4f9da6 !important;
      text-transform: uppercase;
    }

    .warning-card {
      border-left: 4px solid #ffc107;
      background-color: #fff3cd;
    }

    .danger-card {
      border-left: 4px solid #dc3545;
      background-color: #f8d7da;
    }

    .alert-item {
      padding: 0.75rem;
      margin-bottom: 0.5rem;
      border-radius: 6px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: white;
    }

    .alert-warning {
      border: 1px solid #ffc107;
    }

    .alert-danger {
      border: 1px solid #dc3545;
    }

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
      }

      .table {
        min-width: 600px;
      }

      .alert-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
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
    <div class="container-fluid py-4">
      <h1 class="mb-4">Báo Cáo Nhập - Xuất - Tồn</h1>

      <div class="filter-section shadow-sm">
        <form method="GET" action="reports.php">
          <div class="row align-items-end g-3">
            <div class="col-md-3">
              <label class="form-label fw-bold">Từ ngày:</label>
              <input type="date" name="start_date" class="form-control" value="<?= h($start_date) ?>" required />
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Đến ngày:</label>
              <input type="date" name="end_date" class="form-control" value="<?= h($end_date) ?>" required />
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold text-warning">Ngưỡng báo sắp hết hàng:</label>
              <input type="number" name="threshold" class="form-control" value="<?= h($threshold) ?>" min="1" required />
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary w-100 fw-bold">
                <i class="bi bi-search"></i> Xem Báo Cáo
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
          <div class="card danger-card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-danger fw-bold">
                <i class="bi bi-exclamation-triangle-fill"></i> SẢN PHẨM HẾT HÀNG
              </h5>
              <div class="mt-3" style="max-height: 250px; overflow-y: auto;">
                <?php if (empty($outOfStock)): ?>
                  <p class="text-success mb-0 fw-bold">không có sản phẩm hết hàng.</p>
                <?php else: ?>
                  <p class="mb-2"><strong>Có <?= count($outOfStock) ?> sản phẩm đã hết:</strong></p>
                  <?php foreach ($outOfStock as $item): ?>
                    <div class="alert-item alert-danger shadow-sm">
                      <div>
                        <strong><?= h($item['name']) ?></strong><br>
                        <small class="text-muted">Mã SKU: <?= h($item['sku'] ?? 'N/A') ?></small>
                      </div>
                      <span class="badge bg-danger">Hết hàng (0)</span>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card warning-card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-warning fw-bold text-dark">
                <i class="bi bi-exclamation-circle-fill"></i> CẢNH BÁO SẮP HẾT
              </h5>
              <div class="mt-3" style="max-height: 250px; overflow-y: auto;">
                <?php if (empty($lowStock)): ?>
                  <p class="text-success mb-0 fw-bold">Không có sản phẩm nào chạm ngưỡng dưới <?= h($threshold) ?> quyển.</p>
                <?php else: ?>
                  <p class="mb-2"><strong>Có <?= count($lowStock) ?> sản phẩm dưới ngưỡng <?= h($threshold) ?> quyển:</strong></p>
                  <?php foreach ($lowStock as $item): ?>
                    <div class="alert-item alert-warning shadow-sm">
                      <div>
                        <strong><?= h($item['name']) ?></strong><br>
                        <small class="text-muted">Mã SKU: <?= h($item['sku'] ?? 'N/A') ?></small>
                      </div>
                      <span class="badge bg-warning text-dark fs-6 border border-warning">Còn: <?= $item['qty'] ?></span>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card report-card">
        <div class="report-header d-flex justify-content-between align-items-center">
          <span>📊 Chi tiết Nhập - Xuất - Tồn</span>
          <span class="badge bg-light text-dark fs-6">
            Kỳ báo cáo: <?= date('d/m/Y', strtotime($start_date)) ?> đến <?= date('d/m/Y', strtotime($end_date)) ?>
          </span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
              <thead>
                <tr>
                  <th class="ps-4">Mã SP</th>
                  <th>Tên Sách</th>
                  <th class="text-center">Tồn Đầu Kỳ</th>
                  <th class="text-center text-success">Nhập Trong Kỳ</th>
                  <th class="text-center text-danger">Xuất Trong Kỳ</th>
                  <th class="text-center text-primary">Tồn Cuối Kỳ</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($reportData)): ?>
                  <tr>
                    <td colspan="6" class="text-center py-4">Không có dữ liệu sản phẩm.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($reportData as $row): ?>
                    <tr>
                      <td class="ps-4 fw-bold text-muted"><?= h($row['sku'] ?? 'N/A') ?></td>
                      <td class="fw-bold"><?= h($row['name']) ?></td>
                      <td class="text-center fs-5"><?= $row['initial'] ?></td>
                      <td class="text-center text-success fw-bold fs-5">+<?= $row['import'] ?></td>
                      <td class="text-center text-danger fw-bold fs-5">-<?= $row['export'] ?></td>
                      <td class="text-center text-primary fw-bold fs-5"><?= $row['final'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
              <tfoot>
                <tr class="total-row shadow-sm">
                  <td colspan="2" class="text-end pe-4 total-label">TỔNG CỘNG:</td>
                  <td class="text-center"><?= number_format($totalInitial) ?></td>
                  <td class="text-center text-success">+<?= number_format($totalImport) ?></td>
                  <td class="text-center text-danger">-<?= number_format($totalExport) ?></td>
                  <td class="text-center text-primary"><?= number_format($totalFinal) ?></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>