// --- 1. HÀM HỖ TRỢ (HELPER FUNCTIONS) ---

/**
 * Lấy dữ liệu từ localStorage
 * @param {string} key Tên của "bảng" (vd: 'bs_users')
 * @returns {any} Dữ liệu đã parse (thường là Array hoặc Object)
 */
function db_get(key) {
  const data = localStorage.getItem(key);
  // Trả về mảng rỗng làm mặc định cho các "bảng" (orders, users, categories, purchases)
  // Trả về object rỗng cho 'bs_data' (vì nó chứa { products: [] })
  const defaultData = key === "bs_data" ? { products: [] } : [];

  try {
    return JSON.parse(data) || defaultData;
  } catch (e) {
    return defaultData;
  }
}

/**
 * Lưu dữ liệu vào localStorage
 * @param {string} key Tên của "bảng"+6
 * @param {any} data Dữ liệu để lưu
 */
function db_save(key, data) {
  localStorage.setItem(key, JSON.stringify(data));
}

/**
 * Định dạng số thành tiền tệ (vd: 10000 -> "10.000đ")
 */
function formatCurrency(value) {
  if (isNaN(value) || value === null) value = 0;
  return `${value.toLocaleString("vi-VN")}đ`;
}

/**
 * Chuyển chuỗi tiền tệ về số (vd: "10.000đ" -> 10000)
 */
function parseCurrency(value) {
  if (typeof value !== "string") return 0;
  return parseInt(value.replace(/[^0-9]/g, ""), 10) || 0;
}

// --- 2. LOGIC CHÍNH (Chạy khi DOM đã tải) ---

document.addEventListener("DOMContentLoaded", function () {
  const currentPage =
    window.location.pathname.split("/").pop() || "dashboard.html";

  // --- 3. LOGIC TOÀN CỤC (HIGHLIGHT SIDEBAR) ---

  function initGlobal() {
    const sidebarLinks = document.querySelectorAll(".sidebar .nav-link");
    sidebarLinks.forEach((link) => {
      link.classList.remove("active");
      // So sánh href của link với trang hiện tại
      const linkHref = link.getAttribute("href").split("/").pop();
      if (linkHref === currentPage) {
        link.classList.add("active");
      }
    });
  }

  // --- 4. LOGIC TỪNG TRANG ---

  /**
   * Trang: users.html
   */
  function initUsersPage() {
    const tableBody = document.getElementById("user-table-body");
    if (!tableBody) return; // Chỉ chạy trên trang users.html

    // Logic cho Modal Thêm User
    const addUserForm = document.getElementById("addUserForm");
    const addUserModalElement = document.getElementById("addUserModal");

    if (addUserForm && addUserModalElement) {
      const addUserModal = new bootstrap.Modal(addUserModalElement);

      addUserForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const fullName = document.getElementById("add-fullName").value;
        const username = document.getElementById("add-username").value;
        const email = document.getElementById("add-email").value;
        const password = document.getElementById("add-password").value;
        const phone = document.getElementById("add-phone").value;
        const address = document.getElementById("add-address").value;

        if (password.length < 6) {
          alert("Mật khẩu phải có ít nhất 6 ký tự.");
          return;
        }

        let users = db_get("bs_users");
        const emailExists = users.some((user) => user.email === email);
        const usernameExists = users.some((user) => user.username === username);

        if (emailExists) {
          alert("Email này đã được sử dụng.");
          return;
        }
        if (usernameExists) {
          alert("Tên tài khoản này đã được sử dụng.");
          return;
        }

        const newUser = {
          id: Date.now(),
          fullName: fullName,
          username: username,
          email: email,
          password: password,
          phone: phone,
          address: address,
          status: "active",
          createdAt: new Date().toISOString(),
        };

        users.push(newUser);
        db_save("bs_users", users);

        alert("Tạo tài khoản khách hàng thành công!");
        addUserForm.reset();
        addUserModal.hide();
        window.location.reload();
      });
    }

    // Logic render bảng User
    const users = db_get("bs_users");
    tableBody.innerHTML = "";

    if (users.length === 0) {
      tableBody.innerHTML = `<tr><td colspan="5" class="text-center">Chưa có tài khoản nào đăng ký</td></tr>`;
      return;
    }

    users.forEach((user) => {
      const row = document.createElement("tr");
      const statusClass = user.status === "active" ? "delivered" : "pending";
      const statusText = user.status === "active" ? "Hoạt động" : "Đã khóa";
      const lockButtonText = user.status === "active" ? "Khóa" : "Mở khóa";
      const lockButtonClass =
        user.status === "active" ? "btn-outline-danger" : "btn-outline-success";

      const registerDate = user.createdAt
        ? new Date(user.createdAt).toLocaleDateString("vi-VN")
        : "Không xác định";

      row.innerHTML = `
                <td>${user.fullName || "(Không có tên)"}</td>
                <td>${user.email || "(Không có email)"}</td>
                <td>${registerDate}</td>
                <td><span class="status ${statusClass}">${statusText}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-warning btn-reset" data-userid="${
                      user.id
                    }">
                        Đổi MK
                    </button>
                    <button class="btn btn-sm ${lockButtonClass} btn-lock" data-userid="${
        user.id
      }">
                        ${lockButtonText}
                    </button>
                </td>
            `;
      tableBody.appendChild(row);
    });

    // Xử lý click (Reset MK, Khóa)
    tableBody.addEventListener("click", function (event) {
      const target = event.target;
      const userId = target.dataset.userid;
      if (!userId) return;

      let users = db_get("bs_users");

      // Khóa / Mở khóa
      if (target.classList.contains("btn-lock")) {
        users = users.map((u) => {
          if (u.id.toString() === userId) {
            u.status = u.status === "active" ? "locked" : "active";
          }
          return u;
        });
        db_save("bs_users", users);
        alert("Cập nhật trạng thái tài khoản thành công!");
        window.location.reload();
      }

      // Reset mật khẩu
      if (target.classList.contains("btn-reset")) {
        const newPassword = prompt("Nhập mật khẩu mới (ít nhất 6 ký tự):");
        if (!newPassword) return;
        if (newPassword.length < 6) {
          alert("Mật khẩu quá ngắn. Thao tác đã hủy.");
          return;
        }
        users = users.map((u) => {
          if (u.id.toString() === userId) {
            u.password = newPassword;
          }
          return u;
        });
        db_save("bs_users", users);
        alert("Reset mật khẩu thành công!");
      }
    });
  }

  /**
   * Trang: purchase-orders.html (Danh sách phiếu nhập)
   */
  function initPurchaseOrdersPage() {
    const tableBody = document.getElementById("po-table-body");
    if (!tableBody) return;

    const purchases = db_get("bs_purchase_orders");

    // Hàm để render bảng
    function renderTable(data) {
      tableBody.innerHTML = "";
      if (data.length === 0) {
        tableBody.innerHTML =
          '<tr><td colspan="6" class="text-center">Không tìm thấy phiếu nhập nào.</td></tr>';
        return;
      }
      // Sắp xếp mới nhất lên trước
      data.sort((a, b) => b.id - a.id);

      data.forEach((p) => {
        const row = document.createElement("tr");
        const statusText =
          p.status === "completed" ? "Đã hoàn thành" : "Chưa hoàn thành";
        const statusClass = p.status === "completed" ? "delivered" : "pending";
        // Tính tổng số lượng sách trong phiếu
        const totalItems = p.items.reduce(
          (sum, item) => sum + item.quantity,
          0
        );

        row.innerHTML = `
                    <td>#${p.id}</td>
                    <td>${new Date(p.date).toLocaleDateString("vi-VN")}</td>
                    <td>${totalItems}</td>
                    <td>${formatCurrency(p.totalCost)}</td>
                    <td><span class="status ${statusClass}">${statusText}</span></td>
                    <td>
                        <a href="purchase-edit.html?id=${
                          p.id
                        }" class="btn btn-sm btn-outline-primary">
                            ${p.status === "completed" ? "Xem" : "Sửa"}
                        </a>
                    </td>
                `;
        tableBody.appendChild(row);
      });
    }

    // Hiển thị tất cả ban đầu
    renderTable(purchases);

    // Xử lý Lọc (Theo yêu cầu của bạn)
    const filterBtn = document.getElementById("filter-po-btn");
    if (filterBtn) {
      filterBtn.addEventListener("click", function () {
        const poId = document.getElementById("filter-po-id").value.trim();
        const startDate = document.getElementById("filter-start-date").value;
        const endDate = document.getElementById("filter-end-date").value;
        const status = document.getElementById("filter-status").value;

        let filtered = purchases;

        // Lọc theo Mã phiếu
        if (poId) {
          filtered = filtered.filter((p) => p.id.toString().includes(poId));
        }
        // Lọc theo Trạng thái
        if (status) {
          filtered = filtered.filter((p) => p.status === status);
        }

        // Lọc theo Ngày
        const start = startDate ? new Date(startDate) : null;
        const end = endDate ? new Date(endDate) : null;
        if (start) start.setHours(0, 0, 0, 0);
        if (end) end.setHours(23, 59, 59, 999);

        if (start) {
          filtered = filtered.filter((p) => new Date(p.date) >= start);
        }
        if (end) {
          filtered = filtered.filter((p) => new Date(p.date) <= end);
        }

        renderTable(filtered);
      });
    }
  }

  /**
   * Trang: purchase-edit.html (Thêm/Sửa phiếu nhập)
   */
  function initPurchaseEditPage() {
    // Lấy các thành phần DOM
    const title = document.getElementById("po-page-title");
    const productSelect = document.getElementById("po-product-select");
    const costInput = document.getElementById("po-cost-price");
    const qtyInput = document.getElementById("po-quantity");
    const addBtn = document.getElementById("po-add-item-btn");
    const itemsTbody = document.getElementById("po-items-tbody");
    const totalCostCell = document.getElementById("po-total-cost");
    const dateInput = document.getElementById("po-date");
    const statusDisplay = document.getElementById("po-status-display");
    const saveDraftBtn = document.getElementById("po-save-draft-btn");
    const completeBtn = document.getElementById("po-complete-btn");
    const actionButtons = document.getElementById("po-action-buttons");
    const addItemCard = document.getElementById("po-add-item-card");

    if (!productSelect) return; // Chỉ chạy trên trang purchase-edit

    let tempItems = []; // Mảng lưu các sản phẩm trong phiếu
    const urlParams = new URLSearchParams(window.location.search);
    const poId = urlParams.get("id"); // Lấy ID từ URL
    let allProducts = []; // Sẽ lưu danh sách sản phẩm
    let isCompleted = false;

    // 1. Tải sản phẩm (sách) vào dropdown
    function loadProductsIntoSelect() {
      const data = db_get("bs_data"); // Lấy từ db sản phẩm của bạn
      if (!data || !data.products) {
        productSelect.innerHTML =
          '<option value="">Lỗi: Không tìm thấy bs_data</option>';
        return;
      }
      allProducts = data.products;
      productSelect.innerHTML =
        '<option value="">-- Chọn sách (Tìm theo tên hoặc SKU) --</option>';
      // Sắp xếp theo tên
      allProducts.sort((a, b) => a.name.localeCompare(b.name));

      allProducts.forEach((p) => {
        productSelect.innerHTML += `<option value="${p.id}">${p.name} (SKU: ${p.sku})</option>`;
      });
    }

    // 2. Render lại bảng chi tiết
    function renderItemsTable() {
      itemsTbody.innerHTML = "";
      let total = 0;
      tempItems.forEach((item, index) => {
        const lineTotal = item.cost * item.quantity;
        total += lineTotal;
        const row = document.createElement("tr");
        row.innerHTML = `
                    <td>${item.productName}</td>
                    <td>${formatCurrency(item.cost)}</td>
                    <td>${item.quantity}</td>
                    <td class="text-end">${formatCurrency(lineTotal)}</td>
                    <td class="text-end">
                        ${
                          !isCompleted
                            ? `<button class="btn btn-sm btn-outline-danger btn-delete-item" data-index="${index}">Xóa</button>`
                            : ""
                        }
                    </td>
                `;
        itemsTbody.appendChild(row);
      });
      totalCostCell.textContent = formatCurrency(total);
    }

    // 3. Xử lý lưu phiếu (Lưu tạm hoặc Hoàn thành)
    function savePurchaseOrder(status) {
      if (tempItems.length === 0) {
        alert("Bạn phải thêm ít nhất 1 sản phẩm vào phiếu.");
        return;
      }

      const totalCost = parseCurrency(totalCostCell.textContent);
      let allPurchases = db_get("bs_purchase_orders");

      const poData = {
        id: poId ? parseInt(poId) : Date.now(),
        date: dateInput.value,
        status: status,
        items: tempItems,
        totalCost: totalCost,
      };

      if (poId) {
        // Chế độ Sửa
        allPurchases = allPurchases.map((p) =>
          p.id === parseInt(poId) ? poData : p
        );
      } else {
        // Chế độ Tạo mới
        allPurchases.push(poData);
      }

      db_save("bs_purchase_orders", allPurchases);

      // Nếu Hoàn thành, cập nhật kho (YÊU CẦU CỦA BẠN)
      if (status === "completed") {
        updateStockAndCost();
      }

      alert(
        `Đã ${status === "completed" ? "Hoàn thành" : "Lưu tạm"} phiếu nhập!`
      );
      window.location.href = "purchase-orders.html";
    }

    // 4. Hàm cập nhật Tồn kho (Stock) và Giá nhập (CostPrice)
    function updateStockAndCost() {
      let data = db_get("bs_data"); // Lấy kho sản phẩm
      tempItems.forEach((item) => {
        const productIndex = data.products.findIndex(
          (p) => p.id === item.productId
        );
        if (productIndex > -1) {
          // Cập nhật số lượng
          data.products[productIndex].qty =
            (data.products[productIndex].qty || 0) + item.quantity;
          // Cập nhật giá nhập (giá vốn) mới nhất
          data.products[productIndex].costPrice = item.cost;
        }
      });
      db_save("bs_data", data); // Lưu lại kho sản phẩm
    }

    // 5. Vô hiệu hóa form nếu đã hoàn thành (YÊU CẦU CỦA BẠN)
    function disableForm() {
      isCompleted = true;
      title.textContent = `Chi tiết Phiếu nhập #${poId} (Đã hoàn thành)`;
      statusDisplay.innerHTML =
        '<span class="status delivered d-block w-100">Đã hoàn thành</span>';
      addItemCard.style.display = "none"; // Ẩn form thêm SP
      actionButtons.innerHTML =
        '<p class="text-success text-center fw-bold">Phiếu đã hoàn thành, không thể sửa.</p>'; // Xóa các nút
      dateInput.disabled = true;
    }

    // 6. Gán sự kiện
    // Nút Thêm sản phẩm
    addBtn.addEventListener("click", function () {
      const productId = parseInt(productSelect.value);
      const product = allProducts.find((p) => p.id === productId);
      const cost = parseInt(costInput.value) || 0;
      const quantity = parseInt(qtyInput.value) || 1;

      if (!product) {
        alert("Vui lòng chọn một sản phẩm.");
        return;
      }
      if (cost <= 0) {
        alert("Vui lòng nhập giá nhập hợp lệ.");
        return;
      }

      // Kiểm tra xem SP đã có trong list chưa
      const existingItem = tempItems.find(
        (item) => item.productId === productId
      );
      if (existingItem) {
        alert(
          "Sản phẩm này đã có trong phiếu. Bạn có thể xóa và thêm lại với số lượng mới."
        );
        return;
      }

      tempItems.push({
        productId: product.id,
        productName: product.name,
        cost: cost,
        quantity: quantity,
      });

      renderItemsTable();
      // Reset form
      productSelect.selectedIndex = 0;
      costInput.value = "";
      qtyInput.value = "1";
    });

    // Nút Xóa (trong bảng)
    itemsTbody.addEventListener("click", function (e) {
      if (e.target.classList.contains("btn-delete-item")) {
        const index = parseInt(e.target.dataset.index);
        if (confirm("Bạn có chắc muốn xóa sản phẩm này khỏi phiếu?")) {
          tempItems.splice(index, 1);
          renderItemsTable();
        }
      }
    });

    // Nút Lưu
    saveDraftBtn.addEventListener("click", () => savePurchaseOrder("pending"));
    completeBtn.addEventListener("click", () => {
      if (
        confirm(
          "Bạn có chắc muốn hoàn thành phiếu nhập này? \n\n⚠️ HÀNH ĐỘNG NÀY SẼ CẬP NHẬT TỒN KHO VÀ KHÔNG THỂ SỬA LẠI."
        )
      ) {
        savePurchaseOrder("completed");
      }
    });

    // 7. Khởi tạo trang
    loadProductsIntoSelect();

    if (poId) {
      // Chế độ Sửa/Xem
      const purchases = db_get("bs_purchase_orders");
      const po = purchases.find((p) => p.id === parseInt(poId));

      if (po) {
        title.textContent = `Sửa Phiếu nhập #${po.id}`;
        dateInput.value = po.date;
        tempItems = po.items;

        if (po.status === "completed") {
          disableForm();
        } else {
          statusDisplay.innerHTML =
            '<span class="status pending d-block w-100">Chưa hoàn thành</span>';
        }
      } else {
        alert("Không tìm thấy phiếu nhập!");
        window.location.href = "purchase-orders.html";
      }
    } else {
      // Chế độ Tạo mới
      dateInput.value = new Date().toISOString().split("T")[0]; // Set ngày hôm nay
    }

    renderItemsTable(); // Render lần đầu
  }

  /**
   * Trang: orders.html
   */
  function initOrdersPage() {
    const tableBody = document.getElementById("order-table-body");
    if (!tableBody) return;

    const orders = db_get("bs_orders");

    // Hàm render
    function renderTable(filteredOrders) {
      tableBody.innerHTML = "";

      if (filteredOrders.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Không tìm thấy đơn hàng nào khớp.</td></tr>`;
        return;
      }

      // Sắp xếp mới nhất lên đầu
      filteredOrders.sort((a, b) => b.id - a.id);

      filteredOrders.forEach((order) => {
        const row = document.createElement("tr");
        const statusClassMap = {
          "Chờ xử lý": "pending",
          "Đã xử lý": "processed",
          "Đã giao": "delivered",
          "Đã hủy": "cancelled",
        };

        row.innerHTML = `
                    <td>#${order.id}</td>
                    <td>${
                      order.shippingAddress.name || `User: ${order.userId}`
                    }</td>
                    <td>${new Date(order.date).toLocaleDateString("vi-VN")}</td>
                    <td>${formatCurrency(order.total)}</td>
                    <td><span class="status ${
                      statusClassMap[order.status] || "pending"
                    }">${order.status}</span></td>
                    <td>
                        <a href="order-detail.html?id=${
                          order.id
                        }" class="btn btn-sm btn-outline-primary">Xem</a>
                    </td>
                `;
        tableBody.appendChild(row);
      });
    }

    // Hiển thị tất cả ban đầu
    renderTable(orders);

    // Gắn sự kiện cho nút Lọc
    const filterBtn = document.getElementById("filter-btn");
    if (filterBtn) {
      filterBtn.addEventListener("click", function () {
        const statusFilter = document.getElementById("filter-status").value;
        const addressFilter = document
          .getElementById("filter-address")
          .value.toLowerCase()
          .trim();
        const startDate = document.getElementById("filter-start-date").value;
        const endDate = document.getElementById("filter-end-date").value;

        let filtered = orders;

        if (statusFilter) {
          filtered = filtered.filter((o) => o.status === statusFilter);
        }
        if (addressFilter) {
          filtered = filtered.filter(
            (o) =>
              o.shippingAddress &&
              o.shippingAddress.address.toLowerCase().includes(addressFilter)
          );
        }

        const start = startDate ? new Date(startDate) : null;
        const end = endDate ? new Date(endDate) : null;
        if (start) start.setHours(0, 0, 0, 0);
        if (end) end.setHours(23, 59, 59, 999);

        if (start) {
          filtered = filtered.filter((o) => new Date(o.date) >= start);
        }
        if (end) {
          filtered = filtered.filter((o) => new Date(o.date) <= end);
        }
        renderTable(filtered);
      });
    }
  }

  /*
   * Trang: order-detail.html
   */
  function initOrderDetailPage() {
    const form = document.getElementById("orderDetailForm");
    const statusSelect = document.getElementById("order-status");
    if (!form || !statusSelect) return;

    const urlParams = new URLSearchParams(window.location.search);
    const orderId = parseInt(urlParams.get("id"));

    if (!orderId) {
      alert("Không tìm thấy ID đơn hàng.");
      window.location.href = "orders.html";
      return;
    }

    let orders = db_get("bs_orders");
    let order = orders.find((o) => o.id === orderId);

    if (!order) {
      alert("Không tìm thấy đơn hàng");
      window.location.href = "orders.html";
      return;
    }

    // --- 1. Đổ dữ liệu vào HTML ---
    document.getElementById(
      "order-title"
    ).textContent = `Chi tiết Đơn hàng #${order.id}`;

    const customerInfo = document.getElementById("customer-info");
    if (customerInfo) {
      const addr = order.shippingAddress;
      customerInfo.innerHTML = `
                <strong>${addr.name} (User: ${order.userId})</strong>
                <p class="mb-1">${order.paymentMethod}</p>
                <p class="mb-0">${addr.phone}</p>
                <hr>
                <strong>Địa chỉ giao hàng</strong>
                <p class="mb-0">${addr.address}</p>
            `;
    }

    const productTable = document.getElementById("product-items-table");
    if (productTable) {
      productTable.innerHTML = "";
      order.items.forEach((item) => {
        const product = item.product; // Dữ liệu sản phẩm đã được lưu trong đơn hàng
        productTable.innerHTML += `
                    <tr>
                        <td>
                            <img src="../${product.img}" alt="${
          product.name
        }" class="item-image" style="width: 60px; height: 80px; object-fit: cover;">
                        </td>
                        <td>
                            <strong>${product.name}</strong><br>
                            <span class="text-muted">SKU: ${product.sku}</span>
                        </td>
                        <td>x ${item.qty}</td>
                        <td class="text-end">${formatCurrency(
                          item.itemTotal
                        )}</td>
                    </tr>
                `;
      });
    }

    const subtotal = order.total - (order.shippingAddress.shipping || 0);
    const shipping = order.shippingAddress.shipping || 0;

    document.getElementById("summary-subtotal").textContent =
      formatCurrency(subtotal);
    document.getElementById("summary-shipping").textContent =
      formatCurrency(shipping);
    document.getElementById("summary-total").textContent = formatCurrency(
      order.total
    );

    // --- 2. Xử lý Cập nhật trạng thái ---
    statusSelect.value = order.status;

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const newStatus = statusSelect.value;
      const oldStatus = order.status;

      if (newStatus === oldStatus) {
        alert("Trạng thái không đổi.");
        return;
      }

      // Logic trừ/hoàn kho
      let data = db_get("bs_data");
      let products = data.products || [];
      let stockChanged = false;

      // TRỪ KHO: Khi chuyển sang "Đã giao"
      if (oldStatus !== "Đã giao" && newStatus === "Đã giao") {
        let stockOk = true;
        for (const item of order.items) {
          const product = products.find((p) => p.id === item.id);
          if (!product || (product.qty || 0) < item.qty) {
            stockOk = false;
            alert(
              `Không đủ tồn kho cho sản phẩm: ${product.name} (Còn ${
                product.qty || 0
              }, Cần ${item.qty})`
            );
            statusSelect.value = oldStatus; // Reset dropdown
            break;
          }
        }
        if (!stockOk) return; // Dừng nếu không đủ kho

        order.items.forEach((item) => {
          products = products.map((p) => {
            if (p.id === item.id) {
              p.qty = (p.qty || 0) - item.qty;
            }
            return p;
          });
        });
        stockChanged = true;
        alert("Đã trừ tồn kho.");
      }
      // HOÀN KHO: Khi "Đã giao" bị chuyển về "Đã hủy"
      else if (oldStatus === "Đã giao" && newStatus === "Đã hủy") {
        order.items.forEach((item) => {
          products = products.map((p) => {
            if (p.id === item.id) {
              p.qty = (p.qty || 0) + item.qty;
            }
            return p;
          });
        });
        stockChanged = true;
        alert("Đã hoàn kho cho đơn hàng bị hủy.");
      }

      // Lưu lại kho nếu có thay đổi
      if (stockChanged) {
        data.products = products;
        db_save("bs_data", data);
      }

      // Cập nhật trạng thái đơn hàng
      orders = orders.map((o) => {
        if (o.id === orderId) {
          o.status = newStatus;
        }
        return o;
      });

      db_save("bs_orders", orders);

      alert("Cập nhật trạng thái đơn hàng thành công!");
      window.location.reload();
    });
  }

  // --- 5. BỘ ĐỊNH TUYẾN (ROUTER) ---
  // (Chạy logic trang cụ thể)
  // Lưu ý: Các trang products.html, inventory.html, pricing.html
  // đã có script inline riêng nên không cần gọi ở đây.

  initGlobal(); // Luôn chạy

  switch (currentPage) {
    case "users.html":
      initUsersPage();
      break;
    case "purchase-orders.html":
      initPurchaseOrdersPage();
      break;
    case "purchase-edit.html":
      initPurchaseEditPage();
      break;
    case "orders.html":
      initOrdersPage();
      break;
    case "order-detail.html":
      initOrderDetailPage();
      break;
    // Các trang dashboard.html, products.html, inventory.html, pricing.html, v.v...
    // sẽ tự chạy script inline của chúng.
  }
});
