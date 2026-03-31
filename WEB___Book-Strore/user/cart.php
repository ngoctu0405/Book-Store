<?php
session_start();
require_once __DIR__ . '/../api/db.php';

function h($value)
{
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function fmtPrice($value)
{
  return number_format((int)$value, 0, ',', '.') . '₫';
}

function getCartFromSession()
{
  if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    return [];
  }

  $validated = [];
  foreach ($_SESSION['cart'] as $item) {
    if (!is_array($item)) {
      continue;
    }

    $id = isset($item['id']) ? (int)$item['id'] : 0;
    $qty = isset($item['qty']) ? (int)$item['qty'] : 0;

    if ($id <= 0 || $qty <= 0) {
      continue;
    }

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
      if (!isset($products[$productId])) {
        continue;
      }
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

$userInfo = [
  'fullName' => '',
  'email'    => '',
  'phone'    => '',
  'address'  => '',
];
$userId = 0;

// Lấy thông tin user từ session nếu có, không thì để JS tự điền từ localStorage
if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
  $userId = (int)$_SESSION['user_id'];
  $stmt = $conn->prepare('SELECT fullName, email, phone, address FROM users WHERE id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
      $userInfo = array_merge($userInfo, $res->fetch_assoc());
    }
  }
}

// Lấy 3 mẫu buyer_info từ DB nếu đã đăng nhập
$buyerProfiles = [1 => null, 2 => null, 3 => null];
if ($userId > 0) {
  $stmt = $conn->prepare("
    SELECT profileIndex, fullName, email, phone, address, ward, district, city, note
    FROM buyer_info WHERE userId = ? ORDER BY profileIndex ASC
  ");
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($row = $res->fetch_assoc()) {
    $buyerProfiles[$row['profileIndex']] = $row;
  }
}

$shippingFee = $cartSubtotal === 0 || $cartSubtotal >= 500000 ? 0 : 30000;
$totalAmount = $cartSubtotal + $shippingFee;
$hasCartItems = !empty($cartProducts);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Giỏ Hàng - Literary Haven</title>
  <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <style>
    /* CHỈNH SỬA: Sửa lỗi cú pháp, thêm padding: 0 và box-sizing: border-box */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Custom styles cho cart page */
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


    /* Cart Items Section - Improved */
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
      /* CHỈNH SỬA: Thêm đơn vị 'rem' */
      margin-bottom: 1.5rem;
      /* CHỈNH SỬA: Thêm đơn vị 'rem' */
      padding-bottom: 1.2rem;
      border-bottom: 2px solid #f0f0f0;
    }

    .cart-section-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #2c3e50;
      margin: 0;
    }

    .select-all-wrapper {
      display: flex;
      align-items: center;
      gap: 1.2rem;
    }

    .select-all-label {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      margin: 0;
      cursor: pointer;
      font-weight: 600;
      font-size: 1.05rem;
      color: #4f9da6;
      user-select: none;
    }

    .select-all-label input[type="checkbox"] {
      width: 20px;
      height: 20px;
      cursor: pointer;
      accent-color: #4f9da6;
    }

    .btn-clear-all {
      padding: 0.65rem 1.3rem;
      background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    .btn-clear-all:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }

    .btn-clear-all i {
      font-size: 1.1rem;
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

    /* Cart Item - Improved */
    .cart-item {
      display: grid;
      grid-template-columns: 40px 110px 1fr auto;
      align-items: center;
      gap: 1.5rem;
      padding: 1.5rem;
      background: linear-gradient(145deg, #ffffff 0%, #fafafa 100%);
      border-radius: 16px;
      margin-bottom: 1.5rem;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .cart-item:hover {
      transform: translateX(8px);
      box-shadow: 0 8px 24px rgba(79, 157, 166, 0.15);
      border-color: rgba(130, 192, 154, 0.3);
    }

    .item-select-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .item-select-checkbox {
      width: 22px;
      height: 22px;
      cursor: pointer;
      accent-color: #4f9da6;
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

    .qty-btn:disabled {
      opacity: 0.3;
      cursor: not-allowed;
      background: #f5f5f5;
      border-color: #ddd;
      color: #999;
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

    /* Cart Summary - Improved */
    .cart-summary {
      background: white;
      padding: 2rem;
      /* Tăng padding */
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(79, 157, 166, 0.12);
      border: 1px solid rgba(130, 192, 154, 0.15);
      height: fit-content;
      position: sticky;
      top: 100px;
      /* CHỈNH SỬA: Đặt 100% để nó lấp đầy cột grid 500px */
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

    /* CSS MỚI: Định dạng tiêu đề cột chi tiết sản phẩm */
    .summary-header-row {
      display: grid;
      grid-template-columns: 2fr 1fr 1.5fr;
      /* 3 cột thẳng hàng */
      gap: 0.5rem;
      font-weight: 700;
      color: #000000;
      padding: 0 0 0.5rem 0;
      font-size: 1rem;
      border-bottom: 1px solid #f0f0f0;
      margin-bottom: 0.5rem;
      margin-top: 20px;
    }

    .summary-header-row span:nth-child(2) {
      text-align: center;
    }

    .summary-header-row span:last-child {
      text-align: right;
    }

    /* CSS ĐÃ CHỈNH SỬA: Định dạng chi tiết sản phẩm trong tóm tắt */
    .summary-item-detail {
      display: grid;
      /* ĐÃ SỬA: Dùng grid để căn cột */
      grid-template-columns: 2fr 1fr 1.5fr;
      /* Căn chỉnh 3 cột */
      gap: 0.5rem;
      font-size: 1.15rem;
      /* TĂNG: Tăng kích thước font lên 1.15rem */
      color: #333;
      padding: 0.5rem 0;
      /* TĂNG: Tăng padding để dễ đọc hơn */
      align-items: center;
    }

    .summary-item-detail span:first-child {
      /* Tên sản phẩm */
      max-width: 100%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-weight: 500;
      color: #2c3e50;
    }

    .summary-item-detail span:nth-child(2) {
      /* Quantity (Số lượng) */
      font-weight: 600;
      text-align: center;
      color: #4f9da6;
    }

    .summary-item-detail span:last-child {
      /* Total Price (Giá tổng) */
      font-weight: 700;
      color: #e74c3c;
      text-align: right;
      /* Căn phải */
      font-size: 1.05rem;
      /* Tăng độ nổi bật */
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 0;
      font-size: 1.05rem;
      color: #2c3e50;
    }

    .summary-row.temp-total {
      /* ĐIỀU CHỈNH: Padding cho dòng Tạm tính */
      padding-top: 1rem;
      padding-bottom: 1rem;
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

    .text-success {
      color: #27ae60 !important;
      font-weight: 700 !important;
    }

    /* Custom styles for Payment Method (NEW) */
    .payment-method-section {
      margin-top: 1.5rem;
      padding: 1.5rem;
      border-radius: 12px;
      background: #f0f8ff;
      /* Light blue background */
      border: 1px solid #b3e0ff;
      margin-bottom: 50px;
    }

    .payment-method-section h4 {
      font-size: 1.3rem;
      color: #4f9da6;
      margin-bottom: 1rem;
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

    .payment-option input[type="radio"] {
      width: 18px;
      height: 18px;
      accent-color: #4f9da6;
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

    .btn-checkout:disabled {
      opacity: 0.5;
      cursor: not-allowed;
      box-shadow: none;
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
        /* KHÔNG CẦN CHỈNH SỬA WIDTH Ở ĐÂY NỮA VÌ ĐÃ LÀ 100% */
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

      .cart-items-section {
        padding: 1.5rem;
      }

      .cart-section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }

      .select-all-wrapper {
        width: 100%;
        justify-content: space-between;
      }

      .cart-item {
        grid-template-columns: 30px 90px 1fr;
        grid-template-areas:
          "checkbox image details"
          "actions actions actions";
        gap: 0.75rem 1rem;
        padding: 1.5rem;
      }

      .item-select-wrapper {
        grid-area: checkbox;
      }

      .cart-item-image {
        grid-area: image;
        width: 90px;
        height: 120px;
      }

      .cart-item-details {
        grid-area: details;
      }

      .cart-item-title {
        font-size: 1.1rem;
      }

      .cart-item-author {
        font-size: 0.85rem;
      }

      .cart-item-price {
        font-size: 1.2rem;
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

      .cart-item-total {
        font-size: 1.1rem;
        text-align: left;
        order: 1;
        min-width: auto;
      }

      .quantity-controls {
        order: 2;
        gap: 0.25rem;
      }

      .qty-btn {
        width: 26px;
        height: 26px;
        min-width: 26px;
        font-size: 1.1rem;
      }

      .qty-display {
        font-size: 0.9rem;
        min-width: 32px;
        padding: 0.25rem 0.35rem;
      }

      .btn-remove {
        order: 3;
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
        width: auto;
      }

      .buyer-info-card,
      .cart-summary {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(79, 157, 166, 0.12);
        border: 1px solid rgba(130, 192, 154, 0.15);
      }

      .buyer-info-card {
        margin-bottom: 1.5rem;
      }

      .buyer-info-card h4,
      .cart-summary .summary-title {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        color: #2c3e50;
      }

      .summary-title {
        font-size: 1.5rem;
      }

      .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.75rem;
      }

      .buyer-profile-tabs {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
      }

      .buyer-profile-btn {
        padding: 0.65rem 1rem;
        border: 1px solid #d1d5db;
        background: #f8fafc;
        border-radius: 999px;
        color: #334155;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
      }

      .buyer-profile-btn.active,
      .buyer-profile-btn:hover {
        background: #4f9da6;
        color: white;
        border-color: #4f9da6;
      }

      .buyer-info-section .info-row {
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
        align-items: center;
        padding: 0.8rem 0;
        border-bottom: 1px solid #f0f0f0;
      }

      .buyer-info-section .info-row:last-child {
        border-bottom: none;
      }

      .auth-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        background: rgba(0, 0, 0, 0.55);
        overflow-y: auto;
      }

      .auth-modal.show {
        display: flex;
      }

      .auth-modal-content.buyer-modal-content {
        display: block;
        width: min(900px, 100%) !important;
        max-width: 900px !important;
        min-height: 520px;
        max-height: calc(100vh - 3rem);
        overflow-y: auto;
        border-radius: 24px;
        padding: 2rem;
      }

      .buyer-modal-grid-columns {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.5rem;
      }

      .buyer-modal-save-to {
        width: 50%;
        max-width: 360px;
      }

      .buyer-modal-save-to select {
        width: 100%;
      }

      .buyer-modal-column {
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }

      .buyer-modal-grid-full {
        width: 100%;
      }

      .buyer-modal-action {
        margin-top: auto;
      }

      .buyer-modal-column .form-group {
        margin-bottom: 0;
      }

      @media (max-width: 960px) {
        .buyer-modal-grid-columns {
          display: block;
        }
      }

      .auth-modal-content.buyer-modal-content .auth-modal-header {
        margin-bottom: 1.5rem;
      }

      .auth-modal-content.buyer-modal-content .auth-modal-header p {
        margin-top: 0.5rem;
      }

      @media (max-width: 960px) {
        .auth-modal-content.buyer-modal-content {
          display: block;
          width: min(100%, 100%) !important;
          min-height: auto;
          max-height: calc(100vh - 3rem);
        }
      }

      .auth-modal-content.change-profile-modal {
        width: min(720px, 100%);
        max-width: 720px;
      }

      .profile-card {
        border: 2px solid #e0e0e0;
        border-radius: 16px;
        padding: 1rem;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
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
        line-height: 1.45;
      }

      .profile-card-body div {
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
      }

      .profile-card-body div strong {
        color: #2c3e50;
      }

      .buyer-modal-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
      }

      .buyer-modal-grid-full {
        grid-column: 1 / -1;
      }

      .buyer-modal-grid .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
      }

      .buyer-modal-grid input,
      .buyer-modal-grid textarea {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <!-- HEADER -->
  <header class="topbar">
    <div class="logo">
      <a href="index.php">
        <img class="Logo" src="../images/Logo_removebg.png" alt="Logo" />
        <img
          class="Word"
          src="../images/Logo_word_removebg.png"
          alt="Literary Haven" />
      </a>
    </div>

    <div class="auth-cart">
      <div id="authArea">
        <button class="btn-auth" onclick="openLoginModal()">Đăng nhập</button>
        <button class="btn-auth btn-signup" onclick="openRegisterModal()">
          Đăng ký
        </button>
      </div>
    </div>
  </header>

  <!-- NAV -->
  <nav class="navbar" id="mainNav">
    <ul class="menu" id="mainMenu">
      <li><a href="index.php">Trang chủ</a></li>
      <li><a href="about.php">Giới thiệu</a></li>
      <div class="category-menu">
        <button class="category-btn">Danh mục ▾</button>

        <ul class="book-filter">
          <li class="dropdown">
            <a href="category.php?category=Văn học" data-category="Văn học">Văn học ▸</a>
            <ul class="dropdown-content">
              <li>
                <a
                  href="category.php?category=Văn học&subcategory=Tiểu thuyết">Tiểu thuyết</a>
              </li>
              <li>
                <a
                  href="category.php?category=Văn học&subcategory=Truyện ngắn">Truyện ngắn</a>
              </li>
              <li>
                <a href="category.php?category=Văn học&subcategory=Thơ">Thơ</a>
              </li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="category.php?category=Kinh tế">Kinh tế ▸</a>
            <ul class="dropdown-content">
              <li>
                <a href="category.php?category=Kinh tế&subcategory=Quản trị">Quản trị</a>
              </li>
              <li>
                <a href="category.php?category=Kinh tế&subcategory=Tài chính">Tài chính</a>
              </li>
              <li>
                <a href="category.php?category=Kinh tế&subcategory=Marketing">Marketing</a>
              </li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="category.php?category=Thiếu nhi">Thiếu nhi ▸</a>
            <ul class="dropdown-content">
              <li>
                <a
                  href="category.php?category=Thiếu nhi&subcategory=Truyện tranh">Truyện tranh</a>
              </li>
              <li>
                <a
                  href="category.php?category=Thiếu nhi&subcategory=Giáo dục">Giáo dục</a>
              </li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="category.php?category=Giáo khoa">Giáo khoa ▸</a>
            <ul class="dropdown-content">
              <li>
                <a href="category.php?category=Giáo khoa&subcategory=Cấp 1">Cấp 1</a>
              </li>
              <li>
                <a href="category.php?category=Giáo khoa&subcategory=Cấp 2">Cấp 2</a>
              </li>
              <li>
                <a href="category.php?category=Giáo khoa&subcategory=Cấp 3">Cấp 3</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <li><a href="news.php">Tin tức</a></li>
    </ul>
  </nav>

  <!-- Tìm kiếm và giỏ hàng -->
  <div class="nav_2">
    <div class="search-center">
      <input
        id="topSearch"
        class="search-input"
        type="text"
        placeholder="Nhập tên cuốn sách bạn đang tìm ..."
        autocomplete="off" />
      <button class="search-btn" type="button">Tìm kiếm</button>
    </div>
    <div class="cart-float" id="cartFloat">
      <button id="cartBtnFloat" class="btn">
        <span class="cart-icon">🛒</span>
        <span id="cart-count" class="cart-count">0</span>
      </button>
    </div>
  </div>

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
          <div class="buyer-info-card cart-section">
            <h4>👤 Thông tin người mua</h4>
            <div id="buyerInfoDisplay" class="info-grid">
              <div class="info-row"><strong>Họ tên:</strong> <span id="displayBuyerName"><?= h($buyerProfiles[1]['fullName'] ?? $userInfo['fullName'] ?: 'Chưa nhập') ?></span></div>
              <div class="info-row"><strong>Email:</strong> <span id="displayBuyerEmail"><?= h($buyerProfiles[1]['email'] ?? $userInfo['email'] ?: 'Chưa nhập') ?></span></div>
              <div class="info-row"><strong>Số điện thoại:</strong> <span id="displayBuyerPhone"><?= h($buyerProfiles[1]['phone'] ?? $userInfo['phone'] ?: 'Chưa nhập') ?></span></div>
              <div class="info-row"><strong>Địa chỉ:</strong> <span id="displayBuyerAddress"><?= h($buyerProfiles[1]['address'] ?? $userInfo['address'] ?: 'Chưa nhập') ?></span></div>
              <div class="info-row"><strong>Ghi chú:</strong> <span id="displayBuyerNote"><?= h($buyerProfiles[1]['note'] ?? 'Không có') ?></span></div>
            </div>
            <button class="btn-edit-info" type="button" onclick="openBuyerInfoModal()">➕ Thêm thông tin</button>
            <button class="btn-edit-info" type="button" onclick="openChangeProfileModal()" style="margin-top:0.5rem;background:linear-gradient(135deg,#82c09a,#4f9da6);">🔄 Thay đổi thông tin</button>
          </div>

          <div class="cart-summary">
            <div class="summary-title">💳 Tóm tắt đơn hàng</div>
            <div class="summary-row temp-total">
              <span>Tạm tính</span>
              <span><?= fmtPrice($cartSubtotal) ?></span>
            </div>
            <div class="summary-row">
              <span>Phí vận chuyển</span>
              <span class="<?= $shippingFee === 0 ? 'text-success' : '' ?>"><?= $shippingFee === 0 ? 'Miễn phí' : fmtPrice($shippingFee) ?></span>
            </div>
            <div class="summary-row total">
              <span>Tổng cộng</span>
              <span><?= fmtPrice($totalAmount) ?></span>
            </div>
            <button class="btn-checkout" type="button" onclick="checkoutCart()"> Thanh Toán (<?= h($cartTotalQty) ?> sản phẩm)</button>

            <form id="buyerForm" style="display: none;">
              <input type="hidden" id="buyerProfileIndex" value="1">
              <input type="text" id="buyerName" name="name" value="<?= h($userInfo['fullName'] ?? '') ?>" required>
              <input type="email" id="buyerEmail" name="email" value="<?= h($userInfo['email'] ?? '') ?>" required>
              <input type="tel" id="buyerPhone" name="phone" value="<?= h($userInfo['phone'] ?? '') ?>" required>
              <input type="text" id="buyerAddress" name="address" value="<?= h($userInfo['address'] ?? '') ?>" required>
              <textarea id="buyerNote" name="note"></textarea>
            </form>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </main>

  <script>
    // Dữ liệu từ PHP truyền xuống JS
    window.currentUserFromSession = <?= json_encode([
                                      'id'       => $userId ?: null,
                                      'fullName' => $userInfo['fullName'] ?? '',
                                      'email'    => $userInfo['email']    ?? '',
                                      'phone'    => $userInfo['phone']    ?? '',
                                      'address'  => $userInfo['address']  ?? '',
                                    ]) ?>;

    window.buyerProfiles = <?= json_encode($buyerProfiles) ?>;
    window.currentProfileIndex = 1;

    // Chuyển mẫu thông tin
    function switchProfile(index) {
      window.currentProfileIndex = index;

      // Cập nhật tab active
      document.querySelectorAll('.buyer-profile-btn').forEach(btn => {
        btn.classList.toggle('active', parseInt(btn.dataset.profile) === index);
      });

      const profile = window.buyerProfiles[index];
      const user = window.currentUserFromSession;

      // Mẫu 1 mặc định điền thông tin tài khoản nếu chưa có
      const defaultName = (index === 1) ? (user.fullName || 'Chưa nhập') : 'Chưa nhập';
      const defaultEmail = (index === 1) ? (user.email || 'Chưa nhập') : 'Chưa nhập';
      const defaultPhone = (index === 1) ? (user.phone || 'Chưa nhập') : 'Chưa nhập';
      const defaultAddress = (index === 1) ? (user.address || 'Chưa nhập') : 'Chưa nhập';

      document.getElementById('displayBuyerName').textContent = profile ? (profile.fullName || defaultName) : defaultName;
      document.getElementById('displayBuyerEmail').textContent = profile ? (profile.email || defaultEmail) : defaultEmail;
      document.getElementById('displayBuyerPhone').textContent = profile ? (profile.phone || defaultPhone) : defaultPhone;
      document.getElementById('displayBuyerAddress').textContent = profile ? (profile.address || defaultAddress) : defaultAddress;
      document.getElementById('displayBuyerNote').textContent = profile ? (profile.note || 'Không có') : 'Không có';
    }

    // Mở modal thêm thông tin (lưu vào mẫu hiện tại)
    function openBuyerInfoModal() {
      const index = window.currentProfileIndex;
      const profile = window.buyerProfiles[index];
      const user = window.currentUserFromSession;

      // Điền sẵn thông tin tài khoản cho mẫu 1, hoặc profile đã lưu
      document.getElementById('modalBuyerSaveTo').value = index;
      document.getElementById('modalBuyerName').value = profile ? profile.fullName : (index === 1 ? user.fullName : '');
      document.getElementById('modalBuyerEmail').value = profile ? profile.email : (index === 1 ? user.email : '');
      document.getElementById('modalBuyerPhone').value = profile ? profile.phone : (index === 1 ? user.phone : '');
      document.getElementById('modalBuyerAddress').value = profile ? profile.address : (index === 1 ? user.address : '');
      document.getElementById('modalBuyerNote').value = profile ? (profile.note || '') : '';

      const modal = document.getElementById('buyerInfoModal');
      modal.classList.add('show');
    }

    function closeBuyerInfoModal() {
      const modal = document.getElementById('buyerInfoModal');
      modal.classList.remove('show');
    }

    // Mở modal thay đổi thông tin (chọn mẫu khác)
    function refreshChangeProfileCards() {
      for (let i = 1; i <= 3; i++) {
        const body = document.getElementById('profileCardBody-' + i);
        const placeholder = document.getElementById('profileCardEmpty-' + i);
        if (!body) continue;

        const profile = window.buyerProfiles[i];
        if (profile && Object.values(profile).some(value => value && value.toString().trim() !== '')) {
          body.innerHTML = `
            <div><strong>Họ tên:</strong> <span>${escapeHtml(profile.fullName)}</span></div>
            <div><strong>Email:</strong> <span>${escapeHtml(profile.email)}</span></div>
            <div><strong>Phone:</strong> <span>${escapeHtml(profile.phone)}</span></div>
            <div><strong>Địa chỉ:</strong> <span>${escapeHtml(profile.address)}</span></div>
            <div><strong>Ghi chú:</strong> <span>${escapeHtml(profile.note || 'Không có')}</span></div>
          `;
          if (placeholder) placeholder.style.display = 'none';
        } else {
          body.innerHTML = '';
          if (placeholder) placeholder.style.display = 'block';
        }
      }
    }

    function openChangeProfileModal() {
      refreshChangeProfileCards();
      const modal = document.getElementById('changeProfileModal');
      modal.classList.add('show');
    }

    function closeChangeProfileModal() {
      const modal = document.getElementById('changeProfileModal');
      modal.classList.remove('show');
    }

    function escapeHtml(text) {
      if (typeof text !== 'string') return '';
      return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    // Lưu mẫu thông tin lên server
    document.getElementById('buyerInfoForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      const userId = window.currentUserFromSession?.id;
      if (!userId) {
        alert('Bạn cần đăng nhập để lưu thông tin!');
        return;
      }

      const index = parseInt(document.getElementById('modalBuyerSaveTo').value, 10) || window.currentProfileIndex;
      const data = {
        userId,
        profileIndex: index,
        fullName: document.getElementById('modalBuyerName').value.trim(),
        email: document.getElementById('modalBuyerEmail').value.trim(),
        phone: document.getElementById('modalBuyerPhone').value.trim(),
        address: document.getElementById('modalBuyerAddress').value.trim(),
        note: document.getElementById('modalBuyerNote').value.trim(),
      };

      try {
        const res = await fetch(resolveApiUrl('buyer-profiles.php'), {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data),
        });
        const json = await res.json();
        if (!res.ok) throw new Error(json.error || 'Lỗi lưu thông tin');

        // Cập nhật cache local
        window.buyerProfiles[index] = data;
        window.currentProfileIndex = index;
        refreshChangeProfileCards();
        switchProfile(index);
        closeBuyerInfoModal();
        alert(` Đã lưu mẫu ${index} thành công!`);
      } catch (err) {
        alert(err.message);
      }
    });
  </script>

  <!-- Modal thay đổi thông tin (chọn mẫu) -->
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
          <select id="modalBuyerSaveTo" required>
            <option value="1">Thông tin 1</option>
            <option value="2">Thông tin 2</option>
            <option value="3">Thông tin 3</option>
          </select>
        </div>

        <div class="buyer-modal-grid-columns" style="display: grid !important; grid-template-columns: repeat(2, minmax(0, 1fr)) !important; gap: 1.5rem !important; align-items: start !important; width: 100%;">
          <div class="buyer-modal-column" style="display: flex; flex-direction: column; gap: 1rem;">
            <div class="form-group">
              <label for="modalBuyerName">Họ tên *</label>
              <input type="text" id="modalBuyerName" required placeholder="Nhập họ tên đầy đủ" />
            </div>
            <div class="form-group">
              <label for="modalBuyerPhone">Số điện thoại *</label>
              <input type="tel" id="modalBuyerPhone" required placeholder="0123456789" />
            </div>
            <div class="form-group">
              <label for="modalBuyerEmail">Email *</label>
              <input type="email" id="modalBuyerEmail" required placeholder="example@email.com" />
            </div>
          </div>

          <div class="buyer-modal-column" style="display: flex; flex-direction: column; gap: 1rem;">
            <div class="form-group">
              <label for="modalBuyerAddress">Địa chỉ *</label>
              <input type="text" id="modalBuyerAddress" required placeholder="Số nhà, đường" />
            </div>
            <div class="form-group">
              <label for="modalBuyerNote">Ghi chú (tùy chọn)</label>
              <textarea id="modalBuyerNote" rows="3" placeholder="Ghi chú về đơn hàng..."></textarea>
            </div>
            <div class="form-group buyer-modal-action">
              <button type="submit" class="btn-auth-submit">Lưu mẫu</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h3>Về Chúng tôi</h3>
        <ul>
          <li><a href="about.php">Giới thiệu</a></li>
          <li><a href="./news.php">Tin tức</a></li>
          <li><a href="./privacy_policy.php">Chính sách bảo mật</a></li>
          <li><a href="./terms-of-use.php">Điều khoản sử dụng</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h3>Hỗ trợ khách hàng</h3>
        <ul>
          <li><a href="./shopping_guide.php">Hướng dẫn mua hàng</a></li>
          <li><a href="./exchange-policy.php">Chính sách đổi trả</a></li>
          <li><a href="./warranty-policy.php">Chính sách bảo hành</a></li>
          <li>
            <a href="./frequently-asked-questions.php">Câu hỏi thường gặp</a>
          </li>
        </ul>
      </div>

      <div class="footer-section">
        <h3>Chính sách</h3>
        <ul>
          <li><a href="./payment-policy.php">Chính sách thanh toán</a></li>
          <li><a href="./shipping-policy.php">Chính sách vận chuyển</a></li>
          <li><a href="./warranty-policy.php">Chính sách bảo hành</a></li>
          <li><a href="./exchange-policy.php">Chính sách đổi trả</a></li>
        </ul>
      </div>
      <div class="footer-section contact-info">
        <h3>Liên hệ</h3>
        <p>📍 123 Nguyễn Văn Linh, Q7, TP.HCM</p>
        <p>📞 Hotline: 1900 xxxx</p>
        <p>✉️ Email: support@bookstore.vn</p>
        <p>🕐 Giờ làm việc: 8:00 - 22:00</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Book Store. All rights reserved. | Designed with ❤️</p>
    </div>
  </footer>

  <?php include '../includes/auth_modals.php'; ?>

  <div id="addressModal" class="auth-modal">
    <div class="auth-modal-overlay" onclick="closeAddressModal()"></div>
    <div class="auth-modal-content" style="max-width: 600px">
      <button class="auth-modal-close" onclick="closeAddressModal()">
        &times;
      </button>
      <div class="auth-modal-header">
        <h2 style="color: #4f9da6">
          <i class="bi bi-geo-alt-fill"></i> Quản lý Địa chỉ Giao hàng
        </h2>
        <p>Chọn hoặc thêm địa chỉ nhận hàng của bạn</p>
      </div>
      <div id="addressManagementContent"></div>
    </div>
  </div>

  <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js?v=2"></script>
</body>

</html>