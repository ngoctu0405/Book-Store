<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quản lý Sản phẩm</title>
    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />
    <link
      rel="stylesheet"
      href="../bootstrap-5.3.2-dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../assets/css/admin_style.css" />

    <style>
      .product-image-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
      }

      .status-tag {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
      }

      .status-active {
        background-color: #d4edda;
        color: #155724;
      }

      .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
      }

      .image-preview-container {
        position: relative;
        display: inline-block;
      }
      .remove-image-btn {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #dc3545;
        color: white;
        border: 2px solid white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        line-height: 1;
        text-align: center;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
      }

      #product-price {
        background-color: #e9f5ff;
        font-weight: bold;
        color: #0d6efd;
      }

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
          min-width: 600px; /* Vẫn cần min-width cho bảng */
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

      .image-preview-container {
        position: relative;
        display: inline-block;
      }
      .remove-image-btn {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #dc3545;
        color: white;
        border: 2px solid white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        line-height: 1;
        text-align: center;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
      }

      #product-price {
        background-color: #e9f5ff;
        font-weight: bold;
        color: #0d6efd;
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
          <a href="products.php" class="nav-link active">
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
          <a href="inventory.php" class="nav-link">
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
      <div class="container-fluid py-4">
        <div class="card shadow-sm">
          <div
            class="card-header d-flex justify-content-between align-items-center"
          >
            <h1 class="h3 mb-0">Quản lý Sản phẩm</h1>
            <button class="btn btn-primary" onclick="openProductModal(null)">
              + Thêm Sản phẩm
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th>Mã ID</th>
                    <th>Mã SKU</th>
                    <th>Tên Sản phẩm</th>
                    <th>Loại</th>
                    <th>Giá (VND)</th>
                    <th>Tồn kho</th>
                    <th>Hiện trạng</th>
                    <th>Hình Ảnh</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody id="productListTableBody"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>

    <div
      class="modal fade"
      id="productModal"
      tabindex="-1"
      aria-labelledby="productModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">
              Thêm Sản phẩm Mới
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form id="productForm">
              <input type="hidden" id="product-edit-id" />

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="product-id-display" class="form-label"
                      >Mã ID (Tự động tạo)</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="product-id-display"
                      disabled
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-sku" class="form-label">Mã SKU</label>
                    <input
                      type="text"
                      class="form-control"
                      id="product-sku"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-name" class="form-label"
                      >Tên Sản phẩm</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="product-name"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-author" class="form-label"
                      >Tác giả</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="product-author"
                      placeholder="Nhập tên tác giả"
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-category" class="form-label"
                      >Loại (Category)</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="product-category"
                      required
                      placeholder="Ví dụ: Văn học"
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-subcategory" class="form-label"
                      >Phân loại chi tiết (Subcategory)</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="product-subcategory"
                      required
                      placeholder="Ví dụ: Tiểu thuyết"
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-unit" class="form-label"
                      >Đơn vị tính</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="product-unit"
                      required
                      placeholder="Ví dụ: Cuốn, Quyển"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="product-costPrice" class="form-label"
                      >💰 Giá gốc (VND)</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      id="product-costPrice"
                      min="0"
                      value="0"
                      oninput="calculateSellingPrice()"
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-profitMargin" class="form-label"
                      >Tỉ lệ lợi nhuận mong muốn (%)</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      id="product-profitMargin"
                      min="0"
                      max="100"
                      value="0"
                      oninput="calculateSellingPrice()"
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-price" class="form-label"
                      >💵 Giá bán (tính toán, VND)</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      id="product-price"
                      min="0"
                      value="0"
                      readonly
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-qty" class="form-label"
                      >Số lượng (Tồn kho)</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      id="product-qty"
                      required
                      min="0"
                      value="0"
                    />
                  </div>
                  <div class="mb-3">
                    <label for="product-status" class="form-label"
                      >Hiện trạng</label
                    >
                    <select class="form-select" id="product-status" required>
                      <option value="active">Đang bán</option>
                      <option value="inactive">Dừng bán (Hết bán/Ẩn)</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="product-image-upload" class="form-label"
                      >Hình ảnh</label
                    >
                    <input
                      class="form-control"
                      type="file"
                      id="product-image-upload"
                      accept="image/*"
                    />
                    <div id="image-preview-area" class="mt-2"></div>
                    <input type="hidden" id="product-img-path" />
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="product-desc" class="form-label">Mô tả</label>
                <textarea
                  class="form-control"
                  id="product-desc"
                  rows="3"
                  required
                ></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Đóng
            </button>
            <button
              type="button"
              class="btn btn-primary"
              onclick="handleSaveProduct()"
            >
              Lưu Sản phẩm
            </button>
          </div>
        </div>
      </div>
    </div>

    <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
      const productModal = new bootstrap.Modal(
        document.getElementById("productModal")
      );

      function renderProductTable() {
        const data = getData();
        const products = data.products || [];

        const tableBody = document.getElementById("productListTableBody");
        tableBody.innerHTML = "";

        if (products.length === 0) {
          tableBody.innerHTML =
            '<tr><td colspan="9" class="text-center">Chưa có sản phẩm nào.</td></tr>';
          return;
        }

        products.forEach((p) => {
          let statusClass = "";
          let statusText = "";

          if (p.status === "inactive") {
            statusClass = "status-inactive";
            statusText = "Dừng bán";
          } else {
            statusClass = "status-active";
            statusText = "Đang bán";
          }

          const imagePath = p.img ? "../" + p.img : "../images/placeholder.png";

          const row = `
                <tr>
                    <td>${p.id}</td>
                    <td>${p.sku}</td>
                    <td>${p.name}</td>
                    <td>${p.category}</td>
                    <td class="text-end">${(p.price || 0).toLocaleString(
                      "vi-VN"
                    )}đ</td>
                    <td class="text-center">${p.qty}</td>
                    <td><span class="status-tag ${statusClass}">${statusText}</span></td>
                    <td>
                        <img src="${imagePath}" alt="${
            p.name
          }" class="product-image-thumbnail">
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="openProductModal(${
                          p.id
                        })">Sửa</button>
                    </td>
                </tr>
            `;
          tableBody.innerHTML += row;
        });
      }

      function openProductModal(productId = null) {
        document.getElementById("productForm").reset();
        removeImagePreview();

        if (productId) {
          document.getElementById("productModalLabel").textContent =
            "Sửa Sản phẩm";

          const data = getData();
          const product = data.products.find((p) => p.id === productId);

          if (!product) {
            alert("Không tìm thấy sản phẩm!");
            return;
          }

          document.getElementById("product-edit-id").value = product.id;
          document.getElementById("product-id-display").value = product.id;

          document.getElementById("product-sku").value = product.sku;
          document.getElementById("product-name").value = product.name;
          document.getElementById("product-author").value = product.author;
          document.getElementById("product-category").value = product.category;
          document.getElementById("product-subcategory").value =
            product.subcategory;
          document.getElementById("product-unit").value =
            product.unit || "Quyển";
          document.getElementById("product-desc").value = product.desc;
          document.getElementById("product-qty").value = product.qty;
          document.getElementById("product-costPrice").value =
            product.costPrice || product.price;
          document.getElementById("product-profitMargin").value =
            product.profitMargin || 0;
          document.getElementById("product-status").value =
            product.status || "active";

          if (product.img) {
            document.getElementById("product-img-path").value = product.img;
            showImagePreview("../" + product.img);
          }
        } else {
          document.getElementById("productModalLabel").textContent =
            "Thêm Sản phẩm Mới";

          document.getElementById("product-edit-id").value = "";
          document.getElementById("product-id-display").value = "(Tự động tạo)";

          document.getElementById("product-unit").value = "Quyển";
          document.getElementById("product-status").value = "active";
        }

        calculateSellingPrice();
        productModal.show();
      }

      function handleSaveProduct() {
        const id = document.getElementById("product-edit-id").value
          ? parseInt(document.getElementById("product-edit-id").value)
          : null;

        const productData = {
          id: id,
          sku: document.getElementById("product-sku").value,
          name: document.getElementById("product-name").value,
          author: document.getElementById("product-author").value,
          category: document.getElementById("product-category").value,
          subcategory: document.getElementById("product-subcategory").value,
          unit: document.getElementById("product-unit").value,
          desc: document.getElementById("product-desc").value,
          qty: parseInt(document.getElementById("product-qty").value) || 0,
          costPrice:
            parseFloat(document.getElementById("product-costPrice").value) || 0,
          profitMargin:
            parseFloat(document.getElementById("product-profitMargin").value) ||
            0,
          price:
            parseFloat(document.getElementById("product-price").value) || 0,
          status: document.getElementById("product-status").value,
          img: document.getElementById("product-img-path").value,
        };

        let data = getData();

        if (id) {
          const index = data.products.findIndex((p) => p.id === id);
          if (index > -1) {
            data.products[index] = { ...data.products[index], ...productData };
          }
        } else {
          productData.id =
            data.products.reduce((max, p) => (p.id > max ? p.id : max), 0) + 1;
          data.products.push(productData);
        }

        saveData(data);

        productModal.hide();
        renderProductTable();
        alert("Lưu sản phẩm thành công!");
      }

      function calculateSellingPrice() {
        const costPrice =
          parseFloat(document.getElementById("product-costPrice").value) || 0;
        const profitMargin =
          parseFloat(document.getElementById("product-profitMargin").value) ||
          0;
        const calculatedPrice = costPrice * (1 + profitMargin / 100);
        const roundedPrice = Math.round(calculatedPrice / 1000) * 1000;
        document.getElementById("product-price").value = roundedPrice;
      }

      function handleImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
          const base64Image = e.target.result;
          document.getElementById("product-img-path").value = base64Image;
          showImagePreview(base64Image);
        };
        reader.readAsDataURL(file);
      }

      function showImagePreview(imageBase64OrPath) {
        const previewArea = document.getElementById("image-preview-area");
        previewArea.innerHTML = `
                <div class="image-preview-container">
                    <img src="${imageBase64OrPath}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 5px;">
                    <span class="remove-image-btn" onclick="removeImagePreview()">✕</span>
                </div>
            `;
      }

      function removeImagePreview() {
        document.getElementById("image-preview-area").innerHTML = "";
        document.getElementById("product-img-path").value = "";
        document.getElementById("product-image-upload").value = null;
      }

      document
        .getElementById("product-image-upload")
        .addEventListener("change", handleImageUpload);
      document
        .getElementById("product-costPrice")
        .addEventListener("input", calculateSellingPrice);
      document
        .getElementById("product-profitMargin")
        .addEventListener("input", calculateSellingPrice);

      document.addEventListener("DOMContentLoaded", renderProductTable);
    </script>
    <a href="#" class="back-to-top" title="Lên đầu trang">
      <i class="bi bi-chevron-up">
        <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
      </i>
    </a>
  </body>
</html>
