<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// Bảo vệ trang Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: index.php");
  exit;
}

// --- XỬ LÝ AJAX LƯU LỢI NHUẬN (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);

  if (isset($data['action']) && $data['action'] === 'update_margin') {
    $pId = (int)$data['product_id'];
    $margin = (int)$data['profit_margin'];

    // Lấy giá vốn hiện tại từ DB
    $res = $conn->query("SELECT costPrice FROM products WHERE id = $pId");
    if ($row = $res->fetch_assoc()) {
      $costPrice = (int)$row['costPrice'];

      // Tính toán Giá bán mới = Giá vốn * (100% + Lợi nhuận)
      $newSalePrice = round($costPrice * (1 + ($margin / 100)));

      // Cập nhật DB
      $stmt = $conn->prepare("UPDATE products SET profitMargin = ?, price = ? WHERE id = ?");
      $stmt->bind_param("iii", $margin, $newSalePrice, $pId);

      if ($stmt->execute()) {
        echo json_encode(['success' => true, 'new_price' => number_format($newSalePrice) . 'đ']);
        exit;
      }
    }
    echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật CSDL']);
    exit;
  }
}

// --- XỬ LÝ LỌC VÀ TÌM KIẾM (GET) ---
$search = $_GET['search'] ?? '';
$cat_id = $_GET['category_id'] ?? '';

$where = [];
$params = [];
$types = "";

if ($search !== '') {
  $where[] = "(p.name LIKE ? OR p.sku LIKE ?)";
  $searchParam = "%$search%";
  $params[] = $searchParam;
  $params[] = $searchParam;
  $types .= "ss";
}
if ($cat_id !== '') {
  $where[] = "p.category_id = ?";
  $params[] = (int)$cat_id;
  $types .= "i";
}

$whereSql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

// Lấy danh sách sản phẩm
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        $whereSql 
        ORDER BY p.name ASC";

$stmt = $conn->prepare($sql);
if ($types) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Lấy danh mục để đưa vào Select
$categories = $conn->query("SELECT id, name FROM categories WHERE status = 'active'")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Giá bán - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/admin_style.css">
  <style>
    /* CSS Responsive đồng bộ Sidebar */
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
        min-width: 600px;
      }

      .table thead th,
      .table tbody td {
        padding: 8px 6px;
        font-size: 12px;
      }

      .profit-input {
        width: 60px !important;
        text-align: center;
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

      .profit-input {
        width: 80px !important;
        text-align: center;
        margin: 0 auto;
      }
    }

    .price-changed {
      color: #28a745 !important;
      font-weight: bold;
      transition: color 0.3s;
    }
  </style>
</head>

<body>

  <?php include 'admin_sidebar.php'; ?>

  <main class="main-content">
    <div class="page-content p-4">
      <h1 class="mb-4">Quản lý Giá bán</h1>

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="h5 mb-0">Tra cứu và Tinh chỉnh Giá bán</h3>
        </div>
        <div class="card-body">
          <form method="GET" action="pricing.php" class="row g-3 mb-4">
            <div class="col-md-5">
              <input type="text" name="search" class="form-control" placeholder="Tìm theo tên hoặc mã SKU..." value="<?= htmlspecialchars($search) ?>" />
            </div>
            <div class="col-md-5">
              <select name="category_id" class="form-select">
                <option value="">Tất cả loại sản phẩm</option>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= $cat_id == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Tra cứu</button>
            </div>
          </form>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Tên sản phẩm</th>
                  <th>Loại SP</th>
                  <th class="text-end">Giá vốn</th>
                  <th class="text-center">% Lợi nhuận</th>
                  <th class="text-end">Giá bán dự kiến</th>
                  <th class="text-center">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($products)): ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted">Không tìm thấy sản phẩm nào.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($products as $p): ?>
                    <tr id="row-<?= $p['id'] ?>">
                      <td>
                        <strong><?= htmlspecialchars($p['name']) ?></strong><br>
                        <span class="text-muted small">SKU: <?= htmlspecialchars($p['sku']) ?></span>
                      </td>
                      <td><?= htmlspecialchars($p['category_name']) ?></td>
                      <td class="text-end text-danger" id="cost-<?= $p['id'] ?>" data-cost="<?= $p['costPrice'] ?>">
                        <?= number_format($p['costPrice']) ?>đ
                      </td>
                      <td class="text-center">
                        <input type="number" class="form-control profit-input"
                          id="profit-<?= $p['id'] ?>"
                          value="<?= $p['profitMargin'] ?>"
                          min="0" max="1000" step="1"
                          oninput="previewSalePrice(<?= $p['id'] ?>)">
                      </td>
                      <td class="text-end">
                        <span id="price-<?= $p['id'] ?>" class="fw-bold fs-6"><?= number_format($p['price']) ?>đ</span>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-success mb-1 w-100" onclick="saveProductProfit(<?= $p['id'] ?>)">Lưu</button>
                        <button class="btn btn-sm btn-secondary w-100" onclick="resetProductProfit(<?= $p['id'] ?>)">Đưa về 0%</button>
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
  <script>
    // 1. Xem trước giá bán ngay khi gõ số (Client-side preview)
    function previewSalePrice(productId) {
      const costPrice = parseInt(document.getElementById(`cost-${productId}`).getAttribute('data-cost'));
      const profitInput = document.getElementById(`profit-${productId}`);
      const priceSpan = document.getElementById(`price-${productId}`);

      let profitMargin = parseInt(profitInput.value);
      if (isNaN(profitMargin) || profitMargin < 0) profitMargin = 0;

      const newSalePrice = Math.round(costPrice * (1 + (profitMargin / 100)));
      priceSpan.textContent = newSalePrice.toLocaleString('vi-VN') + 'đ';
      priceSpan.classList.add('price-changed');
    }

    // 2. Lưu phần trăm lợi nhuận qua AJAX
    function saveProductProfit(productId) {
      const profitInput = document.getElementById(`profit-${productId}`);
      let profitMargin = parseInt(profitInput.value);

      if (isNaN(profitMargin) || profitMargin < 0) {
        alert("Vui lòng nhập % lợi nhuận hợp lệ (Lớn hơn hoặc bằng 0)!");
        return;
      }

      fetch('pricing.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            action: 'update_margin',
            product_id: productId,
            profit_margin: profitMargin
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            const priceSpan = document.getElementById(`price-${productId}`);
            priceSpan.textContent = data.new_price;
            priceSpan.classList.remove('price-changed');
            priceSpan.style.color = '#212529'; // Đổi lại màu chữ bình thường báo hiệu đã lưu
            alert('Đã cập nhật giá bán thành công!');
          } else {
            alert('Lỗi: ' + data.message);
          }
        })
        .catch(err => alert('Lỗi kết nối tới máy chủ!'));
    }

    // 3. Nút Quay lại 0% (Reset)
    function resetProductProfit(productId) {
      if (!confirm("Bạn có chắc muốn đưa mức lợi nhuận của sản phẩm này về 0% ? (Giá bán sẽ bằng Giá vốn)")) return;

      document.getElementById(`profit-${productId}`).value = 0;
      previewSalePrice(productId); // Cập nhật số hiển thị
      saveProductProfit(productId); // Gọi hàm lưu lên server luôn
    }
  </script>

  <a href="#" class="back-to-top" title="Lên đầu trang">
    <i class="bi bi-chevron-up">
      <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
    </i>
  </a>
</body>

</html>