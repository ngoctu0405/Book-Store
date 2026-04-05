<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// Bảo vệ trang Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

// --- XỬ LÝ POST (LƯU HOẶC HOÀN THÀNH PHIẾU NHẬP) BẰNG AJAX ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu JSON từ Javascript
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data) {
        $poId = isset($data['po_id']) ? (int)$data['po_id'] : null;
        $action = $data['action']; // 'save_draft' hoặc 'complete'
        $items = $data['items'];
        $totalAmount = (int)$data['totalAmount'];
        $status = ($action === 'complete') ? 'hoàn thành' : 'chưa hoàn thành';

        // BẮT ĐẦU GIAO DỊCH (TRANSACTION) - Đảm bảo an toàn dữ liệu
        $conn->begin_transaction();
        try {
            if ($poId) {
                // Cập nhật phiếu cũ
                $stmt = $conn->prepare("UPDATE goods_receipt SET totalAmount = ?, status = ? WHERE id = ?");
                $stmt->bind_param("isi", $totalAmount, $status, $poId);
                $stmt->execute();

                // Xóa chi tiết cũ để ghi đè chi tiết mới (chỉ làm được khi phiếu chưa hoàn thành)
                $conn->query("DELETE FROM goodsReceipts_items WHERE goods_receipt_id = $poId");
            } else {
                // Tạo phiếu mới
                $stmt = $conn->prepare("INSERT INTO goods_receipt (totalAmount, status) VALUES (?, ?)");
                $stmt->bind_param("is", $totalAmount, $status);
                $stmt->execute();
                $poId = $conn->insert_id;
            }

            // Xử lý từng sản phẩm trong phiếu nhập
            foreach ($items as $item) {
                $pId = (int)$item['productId'];
                $qtyImport = (int)$item['quantity'];
                $priceImport = (int)$item['cost'];

                // 1. Thêm vào bảng chi tiết phiếu nhập (goodsReceipts_items)
                $stmt = $conn->prepare("INSERT INTO goodsReceipts_items (goods_receipt_id, product_id, qty, price) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiii", $poId, $pId, $qtyImport, $priceImport);
                $stmt->execute();

                // 2. NẾU HOÀN THÀNH PHIẾU -> CẬP NHẬT KHO VÀ GIÁ BÌNH QUÂN
                if ($action === 'complete') {
                    // Lấy dữ liệu hiện tại của sản phẩm
                    $res = $conn->query("SELECT qty, costPrice, profitMargin FROM products WHERE id = $pId");
                    if ($row = $res->fetch_assoc()) {
                        $oldQty = (int)$row['qty'];
                        $oldCost = (int)$row['costPrice'];
                        $margin = (int)$row['profitMargin'];

                        // Tính tổng tồn kho mới
                        $newQty = $oldQty + $qtyImport;

                        // Công thức Giá Bình Quân: (Tồn * Giá Cũ + Nhập * Giá Nhập) / Tổng Tồn
                        $newCostPrice = 0;
                        if ($newQty > 0) {
                            $newCostPrice = round((($oldQty * $oldCost) + ($qtyImport * $priceImport)) / $newQty);
                        }

                        // Tính Giá Bán mới: Giá Bán = Giá vốn bình quân * (100% + % Lợi nhuận)
                        $newSalePrice = round($newCostPrice * (1 + ($margin / 100)));

                        // Cập nhật lại Sản phẩm
                        $upd = $conn->prepare("UPDATE products SET qty = ?, costPrice = ?, price = ? WHERE id = ?");
                        $upd->bind_param("iiii", $newQty, $newCostPrice, $newSalePrice, $pId);
                        $upd->execute();
                    }
                }
            }

            $conn->commit(); // Xác nhận giao dịch
            $_SESSION['flash_msg'] = $action === 'complete' ? "Đã nhập kho và cập nhật giá bình quân!" : "Đã lưu tạm phiếu nhập!";
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $conn->rollback(); // Hủy nếu có lỗi
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
}

// --- LOGIC HIỂN THỊ TRANG (GET) ---
$poId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$poInfo = null;
$poItems = [];
$isCompleted = false;

if ($poId) {
    $res = $conn->query("SELECT * FROM goods_receipt WHERE id = $poId");
    $poInfo = $res->fetch_assoc();
    if ($poInfo) {
        $isCompleted = ($poInfo['status'] === 'hoàn thành');

        // Lấy chi tiết sản phẩm của phiếu này
        $itemsRes = $conn->query("
            SELECT gi.product_id as productId, p.name as productName, p.sku, gi.qty as quantity, gi.price as cost
            FROM goodsReceipts_items gi
            JOIN products p ON gi.product_id = p.id
            WHERE gi.goods_receipt_id = $poId
        ");
        $poItems = $itemsRes->fetch_all(MYSQLI_ASSOC);
    }
}

// Lấy danh sách sản phẩm để đổ vào Select
$productsList = $conn->query("SELECT id, name, sku FROM products WHERE status = 'active' ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $poId ? "Chi tiết Phiếu nhập #$poId" : "Thêm Phiếu nhập mới" ?></title>
    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <style>
        /* CSS Responsive cho Sidebar (Đồng bộ với các trang khác) */
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

            .table-responsive {
                border: 1px solid var(--border-color);
                border-radius: 12px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
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

    <main class="main-content p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0"><?= $poId ? "Chi tiết Phiếu nhập #$poId" : "Thêm Phiếu nhập hàng mới" ?></h1>
            <a href="purchase-orders.php" class="btn btn-secondary">Quay lại danh sách</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <?php if (!$isCompleted): ?>
                    <div class="card mb-4" id="po-add-item-card">
                        <div class="card-header">
                            <h3 class="h5 mb-0">Thêm sản phẩm vào phiếu</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label">Chọn sản phẩm</label>
                                    <select class="form-select" id="po-product-select">
                                        <option value="">-- Chọn sách --</option>
                                        <?php foreach ($productsList as $p): ?>
                                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> (<?= $p['sku'] ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Giá nhập (đ)</label>
                                    <input type="number" class="form-control" id="po-cost-price" placeholder="0">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" id="po-quantity" value="1" min="1">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary w-100" id="po-add-item-btn">Thêm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="h5 mb-0">Chi tiết phiếu nhập</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Giá nhập</th>
                                        <th>Số lượng</th>
                                        <th class="text-end">Thành tiền</th>
                                        <?php if (!$isCompleted): ?><th></th><?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody id="po-items-tbody"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold h5">Tổng cộng</td>
                                        <td class="text-end fw-bold h5 text-danger" id="po-total-cost">0đ</td>
                                        <?php if (!$isCompleted): ?><td></td><?php endif; ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h5 mb-0">Thông tin Phiếu</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Ngày tạo</label>
                            <input type="text" class="form-control" value="<?= $poInfo ? date('d/m/Y H:i', strtotime($poInfo['createdAt'])) : date('d/m/Y') ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <div>
                                <?php if ($isCompleted): ?>
                                    <span class="status delivered d-block w-100 text-center">Đã hoàn thành</span>
                                <?php else: ?>
                                    <span class="status pending d-block w-100 text-center">Chưa hoàn thành</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!$isCompleted): ?>
                            <hr>
                            <div class="d-grid gap-2">
                                <button class="btn btn-secondary" onclick="submitPO('save_draft')">Lưu tạm (Chưa nhập kho)</button>
                                <button class="btn btn-success" onclick="submitPO('complete')">Hoàn thành (Cộng kho & Tính giá bình quân)</button>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mt-3 text-center">
                                Phiếu đã nhập kho, hệ thống đã cập nhật giá vốn. Không thể chỉnh sửa thêm.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Lấy dữ liệu PHP đưa vào mảng JS
        let tempItems = <?= json_encode($poItems) ?>;
        const isCompleted = <?= $isCompleted ? 'true' : 'false' ?>;
        const poId = <?= $poId ? $poId : 'null' ?>;

        function renderTable() {
            const tbody = document.getElementById('po-items-tbody');
            let total = 0;

            tbody.innerHTML = tempItems.map((item, index) => {
                const lineTotal = item.cost * item.quantity;
                total += lineTotal;
                return `
                    <tr>
                        <td>${item.productName} ${item.sku ? `<small class="text-muted">(${item.sku})</small>` : ''}</td>
                        <td>${Number(item.cost).toLocaleString('vi-VN')}đ</td>
                        <td>${item.quantity}</td>
                        <td class="text-end fw-bold">${lineTotal.toLocaleString('vi-VN')}đ</td>
                        ${!isCompleted ? `<td><button class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})">Xóa</button></td>` : ''}
                    </tr>
                `;
            }).join('');

            if (tempItems.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">Chưa có sản phẩm nào</td></tr>`;
            }

            document.getElementById('po-total-cost').innerText = total.toLocaleString('vi-VN') + 'đ';
        }

        renderTable();

        // Xử lý nút Thêm sản phẩm
        const addBtn = document.getElementById('po-add-item-btn');
        if (addBtn) {
            addBtn.addEventListener('click', function() {
                const select = document.getElementById('po-product-select');
                const cost = parseInt(document.getElementById('po-cost-price').value);
                const qty = parseInt(document.getElementById('po-quantity').value);

                if (!select.value || isNaN(cost) || cost <= 0 || isNaN(qty) || qty <= 0) {
                    alert("Vui lòng nhập đủ thông tin hợp lệ!");
                    return;
                }

                const productName = select.options[select.selectedIndex].text.split(' (')[0];

                const exists = tempItems.find(i => i.productId == select.value);
                if (exists) {
                    alert("Sản phẩm đã có trong phiếu. Vui lòng xóa đi và thêm lại số lượng mới.");
                    return;
                }

                tempItems.push({
                    productId: select.value,
                    productName: productName,
                    cost: cost,
                    quantity: qty
                });
                renderTable();

                select.value = "";
                document.getElementById('po-cost-price').value = "";
                document.getElementById('po-quantity').value = "1";
            });
        }

        function removeItem(index) {
            if (confirm("Xóa sản phẩm này?")) {
                tempItems.splice(index, 1);
                renderTable();
            }
        }

        // Gửi dữ liệu về Server (API)
        function submitPO(action) {
            if (tempItems.length === 0) {
                alert("Bạn phải có ít nhất 1 sản phẩm để lưu!");
                return;
            }
            if (action === 'complete' && !confirm("⚠️ BẠN CÓ CHẮC CHẮN HOÀN THÀNH?\nHành động này sẽ cộng hàng vào kho, tính lại Giá Nhập Bình Quân và tự động đẩy Giá Bán ra. Không thể hoàn tác!")) {
                return;
            }

            const totalAmount = tempItems.reduce((sum, item) => sum + (item.cost * item.quantity), 0);

            const payload = {
                po_id: poId,
                action: action,
                totalAmount: totalAmount,
                items: tempItems
            };

            fetch('purchase-edit.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'purchase-orders.php';
                    } else {
                        alert("Lỗi: " + data.message);
                    }
                })
                .catch(err => alert("Có lỗi xảy ra khi kết nối tới máy chủ."));
        }
    </script>
</body>

</html>