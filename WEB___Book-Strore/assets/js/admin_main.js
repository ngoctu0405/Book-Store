

/**
 * Định dạng số thành tiền tệ (vd: 10000 -> "10.000đ")
 * @param {number} value Số tiền
 * @returns {string} Chuỗi tiền tệ
 */
function formatCurrency(value) {
    if (isNaN(value)) value = 0;
    return `${value.toLocaleString('vi-VN')}đ`;
}

/**
 * Chuyển chuỗi tiền tệ về số (vd: "10.000đ" -> 10000)
 * @param {string} value Chuỗi tiền tệ
 * @returns {number} Số
 */
function parseCurrency(value) {
    if (typeof value !== 'string') return 0;
    return parseInt(value.replace(/[^0-9]/g, ''), 10) || 0;
}

/**
 * Lấy danh sách user từ localStorage
 * @returns {Array} Mảng các đối tượng user
 */
function getUserDatabase() {
    const usersString = localStorage.getItem('bs_users');
    return JSON.parse(usersString) || [];
}

/**
 * Lưu danh sách user vào localStorage
 * @param {Array} users Mảng các đối tượng user
 */
function saveUserDatabase(users) {
    localStorage.setItem('bs_users', JSON.stringify(users));
}

document.addEventListener('DOMContentLoaded', function() {

    const currentPage = window.location.pathname.split('/').pop() || 'dashboard.html';

    // --- 1. LOGIC TOÀN CỤC (Chạy trên mọi trang) ---
    
    /**
     * Tự động tìm và active link sidebar dựa trên URL hiện tại.
     * Xóa class 'active' khỏi HTML của bạn để hàm này hoạt động tốt nhất.
     */
    function initGlobal() {
        const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
        
        sidebarLinks.forEach(link => {
            link.classList.remove('active');
            const linkHref = link.getAttribute('href');

            // So sánh href của link với tên trang hiện tại
            if (linkHref === currentPage) {
                link.classList.add('active');
            }
        });
    }

    // --- 2. LOGIC TỪNG TRANG ---

    function initUsersPage() {
        const tableBody = document.getElementById('user-table-body');
        if (!tableBody) return; // Chỉ chạy nếu tìm thấy bảng

        const users = getUserDatabase(); // Lấy data

        tableBody.innerHTML = ''; // Xóa nội dung mẫu

        if (users.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Chưa có tài khoản nào đăng ký</td></tr>';
            return;
        }

        // Lặp qua mảng users và vẽ ra bảng
        users.forEach(user => {
            const row = document.createElement('tr');

            const userId = user.id || Date.now(); // Tạo id nếu lỡ thiếu
            const userStatus = user.status || 'active'; // Mặc định là active

            const statusClass = (userStatus === 'active') ? 'delivered' : 'pending';
            const statusText = (userStatus === 'active') ? 'Hoạt động' : 'Đã khóa';
            const lockButtonText = (userStatus === 'active') ? 'Khóa' : 'Mở khóa';
            const lockButtonClass = (userStatus === 'active') ? 'btn-outline-danger' : 'btn-outline-success';
            const registerDate = new Date(user.createdAt).toLocaleDateString('vi-VN');

            row.innerHTML = `
                <td>${user.fullName}</td>
                <td>${user.email}</td>
                <td>${registerDate}</td>
                <td><span class="status ${statusClass}">${statusText}</span></td>
                <td>
                    <a href="user-edit.html?id=${userId}" class="btn btn-sm btn-outline-primary">Sửa/Reset MK</a>
                    <button class="btn btn-sm ${lockButtonClass} btn-lock" data-userid="${userId}">
                        ${lockButtonText}
                    </button>
                </td>
            `;
            
            tableBody.appendChild(row);
        });

        // Thêm sự kiện cho các nút "Khóa" / "Mở khóa"
        tableBody.addEventListener('click', function(event) {
            const target = event.target;

            if (target.classList.contains('btn-lock')) {
                const userIdToToggle = target.dataset.userid;
                
                // Cập nhật mảng users
                const updatedUsers = users.map(user => {
                    if (user.id.toString() === userIdToToggle) {
                        user.status = (user.status === 'active') ? 'locked' : 'active';
                    }
                    return user;
                });

                // Lưu lại vào localStorage
                saveUserDatabase(updatedUsers);

                alert('Cập nhật trạng thái thành công!');
                window.location.reload(); // Tải lại trang để thấy thay đổi
            }
        });
    }

    function initUserEditPage() {
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('id');
        
        // Các elements trên trang (Giả sử có các ID này)
        const fullNameInput = document.getElementById('user-edit-fullname');
        const emailInput = document.getElementById('user-edit-email');
        const resetForm = document.getElementById('resetPasswordForm');
        
        if (!userId || !fullNameInput) return; // Thoát nếu không phải trang user-edit

        const users = getUserDatabase();
        const user = users.find(u => u.id.toString() === userId);

        if (!user) {
            alert('Người dùng không tồn tại.');
            window.location.href = 'users.html';
            return;
        }

        // 1. Đổ dữ liệu vào form
        fullNameInput.value = user.fullName;
        emailInput.value = user.email;
        // (Bạn có thể thêm các ô input (disabled) khác cho phone, address...)

        // 2. Xử lý Form Reset Mật khẩu
        if (resetForm) {
            resetForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const newPassword = document.getElementById('new-password').value;

                if (newPassword.length < 6) {
                    alert('Mật khẩu mới phải có ít nhất 6 ký tự.');
                    return;
                }

                // Cập nhật user trong mảng
                const updatedUsers = users.map(u => {
                    if (u.id.toString() === userId) {
                        u.password = newPassword; // Cập nhật mật khẩu
                    }
                    return u;
                });

                // Lưu lại database
                saveUserDatabase(updatedUsers);
                alert('Reset mật khẩu thành công!');
                document.getElementById('new-password').value = ''; // Xóa ô input
            });
        }
        
        // (Code cho nút Khóa/Mở khóa trên trang này cũng tương tự)
    }

    function initProductEditPage() {
        const imageInput = document.getElementById('product-image');
        if (!imageInput) return;

        // Tạo một thẻ img để xem trước nếu nó chưa tồn tại
        let preview = document.getElementById('image-preview');
        if (!preview) {
            preview = document.createElement('img');
            preview.id = 'image-preview';
            preview.style.maxWidth = '200px';
            preview.style.maxHeight = '200px';
            preview.style.marginTop = '15px';
            preview.style.display = 'none'; // Ẩn ban đầu
            imageInput.parentElement.appendChild(preview); // Thêm vào sau ô input
        }

        // nghe sự kiện 'change' của ô input file
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Hiển thị ảnh
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                preview.src = '';
            }
        });
    }

    function initPurchaseEditPage() {
        const addButton = document.querySelector('.card-body form .btn-primary');
        const productsTableBody = document.querySelector('.table tbody');
        const totalCell = document.querySelector('.table tfoot .h5');

        if (!addButton || !productsTableBody || !totalCell) return;

        // Hàm cập nhật tổng tiền
        function updatePurchaseTotal() {
            let total = 0;
            productsTableBody.querySelectorAll('tr').forEach(row => {
                const priceText = row.children[3].innerText;
                total += parseCurrency(priceText); // Dùng hàm helper
            });
            totalCell.innerText = formatCurrency(total); // Dùng hàm helper
        }

        // Hàm xóa 1 hàng
        function deletePurchaseItem(event) {
            event.target.closest('tr').remove();
            updatePurchaseTotal(); // Tính lại tổng tiền sau khi xóa
        }

        // Lắng nghe sự kiện click nút "Thêm"
        addButton.addEventListener('click', function() {
            const productSelect = document.querySelector('.card-body form select');
            const productName = productSelect.options[productSelect.selectedIndex].text;
            const price = parseInt(document.querySelector('input[placeholder="0"]').value) || 0;
            const quantity = parseInt(document.querySelector('input[type="number"][value="1"]').value) || 1;
            
            if (productSelect.value === "") {
                alert('Vui lòng chọn một sản phẩm!');
                return;
            }

            const lineTotal = price * quantity;

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${productName}</td>
                <td>${formatCurrency(price)}</td>
                <td>${quantity}</td>
                <td class="text-end">${formatCurrency(lineTotal)}</td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-danger btn-delete-item">Xóa</button>
                </td>
            `;

            productsTableBody.appendChild(newRow);
            newRow.querySelector('.btn-delete-item').addEventListener('click', deletePurchaseItem);
            updatePurchaseTotal();

            // Reset form
            productSelect.selectedIndex = 0;
            document.querySelector('input[placeholder="0"]').value = '';
            document.querySelector('input[type="number"][value="1"]').value = '1';
        });

        // Thêm sự kiện cho các nút "Xóa" đã có sẵn
        document.querySelectorAll('.btn-delete-item').forEach(button => {
            button.addEventListener('click', deletePurchaseItem);
        });

        updatePurchaseTotal(); // Chạy lần đầu
    }

    function initPricingPage() {
        const pricingTable = document.querySelector('.table');
        if (!pricingTable) return;

        pricingTable.addEventListener('input', function(event) {
            // Chỉ chạy nếu gõ vào ô .profit-input
            if (event.target.classList.contains('profit-input')) {
                const row = event.target.closest('tr');
                if (!row) return;

                const costCell = row.children[2]; 
                const salePriceCell = row.children[4]; 
                
                const costPrice = parseCurrency(costCell.innerText); // Dùng hàm helper
                const profitPercent = parseFloat(event.target.value) || 0;
                
                // Tính giá bán
                const salePrice = costPrice * (1 + profitPercent / 100);

                // Cập nhật ô giá bán
                salePriceCell.innerText = formatCurrency(Math.round(salePrice)); // Dùng hàm helper
            }
        });
    }

    // --- BỘ ĐỊNH TUYẾN (ROUTER) ĐƠN GIẢN ---
    
    // 1. Chạy logic toàn cục
    initGlobal();

    // 2. Chạy logic trang cụ thể
    switch (currentPage) {
        case 'users.html':
            initUsersPage();
            break;
        case 'user-edit.html':
            initUserEditPage();
            break;
        case 'product-edit.html':
            initProductEditPage();
            break;
        case 'purchase-edit.html':
            initPurchaseEditPage();
            break;
        case 'pricing.html':
            initPricingPage();
            break;
    }
});