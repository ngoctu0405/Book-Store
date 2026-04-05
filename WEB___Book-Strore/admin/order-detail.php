<?php
session_start();
require_once __DIR__ . '/../api/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: index.php");
  exit;
}

$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = $_SESSION['flash_msg'] ?? '';
$error = $_SESSION['flash_err'] ?? '';
unset($_SESSION['flash_msg'], $_SESSION['flash_err']);

// Lấy thông tin đơn hàng
$orderStmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$orderStmt->bind_param("i", $orderId);
$orderStmt->execute();
$order = $orderStmt->get_result()->fetch_assoc();

if (!$order) {
  echo "<script>alert('Không tìm thấy đơn hàng!'); window.location.href='orders.php';</script>";
  exit;
}

$currentStatus = trim($order['status']);
$validTransitions = [
  'chưa xử lý' => ['Đã xác nhận', 'Đã hủy'],
  'Chờ xử lý' => ['Đã xác nhận', 'Đã hủy'],
  'Chờ xác nhận' => ['Đã xác nhận', 'Đã hủy'],
  'Đã xác nhận' => ['Đã giao thành công', 'Đã hủy'],
  'Đã giao thành công' => [],
  'Đã hủy' => []
];

$allowedNextStatuses = $validTransitions[$currentStatus] ?? [];

// --- XỬ LÝ CẬP NHẬT TRẠNG THÁI (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_status'])) {
  $newStatus = $_POST['new_status'];

  if (in_array($newStatus, $allowedNextStatuses)) {
    $conn->begin_transaction();
    try {
      // LẤY DANH SÁCH SẢN PHẨM CỦA ĐƠN NÀY ĐỂ XỬ LÝ KHO
      $itemsRes = $conn->query("SELECT product_id, qty FROM order_items WHERE order_id = $orderId");
      $orderItems = $itemsRes->fetch_all(MYSQLI_ASSOC);

      // 1. NẾU CHUYỂN SANG "ĐÃ XÁC NHẬN" -> TRỪ KHO
      if ($newStatus === 'Đã xác nhận') {
        foreach ($orderItems as $item) {
          $pId = $item['product_id'];
          $qtyOrdered = $item['qty'];

          // Kiểm tra tồn kho trước khi trừ
          $checkStock = $conn->query("SELECT qty, name FROM products WHERE id = $pId")->fetch_assoc();
          if ($checkStock['qty'] < $qtyOrdered) {
            throw new Exception("Sản phẩm '{$checkStock['name']}' không đủ hàng (Chỉ còn {$checkStock['qty']}). Không thể xác nhận đơn!");
          }
          // Tiến hành trừ kho
          $conn->query("UPDATE products SET qty = qty - $qtyOrdered WHERE id = $pId");
        }
      }
      // 2. NẾU CHUYỂN SANG "ĐÃ HỦY" TỪ "ĐÃ XÁC NHẬN" -> CỘNG TRẢ LẠI KHO
      elseif ($newStatus === 'Đã hủy' && $currentStatus === 'Đã xác nhận') {
        foreach ($orderItems as $item) {
          $pId = $item['product_id'];
          $qtyOrdered = $item['qty'];
          $conn->query("UPDATE products SET qty = qty + $qtyOrdered WHERE id = $pId");
        }
      }

      // Cập nhật Database
      $updStmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
      $updStmt->bind_param("si", $newStatus, $orderId);
      $updStmt->execute();

      $conn->commit();
      $_SESSION['flash_msg'] = "Đã cập nhật trạng thái thành: $newStatus";
      header("Location: order-detail.php?id=$orderId");
      exit;
    } catch (Exception $e) {
      $conn->rollback();
      $_SESSION['flash_err'] = $e->getMessage();
      header("Location: order-detail.php?id=$orderId");
      exit;
    }
  } else {
    $_SESSION['flash_err'] = "Hành động không hợp lệ. Không được phép quay lui trạng thái!";
    header("Location: order-detail.php?id=$orderId");
    exit;
  }
}

// Lấy chi tiết sản phẩm hiển thị ra HTML
$itemsDisplay = $conn->query("
    SELECT oi.qty, oi.price, oi.product_name, p.sku, p.image 
    FROM order_items oi 
    LEFT JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = $orderId
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chi tiết Đơn hàng #<?= $orderId ?> - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>

<body>

  <?php include 'admin_sidebar.php'; ?>

  <main class="main-content">
    <div class="page-content p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Chi tiết Đơn hàng #<?= $orderId ?></h1>
        <a href="orders.php" class="btn btn-secondary">Quay lại danh sách</a>
      </div>

      <?php if ($message): ?><div class="alert alert-success"><?= $message ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

      <div class="row g-4">
        <div class="col-lg-8">
          <div class="card shadow-sm order-detail-card">
            <div class="card-header">
              <h3 class="h5 mb-0">Sản phẩm đã đặt</h3>
            </div>
            <div class="card-body">
              <table class="table align-middle">
                <tbody>
                  <?php foreach ($itemsDisplay as $item): ?>
                    <tr>
                      <td>
                        <img src="<?= htmlspecialchars($item['image'] ?: '../images/book_placeholder.png') ?>" alt="" style="width: 60px; height: 80px; object-fit: cover; border-radius: 4px;">
                      </td>
                      <td>
                        <strong><?= htmlspecialchars($item['product_name']) ?></strong><br>
                        <span class="text-muted">SKU: <?= htmlspecialchars($item['sku'] ?? 'N/A') ?></span>
                      </td>
                      <td>x <?= $item['qty'] ?></td>
                      <td class="text-end text-danger fw-bold"><?= number_format($item['price'] * $item['qty']) ?>đ</td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <hr />
              <div class="row justify-content-end">
                <div class="col-md-6">
                  <div class="d-flex justify-content-between h4 mt-2">
                    <strong>Tổng thanh toán</strong>
                    <strong class="text-danger"><?= number_format($order['totalAmount']) ?>đ</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm mb-4">
            <div class="card-header">
              <h3 class="h5 mb-0">Thông tin nhận hàng</h3>
            </div>
            <div class="card-body">
              <strong><?= htmlspecialchars($order['buyer_name']) ?></strong>
              <p class="mb-1">SĐT: <?= htmlspecialchars($order['buyer_phone']) ?></p>
              <p class="mb-0">TT: <?= htmlspecialchars($order['payment_method']) ?></p>
              <hr />
              <strong>Địa chỉ giao hàng:</strong>
              <p class="mb-0"><?= htmlspecialchars($order['buyer_address']) ?></p>
              <?php if ($order['buyer_note']): ?>
                <hr>
                <strong>Ghi chú:</strong>
                <p class="mb-0 text-danger"><?= htmlspecialchars($order['buyer_note']) ?></p>
              <?php endif; ?>
            </div>
          </div>

          <div class="card shadow-sm">
            <div class="card-header">
              <h3 class="h5 mb-0">Cập nhật trạng thái</h3>
            </div>
            <div class="card-body">
              <p>Trạng thái hiện tại:
                <span class="badge bg-secondary fs-6"><?= $currentStatus ?></span>
              </p>

              <?php if (!empty($allowedNextStatuses)): ?>
                <form method="POST" action="order-detail.php?id=<?= $orderId ?>" onsubmit="return confirm('Bạn có chắc muốn cập nhật trạng thái?\\nHành động này không thể quay lui!')">
                  <div class="mb-3">
                    <label class="form-label">Chọn trạng thái tiếp theo:</label>
                    <select class="form-select" name="new_status" required>
                      <option value="">-- Chọn --</option>
                      <?php foreach ($allowedNextStatuses as $nextStatus): ?>
                        <option value="<?= $nextStatus ?>"><?= $nextStatus ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Xác nhận cập nhật</button>
                  </div>
                </form>
              <?php else: ?>
                <div class="alert alert-info text-center mb-0">
                  Đơn hàng đã hoàn tất hoặc bị hủy. Không thể thay đổi trạng thái.
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>