<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// Bảo vệ trang Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: index.php");
  exit;
}

$message = $_SESSION['flash_msg'] ?? '';
$error = $_SESSION['flash_err'] ?? '';
unset($_SESSION['flash_msg'], $_SESSION['flash_err']);

// --- XỬ LÝ LƯU SẢN PHẨM (THÊM & SỬA) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_product') {
  $id           = !empty($_POST['id']) ? (int)$_POST['id'] : null;
  $sku          = trim($_POST['sku']);
  $name         = trim($_POST['name']);
  $author       = trim($_POST['author']);
  $supplier     = trim($_POST['supplier'] ?? ''); // Thêm biến Nhà cung cấp
  $category_id  = (int)$_POST['category_id'];
  $subcategory  = trim($_POST['subcategory']);
  $unit         = trim($_POST['unit']);
  $costPrice    = (int)$_POST['costPrice'];
  $profitMargin = (int)$_POST['profitMargin'];
  $price        = (int)$_POST['price'];
  $qty          = (int)$_POST['qty'];
  $status       = $_POST['status'];
  $description  = trim($_POST['description']);
  $image        = trim($_POST['image']);

  if ($id) {
    // Cập nhật - Thêm biến supplier (Tổng cộng 15 biến: ssssiiiissssisi)
    $sql = "UPDATE products SET sku=?, name=?, author=?, supplier=?, price=?, costPrice=?, profitMargin=?, category_id=?, subcategory=?, unit=?, description=?, image=?, qty=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiiiissssisi", $sku, $name, $author, $supplier, $price, $costPrice, $profitMargin, $category_id, $subcategory, $unit, $description, $image, $qty, $status, $id);
  } else {
    // Thêm mới - Thêm biến supplier (Tổng cộng 14 biến: ssssiiiissssis)
    $sql = "INSERT INTO products (sku, name, author, supplier, price, costPrice, profitMargin, category_id, subcategory, unit, description, image, qty, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiiiissssis", $sku, $name, $author, $supplier, $price, $costPrice, $profitMargin, $category_id, $subcategory, $unit, $description, $image, $qty, $status);
  }

  if ($stmt->execute()) {
    $_SESSION['flash_msg'] = "Lưu sản phẩm thành công!";
  } else {
    $_SESSION['flash_err'] = "Lỗi Database: " . $conn->error;
  }
  header("Location: products.php");
  exit;
}

// --- XỬ LÝ XÓA HOẶC ẨN SẢN PHẨM ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_product') {
  $id = (int)$_POST['id'];

  $checkStmt = $conn->prepare("SELECT COUNT(*) as count FROM goodsReceipts_items WHERE product_id = ?");
  $checkStmt->bind_param("i", $id);
  $checkStmt->execute();
  $result = $checkStmt->get_result()->fetch_assoc();

  if ($result['count'] > 0) {
    $updateStmt = $conn->prepare("UPDATE products SET status = 'inactive' WHERE id = ?");
    $updateStmt->bind_param("i", $id);

    if ($updateStmt->execute()) {
      $_SESSION['flash_msg'] = "Sản phẩm này đã có lịch sử nhập kho. Hệ thống tự động chuyển trạng thái thành <b>'Dừng bán'</b> để bảo toàn dữ liệu kế toán!";
    } else {
      $_SESSION['flash_err'] = "Lỗi khi ẩn sản phẩm: " . $conn->error;
    }
  } else {
    $deleteStmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $deleteStmt->bind_param("i", $id);

    if ($deleteStmt->execute()) {
      $_SESSION['flash_msg'] = "Đã xóa vĩnh viễn sản phẩm khỏi hệ thống!";
    } else {
      $_SESSION['flash_err'] = "Lỗi khi xóa sản phẩm: " . $conn->error;
    }
  }
  header("Location: products.php");
  exit;
}

// --- LẤY DANH SÁCH ---
$products = $conn->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetch_all(MYSQLI_ASSOC);
$categories = $conn->query("SELECT id, name FROM categories WHERE status = 'active'")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Quản lý Sản phẩm - Literary Haven</title>
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
      }

      .table {
        min-width: 800px;
      }

      /* Mở rộng thêm xíu cho đủ chỗ 2 cột mới trên mobile */
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
    <div class="container-fluid py-4 page-content">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h1 class="h3 mb-0">Quản lý Sản phẩm</h1>
          <button class="btn btn-primary" onclick="openProductModal()">+ Thêm Sản phẩm</button>
        </div>
        <div class="card-body">
          <?php if ($message): ?><div class="alert alert-success"><?= $message ?></div><?php endif; ?>
          <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>Mã SKU</th>
                  <th>Tên Sản phẩm</th>
                  <th>Tác giả</th>
                  <th>Nhà cung cấp</th>
                  <th>Loại</th>
                  <th class="text-end">Giá bán</th>
                  <th class="text-center">Tồn kho</th>
                  <th>Trạng thái</th>
                  <th class="text-center">Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($products)): ?>
                  <tr>
                    <td colspan="9" class="text-center text-muted">Chưa có sản phẩm nào.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($products as $p): ?>
                    <tr>
                      <td><?= htmlspecialchars($p['sku']) ?></td>
                      <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                      <td><?= htmlspecialchars($p['author'] ?? '') ?></td>
                      <td><?= htmlspecialchars($p['supplier'] ?? '') ?></td>
                      <td><?= htmlspecialchars($p['category_name']) ?></td>
                      <td class="text-end fw-bold text-danger"><?= number_format($p['price']) ?>đ</td>
                      <td class="text-center"><?= $p['qty'] ?></td>
                      <td>
                        <?php if ($p['status'] === 'active'): ?>
                          <span class="status delivered">Đang bán</span>
                        <?php else: ?>
                          <span class="status pending">Dừng bán</span>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-outline-primary mb-1" onclick='editProduct(<?= json_encode($p) ?>)'>Sửa</button>
                        <button class="btn btn-sm btn-outline-danger mb-1" onclick='deleteProduct(<?= $p['id'] ?>, <?= json_encode($p['name']) ?>)'>Xóa</button>
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

  <div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form action="products.php" method="POST" class="modal-content">
        <input type="hidden" name="action" value="save_product">
        <input type="hidden" name="id" id="form-id">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Thêm Sản phẩm</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3 mb-3">
              <label class="form-label">Mã SKU</label>
              <input type="text" name="sku" id="form-sku" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Tên sách</label>
              <input type="text" name="name" id="form-name" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Tác giả</label>
              <input type="text" name="author" id="form-author" class="form-control">
            </div>
            <div class="col-md-3 mb-3"> <label class="form-label">Nhà cung cấp</label>
              <input type="text" name="supplier" id="form-supplier" class="form-control" placeholder="VD: NXB Trẻ...">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Danh mục chính</label>
              <select name="category_id" id="form-category" class="form-select">
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Phân loại chi tiết</label>
              <input type="text" name="subcategory" id="form-sub" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Đơn vị tính</label>
              <input type="text" name="unit" id="form-unit" class="form-control" value="Quyển">
            </div>
          </div>
          <div class="row bg-light p-2 rounded mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">Giá vốn bình quân (đ)</label>
              <input type="number" name="costPrice" id="form-cost" class="form-control" oninput="calcPrice()" min="0">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Lợi nhuận (%)</label>
              <input type="number" name="profitMargin" id="form-profit" class="form-control" oninput="calcPrice()">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Giá bán ra (đ)</label>
              <input type="number" name="price" id="form-price" class="form-control text-danger fw-bold" oninput="calcProfit()" min="0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Ảnh (Đường dẫn)</label>
              <input type="text" name="image" id="form-image" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Số lượng kho</label>
              <input type="number" name="qty" id="form-qty" class="form-control" min="0">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Trạng thái</label>
              <select name="status" id="form-status" class="form-select">
                <option value="active">Đang bán</option>
                <option value="inactive">Dừng bán</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Mô tả sản phẩm</label>
            <textarea name="description" id="form-desc" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
        </div>
      </form>
    </div>
  </div>

  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Lên đầu trang" />
    </i>
  </a>

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const modal = new bootstrap.Modal(document.getElementById('productModal'));

    function calcPrice() {
      let cost = parseInt(document.getElementById('form-cost').value) || 0;
      let margin = parseInt(document.getElementById('form-profit').value) || 0;
      document.getElementById('form-price').value = Math.round(cost * (1 + margin / 100));
    }

    function calcProfit() {
      let cost = parseInt(document.getElementById('form-cost').value) || 0;
      let price = parseInt(document.getElementById('form-price').value) || 0;
      if (cost > 0) {
        document.getElementById('form-profit').value = Math.round(((price - cost) / cost) * 100);
      }
    }

    function openProductModal() {
      document.getElementById('modalTitle').innerText = "Thêm Sản phẩm Mới";
      document.querySelector('#productModal form').reset();
      document.getElementById('form-id').value = "";
      document.getElementById('form-unit').value = "Quyển";
      modal.show();
    }

    function editProduct(p) {
      document.getElementById('modalTitle').innerText = "Sửa Sản phẩm: " + p.name;
      document.getElementById('form-id').value = p.id;
      document.getElementById('form-sku').value = p.sku;
      document.getElementById('form-name').value = p.name;
      document.getElementById('form-author').value = p.author;
      document.getElementById('form-supplier').value = p.supplier || ''; // NẠP DATA NHÀ CUNG CẤP
      document.getElementById('form-category').value = p.category_id;
      document.getElementById('form-sub').value = p.subcategory;
      document.getElementById('form-unit').value = p.unit;
      document.getElementById('form-cost').value = p.costPrice;
      document.getElementById('form-profit').value = p.profitMargin;
      document.getElementById('form-price').value = p.price;
      document.getElementById('form-qty').value = p.qty;
      document.getElementById('form-status').value = p.status;
      document.getElementById('form-image').value = p.image;
      document.getElementById('form-desc').value = p.description;
      modal.show();
    }

    function deleteProduct(id, name) {
      if (confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${name}"?\n\n(Hệ thống sẽ kiểm tra: Nếu chưa từng nhập hàng sẽ xóa vĩnh viễn, nếu đã nhập hàng sẽ tự động chuyển sang trạng thái "Dừng bán")`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'products.php';

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'delete_product';
        form.appendChild(actionInput);

        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        idInput.value = id;
        form.appendChild(idInput);

        document.body.appendChild(form);
        form.submit();
      }
    }
  </script>
</body>

</html>