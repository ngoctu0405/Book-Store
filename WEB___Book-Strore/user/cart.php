<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// Nếu chưa đăng nhập thì đá về trang chủ bắt đăng nhập
if (empty($_SESSION['user_id'])) {
  header('Location: index.php?login=1');
  exit;
}

function h($value)
{
  return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function fmtPrice($value)
{
  return number_format((int) $value, 0, ',', '.') . '₫';
}

function getCartFromSession()
{
  if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    return [];
  }

  $validated = [];
  foreach ($_SESSION['cart'] as $item) {
    if (!is_array($item)) continue;
    $id = isset($item['id']) ? (int) $item['id'] : 0;
    $qty = isset($item['qty']) ? (int) $item['qty'] : 0;
    if ($id <= 0 || $qty <= 0) continue;
    $validated[] = ['id' => $id, 'qty' => $qty];
  }
  return $validated;
}

$cartItems = getCartFromSession();
$cartProducts = [];
$cartTotalQty = 0;
$cartSubtotal = 0;

if (!empty($cartItems)) {
  $productIds = array_unique(array_column($cartItems, 'id'));
  $placeholders = implode(',', array_fill(0, count($productIds), '?'));
  $types = str_repeat('i', count($productIds));

  $stmt = $conn->prepare("SELECT id, name, author, price, image, qty FROM products WHERE id IN ($placeholders)");
  if ($stmt) {
    $stmt->bind_param($types, ...$productIds);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
      $products[$row['id']] = $row;
    }

    foreach ($cartItems as $item) {
      $productId = $item['id'];
      if (!isset($products[$productId])) continue;
      $product = $products[$productId];
      $qty = $item['qty'];
      $lineTotal = $product['price'] * $qty;

      $cartProducts[] = array_merge($product, [
        'qty' => $qty,
        'lineTotal' => $lineTotal,
      ]);
      $cartTotalQty += $qty;
      $cartSubtotal += $lineTotal;
    }
  }
}

$userInfo = ['fullName' => '', 'email' => '', 'phone' => '', 'address' => ''];
$userId = (int) $_SESSION['user_id'];

// Lấy thông tin user
$stmt = $conn->prepare('SELECT fullName, email, phone, address FROM users WHERE id = ?');
if ($stmt) {
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res && $res->num_rows > 0) {
    $userInfo = array_merge($userInfo, $res->fetch_assoc());
  }
}

// Lấy 3 mẫu buyer_info
$buyerProfiles = [1 => null, 2 => null, 3 => null];
$stmt = $conn->prepare("SELECT profileIndex, fullName, email, phone, address, ward, district, city, note FROM buyer_info WHERE userId = ? ORDER BY profileIndex ASC");
$stmt->bind_param('i', $userId);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
  $buyerProfiles[$row['profileIndex']] = $row;
}

$totalAmount = $cartSubtotal;
$hasCartItems = !empty($cartProducts);

// ==================== CHUẨN BỊ GIAO DIỆN ====================
$pageTitle = "Giỏ Hàng - Literary Haven";

// Gói CSS riêng của giỏ hàng vào biến $extraCss
ob_start();
?>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 3rem 2rem;
    position: relative;
    top: 2rem;
  }

  .cart-heading {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #4f9da6 0%, #82c09a 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-top: 70px;
    margin-bottom: 2rem;
    text-align: center;
    text-shadow: none;
  }

  .cart-layout {
    display: grid;
    grid-template-columns: 1fr 500px;
    gap: 2rem;
    margin-top: 2rem;
  }

  .cart-right-panel {
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }

  .cart-items-section {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(79, 157, 166, 0.12);
    border: 1px solid rgba(130, 192, 154, 0.15);
  }

  .cart-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1.2rem;
    border-bottom: 2px solid #f0f0f0;
  }

  .cart-section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
  }

  .empty-cart {
    text-align: center;
    padding: 5rem 2rem;
  }

  .empty-cart-icon {
    font-size: 6rem;
    margin-bottom: 1.5rem;
    opacity: 0.4;
    display: block;
  }

  .empty-cart h3 {
    font-size: 2rem;
    color: #2c3e50;
    margin-bottom: 1rem;
    font-weight: 700;
  }

  .empty-cart p {
    color: #7f8c8d;
    margin-bottom: 2.5rem;
    font-size: 1.1rem;
  }

  .btn-continue {
    display: inline-block;
    padding: 1.2rem 2.5rem;
    background: linear-gradient(135deg, #4f9da6 0%, #82c09a 100%);
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

  .cart-item {
    display: grid !important;
    grid-template-columns: 110px 1fr auto !important;
    align-items: center !important;
    gap: 1.5rem !important;
    padding: 1.5rem !important;
    background: linear-gradient(145deg, #ffffff 0%, #fafafa 100%) !important;
    border-radius: 16px !important;
    margin-bottom: 1.5rem !important;
    transition: all 0.3s ease !important;
    border: 2px solid transparent !important;
  }

  .cart-item:hover {
    transform: translateX(8px);
    box-shadow: 0 8px 24px rgba(79, 157, 166, 0.15);
    border-color: rgba(130, 192, 154, 0.3);
  }

  .cart-item-image {
    width: 110px;
    height: 150px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
  }

  .cart-item-image:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  }

  .cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .cart-item-details {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 0.5rem;
  }

  .cart-item-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0 0 0.3rem 0;
    line-height: 1.4;
  }

  .cart-item-author {
    color: #7f8c8d;
    font-size: 0.95rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .cart-item-author i {
    color: #4f9da6;
  }

  .cart-item-price {
    font-size: 1.25rem;
    color: #e74c3c;
    font-weight: 700;
    margin: 0.3rem 0 0 0;
  }

  .cart-item-actions {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-end;
    gap: 1rem;
    min-width: 180px;
  }

  .cart-item-total {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    min-width: 120px;
    text-align: right;
    padding: 0.5rem 0;
  }

  .quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    background: transparent;
  }

  .qty-btn {
    width: 28px;
    height: 28px;
    min-width: 28px;
    border: 2px solid #e0e0e0;
    background: white;
    color: #5a5a5a;
    cursor: pointer;
    font-size: 1.2rem;
    font-weight: 700;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
  }

  .qty-btn.minus-btn {
    border-color: #ffb3b3;
    color: #ff4d4d;
  }

  .qty-btn.minus-btn:hover:not(:disabled) {
    background: #ff4d4d;
    color: white;
    border-color: #ff4d4d;
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(255, 77, 77, 0.3);
  }

  .qty-btn.plus-btn {
    border-color: #b3e0cc;
    color: #27ae60;
  }

  .qty-btn.plus-btn:hover:not(:disabled) {
    background: #27ae60;
    color: white;
    border-color: #27ae60;
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
  }

  .qty-btn:active:not(:disabled) {
    transform: scale(0.95);
  }

  .qty-display {
    min-width: 35px;
    text-align: center;
    font-size: 0.95rem;
    font-weight: 700;
    color: #2c3e50;
    border: 2px solid #e8e8e8;
    border-radius: 6px;
    padding: 0.3rem 0.4rem;
    background: #fafafa;
    pointer-events: none;
  }

  .btn-remove {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    width: 100%;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(255, 107, 107, 0.2);
  }

  .btn-remove:hover {
    background: linear-gradient(135deg, #ee5a6f 0%, #d63447 100%);
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
  }

  .cart-summary {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(79, 157, 166, 0.12);
    border: 1px solid rgba(130, 192, 154, 0.15);
    height: fit-content;
    position: sticky;
    top: 100px;
    width: 100%;
  }

  .summary-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 1.2rem;
    border-bottom: 2px solid #f0f0f0;
    text-align: center;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    font-size: 1.05rem;
    color: #2c3e50;
  }

  .summary-row span:first-child {
    font-weight: 500;
  }

  .summary-row span:last-child {
    font-weight: 700;
  }

  .summary-row.total {
    font-size: 1.6rem;
    font-weight: 700;
    color: #e74c3c;
    border-top: 2px solid #f0f0f0;
    margin-top: 1rem;
    padding-top: 1.5rem;
  }

  .payment-method-section {
    margin-top: 1.5rem;
    padding: 1.5rem;
    border-radius: 12px;
    background: #f0f8ff;
    border: 1px solid #b3e0ff;
    margin-bottom: 50px;
  }

  .payment-options {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
  }

  .payment-option {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    font-size: 1.05rem;
    cursor: pointer;
    user-select: none;
    padding: 0.5rem;
    border-radius: 6px;
    transition: background-color 0.2s;
  }

  .payment-option:hover {
    background-color: #e6f7ff;
  }

  .btn-checkout {
    width: 100%;
    padding: 1.4rem;
    background: linear-gradient(135deg, #ff7f50 0%, #ff6347 100%);
    color: white;
    border: none;
    border-radius: 16px;
    font-size: 1.2rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 2rem;
    text-decoration: none;
    display: block;
    text-align: center;
    box-shadow: 0 6px 20px rgba(255, 99, 71, 0.3);
  }

  .btn-checkout:hover:not(:disabled) {
    background: linear-gradient(135deg, #ff6347 0%, #e8533f 100%);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(255, 99, 71, 0.4);
  }

  .btn-edit-info {
    display: inline-block;
    width: 100%;
    padding: 0.95rem 1rem;
    margin-top: 1.5rem;
    background: linear-gradient(135deg, #4f9da6 0%, #82c09a 100%);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
  }

  .btn-edit-info:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 16px rgba(79, 157, 166, 0.2);
  }

  @media (max-width: 1024px) {
    .cart-layout {
      grid-template-columns: 1fr;
    }

    .cart-summary {
      position: relative;
      top: 0;
    }
  }

  @media (max-width: 768px) {
    .container {
      padding: 0 1rem;
    }

    .cart-heading {
      font-size: 2rem;
      margin-top: 60px;
    }

    .cart-item {
      grid-template-columns: 90px 1fr !important;
      grid-template-areas: "image details" "actions actions" !important;
      gap: 0.75rem 1rem !important;
      padding: 1.5rem !important;
    }

    .cart-item-image {
      grid-area: image;
      width: 90px;
      height: 120px;
    }

    .cart-item-details {
      grid-area: details;
    }

    .cart-item-actions {
      grid-area: actions;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      margin-top: 0.75rem;
      min-width: unset;
      gap: 0.75rem;
      border-top: 1px solid #e0e0e0;
      padding-top: 1rem;
    }

    .buyer-info-card,
    .cart-summary {
      padding: 2rem;
      border-radius: 20px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 0.75rem;
    }

    .buyer-modal-content {
      display: block;
      width: 100% !important;
      padding: 1.5rem;
    }

    .buyer-modal-grid-columns {
      display: block !important;
    }

    .change-profile-modal {
      width: 100% !important;
    }
  }

  /* Các style modal khác được giữ nguyên */
  .profile-card {
    border: 2px solid #e0e0e0;
    border-radius: 16px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .profile-card:hover {
    border-color: #4f9da6;
    box-shadow: 0 10px 30px rgba(79, 157, 166, 0.12);
  }

  .profile-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
  }

  .profile-card-body {
    display: grid;
    gap: 0.45rem;
    color: #4a4a4a;
    font-size: 0.95rem;
  }

  .profile-card-body div {
    display: flex;
    justify-content: space-between;
    gap: 0.75rem;
  }
</style>
<?php
$extraCss = ob_get_clean();

// Gọi header chung (đã bao gồm navbar)
include '../includes/header.php';
?>

<main class="container">
  <h2 class="cart-heading">🛒 Giỏ Hàng Của Bạn</h2>

  <?php if (!$hasCartItems): ?>
    <div class="empty-cart">
      <span class="empty-cart-icon">🛍️</span>
      <h3>Giỏ hàng của bạn đang trống!</h3>
      <p>Hãy thêm sách vào giỏ hàng để bắt đầu mua sắm.</p>
      <a href="category.php" class="btn-continue">Tiếp tục mua sắm</a>
    </div>
  <?php else: ?>
    <div class="cart-layout">
      <div class="cart-items-section">
        <div class="cart-section-header">
          <h3 class="cart-section-title">Danh sách sản phẩm (<?= h($cartTotalQty) ?> sản phẩm)</h3>
        </div>
        <div class="cart-items-list">
          <?php foreach ($cartProducts as $item): ?>
            <div class="cart-item" data-product-id="<?= $item['id'] ?>">
              <div class="cart-item-image">
                <img src="<?= h($item['image']) ?>" alt="<?= h($item['name']) ?>" />
              </div>
              <div class="cart-item-details">
                <h4 class="cart-item-title"><?= h($item['name']) ?></h4>
                <p class="cart-item-author"><i class="bi bi-person"></i> <?= h($item['author']) ?></p>
                <p class="cart-item-price"><?= fmtPrice($item['price']) ?> / cuốn</p>
              </div>
              <div class="cart-item-actions">
                <p class="cart-item-total"><?= fmtPrice($item['lineTotal']) ?></p>
                <div class="quantity-controls">
                  <button class="qty-btn minus-btn" type="button" onclick="changeQuantity(<?= $item['id'] ?>, -1)">-</button>
                  <span class="qty-display"><?= $item['qty'] ?></span>
                  <button class="qty-btn plus-btn" type="button" onclick="changeQuantity(<?= $item['id'] ?>, 1)">+</button>
                </div>
                <button class="btn-remove" type="button" onclick="removeCartItem(<?= $item['id'] ?>)">
                  <i class="bi bi-trash"></i> Xóa
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="cart-right-panel">
        <div class="buyer-info-card cart-section" style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(79, 157, 166, 0.12); border: 1px solid rgba(130, 192, 154, 0.15);">
          <h4 style="font-size: 1.5rem; margin-bottom: 1.5rem; color: #2c3e50;">👤 Thông tin người mua</h4>
          <div id="buyerInfoDisplay" class="info-grid">
            <div class="info-row" style="margin-bottom: 0.5rem;"><strong>Họ tên:</strong> <span id="displayBuyerName"><?= h($buyerProfiles[1]['fullName'] ?? $userInfo['fullName'] ?: 'Chưa nhập') ?></span></div>
            <div class="info-row" style="margin-bottom: 0.5rem;"><strong>Email:</strong> <span id="displayBuyerEmail"><?= h($buyerProfiles[1]['email'] ?? $userInfo['email'] ?: 'Chưa nhập') ?></span></div>
            <div class="info-row" style="margin-bottom: 0.5rem;"><strong>Số điện thoại:</strong> <span id="displayBuyerPhone"><?= h($buyerProfiles[1]['phone'] ?? $userInfo['phone'] ?: 'Chưa nhập') ?></span></div>
            <div class="info-row" style="margin-bottom: 0.5rem;"><strong>Địa chỉ:</strong> <span id="displayBuyerAddress"><?= h($buyerProfiles[1]['address'] ?? $userInfo['address'] ?: 'Chưa nhập') ?></span></div>
            <div class="info-row" style="margin-bottom: 0.5rem;"><strong>Ghi chú:</strong> <span id="displayBuyerNote"><?= h($buyerProfiles[1]['note'] ?? 'Không có') ?></span></div>
          </div>

          <button class="btn-edit-info" type="button" onclick="openBuyerInfoModal()">➕ Thêm thông tin</button>
          <button class="btn-edit-info" type="button" onclick="openChangeProfileModal()" style="margin-top:0.5rem;background:linear-gradient(135deg,#82c09a,#4f9da6);">🔄 Thay đổi thông tin</button>
          <button class="btn-edit-info" type="button" onclick="resetBuyerInfoToDefault()" style="margin-top:0.5rem;background:#f8f9fa;color:#2c3e50;border:1px solid #d1d5db;">⚙️ Đặt mặc định</button>
        </div>

        <div class="cart-summary">
          <div class="summary-title">💳 Tóm tắt đơn hàng</div>
          <div class="summary-row total" style="margin-top: 0; border-top: none; padding-top: 0;">
            <span>Tổng thanh toán</span>
            <span><?= fmtPrice($totalAmount) ?></span>
          </div>

          <div class="payment-method-section">
            <h4 style="font-size: 1.1rem; color: #2c3e50; margin-bottom: 1rem; font-weight: 700;">💳 Phương thức thanh toán</h4>
            <div class="payment-options">
              <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="radio" name="payment_method" value="Tiền mặt" checked onchange="toggleBankInfo()" style="width: 18px; height: 18px; accent-color: #4f9da6;">
                <span>💵 Thanh toán tiền mặt (COD)</span>
              </label>
              <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="radio" name="payment_method" value="Chuyển khoản" onchange="toggleBankInfo()" style="width: 18px; height: 18px; accent-color: #4f9da6;">
                <span>🏦 Chuyển khoản ngân hàng</span>
              </label>
              <div id="bankInfoBox" style="display: none; background: #f8f9fa; padding: 1rem; border-radius: 8px; font-size: 0.95rem; margin-left: 1.8rem; border: 1px solid #b3e0ff;">
                <strong style="color: #4f9da6;">Ngân hàng:</strong> Viettinbank<br>
                <strong style="color: #4f9da6;">Số tài khoản:</strong> 0368988328<br>
                <strong style="color: #4f9da6;">Chủ tài khoản:</strong> Lê Phú Hiếu<br>
                <strong style="color: #e74c3c;">Nội dung CK:</strong> Thanh toan [Số Điện Thoại]
              </div>
              <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="radio" name="payment_method" value="Trực tuyến" onchange="toggleBankInfo()" style="width: 18px; height: 18px; accent-color: #4f9da6;">
                <span>🌐 Thanh toán trực tuyến (VNPAY/Momo)</span>
              </label>
            </div>
          </div>

          <button class="btn-checkout" type="button" onclick="checkoutCart()">Thanh Toán (<?= h($cartTotalQty) ?> sản phẩm)</button>

          <form id="buyerForm" style="display: none;">
            <input type="hidden" id="buyerProfileIndex" value="1">
            <input type="text" id="buyerName" name="name" value="<?= h($userInfo['fullName'] ?? '') ?>">
            <input type="email" id="buyerEmail" name="email" value="<?= h($userInfo['email'] ?? '') ?>">
            <input type="tel" id="buyerPhone" name="phone" value="<?= h($userInfo['phone'] ?? '') ?>">
            <input type="text" id="buyerAddress" name="address" value="<?= h($userInfo['address'] ?? '') ?>">
            <textarea id="buyerNote" name="note"></textarea>
          </form>
        </div>
      </div>
    </div>
  <?php endif; ?>
</main>

<div id="changeProfileModal" class="auth-modal">
  <div class="auth-modal-overlay" onclick="closeChangeProfileModal()"></div>
  <div class="auth-modal-content change-profile-modal">
    <button class="auth-modal-close" onclick="closeChangeProfileModal()">&times;</button>
    <div class="auth-modal-header">
      <h2>Chọn mẫu thông tin</h2>
      <p>Chọn mẫu bạn muốn dùng cho đơn hàng này</p>
    </div>
    <div style="display:flex;flex-direction:column;gap:1rem;padding:1rem 0;">
      <?php for ($i = 1; $i <= 3; $i++): ?>
        <div id="profileCard-<?= $i ?>" class="profile-card" onclick="switchProfile(<?= $i ?>); closeChangeProfileModal();">
          <div class="profile-card-header">
            <strong style="color:#4f9da6;">Thông tin <?= $i ?></strong>
            <span style="font-size:0.9rem;color:#6b7280;">Chọn thông tin</span>
          </div>
          <div id="profileCardBody-<?= $i ?>" class="profile-card-body" style="<?= empty($buyerProfiles[$i]) ? 'display:none;' : '' ?>">
            <div><strong>Họ tên:</strong> <span><?= h($buyerProfiles[$i]['fullName'] ?? '') ?></span></div>
            <div><strong>Email:</strong> <span><?= h($buyerProfiles[$i]['email'] ?? '') ?></span></div>
            <div><strong>Phone:</strong> <span><?= h($buyerProfiles[$i]['phone'] ?? '') ?></span></div>
            <div><strong>Địa chỉ:</strong> <span><?= h($buyerProfiles[$i]['address'] ?? '') ?></span></div>
            <div><strong>Ghi chú:</strong> <span><?= h($buyerProfiles[$i]['note'] ?? 'Không có') ?></span></div>
          </div>
          <button type="button" class="btn-select-profile" onclick="event.stopPropagation(); switchProfile(<?= $i ?>); closeChangeProfileModal();" style="margin-top:1rem;padding:0.75rem 1rem;border:none;border-radius:12px;background:#4f9da6;color:white;cursor:pointer;width:100%;font-weight:600;">Chọn thông tin</button>
          <p id="profileCardEmpty-<?= $i ?>" style="margin:0.3rem 0 0;color:#aaa;font-size:0.95rem;<?= empty($buyerProfiles[$i]) ? '' : 'display:none;' ?>">Chưa có thông tin</p>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</div>

<div id="buyerInfoModal" class="auth-modal">
  <div class="auth-modal-overlay" onclick="closeBuyerInfoModal()"></div>
  <div class="auth-modal-content buyer-modal-content" style="width:900px;max-width:100%;min-height:520px;">
    <button class="auth-modal-close" onclick="closeBuyerInfoModal()">&times;</button>
    <div class="auth-modal-header">
      <h2>Thay đổi thông tin người mua</h2>
      <p>Thông tin đã được điền sẵn, bạn có thể chỉnh lại mọi lúc</p>
    </div>
    <form id="buyerInfoForm" class="auth-modal-form">
      <div class="form-group buyer-modal-grid-full">
        <label for="modalBuyerSaveTo">Lưu vào *</label>
        <select id="modalBuyerSaveTo" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
          <option value="1">Thông tin 1</option>
          <option value="2">Thông tin 2</option>
          <option value="3">Thông tin 3</option>
        </select>
      </div>
      <div class="buyer-modal-grid-columns" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
        <div class="buyer-modal-column" style="display: flex; flex-direction: column; gap: 1rem;">
          <div class="form-group">
            <label>Họ tên *</label>
            <input type="text" id="modalBuyerName" required placeholder="Nhập họ tên đầy đủ" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;" />
          </div>
          <div class="form-group">
            <label>Số điện thoại *</label>
            <input type="tel" id="modalBuyerPhone" required placeholder="0123456789" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;" />
          </div>
          <div class="form-group">
            <label>Email *</label>
            <input type="email" id="modalBuyerEmail" required placeholder="example@email.com" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;" />
          </div>
        </div>
        <div class="buyer-modal-column" style="display: flex; flex-direction: column; gap: 1rem;">
          <div class="form-group">
            <label>Địa chỉ *</label>
            <input type="text" id="modalBuyerAddress" required placeholder="Số nhà, đường" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;" />
          </div>
          <div class="form-group">
            <label>Ghi chú (tùy chọn)</label>
            <textarea id="modalBuyerNote" rows="3" placeholder="Ghi chú về đơn hàng..." style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;"></textarea>
          </div>
          <div class="form-group buyer-modal-action" style="margin-top: auto;">
            <button type="submit" class="btn-auth-submit" style="width: 100%; padding: 12px; background: #4f9da6; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Lưu mẫu</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
// Gói tất cả Javascript riêng của giỏ hàng vào biến $extraJs để chèn xuống cuối footer
ob_start();
?>
<script>
  // JS Ẩn/Hiện ngân hàng
  function toggleBankInfo() {
    const method = document.querySelector('input[name="payment_method"]:checked').value;
    document.getElementById('bankInfoBox').style.display = (method === 'Chuyển khoản') ? 'block' : 'none';
  }

  // Data từ PHP (single source of truth)
  window.currentUserFromSession = <?= json_encode([
                                    'id'       => $userId ?: null,
                                    'fullName' => $userInfo['fullName'] ?? '',
                                    'email'    => $userInfo['email']    ?? '',
                                    'phone'    => $userInfo['phone']    ?? '',
                                    'address'  => $userInfo['address']  ?? '',
                                  ]) ?>;

  window.buyerProfiles = <?= json_encode($buyerProfiles) ?>;
  window.currentProfileIndex = 1;

  function escapeHtml(text) {
    if (!text || typeof text !== 'string') return '';
    return text.replace(/&amp;/g, '&').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }

  function switchProfile(index) {
    window.currentProfileIndex = index;

    const profile = window.buyerProfiles ? window.buyerProfiles[index] : null;
    const user = window.currentUserFromSession || {};

    const name = (profile && (profile.fullName || profile.name)) ? (profile.fullName || profile.name) : (index === 1 ? user.fullName : '');
    const email = (profile && profile.email) ? profile.email : (index === 1 ? user.email : '');
    const phone = (profile && profile.phone) ? profile.phone : (index === 1 ? user.phone : '');
    const address = (profile && profile.address) ? profile.address : (index === 1 ? user.address : '');
    const note = (profile && profile.note) ? profile.note : '';

    const set = (id, val) => {
      const el = document.getElementById(id);
      if (el) el.value = val;
    };
    set('buyerProfileIndex', index);
    set('buyerName', name);
    set('buyerEmail', email);
    set('buyerPhone', phone);
    set('buyerAddress', address);
    set('buyerNote', note);

    const setText = (id, val, fallback) => {
      const el = document.getElementById(id);
      if (el) el.textContent = val || fallback;
    };
    setText('displayBuyerName', name, 'Chưa nhập');
    setText('displayBuyerEmail', email, 'Chưa nhập');
    setText('displayBuyerPhone', phone, 'Chưa nhập');
    setText('displayBuyerAddress', address, 'Chưa nhập');
    setText('displayBuyerNote', note, 'Không có');
  }

  function openBuyerInfoModal() {
    const index = window.currentProfileIndex;
    const profile = window.buyerProfiles ? window.buyerProfiles[index] : null;
    const user = window.currentUserFromSession || {};

    document.getElementById('modalBuyerSaveTo').value = index;
    document.getElementById('modalBuyerName').value = (profile && profile.fullName) ? profile.fullName : (index === 1 ? user.fullName : '');
    document.getElementById('modalBuyerEmail').value = (profile && profile.email) ? profile.email : (index === 1 ? user.email : '');
    document.getElementById('modalBuyerPhone').value = (profile && profile.phone) ? profile.phone : (index === 1 ? user.phone : '');
    document.getElementById('modalBuyerAddress').value = (profile && profile.address) ? profile.address : (index === 1 ? user.address : '');
    document.getElementById('modalBuyerNote').value = (profile && profile.note) ? profile.note : '';

    document.getElementById('buyerInfoModal').classList.add('show');
  }

  function closeBuyerInfoModal() {
    document.getElementById('buyerInfoModal').classList.remove('show');
  }

  function resetBuyerInfoToDefault() {
    const user = window.currentUserFromSession || {};
    const set = (id, val) => {
      const el = document.getElementById(id);
      if (el) el.value = val;
    };
    set('buyerName', user.fullName || '');
    set('buyerEmail', user.email || '');
    set('buyerPhone', user.phone || '');
    set('buyerAddress', user.address || '');
    set('buyerNote', '');

    const setText = (id, val, fallback) => {
      const el = document.getElementById(id);
      if (el) el.textContent = val || fallback;
    };
    setText('displayBuyerName', user.fullName, 'Chưa nhập');
    setText('displayBuyerEmail', user.email, 'Chưa nhập');
    setText('displayBuyerPhone', user.phone, 'Chưa nhập');
    setText('displayBuyerAddress', user.address, 'Chưa nhập');
    setText('displayBuyerNote', '', 'Không có');
  }

  function refreshChangeProfileCards() {
    for (let i = 1; i <= 3; i++) {
      const body = document.getElementById('profileCardBody-' + i);
      const placeholder = document.getElementById('profileCardEmpty-' + i);
      if (!body) continue;
      const p = window.buyerProfiles ? window.buyerProfiles[i] : null;
      if (p && (p.fullName || p.phone || p.address)) {
        body.style.display = '';
        body.innerHTML = `
            <div><strong>Họ tên:</strong> <span>${escapeHtml(p.fullName)}</span></div>
            <div><strong>Email:</strong> <span>${escapeHtml(p.email)}</span></div>
            <div><strong>ĐT:</strong> <span>${escapeHtml(p.phone)}</span></div>
            <div><strong>Địa chỉ:</strong> <span>${escapeHtml(p.address)}</span></div>
            <div><strong>Ghi chú:</strong> <span>${escapeHtml(p.note || 'Không có')}</span></div>`;
        if (placeholder) placeholder.style.display = 'none';
      } else {
        body.style.display = 'none';
        if (placeholder) placeholder.style.display = '';
      }
    }
  }

  function openChangeProfileModal() {
    refreshChangeProfileCards();
    document.getElementById('changeProfileModal').classList.add('show');
  }

  function closeChangeProfileModal() {
    document.getElementById('changeProfileModal').classList.remove('show');
  }

  document.addEventListener('DOMContentLoaded', function() {
    switchProfile(1);
    refreshChangeProfileCards();

    const form = document.getElementById('buyerInfoForm');
    if (form) {
      form.addEventListener('submit', async function(e) {
        e.preventDefault();
        var userId = (window.currentUserFromSession && window.currentUserFromSession.id) ? window.currentUserFromSession.id : null;
        var index = parseInt(document.getElementById('modalBuyerSaveTo').value, 10) || window.currentProfileIndex || 1;
        var name = document.getElementById('modalBuyerName').value.trim();
        var email = document.getElementById('modalBuyerEmail').value.trim();
        var phone = document.getElementById('modalBuyerPhone').value.trim();
        var address = document.getElementById('modalBuyerAddress').value.trim();
        var note = document.getElementById('modalBuyerNote').value.trim();

        if (!name || !phone || !address) {
          alert('⚠️ Vui lòng nhập đầy đủ Họ tên, SĐT, Địa chỉ');
          return;
        }
        if (!/^[0-9]{9,11}$/.test(phone)) {
          alert('⚠️ Số điện thoại không hợp lệ.');
          return;
        }

        var profile = {
          name,
          email,
          phone,
          address,
          note
        };
        var apiUrl = userId ? resolveApiUrl('buyer-profiles.php') : resolveApiUrl('session-buyer.php');
        var payload = userId ? {
          userId,
          profileIndex: index,
          profile
        } : {
          profileIndex: index,
          profile
        };

        try {
          var res = await fetch(apiUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
          });
          var json = await res.json();
          if (!res.ok) throw new Error(json.error || 'Lỗi lưu thông tin');

          if (!window.buyerProfiles) window.buyerProfiles = {};
          window.buyerProfiles[index] = {
            fullName: name,
            email,
            phone,
            address,
            note
          };

          refreshChangeProfileCards();
          switchProfile(window.currentProfileIndex || 1);
          closeBuyerInfoModal();
          alert('✅ Đã lưu thông tin mẫu ' + index + ' thành công!');
        } catch (err) {
          alert('❌ Lỗi: ' + err.message);
        }
      });
    }
  });
</script>
<?php
$extraJs = ob_get_clean();

include '../includes/footer.php';
?>