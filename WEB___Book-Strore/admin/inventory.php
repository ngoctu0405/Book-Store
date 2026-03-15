<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale-1.0" />
    <title>Quản lý Tồn kho - Literary Haven Admin</title>

    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link
      rel="stylesheet"
      href="../bootstrap-5.3.2-dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../assets/css/admin_style.css" />
    <style>
      /* Responsive cho thiết bị di động (max-width: 768px) */
      @media (max-width: 768px) {
        /* 1. Body: Chuyển hướng Flexbox thành column để Sidebar và Main-Content xếp chồng */
        body {
          display: flex !important;
          flex-direction: column !important; /* Quan trọng: Sidebar sẽ nằm trên Main-Content */
          overflow-x: hidden; /* Tắt cuộn ngang vì đã xếp chồng */
        }

        /* 2. Sidebar: Sidebar giờ chiếm toàn bộ chiều rộng (100%) */
        .sidebar {
          width: 100% !important;
          /* Tắt vh-100 vì giờ nó nằm ngang, không cần chiều cao toàn màn hình */
          height: auto !important;
          flex-shrink: 0;
          display: flex !important;

          /* Bổ sung: Điều chỉnh Sidebar để dễ sử dụng hơn khi nằm ngang */
          overflow-x: auto; /* Cho phép menu cuộn ngang nếu có nhiều mục */
          white-space: nowrap; /* Ngăn các mục menu xuống dòng */
        }

        /* 3. Main Content: Đảm bảo nội dung chính chiếm toàn bộ chiều rộng */
        .main-content {
          width: 100%;
          min-width: auto;
        }

        /* 4. Tinh chỉnh Padding và Kích thước (bên trong page-content) */
        .page-content {
          padding: 15px !important;
        }

        .page-content h1 {
          font-size: 20px;
          margin-bottom: 15px;
        }

        /* 5. Điều chỉnh bảng (Đảm bảo bảng vẫn cuộn ngang nếu quá nhiều cột) */
        .table-responsive {
          border: 1px solid var(--border-color);
          border-radius: 12px;
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
        }

        .table {
          min-width: 700px; /* Tăng min-width do có thêm cột */
        }

        .table thead th,
        .table tbody td {
          padding: 8px 6px;
          font-size: 12px;
        }

        .input-qty {
          width: 50px;
          padding: 4px 2px;
          font-size: 12px;
        }

        .btn-sm,
        .btn-action-small {
          padding: 3px 6px;
          font-size: 10px;
        }

        .table tbody td span.small {
          display: none;
        }
      }

      /* Kích hoạt lại bố cục Desktop (Sidebar nằm cạnh Main-Content) */
      @media (min-width: 769px) {
        body {
          display: flex !important;
          flex-direction: row !important; /* Khôi phục thành row trên desktop */
          overflow-x: hidden;
        }
        .sidebar {
          /* Giả sử chiều rộng desktop là 250px */
          width: 250px !important;
          height: 100vh !important; /* Khôi phục vh-100 trên desktop */
          display: flex !important;
        }
        .main-content {
          width: 100%;
        }
      }

      /* Style cho input số lượng và nút hành động */
      .input-qty {
        width: 70px;
        padding: 5px;
        margin-right: 5px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        text-align: center;
      }

      .btn-action-small {
        padding: 5px 10px;
        margin: 2px;
        font-size: 12px;
      }
    </style>
  </head>
  <body>
    <aside class="sidebar d-flex flex-column vh-100">
      <div class="sidebar-header">Literary Haven</div>

      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <span class="nav-icon">◈</span>
            <span>Bảng điều khiển</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="users.php" class="nav-link">
            <span class="nav-icon">◉</span>
            <span>Khách hàng</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="categories.php" class="nav-link">
            <span class="nav-icon">◫</span>
            <span>Loại sản phẩm</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="products.php" class="nav-link">
            <span class="nav-icon">◪</span>
            <span>Sản phẩm</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="purchase-orders.php" class="nav-link">
            <span class="nav-icon">◩</span>
            <span>Nhập hàng</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="pricing.php" class="nav-link">
            <span class="nav-icon">◎</span>
            <span>Quản lý giá</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="orders.php" class="nav-link">
            <span class="nav-icon">◧</span>
            <span>Đơn hàng</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="inventory.php" class="nav-link active">
            <span class="nav-icon">◨</span>
            <span>Tồn kho</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="reports.php" class="nav-link">
            <span class="nav-icon">◔</span>
            <span>Báo cáo</span>
          </a>
        </li>
      </ul>

      <div class="mt-auto p-3">
        <a href="index.php" class="logout-link">
          <span>◀</span>
          <span>Đăng xuất</span>
        </a>
      </div>
    </aside>

    <main class="main-content">
      <div class="page-content p-4">
        <h1 class="mb-4">Quản Lý Tồn Kho Sản Phẩm</h1>

        <!-- Bộ lọc và tìm kiếm -->
        <div class="card mb-3">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-3">
                <label for="searchInput" class="form-label">Tìm kiếm</label>
                <input
                  type="text"
                  class="form-control"
                  id="searchInput"
                  placeholder="Tìm theo mã, tên sách, tác giả..."
                />
              </div>
              <div class="col-md-2">
                <label for="categoryFilter" class="form-label"
                  >Lọc theo loại</label
                >
                <select class="form-select" id="categoryFilter">
                  <option value="">Tất cả loại</option>
                </select>
              </div>
              <div class="col-md-2">
                <label for="statusFilter" class="form-label"
                  >Lọc theo trạng thái</label
                >
                <select class="form-select" id="statusFilter">
                  <option value="">Tất cả trạng thái</option>
                  <option value="normal">Bình thường</option>
                  <option value="low">Sắp hết</option>
                  <option value="out">Hết hàng</option>
                  <option value="inactive">Dừng bán</option>
                </select>
              </div>
              <div class="col-md-2">
                <label class="form-label d-block">&nbsp;</label>
                <button
                  class="btn btn-primary w-100"
                  onclick="filterInventory()"
                >
                  <span>🔍</span> Tra cứu
                </button>
              </div>
              <div class="col-md-2">
                <label class="form-label d-block">&nbsp;</label>
                <button
                  class="btn btn-secondary w-100"
                  onclick="resetFilters()"
                >
                  <span>↺</span> Đặt lại
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="card card-inventory">
          <div class="card-header card-header-inventory">Tồn Kho Hiện Tại</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">Mã SP</th>
                    <th scope="col">Tên Sách</th>
                    <th scope="col" class="text-center">Loại</th>
                    <th scope="col" class="text-center">SL Còn Lại</th>
                    <th scope="col" class="text-center">Trạng Thái</th>
                    <th scope="col" class="text-center">Thời Gian Cập Nhật</th>
                    <th scope="col" class="text-center">Hành động</th>
                  </tr>
                </thead>
                <tbody id="inventoryTableBody">
                  <tr>
                    <td colspan="7" class="text-center">
                      Đang tải dữ liệu tồn kho...
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>

    <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
      // Ngưỡng cảnh báo theo yêu cầu: dưới 20 quyển
      const LOW_STOCK_THRESHOLD = 20;

      // Biến lưu trữ dữ liệu gốc
      let originalInventoryData = [];

      // --- Helper Functions ---

      /** Định dạng chuỗi ngày tháng ISO sang định dạng giờ-ngày tháng năm Việt Nam. */
      function formatDateTime(dateString) {
        if (!dateString) return "Chưa có giao dịch bán";
        try {
          const date = new Date(dateString);
          if (isNaN(date)) return "Lỗi định dạng ngày";

          const options = {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
            hour12: false,
          };
          return date.toLocaleDateString("vi-VN", options);
        } catch (e) {
          return "Chưa có giao dịch bán";
        }
      }

      /**
       * Lấy tên category từ sản phẩm
       */
      function getCategoryName(product) {
        // Trường hợp 1: Nếu có trường category trực tiếp (string)
        if (product.category) {
          return product.category;
        }

        // Trường hợp 2: Nếu có categoryId, tìm trong danh sách categories
        if (product.categoryId) {
          const data = typeof getData === "function" ? getData() : null;
          if (data && data.categories) {
            const category = data.categories.find(
              (cat) => cat.id === product.categoryId
            );
            if (category) return category.name;
          }
        }

        return "Chưa phân loại";
      }

      // --- Hành động Tương tác ---

      /**
       * Xử lý nhập thêm số lượng tồn kho.
       * @param {number} productId - ID sản phẩm.
       * @param {string} productName - Tên sản phẩm.
       */
      function handleImport(productId, productName) {
        const inputElement = document.getElementById(`inputQty_${productId}`);
        const qty = parseInt(inputElement.value);

        if (isNaN(qty) || qty <= 0) {
          alert("Vui lòng nhập số lượng hợp lệ (> 0) để nhập thêm.");
          return;
        }

        let data = typeof getData === "function" ? getData() : null;
        if (!data) return;

        const productIndex = data.products.findIndex((p) => p.id === productId);

        if (productIndex > -1) {
          const currentStock = data.products[productIndex].qty || 0;

          // Cập nhật tồn kho mới
          data.products[productIndex].qty = currentStock + qty;
          data.products[productIndex].lastStockUpdate =
            new Date().toISOString();

          // Nếu sản phẩm đang bị khóa, mở khóa (active)
          if (data.products[productIndex].status === "inactive") {
            data.products[productIndex].status = "active";
          }

          if (typeof saveData === "function") {
            saveData(data);
            alert(
              `✅ Đã nhập thêm ${qty} cuốn sách "${productName}". Tồn kho mới: ${
                currentStock + qty
              }.`
            );
            // Cập nhật lại dữ liệu và render
            originalInventoryData = generateInventoryReport();
            filterInventory();
          }
        }
      }

      /**
       * Xử lý Dừng Bán/Bán Lại (Khóa/Mở khóa sản phẩm).
       * @param {number} productId - ID sản phẩm.
       * @param {string} productName - Tên sản phẩm.
       * @param {string} currentStatus - Trạng thái hiện tại ('active' hoặc 'inactive').
       */
      function handleToggleStatus(productId, productName, currentStatus) {
        const newStatus = currentStatus === "active" ? "inactive" : "active";
        const actionText = newStatus === "inactive" ? "DỪNG BÁN" : "BÁN LẠI";

        if (
          !confirm(
            `⚠️ Bạn có chắc chắn muốn ${actionText} sách "${productName}" không?`
          )
        ) {
          return;
        }

        let data = typeof getData === "function" ? getData() : null;
        if (!data) return;

        const productIndex = data.products.findIndex((p) => p.id === productId);

        if (productIndex > -1) {
          data.products[productIndex].status = newStatus;

          if (typeof saveData === "function") {
            saveData(data);
            alert(
              `✅ Đã cập nhật trạng thái sách "${productName}" thành: ${
                newStatus === "active" ? "Đang Bán" : "Dừng Bán (Khóa)"
              }.`
            );
            // Cập nhật lại dữ liệu và render
            originalInventoryData = generateInventoryReport();
            filterInventory();
          }
        }
      }

      // --- RENDERING LOGIC ---

      /**
       * Tải danh sách categories vào dropdown filter
       */
      function loadCategoryFilter() {
        const data = typeof getData === "function" ? getData() : null;
        if (!data) return;

        const categoryFilter = document.getElementById("categoryFilter");
        if (!categoryFilter) return;

        // Xóa các option cũ (trừ "Tất cả loại")
        categoryFilter.innerHTML = '<option value="">Tất cả loại</option>';

        // Lấy danh sách category từ data.categories
        if (data.categories && data.categories.length > 0) {
          data.categories.forEach((cat) => {
            const option = document.createElement("option");
            option.value = cat.name;
            option.textContent = cat.name;
            categoryFilter.appendChild(option);
          });
        } else {
          // Nếu không có data.categories, lấy từ products
          const uniqueCategories = new Set();
          if (data.products) {
            data.products.forEach((p) => {
              const catName = getCategoryName(p);
              if (catName && catName !== "Chưa phân loại") {
                uniqueCategories.add(catName);
              }
            });

            uniqueCategories.forEach((catName) => {
              const option = document.createElement("option");
              option.value = catName;
              option.textContent = catName;
              categoryFilter.appendChild(option);
            });
          }
        }
      }

      /**
       * Lọc và tìm kiếm tồn kho
       */
      function filterInventory() {
        const searchText = document
          .getElementById("searchInput")
          .value.toLowerCase();
        const categoryFilter = document.getElementById("categoryFilter").value;
        const statusFilter = document.getElementById("statusFilter").value;

        let filteredData = originalInventoryData.filter((item) => {
          // Lọc theo text search
          const matchSearch =
            item.sku.toLowerCase().includes(searchText) ||
            item.name.toLowerCase().includes(searchText) ||
            (item.author && item.author.toLowerCase().includes(searchText)) ||
            item.category.toLowerCase().includes(searchText);

          if (!matchSearch) return false;

          // Lọc theo category
          if (categoryFilter && item.category !== categoryFilter) {
            return false;
          }

          // Lọc theo trạng thái
          if (statusFilter) {
            if (statusFilter === "out" && item.endQty > 0) return false;
            if (
              statusFilter === "low" &&
              (item.endQty === 0 || item.endQty >= LOW_STOCK_THRESHOLD)
            )
              return false;
            if (
              statusFilter === "normal" &&
              (item.endQty === 0 ||
                item.endQty < LOW_STOCK_THRESHOLD ||
                item.status === "inactive")
            )
              return false;
            if (statusFilter === "inactive" && item.status !== "inactive")
              return false;
          }

          return true;
        });

        renderInventoryTable(filteredData);
      }

      /**
       * Reset tất cả bộ lọc
       */
      function resetFilters() {
        document.getElementById("searchInput").value = "";
        document.getElementById("categoryFilter").value = "";
        document.getElementById("statusFilter").value = "";
        renderInventoryTable(originalInventoryData);
      }

      /**
       * Lấy dữ liệu tồn kho và tạo báo cáo
       */
      function generateInventoryReport() {
        const data =
          typeof getData === "function" ? getData() : { products: [] };
        const products = data.products || [];
        const report = [];

        products.forEach((p) => {
          const endQty = p.qty || 0;
          const lastUpdate = p.lastStockUpdate || null;
          const status = p.status || "active"; // Mặc định là 'active'

          let stockStatusText = "";
          let rowClass = "";
          let actionElements = "";
          let statusBadge = "";

          // Xác định trạng thái tồn kho
          if (endQty <= 0) {
            stockStatusText = "HẾT HÀNG";
            rowClass = "table-danger";
          } else if (endQty < LOW_STOCK_THRESHOLD) {
            stockStatusText = "SẮP HẾT!";
            rowClass = "table-warning";
          } else {
            stockStatusText = "Bình thường";
          }

          // Xác định trạng thái bán hàng và hành động
          if (status === "inactive") {
            statusBadge =
              '<span class="badge bg-secondary">KHÓA/DỪNG BÁN</span>';
            rowClass = "table-secondary"; // Ưu tiên màu khóa/dừng bán
            actionElements = `<button class="btn btn-success btn-action-small" onclick="handleToggleStatus(${
              p.id
            }, '${p.name.replace(
              /'/g,
              "\\'"
            )}', '${status}')">Bán Lại</button>`;
          } else {
            statusBadge = `<span class="badge bg-${
              endQty < LOW_STOCK_THRESHOLD ? "danger" : "success"
            }">${stockStatusText}</span>`;

            // Thêm ô nhập số lượng
            actionElements += `<input type="number" id="inputQty_${p.id}" class="input-qty" value="10" min="1">`;
            actionElements += `<button class="btn btn-primary btn-action-small" onclick="handleImport(${
              p.id
            }, '${p.name.replace(/'/g, "\\'")}')">Nhập Thêm</button>`;

            // Nút Dừng Bán
            actionElements += `<button class="btn btn-danger btn-action-small" onclick="handleToggleStatus(${
              p.id
            }, '${p.name.replace(
              /'/g,
              "\\'"
            )}', '${status}')">Dừng Bán</button>`;
          }

          report.push({
            id: p.id,
            sku: p.sku || "N/A",
            name: p.name || "Sản phẩm không tên",
            author: p.author || "",
            category: getCategoryName(p),
            endQty: endQty,
            lastUpdate: formatDateTime(lastUpdate),
            rowClass: rowClass,
            statusBadge: statusBadge,
            actionElements: actionElements,
            status: status,
          });
        });

        return report;
      }

      /**
       * Hiển thị dữ liệu báo cáo lên bảng.
       */
      function renderInventoryTable(reportData) {
        const tableBody = document.getElementById("inventoryTableBody");
        if (!tableBody) return;

        let html = "";

        if (reportData.length === 0) {
          html =
            '<tr><td colspan="7" class="text-center">Không có dữ liệu tồn kho sách.</td></tr>';
        } else {
          reportData.forEach((item) => {
            const qtyClass =
              item.rowClass === "table-danger" ||
              item.rowClass === "table-warning"
                ? "text-danger fw-bold"
                : "";

            html += `
                        <tr class="${item.rowClass}">
                            <td>${item.sku}</td>
                            <td>${item.name}</td>
                            <td class="text-center">${item.category}</td>
                            <td class="text-center ${qtyClass}">${item.endQty}</td>
                            <td class="text-center">${item.statusBadge}</td>
                            <td class="text-center">${item.lastUpdate}</td>
                            <td class="text-center">${item.actionElements}</td>
                        </tr>
                    `;
          });
        }
        tableBody.innerHTML = html;
      }

      /**
       * Hàm khởi tạo chính
       */
      function initInventoryPage() {
        if (typeof getData !== "function") {
          document.getElementById("inventoryTableBody").innerHTML =
            '<tr><td colspan="7" class="text-center text-danger fw-bold">Lỗi: Cần import main.js và đảm bảo hàm getData()/saveData() tồn tại.</td></tr>';
          console.error(
            "Lỗi: Hàm getData() không tồn tại. Vui lòng đảm bảo main.js đã được import."
          );
          return;
        }

        originalInventoryData = generateInventoryReport();
        loadCategoryFilter();
        renderInventoryTable(originalInventoryData);
      }

      // Chạy hàm khởi tạo khi DOM đã load
      document.addEventListener("DOMContentLoaded", initInventoryPage);
    </script>
    <a href="#" class="back-to-top" title="Lên đầu trang">
      <i class="bi bi-chevron-up">
        <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
      </i>
    </a>
  </body>
</html>
