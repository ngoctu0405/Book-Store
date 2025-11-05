// --- 1. HÀM HỖ TRỢ (HELPER FUNCTIONS) ---

/**
 * Lấy dữ liệu từ localStorage
 * @param {string} key Tên của "bảng" (vd: 'bs_users')
 * @returns {Array} Mảng dữ liệu
 */
function db_get(key) {
    const data = localStorage.getItem(key);
    return JSON.parse(data) || [];
}

/**
 * Lưu dữ liệu vào localStorage
 * @param {string} key Tên của "bảng"
 * @param {Array} data Mảng dữ liệu để lưu
 */
function db_save(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
}

/**
 * Định dạng số thành tiền tệ (vd: 10000 -> "10.000đ")
 */
function formatCurrency(value) {
    if (isNaN(value)) value = 0;
    return `${value.toLocaleString('vi-VN')}đ`;
}

/**
 * Chuyển chuỗi tiền tệ về số (vd: "10.000đ" -> 10000)
 */
function parseCurrency(value) {
    if (typeof value !== 'string') return 0;
    return parseInt(value.replace(/[^0-9]/g, ''), 10) || 0;
}

// --- 2. LOGIC CHÍNH (Chạy khi DOM đã tải) ---

document.addEventListener('DOMContentLoaded', function () {

    const currentPage = window.location.pathname.split('/').pop() || 'dashboard.html';

    // --- 3. LOGIC TOÀN CỤC (YÊU CẦU 1) ---

    function initGlobal() {
        const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
        sidebarLinks.forEach(link => {
            link.classList.remove('active');
            const linkHref = link.getAttribute('href').split('/').pop();
            if (linkHref === currentPage) {
                link.classList.add('active');
            }
        });
    }

    // --- 4. LOGIC TỪNG TRANG ---

    /**
     *  YÊU CẦU 2: Quản lý người dùng
     * - Trang: users.html (Cần: <tbody id="user-table-body">)
     */

     function initUsersPage() {
    const tableBody = document.getElementById('user-table-body');
    if (!tableBody) return; // Chỉ chạy trên trang users.html

    // ==========================================================
    // ===== BẮT ĐẦU CODE: XỬ LÝ MODAL THÊM NGƯỜI DÙNG (LƯU MẬT KHẨU) =====
    // ==========================================================
    const addUserForm = document.getElementById('addUserForm');
    const addUserModalElement = document.getElementById('addUserModal');
    
    // Kiểm tra nếu form và modal tồn tại
    if (addUserForm && addUserModalElement) {
        // Lấy đối tượng modal của Bootstrap
        const addUserModal = new bootstrap.Modal(addUserModalElement);

        addUserForm.addEventListener('submit', function (event) {
            event.preventDefault();

            // 1. Lấy dữ liệu từ form
            const fullName = document.getElementById('add-fullName').value;
            const username = document.getElementById('add-username').value; 
            const email = document.getElementById('add-email').value;
            // LẤY MẬT KHẨU TỪ Ô INPUT
            const password = document.getElementById('add-password').value; 
            const phone = document.getElementById('add-phone').value; 
            const address = document.getElementById('add-address').value; 

            // 2. Validate
            if (password.length < 6) {
                alert('Mật khẩu phải có ít nhất 6 ký tự.');
                return;
            }

            // 3. Lấy danh sách users hiện tại và kiểm tra trùng
            let users = db_get('bs_users') || [];
            const emailExists = users.some(user => user.email === email);
            const usernameExists = users.some(user => user.username === username); 

            if (emailExists) {
                alert('Email này đã được sử dụng. Vui lòng chọn email khác.');
                return;
            }
            if (usernameExists) {
                alert('Tên tài khoản này đã được sử dụng. Vui lòng chọn tên khác.');
                return;
            }

            // 4. Tạo đối tượng user mới
            const newUser = {
                id: Date.now(),
                fullName: fullName,
                username: username, 
                email: email,
                password: password, // LƯU MẬT KHẨU VÀO ĐÂY
                phone: phone, 
                address: address, 
                status: 'active',
                createdAt: new Date().toISOString()
            };

            // 5. Thêm user mới và lưu lại
            users.push(newUser);
            db_save('bs_users', users);

            // 6. Thông báo, đóng modal, reset form và tải lại trang
            alert('Tạo tài khoản khách hàng thành công!');
            addUserForm.reset();
            addUserModal.hide();
            window.location.reload(); 
        });
    }
    // ========================================================
    // ===== KẾT THÚC CODE MỚI ===============================
    // ========================================================


    // ----- (Code render bảng) -----
    const users = db_get('bs_users') || [];
    tableBody.innerHTML = '';

    if (users.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">Chưa có tài khoản nào đăng ký</td>
            </tr>`;
        return;
    }

    // Duyệt và render danh sách người dùng
    users.forEach(user => {
        const row = document.createElement('tr');
        const statusClass = (user.status === 'active') ? 'delivered' : 'pending';
        const statusText = (user.status === 'active') ? 'Hoạt động' : 'Đã khóa';
        const lockButtonText = (user.status === 'active') ? 'Khóa' : 'Mở khóa';
        const lockButtonClass = (user.status === 'active') ? 'btn-outline-danger' : 'btn-outline-success';

        const registerDate = user.createdAt
            ? new Date(user.createdAt).toLocaleDateString('vi-VN')
            : 'Không xác định';

        row.innerHTML = `
            <td>${user.fullName || '(Không có tên)'}</td>
            <td>${user.email || '(Không có email)'}</td>
            <td>${registerDate}</td>
            <td><span class="status ${statusClass}">${statusText}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-warning btn-reset" data-userid="${user.id}">
                    Reset MK
                </button>
                <button class="btn btn-sm ${lockButtonClass} btn-lock" data-userid="${user.id}">
                    ${lockButtonText}
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    // Xử lý click trên bảng (event delegation)
    tableBody.addEventListener('click', function (event) {
        const target = event.target;
        const userId = target.dataset.userid;
        if (!userId) return;

        let users = db_get('bs_users') || [];

        //  Xử lý nút Khóa / Mở khóa
        if (target.classList.contains('btn-lock')) {
            users = users.map(u => {
                if (u.id.toString() === userId) {
                    u.status = (u.status === 'active') ? 'locked' : 'active';
                }
                return u;
            });

            db_save('bs_users', users);
            alert(' Cập nhật trạng thái tài khoản thành công!');
            window.location.reload();
        }

        //  Xử lý nút Reset mật khẩu (để admin TỰ NHẬP mật khẩu mới)
        if (target.classList.contains('btn-reset')) {
            const newPassword = prompt("Nhập mật khẩu mới (ít nhất 6 ký tự):");
            if (!newPassword) return;
            if (newPassword.length < 6) {
                alert(' Mật khẩu quá ngắn. Thao tác đã hủy.');
                return;
            }

            users = users.map(u => {
                if (u.id.toString() === userId) {
                    u.password = newPassword;
                }
                return u;
            });

            db_save('bs_users', users);
            alert(' Reset mật khẩu thành công!');
        }
    });
}
    /**
     * YÊU CẦU 4: Quản lý danh mục sản phẩm
     * - Trang: products.html (Cần: <tbody id="product-table-body">)
     */
    function initProductsPage() {
        const tableBody = document.getElementById('product-table-body');
        if (!tableBody) return;

        const products = db_get('db_products');
        const categories = db_get('db_categories'); // Lấy loại SP để map tên

        tableBody.innerHTML = '';
        products.forEach(p => {
            const category = categories.find(c => c.id === p.categoryId) || {
                name: 'N/A'
            };
            const statusText = (p.status === 'visible') ? 'Đang hiển thị' : 'Đã ẩn';
            const statusClass = (p.status === 'visible') ? 'delivered' : 'pending';
            const toggleButtonText = (p.status === 'visible') ? 'Ẩn' : 'Hiện';
            const toggleButtonClass = (p.status === 'visible') ? 'btn-outline-danger' : 'btn-outline-success';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td><img src="${p.image}" alt="${p.name}" style="width:60px; height:60px; object-fit:cover;"></td>
                <td>${p.code}</td>
                <td>${p.name}</td>
                <td>${category.name}</td>
                <td><span class="status ${statusClass}">${statusText}</span></td>
                <td>
                    <a href="product-edit.html?id=${p.id}" class="btn btn-sm btn-outline-primary">Sửa</a>
                    <button class="btn btn-sm ${toggleButtonClass} btn-toggle" data-id="${p.id}">
                        ${toggleButtonText}
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // (Logic nút Ẩn/Hiện tương tự trang categories)
    }

    /**
     * YÊU CẦU 4: Thêm/Sửa sản phẩm
     * - Trang: product-edit.html (Cần: <form id="productForm">, <select id="product-category">)
     */
    function initProductEditPage() {
        const form = document.getElementById('productForm');
        const categorySelect = document.getElementById('product-category');
        const imageInput = document.getElementById('product-image');
        if (!form) return;

        // 1. Tải loại sản phẩm vào dropdown
        const categories = db_get('db_categories');
        categorySelect.innerHTML = '<option value="">-- Chọn loại --</option>';
        categories.forEach(cat => {
            categorySelect.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
        });

        // 2. Xử lý xem trước ảnh
        let preview = document.getElementById('image-preview');
        if (!preview) {
            preview = document.createElement('img');
            preview.id = 'image-preview';
            preview.style.cssText = 'max-width: 200px; max-height: 200px; margin-top: 15px; display: none;';
            imageInput.parentElement.appendChild(preview);
        }
        imageInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // 3. Xử lý lưu sản phẩm
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            let products = db_get('db_products');
            const newProduct = {
                id: Date.now(),
                name: document.getElementById('product-name').value,
                code: document.getElementById('product-code').value,
                categoryId: parseInt(categorySelect.value), // Lưu ID loại
                description: document.getElementById('product-description').value,
                image: preview.src, // Lưu ảnh đã xem trước (Base64)
                stock: 0, // Tồn kho ban đầu
                status: 'visible'
            };

            products.push(newProduct);
            db_save('db_products', products);

            alert('Thêm sản phẩm thành công!');
            window.location.href = 'products.html'; // Chuyển về trang danh sách
        });

        // (Code cho Sửa sản phẩm sẽ cần đọc ?id= từ URL và điền vào form)
    }

    /**
     *  YÊU CẦU 5: Quản lý Nhập sản phẩm
     * - Trang: purchase-orders.html (Cần: <tbody id="purchase-table-body">)
     */
    function initPurchaseOrdersPage() {
        const tableBody = document.getElementById('purchase-table-body');
        if (!tableBody) return;

        const purchases = db_get('db_purchases');
        tableBody.innerHTML = '';

        purchases.forEach(p => {
            const row = document.createElement('tr');
            const statusText = (p.status === 'completed') ? 'Đã hoàn thành' : 'Chưa hoàn thành';
            const statusClass = (p.status === 'completed') ? 'delivered' : 'pending';
            row.innerHTML = `
                <td>PN${p.id}</td>
                <td>${new Date(p.date).toLocaleDateString('vi-VN')}</td>
                <td>${p.items.length}</td>
                <td>${formatCurrency(p.totalCost)}</td>
                <td><span class="status ${statusClass}">${statusText}</span></td>
                <td>
                    <a href="purchase-edit.html?id=${p.id}" class="btn btn-sm btn-outline-primary">
                        ${(p.status === 'completed') ? 'Xem' : 'Sửa'}
                    </a>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    /**
     * YÊU CẦU 5: Thêm/Sửa phiếu nhập
     * - Trang: purchase-edit.html (Cần: <tbody id="purchase-items-body">, <tfoot id="purchase-total">, <select id="product-select">)
     */
    function initPurchaseEditPage() {
        const addButton = document.querySelector('.card-body form .btn-primary');
        const productsTableBody = document.getElementById('purchase-items-body');
        const totalCell = document.getElementById('purchase-total');
        const productSelect = document.getElementById('product-select');
        const completeButton = document.getElementById('complete-purchase-btn'); // Cần thêm ID này

        if (!addButton || !productsTableBody || !totalCell || !productSelect) return;

        let tempItems = []; // Lưu các item tạm thời

        // 1. Tải sản phẩm vào dropdown
        const products = db_get('db_products');
        productSelect.innerHTML = '<option value="">-- Chọn sản phẩm --</option>';
        products.forEach(p => {
            productSelect.innerHTML += `<option value="${p.id}">${p.name} (${p.code})</option>`;
        });

        // 2. Hàm vẽ lại bảng
        function renderPurchaseItems() {
            productsTableBody.innerHTML = '';
            let total = 0;
            tempItems.forEach((item, index) => {
                const product = products.find(p => p.id === item.productId);
                const lineTotal = item.cost * item.quantity;
                total += lineTotal;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.name}</td>
                    <td>${formatCurrency(item.cost)}</td>
                    <td>${item.quantity}</td>
                    <td class="text-end">${formatCurrency(lineTotal)}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-danger btn-delete-item" data-index="${index}">Xóa</button>
                    </td>
                `;
                productsTableBody.appendChild(row);
            });
            totalCell.innerText = formatCurrency(total);
        }

        // 3. Xử lý nút "Thêm"
        addButton.addEventListener('click', function () {
            const productId = parseInt(productSelect.value);
            const cost = parseInt(document.getElementById('purchase-cost').value) || 0; // Cần <input id="purchase-cost">
            const quantity = parseInt(document.getElementById('purchase-quantity').value) || 1; // Cần <input id="purchase-quantity">

            if (!productId) {
                alert('Vui lòng chọn một sản phẩm!');
                return;
            }

            tempItems.push({
                productId: productId,
                cost: cost,
                quantity: quantity
            });
            renderPurchaseItems();
            // Reset form
            productSelect.selectedIndex = 0;
            document.getElementById('purchase-cost').value = '';
            document.getElementById('purchase-quantity').value = '1';
        });

        // 4. Xử lý nút "Xóa"
        productsTableBody.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-delete-item')) {
                const index = parseInt(e.target.dataset.index);
                tempItems.splice(index, 1); // Xóa item khỏi mảng tạm
                renderPurchaseItems();
            }
        });

        // 5. YÊU CẦU 5 & 8: Hoàn thành phiếu (Cập nhật tồn kho)
        completeButton.addEventListener('click', function () {
            if (tempItems.length === 0) {
                alert('Phiếu nhập rỗng!');
                return;
            }

            // a. Lưu phiếu nhập
            let purchases = db_get('db_purchases');
            const newPurchase = {
                id: Date.now(),
                date: new Date().toISOString(),
                status: 'completed',
                items: tempItems,
                totalCost: parseCurrency(totalCell.innerText)
            };
            purchases.push(newPurchase);
            db_save('db_purchases', purchases);

            // b. Cập nhật tồn kho (YÊU CẦU 8)
            let currentProducts = db_get('db_products');
            tempItems.forEach(item => {
                currentProducts = currentProducts.map(p => {
                    if (p.id === item.productId) {
                        p.stock = (p.stock || 0) + item.quantity; // Thêm số lượng vào tồn kho
                    }
                    return p;
                });
            });
            db_save('db_products', currentProducts); // Lưu lại kho

            alert('Hoàn thành phiếu nhập và đã cập nhật tồn kho!');
            window.location.href = 'purchase-orders.html';
        });

        renderPurchaseItems(); // Chạy lần đầu
    }

    /**
     *  YÊU CẦU 6: Quản lý giá bán
     * - Trang: pricing.html (Cần: <table> có class "table" và <input class="profit-input">)
     */
    function initPricingPage() {
        const pricingTable = document.querySelector('.table');
        if (!pricingTable || !pricingTable.querySelector('.profit-input')) return;

        pricingTable.addEventListener('input', function (event) {
            if (event.target.classList.contains('profit-input')) {
                const row = event.target.closest('tr');
                if (!row) return;

                const costCell = row.children[2];
                const salePriceCell = row.children[4];
                const costPrice = parseCurrency(costCell.innerText);
                const profitPercent = parseFloat(event.target.value) || 0;

                const salePrice = costPrice * (1 + profitPercent / 100);
                salePriceCell.innerText = formatCurrency(Math.round(salePrice));
            }
        });
    }

    /**
     * Quản lý Đơn hàng (orders.html)
     */
   function initOrdersPage() {
        const tableBody = document.getElementById('order-table-body');
        if (!tableBody) return;

        const orders = db_get('bs_orders');
        tableBody.innerHTML = '';

        if (orders.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Chưa có đơn hàng nào.</td></tr>`;
            return;
        }
   
        // Lọc và hiển thị
        function renderTable(filteredOrders) {
            tableBody.innerHTML = '';
            
            if (filteredOrders.length === 0) {
                 tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Không tìm thấy đơn hàng nào khớp.</td></tr>`;
                 return;
            }
            
            filteredOrders.forEach(order => {
                const row = document.createElement('tr');
                
                const statusClassMap = {
                    'Chờ xử lý': 'pending',
                    'Đã xử lý': 'processed',
                    'Đã giao': 'delivered',
                    'Đã hủy': 'cancelled'
                };
                
                row.innerHTML = `
                    <td>#${order.id}</td>
                    <td>${order.userId}</td>
                    <td>${new Date(order.date).toLocaleDateString('vi-VN')}</td>
                    <td>${formatCurrency(order.total)}</td>
                    <td><span class="status ${statusClassMap[order.status] || 'pending'}">${order.status}</span></td>
                    <td>
                        <a href="order-detail.html?id=${order.id}" class="btn btn-sm btn-outline-primary">Xem</a>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }
        
        // Hiển thị tất cả ban đầu (sắp xếp mới nhất lên đầu)
        renderTable(orders.slice().reverse());

        // ✅ BẮT ĐẦU THAY ĐỔI: Gắn sự kiện cho nút Lọc
        const filterBtn = document.getElementById('filter-btn');
        if(filterBtn) {
            filterBtn.addEventListener('click', function() {
                // Lấy tất cả giá trị lọc
                const statusFilter = document.getElementById('filter-status').value;
                const addressFilter = document.getElementById('filter-address').value.toLowerCase().trim();
                const startDate = document.getElementById('filter-start-date').value;
                const endDate = document.getElementById('filter-end-date').value;

                let filtered = orders; // Bắt đầu với tất cả đơn hàng

                // 1. Lọc theo Trạng thái
                if (statusFilter) {
                    filtered = filtered.filter(o => o.status === statusFilter);
                }

                // 2. Lọc theo Địa chỉ (kiểm tra có chứa chuỗi nhập vào)
                if (addressFilter) {
                    filtered = filtered.filter(o => 
                        o.shippingAddress && 
                        o.shippingAddress.address.toLowerCase().includes(addressFilter)
                    );
                }

                // 3. Lọc theo Ngày
                const start = startDate ? new Date(startDate) : null;
                const end = endDate ? new Date(endDate) : null;

                // Đặt giờ về đầu ngày cho ngày bắt đầu
                if (start) start.setHours(0, 0, 0, 0);
                
                // Đặt giờ về cuối ngày cho ngày kết thúc (để bao gồm cả ngày đó)
                if (end) end.setHours(23, 59, 59, 999); 

                if (start) {
                    filtered = filtered.filter(o => new Date(o.date) >= start);
                }
                if (end) {
                    filtered = filtered.filter(o => new Date(o.date) <= end);
                }

                // Sắp xếp kết quả (mới nhất lên đầu) và hiển thị
                renderTable(filtered.slice().reverse());
            });
        }
        // ✅ KẾT THÚC THAY ĐỔI
    }

    /*
     * Chi tiết đơn hàng (order-detail.html)
     */
    function initOrderDetailPage() {
        const form = document.getElementById('orderDetailForm');
        const statusSelect = document.getElementById('order-status');
        if (!form || !statusSelect) return;

        const urlParams = new URLSearchParams(window.location.search);
        const orderId = parseInt(urlParams.get('id'));

        if (!orderId) {
            alert('Không tìm thấy ID đơn hàng.');
            window.location.href = 'orders.html';
            return;
        }

        let orders = db_get('bs_orders');
        let order = orders.find(o => o.id === orderId);

        if (!order) {
            alert('Không tìm thấy đơn hàng');
            window.location.href = 'orders.html';
            return;
        }

        // --- 1. Đổ dữ liệu vào HTML ---
        document.getElementById('order-title').textContent = `Chi tiết Đơn hàng #${order.id}`;
        
        const customerInfo = document.getElementById('customer-info');
        if(customerInfo) {
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
        
        const productTable = document.getElementById('product-items-table');
        if(productTable) {
            productTable.innerHTML = ''; 
            order.items.forEach(item => {
                const product = item.product;
                productTable.innerHTML += `
                    <tr>
                        <td>
                            <img src="../${product.img}" alt="${product.name}" class="item-image" style="width: 60px; height: 80px; object-fit: cover;">
                        </td>
                        <td>
                            <strong>${product.name}</strong><br>
                            <span class="text-muted">SKU: ${product.sku}</span>
                        </td>
                        <td>x ${item.qty}</td>
                        <td class="text-end">${formatCurrency(item.itemTotal)}</td>
                    </tr>
                `;
            });
        }

        const subtotal = order.total - (order.shippingAddress.shipping || 30000); 
        const shipping = order.total - subtotal;
        
        document.getElementById('summary-subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('summary-shipping').textContent = formatCurrency(shipping);
        document.getElementById('summary-total').textContent = formatCurrency(order.total);
        
        // --- 2. Xử lý Cập nhật trạng thái ---
        statusSelect.value = order.status; 

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const newStatus = statusSelect.value;
            const oldStatus = order.status;

            if (newStatus === oldStatus) {
                alert('Trạng thái không đổi.');
                return;
            }

            // Logic trừ/hoàn kho (đã chính xác từ lần trước)
            if (oldStatus !== 'Đã giao' && newStatus === 'Đã giao') {
                let data = db_get('bs_data');
                let products = data.products || [];
                let stockOk = true;
                for (const item of order.items) {
                    const product = products.find(p => p.id === item.id); 
                    if (!product || (product.qty || 0) < item.qty) {
                        stockOk = false;
                        alert(`Không đủ tồn kho cho sản phẩm: ${product.name} (Còn ${product.qty || 0}, Cần ${item.qty})`);
                        break; 
                    }
                }
                if (!stockOk) return; 
                order.items.forEach(item => {
                    products = products.map(p => {
                        if (p.id === item.id) {
                            p.qty = (p.qty || 0) - item.qty;
                        }
                        return p;
                    });
                });
                data.products = products;
                db_save('bs_data', data); 
            } 
            else if (oldStatus === 'Đã giao' && (newStatus === 'Đã hủy' || newStatus === 'Chờ xử lý')) {
                let data = db_get('bs_data');
                let products = data.products || [];
                order.items.forEach(item => {
                    products = products.map(p => {
                        if (p.id === item.id) {
                            p.qty = (p.qty || 0) + item.qty;
                        }
                        return p;
                    });
                });
                data.products = products;
                db_save('bs_data', data);
                alert('Đã hoàn kho cho đơn hàng bị hủy/trả lại.');
            }

            // Cập nhật trạng thái đơn hàng
            orders = orders.map(o => {
                if (o.id === orderId) {
                    o.status = newStatus;
                }
                return o;
            });
            
            db_save('bs_orders', orders);

            alert('Cập nhật trạng thái đơn hàng thành công!');
            window.location.reload();
        });
    }

    /**
     * YÊU CẦU 8: Quản lý số lượng tồn
     * - Trang: inventory.html (Cần: <tbody id="inventory-table-body">)
     */
    function initInventoryPage() {
        const tableBody = document.getElementById('inventory-table-body');
        if (!tableBody) return;

        // Yêu cầu 8 đã được xử lý bằng cách lưu 'stock' trực tiếp trong 'db_products'
        // Chúng ta chỉ cần đọc 'db_products'
        const products = db_get('db_products');

        tableBody.innerHTML = '';
        products.forEach(p => {
            const row = document.createElement('tr');
            const stock = p.stock || 0;

            // Yêu cầu 8.2: Cảnh báo sắp hết hàng
            let rowClass = '';
            let stockText = stock;
            if (stock <= 10) { // Giả sử ngưỡng là 10
                rowClass = 'table-danger-light'; // Dùng class CSS đã tạo
                stockText = `${stock} (Sắp hết!)`;
            }

            row.className = rowClass;
            row.innerHTML = `
                <td>${p.code}</td>
                <td>${p.name}</td>
                <td class="text-center">N/A</td> <td class="text-center">N/A</td> <td class="text-center">N/A</td> <td class="text-center fw-bold">${stockText}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    // --- 5. BỘ ĐỊNH TUYẾN (ROUTER) ---

    initGlobal(); // Luôn chạy

    // Chạy logic trang cụ thể
    switch (currentPage) {
        case 'users.html':
            initUsersPage();
            break;
        case 'products.html':
            initProductsPage();
            break;
        case 'product-edit.html':
            initProductEditPage();
            break;
        case 'purchase-orders.html':
            initPurchaseOrdersPage();
            break;
        case 'purchase-edit.html':
            initPurchaseEditPage();
            break;
        case 'pricing.html':
            initPricingPage();
            break;
        case 'orders.html':
            initOrdersPage();
            break;
        case 'order-detail.html':
            initOrderDetailPage();
            break;
        case 'inventory.html':
            initInventoryPage();
            break;
        case 'dashboard.html':
            break; // Không cần JS
    }
});