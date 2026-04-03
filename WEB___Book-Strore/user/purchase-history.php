<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// Kiểm tra đăng nhập
if (empty($_SESSION['user_id'])) {
  header("Location: index.php?require_login=true");
  exit;
}

$userId = (int)$_SESSION['user_id'];

function fmtPrice($value)
{
  return number_format((int)$value, 0, ',', '.') . '₫';
}

// Lấy danh sách đơn hàng của người dùng
$stmt = $conn->prepare("SELECT * FROM orders WHERE userId = ? ORDER BY orderDate DESC");
$stmt->bind_param('i', $userId);
$stmt->execute();
$ordersResult = $stmt->get_result();

$orders = [];
$orderIds = [];
while ($row = $ordersResult->fetch_assoc()) {
  $orders[$row['id']] = $row;
  $orders[$row['id']]['items'] = [];
  $orderIds[] = $row['id'];
}

// Lấy chi tiết đơn hàng (Kết hợp bảng order_items và products để lấy ảnh/tác giả)
if (!empty($orderIds)) {
  $placeholders = implode(',', array_fill(0, count($orderIds), '?'));
  $types = str_repeat('i', count($orderIds));

  $sqlItems = "SELECT oi.*, p.image as img, p.author 
                 FROM order_items oi 
                 LEFT JOIN products p ON oi.product_id = p.id 
                 WHERE oi.order_id IN ($placeholders)";

  $stmtItems = $conn->prepare($sqlItems);
  $stmtItems->bind_param($types, ...$orderIds);
  $stmtItems->execute();
  $itemsResult = $stmtItems->get_result();

  while ($item = $itemsResult->fetch_assoc()) {
    // Fallback nếu sản phẩm đã bị xóa khỏi kho
    $item['img'] = !empty($item['img']) ? $item['img'] : '../images/default_book.png';
    $item['author'] = !empty($item['author']) ? $item['author'] : 'Đang cập nhật';

    $orders[$item['order_id']]['items'][] = $item;
  }
}

// ==================== CHUẨN BỊ GIAO DIỆN ====================
$pageTitle = "Lịch sử mua hàng - Literary Haven";

// Gói CSS riêng của trang Lịch sử
ob_start();
?>
<style>
  body {
    background: linear-gradient(135deg, #f5f2e8 0%, #e8d5b7 50%, #7fb3d3 100%);
    color: #2c3e50;
    min-height: 100vh;
  }

  .container {
    position: relative;
    max-width: 1400px;
    margin: 5rem auto;
    margin-top: 8rem;
    /* Đẩy xuống để không bị menu đè lên */
  }

  .page-heading {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-top: 20px;
    margin-bottom: 2rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
  }

  .history-container {
    background: white;
    border-radius: 24px;
    padding: 3rem;
    box-shadow: 0 10px 40px rgba(79, 157, 166, 0.15);
    border: 1px solid rgba(130, 192, 154, 0.2);
    min-height: 400px;
  }

  .filter-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f0f0f0;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .section-title {
    font-size: 1.6rem;
    color: #2c3e50;
    font-weight: 700;
  }

  .order-stats {
    display: flex;
    gap: 1rem;
    font-size: 1.2rem;
    color: #2c3e50;
    font-weight: 600;
  }

  .order-stats strong {
    color: #4f9da6;
    font-size: 1.3rem;
  }

  .order-card {
    background: linear-gradient(145deg, #ffffff 0%, #fafafa 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .order-card:hover {
    transform: translateX(8px);
    box-shadow: 0 8px 24px rgba(79, 157, 166, 0.15);
    border-color: rgba(79, 157, 166, 0.3);
  }

  .order-header {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .order-id-wrapper {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .order-id {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .order-id span {
    color: #4f9da6;
  }

  .order-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #7f8c8d;
    font-size: 0.95rem;
  }

  .order-items-preview {
    background: rgba(79, 157, 166, 0.05);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .preview-item {
    display: grid;
    grid-template-columns: 80px 1fr auto;
    align-items: center;
    gap: 1.5rem;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  }

  .preview-item:last-child {
    border-bottom: none;
  }

  .preview-image {
    width: 80px;
    height: 100px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .preview-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .preview-info {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
  }

  .preview-name {
    font-weight: 700;
    color: #2c3e50;
    font-size: 1.1rem;
  }

  .preview-author {
    font-size: 0.9rem;
    color: #7f8c8d;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .preview-price-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.4rem;
  }

  .preview-quantity {
    font-size: 0.95rem;
    color: #666;
    font-weight: 600;
  }

  .preview-total {
    font-weight: 700;
    color: #e74c3c;
    font-size: 1.2rem;
  }

  .more-items-notice {
    text-align: center;
    color: #7f8c8d;
    font-style: italic;
    padding-top: 1rem;
    font-size: 0.95rem;
  }

  .order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 2px solid #f0f0f0;
    flex-wrap: wrap;
    gap: 1.5rem;
  }

  .order-total {
    font-size: 1.6rem;
    font-weight: 700;
    color: #4f9da6;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .order-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .btn-action {
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .btn-detail {
    background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
    color: white;
  }

  .btn-detail:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(79, 157, 166, 0.4);
    color: white;
  }

  .btn-reorder {
    background: linear-gradient(135deg, #ff7f50 0%, #ff4500 100%);
    color: white;
  }

  .btn-reorder:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(255, 99, 71, 0.4);
    color: white;
  }

  .empty-state {
    text-align: center;
    padding: 5rem 2rem;
  }

  .empty-state-icon {
    font-size: 6rem;
    margin-bottom: 1.5rem;
    opacity: 0.4;
  }

  .empty-state h3 {
    color: #2c3e50;
    font-size: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
  }

  .empty-state p {
    color: #7f8c8d;
    font-size: 1.1rem;
    margin-bottom: 2.5rem;
  }

  .btn-continue {
    display: inline-block;
    padding: 1.2rem 2.5rem;
    background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
    color: white;
    text-decoration: none;
    border-radius: 16px;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(79, 157, 166, 0.25);
  }

  .btn-continue:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(79, 157, 166, 0.35);
    color: white;
  }

  /* Modal styles */
  .order-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 2rem;
  }

  .order-modal.active {
    display: flex;
  }

  .modal-content {
    background: white;
    border-radius: 24px;
    padding: 3rem;
    max-width: 900px;
    width: 100%;
    max-height: 85vh;
    overflow-y: auto;
    position: relative;
    animation: slideIn 0.3s ease;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  }

  @keyframes slideIn {
    from {
      transform: translateY(-50px);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .modal-close {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    font-size: 2rem;
    cursor: pointer;
    color: #666;
    transition: all 0.3s;
    background: none;
    border: none;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
  }

  .modal-close:hover {
    color: #333;
    background: #f0f0f0;
    transform: rotate(90deg);
  }

  .modal-header {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f0f0f0;
  }

  .modal-header h2 {
    color: #4f9da6;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    font-weight: 700;
  }

  .modal-order-info {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f0f8f7 0%, #e6f4f1 100%);
    border-radius: 12px;
  }

  .info-item {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
  }

  .info-label {
    font-size: 0.85rem;
    color: #7f8c8d;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
  }

  .info-value {
    font-size: 1.15rem;
    color: #2c3e50;
    font-weight: 600;
  }

  .modal-items-section {
    margin-top: 2rem;
  }

  .modal-items-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .modal-items-header {
    display: grid;
    grid-template-columns: 100px 2fr 1fr 1.5fr;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    font-weight: 700;
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-bottom: 1rem;
  }

  .modal-items-header span:nth-child(3),
  .modal-items-header span:nth-child(4) {
    text-align: right;
  }

  .modal-item {
    display: grid;
    grid-template-columns: 100px 2fr 1fr 1.5fr;
    gap: 1rem;
    padding: 1.5rem 1rem;
    border-bottom: 1px solid #e9ecef;
    align-items: center;
  }

  .modal-item:last-child {
    border-bottom: none;
  }

  .modal-item-image {
    width: 100px;
    height: 130px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .modal-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .modal-item-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .modal-item-name {
    font-weight: 700;
    color: #2c3e50;
    font-size: 1.1rem;
    line-height: 1.4;
  }

  .modal-item-author {
    color: #7f8c8d;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .modal-item-price {
    color: #666;
    font-size: 0.95rem;
    margin-top: 0.3rem;
  }

  .modal-item-quantity {
    text-align: right;
    font-weight: 600;
    color: #4f9da6;
    font-size: 1.1rem;
  }

  .modal-item-total {
    text-align: right;
    font-weight: 700;
    color: #e74c3c;
    font-size: 1.3rem;
  }

  .modal-summary {
    margin-top: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f0f8f7 0%, #e6f4f1 100%);
    border-radius: 12px;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 0;
    font-size: 1.1rem;
  }

  .summary-row.subtotal,
  .summary-row.shipping {
    color: #2c3e50;
    font-weight: 600;
  }

  .summary-row.shipping .text-success {
    color: #27ae60 !important;
    font-weight: 700;
  }

  .summary-row.total {
    font-size: 1.6rem;
    font-weight: 700;
    color: #4f9da6;
    border-top: 2px solid #ddd;
    margin-top: 1rem;
    padding-top: 1.5rem;
  }
</style>
<?php
$extraCss = ob_get_clean();

// Gọi Header chung (Đã bao gồm Navbar, Tự động tìm kiếm...)
include '../includes/header.php';
?>

<main class="container">
  <h2 class="page-heading"><span>📦</span> Lịch sử mua hàng</h2>

  <div class="history-container">
    <div class="filter-section">
      <div class="section-title">Thông tin chi tiết</div>
      <div class="order-stats">
        <span>Tổng đơn hàng: <strong><?= count($orders) ?></strong></span>
      </div>
    </div>

    <div id="orderList">
      <?php if (empty($orders)): ?>
        <div class="empty-state">
          <div class="empty-state-icon">🔭</div>
          <h3>Chưa có đơn hàng nào</h3>
          <p>Hãy bắt đầu mua sắm ngay!</p>
          <a href="category.php" class="btn-continue">Tiếp tục mua sắm</a>
        </div>
      <?php else: ?>
        <?php foreach ($orders as $order): ?>
          <?php
          // Xử lý 3 món xem trước
          $itemsPreview = array_slice($order['items'], 0, 3);
          $moreItems = count($order['items']) > 3 ? count($order['items']) - 3 : 0;
          ?>
          <div class="order-card">
            <div class="order-header">
              <div class="order-id-wrapper">
                <div class="order-id">Đơn hàng: <span>#<?= $order['id'] ?></span></div>
                <div class="order-date">
                  <i class="bi bi-calendar"></i>
                  <?= date('d/m/Y H:i', strtotime($order['orderDate'])) ?>
                </div>
              </div>
            </div>

            <div class="order-items-preview">
              <?php foreach ($itemsPreview as $item): ?>
                <div class="preview-item">
                  <div class="preview-image">
                    <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                  </div>
                  <div class="preview-info">
                    <div class="preview-name"><?= htmlspecialchars($item['product_name']) ?></div>
                    <div class="preview-author"><i class="bi bi-person"></i> <?= htmlspecialchars($item['author']) ?></div>
                  </div>
                  <div class="preview-price-info">
                    <div class="preview-quantity">x<?= $item['qty'] ?></div>
                    <div class="preview-total"><?= fmtPrice($item['price'] * $item['qty']) ?></div>
                  </div>
                </div>
              <?php endforeach; ?>

              <?php if ($moreItems > 0): ?>
                <div class="more-items-notice">
                  và <?= $moreItems ?> sản phẩm khác...
                </div>
              <?php endif; ?>
            </div>

            <div class="order-footer">
              <div class="order-total">
                <i class="bi bi-cash-coin"></i>
                Tổng cộng: <?= fmtPrice($order['totalAmount']) ?>
              </div>
              <div class="order-actions">
                <button class="btn-action btn-detail" onclick='showOrderDetail(<?= htmlspecialchars(json_encode($order), ENT_QUOTES, "UTF-8") ?>)'>
                  <i class="bi bi-eye"></i> Xem chi tiết
                </button>
                <input type="hidden" id="order-data-<?= $order['id'] ?>" value='<?= htmlspecialchars(json_encode($order), ENT_QUOTES, "UTF-8") ?>'>

                <button class="btn-action btn-reorder" onclick="reorder(<?= $order['id'] ?>)">
                  <i class="bi bi-arrow-repeat"></i> Mua lại
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</main>

<div id="orderModal" class="order-modal">
  <div class="modal-content">
    <button class="modal-close" onclick="closeOrderModal()">&times;</button>
    <div id="modalBody"></div>
  </div>
</div>

<?php
// Gói Javascript riêng của trang Lịch sử
ob_start();
?>
<script>
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
    minimumFractionDigits: 0,
  });

  function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN", {
      day: "2-digit",
      month: "2-digit",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    });
  }

  // Modal chi tiết đơn hàng (Dữ liệu đã có sẵn từ PHP đổ vào đây)
  function showOrderDetail(order) {
    const modal = document.getElementById("orderModal");
    const modalBody = document.getElementById("modalBody");

    const SHIPPING_THRESHOLD = 500000;
    const STANDARD_SHIPPING_FEE = 30000;

    let calculatedSubtotal = 0;
    order.items.forEach(item => {
      calculatedSubtotal += item.price * item.qty;
    });

    const shippingFee = (calculatedSubtotal >= SHIPPING_THRESHOLD || calculatedSubtotal == order.totalAmount) ? 0 : STANDARD_SHIPPING_FEE;

    const itemsHtml = order.items.map(item => `
          <div class="modal-item">
            <div class="modal-item-image">
              <img src="${item.img}" alt="${item.product_name}">
            </div>
            <div class="modal-item-info">
              <div class="modal-item-name">${item.product_name}</div>
              <div class="modal-item-author"><i class="bi bi-person"></i> ${item.author}</div>
              <div class="modal-item-price">Đơn giá: ${formatter.format(item.price)}</div>
            </div>
            <div class="modal-item-quantity">x${item.qty}</div>
            <div class="modal-item-total">${formatter.format(item.price * item.qty)}</div>
          </div>
        `).join("");

    modalBody.innerHTML = `
        <div class="modal-header">
          <h2>Chi tiết đơn hàng #${order.id}</h2>
        </div>

        <div class="modal-order-info">
          <div class="info-item">
            <div class="info-label">Mã đơn hàng</div>
            <div class="info-value">#${order.id}</div>
          </div>
          <div class="info-item">
            <div class="info-label">Ngày đặt</div>
            <div class="info-value">${formatDate(order.orderDate)}</div>
          </div>
          <div class="info-item">
            <div class="info-label">Phương thức TT</div>
            <div class="info-value">${order.payment_method || "Tiền mặt"}</div>
          </div>
          <div class="info-item">
            <div class="info-label">Tổng tiền</div>
            <div class="info-value" style="color: #4f9da6;">${formatter.format(order.totalAmount)}</div>
          </div>
        </div>

        ${order.buyer_name ? `
          <div class="shipping-address-info" style="background: linear-gradient(135deg, #fff8e1 0%, #ffe6cc 100%); padding: 1.5rem; border-radius: 12px; margin: 2rem 0; border-left: 4px solid #ff9800;">
            <h3 style="margin: 0 0 1rem 0; color: #2c3e50; font-size: 1.3rem; display: flex; align-items: center; gap: 0.5rem;">
              <i class="bi bi-geo-alt-fill" style="color: #ff9800;"></i> Thông tin giao hàng
            </h3>
            <div style="display: grid; gap: 0.8rem;">
              <div style="display: flex; align-items: center; gap: 0.8rem;">
                <i class="bi bi-person-fill" style="color: #ff9800; font-size: 1.1rem;"></i>
                <div>
                  <span style="font-weight: 600; color: #666; font-size: 0.9rem; display: block;">Người nhận:</span>
                  <strong style="font-size: 1.1rem; color: #2c3e50;">${order.buyer_name}</strong>
                </div>
              </div>
              <div style="display: flex; align-items: center; gap: 0.8rem;">
                <i class="bi bi-telephone-fill" style="color: #ff9800; font-size: 1.1rem;"></i>
                <div>
                  <span style="font-weight: 600; color: #666; font-size: 0.9rem; display: block;">Số điện thoại:</span>
                  <strong style="font-size: 1.1rem; color: #2c3e50;">${order.buyer_phone}</strong>
                </div>
              </div>
              <div style="display: flex; align-items: start; gap: 0.8rem;">
                <i class="bi bi-house-door-fill" style="color: #ff9800; font-size: 1.1rem; margin-top: 0.2rem;"></i>
                <div>
                  <span style="font-weight: 600; color: #666; font-size: 0.9rem; display: block;">Địa chỉ giao hàng:</span>
                  <strong style="font-size: 1.05rem; color: #2c3e50; line-height: 1.5;">${order.buyer_address}</strong>
                </div>
              </div>
              ${order.buyer_note ? `
              <div style="display: flex; align-items: start; gap: 0.8rem;">
                <i class="bi bi-chat-text-fill" style="color: #ff9800; font-size: 1.1rem; margin-top: 0.2rem;"></i>
                <div>
                  <span style="font-weight: 600; color: #666; font-size: 0.9rem; display: block;">Ghi chú:</span>
                  <span style="font-size: 1.05rem; color: #2c3e50;">${order.buyer_note}</span>
                </div>
              </div>` : ''}
            </div>
          </div>
        ` : ''}

        <div class="modal-items-section">
          <h3 class="modal-items-title"><i class="bi bi-box-seam"></i> Danh sách sản phẩm</h3>
          <div class="modal-items-header">
            <span>Hình ảnh</span>
            <span>Sản phẩm</span>
            <span>Số lượng</span>
            <span>Thành tiền</span>
          </div>
          ${itemsHtml}
        </div>

        <div class="modal-summary">
          <div class="summary-row subtotal">
            <span>Tạm tính:</span>
            <span>${formatter.format(calculatedSubtotal)}</span>
          </div>
          <div class="summary-row shipping">
            <span>Phí vận chuyển:</span>
            <span class="${shippingFee === 0 ? "text-success" : ""}">
              ${shippingFee === 0 ? "Miễn phí ✓" : formatter.format(shippingFee)}
            </span>
          </div>
          <div class="summary-row total">
            <span>Tổng cộng:</span>
            <span>${formatter.format(order.totalAmount)}</span>
          </div>
        </div>
      `;

    modal.classList.add("active");
  }

  function closeOrderModal() {
    document.getElementById("orderModal").classList.remove("active");
  }

  // Logic Mua Lại (Reorder) KẾT NỐI VỚI BACKEND PHP
  async function reorder(orderId) {
    const orderDataInput = document.getElementById('order-data-' + orderId);
    if (!orderDataInput) return;

    const order = JSON.parse(orderDataInput.value);

    if (confirm(`Bạn có muốn mua lại ${order.items.length} sản phẩm từ đơn hàng #${orderId}?`)) {
      try {
        // Lấy giỏ hàng PHP hiện tại
        const res = await fetch('../api/cart.php');
        const data = await res.json();
        let cart = data.cart || [];

        // Trộn sản phẩm vào giỏ
        order.items.forEach((item) => {
          const existingItem = cart.find((c) => c.id === item.product_id);
          if (existingItem) {
            existingItem.qty += item.qty;
          } else {
            cart.push({
              id: item.product_id,
              qty: item.qty
            });
          }
        });

        // Lưu giỏ hàng lên server
        await fetch('../api/cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            action: 'save',
            cart: cart
          })
        });

        alert("✅ Đã thêm tất cả sản phẩm vào giỏ hàng!");
        window.location.href = "cart.php";
      } catch (error) {
        alert("Lỗi kết nối máy chủ: " + error.message);
      }
    }
  }

  document.getElementById("orderModal").addEventListener("click", function(e) {
    if (e.target === this) {
      closeOrderModal();
    }
  });
</script>
<?php
$extraJs = ob_get_clean();

// Gọi Footer chung
include '../includes/footer.php';
?>