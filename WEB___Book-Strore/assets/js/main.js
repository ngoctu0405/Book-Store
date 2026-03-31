// Kiểm tra trạng thái tài khoản từ server mỗi khi trang load
document.addEventListener("DOMContentLoaded", async function () {
  const currentUser = JSON.parse(localStorage.getItem("bs_user"));
  if (!currentUser || !currentUser.id) return;

  try {
    const data = await apiFetchJson(resolveApiUrl("check-status.php"), {
      method: "POST",
      body: JSON.stringify({ id: currentUser.id }),
    });

    const user = data.user;
    if (!user) return;

    // Tài khoản bị khóa -> đăng xuất
    if (user.status === "locked") {
      alert("🚫 Tài khoản của bạn đã bị khóa. Bạn sẽ được đăng xuất.");
      localStorage.removeItem("bs_user");
      await clearCart();
      updateAuthUI();
      return;
    }

    // Đồng bộ lại thông tin mới nhất từ server vào localStorage
    localStorage.setItem("bs_user", JSON.stringify({
      id: user.id,
      status: user.status,
      username: user.username,
      fullName: user.fullName,
      email: user.email,
      phone: user.phone,
      address: user.address,
    }));

  } catch (err) {
    // Không làm gì nếu API lỗi, tránh đăng xuất nhầm
    console.warn("Không thể kiểm tra trạng thái tài khoản:", err.message);
  }
});

// ==================== API HELPERS (BACKEND) ====================

async function apiFetchJson(url, options = {}) {
  const fetchOptions =
    typeof options === "string"
      ? { method: options }
      : { ...options };

  const res = await fetch(url, {
    headers: {
      "Content-Type": "application/json",
      ...(fetchOptions.headers || {}),
    },
    ...fetchOptions,
  });

  const data = await res.json().catch(() => null);

  if (!res.ok) {
    const msg = data && data.error ? data.error : "Lỗi gọi API";
    throw new Error(msg);
  }
  return data;
}

function resolveApiUrl(filename) {
  const pathname = window.location.pathname;
  if (pathname.includes('/user/') || pathname.includes('/admin/')) {
    return `../api/${filename}`;
  }
  return `api/${filename}`;
}

// Lấy dữ liệu sản phẩm từ server (MySQL)
async function fetchDataFromServer() {
  const apiUrl = resolveApiUrl("products.php");

  try {
    const data = await apiFetchJson(apiUrl, { method: "GET" });
    return data; // { products: [...] }
  } catch (err) {
    console.error("Lỗi gọi API products:", err);
    return { products: [] };
  }
}

// Đăng nhập qua API
async function loginViaApi(username, password) {
  return apiFetchJson(resolveApiUrl("login.php"), {
    method: "POST",
    body: JSON.stringify({ username, password }),
  });
}

// Đăng ký qua API
async function registerViaApi(userPayload) {
  return apiFetchJson(resolveApiUrl("register.php"), {
    method: "POST",
    body: JSON.stringify(userPayload),
  });
}

// Thanh toán / tạo đơn hàng
async function checkoutViaApi(userId, items) {
  return apiFetchJson(resolveApiUrl("checkout.php"), {
    method: "POST",
    body: JSON.stringify({ userId, items }),
  });
}


// Dữ liệu sản phẩm lấy từ server (MySQL) thông qua API
let bs_data = { products: [] };

function getVisibleProducts() {
  // ✅ ĐỌC TRỰC TIẾP TỪ LOCALSTORAGE
  const dataString = localStorage.getItem("bs_data");
  let allProducts = [];

  if (dataString) {
    try {
      const data = JSON.parse(dataString);
      allProducts = data.products || [];
    } catch (e) {
      console.error("Lỗi đọc bs_data:", e);
      allProducts = [];
    }
  }

  // ✅ CHỈ LỌC STATUS = 'active' (không lọc category nữa)
  return allProducts.filter((p) => p.status === "active");
}



// ==================== KHỞI TẠO DỮ LIỆU MẶC ĐỊNH CHO USER ====================
// --- KHAI BÁO VÀ KHỞI TẠO DỮ LIỆU ---
const CATEGORIES_STORAGE_KEY = "admin_categories_data";

// Dữ liệu mặc định cho lần chạy đầu tiên (để có sẵn menu bên user)
const defaultCategories = [
  {
    name: "Văn học",
    subcategories: ["Tiểu thuyết", "Truyện ngắn", "Thơ"],
    status: "active",
  },
  {
    name: "Kinh tế",
    subcategories: ["Quản trị", "Tài chính", "Marketing"],
    status: "active",
  },
  {
    name: "Thiếu nhi",
    subcategories: ["Truyện tranh", "Giáo dục"],
    status: "active",
  },
  {
    name: "Giáo khoa",
    subcategories: ["Cấp 1", "Cấp 2", "Cấp 3"],
    status: "active",
  },
];

// Hàm kiểm tra và lưu dữ liệu mặc định
function initializeDefaultCategories() {
  // Chỉ tạo dữ liệu mặc định nếu chưa có trong Local Storage
  if (!localStorage.getItem(CATEGORIES_STORAGE_KEY)) {
    localStorage.setItem(
      CATEGORIES_STORAGE_KEY,
      JSON.stringify(defaultCategories)
    );
    console.log("Đã khởi tạo dữ liệu category mặc định cho Local Storage.");
  }
}
initializeDefaultCategories();
// ==================== KẾT THÚC KHỞI TẠO DỮ LIỆU MẶC ĐỊNH ====================
// ==================== CẬP NHẬT MENU DANH MỤC TỪ ADMIN ====================
// Biến Local Storage Key phải khớp với bên Admin
const CATEGORIES_STORAGE_KEY_NAV = "admin_categories_data";

// Hàm Tải Danh mục từ Local Storage và Cập nhật menu điều hướng
function loadCategoriesAndPopulateMenu() {
  const categoriesMenu = document.querySelector("#mainMenu .book-filter");
  if (!categoriesMenu) {
    // Không báo lỗi ở đây vì một số trang có thể không có menu này
    return;
  }

  // 1. Tải dữ liệu từ Local Storage
  const storedData = localStorage.getItem(CATEGORIES_STORAGE_KEY_NAV);
  let categories;
  try {
    categories = storedData ? JSON.parse(storedData) : [];
  } catch (e) {
    console.error("Lỗi khi phân tích dữ liệu categories từ localStorage:", e);
    categories =
      JSON.parse(localStorage.getItem(CATEGORIES_STORAGE_KEY_NAV)) || [];
  }

  // Lọc ra các category đang 'active' (ĐÂY LÀ CHỖ XỬ LÝ ẨN/HIỆN)
  const activeCategories = categories.filter((cat) => cat.status === "active");

  let menuHTML = "";

  // 2. Tạo HTML cho menu
  activeCategories.forEach((cat) => {
    let subMenuHTML = "";
    // Đảm bảo subcategories là một mảng
    if (Array.isArray(cat.subcategories)) {
      cat.subcategories.forEach((sub) => {
        subMenuHTML += `
                    <li><a href="category.php?category=${encodeURIComponent(
          cat.name
        )}&subcategory=${encodeURIComponent(sub)}" 
                        data-category="${cat.name
          }" data-subcategory="${sub}">${sub}</a></li>
                `;
      });
    }

    menuHTML += `
            <li class="dropdown">
                <a href="category.php?category=${encodeURIComponent(
      cat.name
    )}" data-category="${cat.name}">${cat.name} ▸</a>
                <ul class="dropdown-content">
                    ${subMenuHTML}
                </ul>
            </li>
        `;
  });

  // 3. Cập nhật menu điều hướng
  categoriesMenu.innerHTML = menuHTML;

  console.log("Menu danh mục đã được cập nhật từ Local Storage.");
}
// ==================== KẾT THÚC BỔ SUNG ====================

// getData giờ chỉ là helper đọc từ biến bs_data đã sync từ server
function getData() {
  return bs_data || { products: [] };
}
let cartCache = [];

function getCart() {
  return cartCache;
}

async function loadServerCart() {
  try {
    const response = await apiFetchJson(resolveApiUrl("cart.php"), { method: "GET" });
    cartCache = Array.isArray(response.cart) ? response.cart : [];
  } catch (err) {
    console.error("Lỗi tải giỏ hàng từ session:", err);
    cartCache = [];
  }
  return cartCache;
}

async function saveCart(c) {
  cartCache = Array.isArray(c) ? c : [];
  try {
    await apiFetchJson(resolveApiUrl("cart.php"), {
      method: "POST",
      body: JSON.stringify({ action: "save", cart: cartCache }),
    });
  } catch (err) {
    console.error("Lỗi lưu giỏ hàng vào session:", err);
  }
  return cartCache;
}

async function clearCart() {
  cartCache = [];
  try {
    await apiFetchJson(resolveApiUrl("cart.php"), {
      method: "POST",
      body: JSON.stringify({ action: "clear" }),
    });
  } catch (err) {
    console.error("Lỗi xoá giỏ hàng session:", err);
  }
}

async function changeQuantity(productId, delta) {
  const cart = getCart();
  const itemIndex = cart.findIndex((item) => item.id === productId);
  if (itemIndex === -1) return;
  const nextQty = cart[itemIndex].qty + delta;
  if (nextQty <= 0) {
    if (!confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) return;
    cart.splice(itemIndex, 1);
  } else {
    cart[itemIndex].qty = nextQty;
  }
  await saveCart(cart);
  if (typeof updateCartCount === "function") updateCartCount();
  window.location.reload();
}

async function removeCartItem(productId) {
  if (!confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) return;
  const cart = getCart().filter((item) => item.id !== productId);
  await saveCart(cart);
  if (typeof updateCartCount === "function") updateCartCount();
  window.location.reload();
}

const ACTIVE_BUYER_PROFILE_KEY = "bs_active_buyer_profile";
let cachedBuyerProfiles = null;

function getActiveBuyerProfileIndex() {
  const index = Number(localStorage.getItem(ACTIVE_BUYER_PROFILE_KEY));
  return index >= 1 && index <= 3 ? index : 1;
}

function setActiveBuyerProfileIndex(index) {
  localStorage.setItem(ACTIVE_BUYER_PROFILE_KEY, index);
}

function createProfileFromFormFields() {
  return {
    name: document.getElementById("buyerName")?.value || "",
    email: document.getElementById("buyerEmail")?.value || "",
    phone: document.getElementById("buyerPhone")?.value || "",
    address: document.getElementById("buyerAddress")?.value || "",
    note: document.getElementById("buyerNote")?.value || "",
  };
}

function fillBuyerFormFromLocalStorage() {
  const user = getCurrentUser();
  if (!user) return;

  const fieldMap = [
    { id: 'buyerName', key: 'fullName' },
    { id: 'buyerEmail', key: 'email' },
    { id: 'buyerPhone', key: 'phone' },
    { id: 'buyerAddress', key: 'address' },
  ];

  fieldMap.forEach(({ id, key }) => {
    const input = document.getElementById(id);
    if (!input) return;
    if (!input.value && user[key]) {
      input.value = user[key];
    }
  });
}

async function loadBuyerProfilesFromServer() {
  let user = getCurrentUser() || {};
  if (!user.id && window.currentUserFromSession && window.currentUserFromSession.id) {
    user = window.currentUserFromSession;
  }
  if (!user.id) return null;

  try {
    const response = await apiFetchJson(
      resolveApiUrl("buyer-profiles.php") + "?userId=" + user.id,
      { method: "GET" }
    );
    if (response && response.profiles) {
      cachedBuyerProfiles = response.profiles;
      return response.profiles;
    }
  } catch (err) {
    console.error("Lỗi tải profile:", err);
  }
  return null;
}

function getCachedBuyerProfiles() {
  if (!cachedBuyerProfiles) {
    // Khởi tạo 3 profile trống nếu chưa tải từ server
    cachedBuyerProfiles = {
      1: createProfileFromFormFields(),
      2: createProfileFromFormFields(),
      3: createProfileFromFormFields(),
    };
  }
  return cachedBuyerProfiles;
}

async function initBuyerProfiles() {
  const loaded = await loadBuyerProfilesFromServer();
  return loaded || getCachedBuyerProfiles();
}

async function getBuyerProfile(index) {
  const profiles = cachedBuyerProfiles || (await initBuyerProfiles());
  const profile = profiles[index];
  const defaults = createProfileFromFormFields();

  if (!profile || Object.values(profile).every((value) => !value)) {
    return defaults;
  }

  return {
    name: profile.name || defaults.name,
    email: profile.email || defaults.email,
    phone: profile.phone || defaults.phone,
    address: profile.address || defaults.address,
    note: profile.note || defaults.note,
  };
}

async function saveBuyerProfile(index, profile) {
  let user = getCurrentUser() || {};
  if (!user.id && window.currentUserFromSession && window.currentUserFromSession.id) {
    user = window.currentUserFromSession;
  }
  if (!user.id) {
    console.error("Không tìm thấy userId");
    return;
  }

  try {
    await apiFetchJson(resolveApiUrl("buyer-profiles.php"), {
      method: "POST",
      body: JSON.stringify({
        userId: user.id,
        profileIndex: index,
        profile: profile,
      }),
    });

    // Cập nhật cache
    if (!cachedBuyerProfiles) cachedBuyerProfiles = {};
    cachedBuyerProfiles[index] = profile;
  } catch (err) {
    console.error("Lỗi lưu profile:", err);
  }
}

function applyBuyerProfile(profile) {
  document.getElementById("buyerName").value = profile.name;
  document.getElementById("buyerEmail").value = profile.email;
  document.getElementById("buyerPhone").value = profile.phone;
  document.getElementById("buyerAddress").value = profile.address;
  document.getElementById("buyerNote").value = profile.note;
  document.getElementById("buyerProfileIndex").value = getActiveBuyerProfileIndex();
  updateBuyerInfoDisplay();
}

function switchProfile(index) {
  return switchBuyerProfile(index);
}

function refreshChangeProfileCards() {
  for (let i = 1; i <= 3; i++) {
    const body = document.getElementById(`profileCardBody-${i}`);
    const placeholder = document.getElementById(`profileCardEmpty-${i}`);
    if (!body) continue;

    const profile = window.buyerProfiles?.[i] || {};
    const hasProfile = Object.values(profile).some((value) => value && value.toString().trim() !== "");

    if (hasProfile) {
      const name = profile.fullName || profile.name || "";
      const email = profile.email || "";
      const phone = profile.phone || "";
      const address = profile.address || "";
      const note = profile.note || "Không có";

      body.style.display = "grid";
      body.innerHTML = `
        <div><strong>Họ tên:</strong> <span>${escapeHtml(name)}</span></div>
        <div><strong>Email:</strong> <span>${escapeHtml(email)}</span></div>
        <div><strong>Phone:</strong> <span>${escapeHtml(phone)}</span></div>
        <div><strong>Địa chỉ:</strong> <span>${escapeHtml(address)}</span></div>
        <div><strong>Ghi chú:</strong> <span>${escapeHtml(note)}</span></div>
      `;
      if (placeholder) placeholder.style.display = "none";
    } else {
      body.style.display = "none";
      if (placeholder) placeholder.style.display = "block";
    }
  }
}

function escapeHtml(text) {
  if (typeof text !== "string") return "";
  return text
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function openChangeProfileModal() {
  refreshChangeProfileCards();
  const modal = document.getElementById("changeProfileModal");
  if (!modal) return;
  modal.classList.add("show");
}

function closeChangeProfileModal() {
  const modal = document.getElementById("changeProfileModal");
  if (!modal) return;
  modal.classList.remove("show");
}

function renderBuyerProfileTabs() {
  document.querySelectorAll(".buyer-profile-btn").forEach((button) => {
    const index = Number(button.dataset.profile);
    button.classList.toggle("active", index === getActiveBuyerProfileIndex());
  });
}

async function switchBuyerProfile(index) {
  setActiveBuyerProfileIndex(index);
  renderBuyerProfileTabs();
  const profile = await getBuyerProfile(index);
  applyBuyerProfile(profile);
}

async function openBuyerInfoModal() {
  const modal = document.getElementById("buyerInfoModal");
  if (!modal) return;
  const profile = await getBuyerProfile(getActiveBuyerProfileIndex());
  document.getElementById("modalBuyerSaveTo").value = getActiveBuyerProfileIndex();
  document.getElementById("modalBuyerName").value = profile.name;
  document.getElementById("modalBuyerEmail").value = profile.email;
  document.getElementById("modalBuyerPhone").value = profile.phone;
  document.getElementById("modalBuyerAddress").value = profile.address;
  document.getElementById("modalBuyerNote").value = profile.note;
  modal.classList.add("show");
}

function closeBuyerInfoModal() {
  const modal = document.getElementById("buyerInfoModal");
  if (!modal) return;
  modal.classList.remove("show");
}

function updateBuyerInfoDisplay() {
  const name = document.getElementById("buyerName")?.value || "Chưa nhập";
  const email = document.getElementById("buyerEmail")?.value || "Chưa nhập";
  const phone = document.getElementById("buyerPhone")?.value || "Chưa nhập";
  const address = document.getElementById("buyerAddress")?.value || "Chưa nhập";
  const note = document.getElementById("buyerNote")?.value || "Không có";

  document.getElementById("displayBuyerName").textContent = name;
  document.getElementById("displayBuyerEmail").textContent = email;
  document.getElementById("displayBuyerPhone").textContent = phone;
  document.getElementById("displayBuyerAddress").textContent = address;
  document.getElementById("displayBuyerNote").textContent = note;
}

function checkoutCart() {
  const currentUser = getCurrentUser() || window.currentUserFromSession || {};
  if (!currentUser || !currentUser.id) {
    alert("Vui lòng đăng nhập để thanh toán!");
    openLoginModal();
    return;
  }

  const cart = getCart();
  if (!cart.length) {
    alert("Giỏ hàng trống!");
    return;
  }

  const buyerName = document.getElementById("buyerName")?.value?.trim();
  const buyerEmail = document.getElementById("buyerEmail")?.value?.trim();
  const buyerPhone = document.getElementById("buyerPhone")?.value?.trim();
  const buyerAddress = document.getElementById("buyerAddress")?.value?.trim();
  const buyerNote = document.getElementById("buyerNote")?.value?.trim();

  if (!buyerName || !buyerEmail || !buyerPhone || !buyerAddress) {
    alert("Vui lòng điền đầy đủ thông tin giao hàng!");
    return;
  }

  const buyerInfo = {
    name: buyerName,
    email: buyerEmail,
    phone: buyerPhone,
    address: buyerAddress,
    note: buyerNote,
  };

  apiFetchJson(resolveApiUrl("checkout.php"), {
    method: "POST",
    body: JSON.stringify({ userId: currentUser.id, items: cart, buyerInfo }),
  })
    .then((result) => {
      if (result.success) {
        alert("Đặt hàng thành công! Mã đơn hàng: " + result.orderId);
        saveCart([]);
        window.location.href = "index.php";
      } else {
        alert("Lỗi đặt hàng: " + (result.error || "Không xác định"));
      }
    })
    .catch((err) => {
      console.error(err);
      alert("Lỗi thanh toán: " + err.message);
    });
}

function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  modal.classList.add("show");
  document.body.style.overflow = "hidden";
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  modal.classList.remove("show");
  document.body.style.overflow = "";
  modal.querySelectorAll(".error-msg").forEach((el) => (el.textContent = ""));
  const form = modal.querySelector("form");
  if (form) form.reset();
  const editForm = document.getElementById("editAddressForm");
  if (editForm) editForm.remove();
}

// ==================== BẮT ĐẦU: LỌC SẢN PHẨM THEO CATEGORY ADMIN ====================

/**
 * Lấy danh sách TÊN của các category đang 'active'
 */
function getActiveCategoryNames() {
  // Dùng CATEGORIES_STORAGE_KEY_NAV vì nó đã được định nghĩa ở trên
  const storedData = localStorage.getItem(CATEGORIES_STORAGE_KEY_NAV);
  if (!storedData) {
    // Nếu không có dữ liệu admin, tạm thời coi như tất cả đều active
    // Dữ liệu này sẽ được initializeDefaultCategories() tạo ra ngay sau đó
    console.warn("Chưa có dữ liệu category, tạm thời hiển thị tất cả.");
    return null;
  }
  try {
    const categories = JSON.parse(storedData);
    // Trả về một mảng chỉ chứa TÊN của category active
    return categories
      .filter((cat) => cat.status === "active")
      .map((cat) => cat.name);
  } catch (e) {
    console.error(
      "Lỗi khi đọc dữ liệu categories, tạm thời hiển thị tất cả:",
      e
    );
    return null; // Trả về null để biết là có lỗi và không lọc
  }
}

/**
 * Lấy danh sách sản phẩm (đã lọc) MÀ USER ĐƯỢC PHÉP XEM
 */
function getVisibleProducts() {
  // Lấy dữ liệu mới nhất từ bs_data (đã sync với server)
  let allProducts = (bs_data && bs_data.products) || [];

  // 1. Lọc các sản phẩm bị DỪNG BÁN (status = 'inactive')
  allProducts = allProducts.filter((p) => p.status !== "inactive");

  // 2. Ẩn sản phẩm hết hàng
  allProducts = allProducts.filter((p) => p.qty > 0);

  // 3. Lọc theo category 'active' (từ cấu hình admin/local)
  const activeCategoryNames = getActiveCategoryNames();
  if (activeCategoryNames === null) {
    return allProducts;
  }

  return allProducts.filter((product) =>
    activeCategoryNames.includes(product.category)
  );
}
// ==================== KẾT THÚC: LỌC SẢN PHẨM ====================

// Sửa lại hàm updateCartCount để hiển thị số lượng chính xác trên giỏ hàng
function updateCartCount() {
  // 1. Tính tổng số lượng từ giỏ hàng.
  // Giả định hàm getCart() đã được định nghĩa và trả về mảng giỏ hàng [{id: X, qty: Y}]
  const count = getCart().reduce((s, i) => s + i.qty, 0);

  // 2. Lấy thẻ span đã có sẵn trong HTML bằng ID
  // Thẻ này nằm trong nút giỏ hàng nổi trên header
  const span = document.getElementById("cart-count");

  // 3. Cập nhật nội dung của thẻ span
  if (span) {
    span.textContent = count;
  }
  // Không cần logic tạo mới vì element đã có sẵn trong HTML (từ file cart.php)
}
//-----------------------------------------------------------------------------------------------------------------
let currentPage = 1;
const perPage = 8;
let currentList = getVisibleProducts(); // Đã lọc sản phẩm và category ẩn

// SỬA: Cập nhật hàm renderProductList TOÀN CỤC để bao gồm Tác giả
function renderProductList(page = 1) {
  const wrap = document.getElementById("product-list");
  if (!wrap) return;

  currentPage = page;
  const all = currentList;
  const start = (page - 1) * perPage;
  const list = all.slice(start, start + perPage);

  // Sử dụng HTML giống như trang category để hiển thị tác giả
  wrap.innerHTML = list
    .map(
      (it) => `
    <div class="product-card">
      <img src="${it.img}" alt="${it.name}">
      <div class="product-info">
        <h3>${it.name}</h3>
        <p class="product-author">Tác giả: ${it.author || "Đang cập nhật"}</p>
        <div class="price">${(it.price || 0).toLocaleString("vi-VN")}₫</div>
        <div class="button-row">
          <a class="btn btn-small" href="user/product-detail.php?id=${it.id
        }">Xem</a>
          <button class="btn btn-cart" onclick="addToCart(${it.id
        }, 1)">Thêm vào giỏ</button>
        </div>
      </div>
    </div>
    `
    )
    .join("");

  renderPagination(Math.ceil(all.length / perPage));

  // Thêm hiệu ứng cuộn lên đầu trang sau khi nhấn đổi trang
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}

function renderPagination(totalPages) {
  const pag = document.getElementById("pagination");
  if (!pag) return;
  if (totalPages <= 1) {
    pag.innerHTML = "";
    return;
  }

  let html = '<div class="pagination-wrap">';
  if (currentPage > 1) {
    html += `<button class="page-btn" onclick="changePage(${currentPage - 1
      })">« Trước</button>`;
  }
  for (let i = 1; i <= totalPages; i++) {
    html += `<button class="page-btn ${i === currentPage ? "active" : ""
      }" onclick="changePage(${i})">${i}</button>`;
  }
  if (currentPage < totalPages) {
    html += `<button class="page-btn" onclick="changePage(${currentPage + 1
      })">Sau »</button>`;
  }
  html += "</div>";
  pag.innerHTML = html;
}

function changePage(p) {
  renderProductList(p);
}

// ===== CHỈNH LẠI LOGIC PHẦN TÌM KIẾM =================================================================================================
// ===== LOGIC TÌM KIẾM =================================
document.addEventListener("DOMContentLoaded", function () {
  // Lấy nút tìm kiếm
  const searchBtn = document.querySelector(".search-btn");
  if (searchBtn) {
    searchBtn.addEventListener("click", function () {
      doSearch();
    });
  }

  // Cho phép nhấn Enter trên input để tìm kiếm
  const searchInput = document.getElementById("topSearch");
  if (searchInput) {
    searchInput.addEventListener("keypress", function (event) {
      if (event.key === "Enter") {
        doSearch();
      }
    });
  }
});

function doSearch() {
  const q = (document.getElementById("topSearch")?.value || "").trim();
  if (!q) {
    alert("Vui lòng nhập từ khóa tìm kiếm");
    return;
  }
  // Không chuyển trang nữa, lọc trực tiếp trên danh sách hiện tại
  const wrap = document.getElementById("product-list");
  if (!wrap) return;

  const keywords = q
    .toLowerCase()
    .split(/\s+/)
    .filter((k) => k);

  const res = getVisibleProducts().filter((p) =>
    keywords.every((k) => p.name.toLowerCase().includes(k))
  );

  if (res.length > 0) {
    currentList = res;
    renderProductList(1);
  } else {
    wrap.innerHTML = `<p class="no-results">Không tìm thấy sản phẩm nào với từ khóa "<strong>${q}</strong>"</p>`;
    const pag = document.getElementById("pagination");
    if (pag) pag.innerHTML = "";
  }
}

function renderSearchResults() {
  // Hàm này giờ không còn cần thiết cho tìm kiếm trang riêng,
  // vì doSearch() đã xử lý lọc trực tiếp mà không reload trang.
  return;
}

// SỬA: Cập nhật hàm renderProductDetail() trong main.js
function renderProductDetail() {
  const mainContent = document.getElementById("mainContent");
  if (!mainContent) return;
  if (mainContent.getAttribute("data-rendered-by") === "php") return;

  const productId = getProductIdFromURL();
  const product = findProductById(productId);

  if (!product) {
    showError();
    return;
  }

  // 1. Lấy số lượng tồn kho thực tế và đảm bảo là giá trị số
  const realStockQty = product ? parseInt(product.qty) || 0 : 0;
  const maxQtyValue = realStockQty;

  // 2. Thiết lập biến kiểm tra hết hàng (qty <= 0)
  const isOutOfStock = realStockQty <= 0;

  // 3. Tạo HTML có điều kiện
  let productActionsHtml;

  if (isOutOfStock) {
    // TRƯỜNG HỢP: HẾT HÀNG (ẨN input, Vô hiệu hóa nút)
    productActionsHtml = `
            <p id="stock-qty" class="stock-info" style="margin-top: 1rem; color: #e74c3c; font-size: 1.2rem; font-weight: 700;">
                💔 HẾT HÀNG - Sản phẩm tạm thời không có sẵn.
            </p>
            <div class="action-buttons">
                <button class="btn-add-to-cart disabled" disabled>
                    <i class="bi bi-cart-plus-fill"></i> Thêm vào giỏ hàng
                </button>
                <button class="btn-buy-now disabled" disabled>
                    <i class="bi bi-wallet-fill"></i> Mua ngay
                </button>
            </div> 
        `;
  } else {
    // TRƯỜNG HỢP: CÒN HÀNG (Hiển thị input và nút)
    productActionsHtml = `
            <div class="quantity-controls">
                <button class="qty-btn minus-btn" onclick="decreaseQty()">-</button>
                <input type="number" id="qty" value="1" min="1" max="${maxQtyValue}">
                <button class="qty-btn plus-btn" onclick="increaseQty()">+</button>
            </div>

            <p id="stock-qty" class="stock-info" style="margin-top: 1rem; color: #7f8c8d; font-size: 0.95rem;">
                Kho: <b>${realStockQty}</b> sản phẩm có sẵn
            </p>

            <div class="action-buttons">
                <button class="btn-add-to-cart" onclick="addToCart(${product.id}, document.getElementById('qty').value)">
                    <i class="bi bi-cart-plus-fill"></i> Thêm vào giỏ hàng
                </button>
                <button class="btn-buy-now">
                    <i class="bi bi-wallet-fill"></i> Mua ngay
                </button>
            </div> 
        `;
  }

  const mainHtml = `
        <div class="product-actions">
            ${productActionsHtml}
        </div>
        
        `;

  mainContent.innerHTML = mainHtml;
  // ... (Phần cuối) ...
}

// SỬA: Cập nhật hàm increaseQty để tôn trọng giá trị max
function increaseQty() {
  const input = document.getElementById("qty");
  if (!input) return;
  // Lấy max từ thuộc tính của input đã được set trong renderProductDetail
  const max = parseInt(input.getAttribute("max"));
  if (parseInt(input.value) < max) {
    input.value = parseInt(input.value) + 1;
  }
}
// Vị trí: Thay thế hàm renderProductDetail và increaseQty hiện có trong main.js.

// BẮT ĐẦU PHẦN CHỈNH SỬA LOGIC GIỎ HÀNG
// Sửa lại hàm addToCart để yêu cầu đăng nhập trước khi thêm vào giỏ
async function addToCart(id, qty = 1) {
  // LOGIC BẮT BUỘC ĐĂNG NHẬP
  const user = localStorage.getItem("bs_user");
  if (!user) {
    openLoginModal();
    return;
  }
  // KẾT THÚC LOGIC BẮT BUỘC ĐĂNG NHẬP

  const quantityToAdd = Number(qty);
  const productId = id;
  const cart = getCart();
  const product = findProductById(productId);

  if (!product) {
    alert("Lỗi: Không tìm thấy thông tin sản phẩm.");
    return;
  }

  const itemInCart = cart.find((i) => i.id === productId);
  const qtyInCart = itemInCart ? itemInCart.qty : 0;
  const stockQty = product.qty;

  if (qtyInCart + quantityToAdd > stockQty) {
    alert(`Số lượng tồn kho của sản phẩm "${product.name}" không đủ.\n\nTồn kho: ${stockQty}\nTrong giỏ: ${qtyInCart}\n\nBạn không thể thêm ${quantityToAdd} sản phẩm nữa.`);
    return;
  }

  const ex = cart.find((i) => i.id === id);
  if (ex) {
    ex.qty += Number(qty);
  } else {
    cart.push({ id: id, qty: Number(qty) });
  }

  await saveCart(cart);
  if (typeof updateCartCount === "function") updateCartCount();

  alert("✅ Đã thêm sản phẩm vào giỏ hàng thành công!");
}
// KẾT THÚC PHẦN CHỈNH SỬA LOGIC GIỎ HÀNG

function renderMenu() {
  const menu = document.getElementById("menu");
  if (!menu) return;

  const user = JSON.parse(localStorage.getItem("bs_user"));
  menu.innerHTML = "";

  menu.innerHTML += `<li><a href="index.php">Trang chủ</a></li>`;
  menu.innerHTML += `<li><a href="cart.php">Giỏ hàng</a></li>`;

  if (user) {
    menu.innerHTML += `<li><a href="profile.php">Thông tin</a></li>`;
    menu.innerHTML += `<li><a href="#" onclick="logout()">Đăng xuất</a></li>`;
  } else {
    menu.innerHTML += `<li><a href="register.php">Đăng ký</a></li>`;
    menu.innerHTML += `<li><a href="login.php">Đăng nhập</a></li>`;
  }
}

function login(username) {
  localStorage.setItem("bs_user", JSON.stringify({ username }));
  renderMenu();
}

// ==========================================================
// ✅ ĐIỂM SỬA LỖI 1: Cập nhật hàm logout()
async function logout() {
  localStorage.removeItem("bs_user");
  await clearCart();
  renderMenu();
  if (typeof updateCartCount === "function") updateCartCount();
  location.reload();
}
// ==========================================================

// ===== PRODUCT DETAIL PAGE FUNCTIONS =====
function getProductIdFromURL() {
  const urlParams = new URLSearchParams(window.location.search);
  return parseInt(urlParams.get("id"));
}

function formatPrice(price) {
  return price.toLocaleString("vi-VN") + "đ";
}

function findProductById(id) {
  return getData().products.find((p) => p.id === id);
}

function goBack() {
  if (document.referrer && (document.referrer.includes("category") || document.referrer.includes("index"))) {
    window.history.back();
  } else {
    window.location.href = "index.php";
  }
}

function showError() {
  const mainContent = document.getElementById("mainContent");
  if (!mainContent) return;

  mainContent.innerHTML = `
    <div class="error-container">
      <h2>❌ Không tìm thấy sản phẩm</h2>
      <p>Sản phẩm bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
      <a href="index.php">← Quay về trang chủ</a>
    </div>
  `;
}

function renderProductDetailPage(product) {
  const mainContent = document.getElementById("mainContent");
  if (!mainContent) return;

  document.title = `${product.name} - Literary Haven`;
  mainContent.innerHTML = `
    <button class="back-button" onclick="goBack()">
      <span class="back-button-arrow">←</span> Quay Lại
    </button>
    
    <div class="breadcrumb">
      <a href="index.php">Literary Haven</a>
      <span>›</span>
      <a href="category.php">${product.category}</a>
      <span>›</span>
      <span style="color: #2c3e50;">${product.subcategory}</span>
    </div>

    <div class="product-layout">
      <div class="image-gallery">
        <div class="main-image">
          <img src="${product.img}" alt="${product.name}">
        </div>
      </div>

      <div class="product-info">
        <h1 class="product-title">📚 ${product.name}</h1>
        
        <span class="badge">${product.category} - ${product.subcategory}</span>

        <div class="product-price">${formatPrice(product.price)}</div>

        <div class="shipping-info">
          <div class="shipping-row">
            <span class="shipping-label">Tác giả:</span>
            <span class="shipping-value">${product.author}</span>
          </div>
          <div class="shipping-row">
            <span class="shipping-label">Mã sản phẩm:</span>
            <span class="shipping-value">${product.sku}</span>
          </div>
          <div class="shipping-row">
            <span class="shipping-label">Danh mục:</span>
            <span class="shipping-value">${product.category} › ${product.subcategory
    }</span>
          </div>
          <div class="shipping-row">
            <span class="shipping-label">Số lượng sách  :</span>
            <span class="shipping-value">${product.qty} quyển </span>
          </div>
        </div>

       <div class="quantity-selector">
          <span class="shipping-label">Số lượng:</span>
          <div class="quantity-controls">
            <button class="qty-btn" onclick="decreaseQty()">−</button>
            <input type="number" class="qty-input" value="1" id="qty" min="1" max="${product.qty}" onchange="validateQtyInput()">
            <button class="qty-btn" onclick="increaseQty()">+</button>
          </div>
          <span class="stock-status">Còn hàng</span>
        </div>

        <div class="action-buttons">
          <button class="btn btn-add-cart" onclick="addToCartDetail(${product.id
    })">🛒 Thêm vào giỏ hàng</button>
          <button class="btn btn-buy-now" onclick="buyNow(${product.id
    })">⚡ Mua ngay</button>
        </div>

        <div class="guarantee-section">
          <div class="guarantee-item">
            <span class="guarantee-icon">✓</span>
            <span>Literary Haven cam kết: nhận sản phẩm như mô tả hoặc nhận tiền hoàn. Mọi thông tin thẻ thanh toán của bạn được bảo mật tuyệt đối.</span>
          </div>
          <div class="guarantee-item">
            <span class="guarantee-icon">✓</span>
            <span>Literary Haven - "The Home, All Tomes" - Nơi mọi cuốn sách tìm thấy ngôi nhà!</span>
          </div>
        </div>
      </div>
    </div>
<div class="details-section">
      <h2 class="section-title">📋 Thông tin chi tiết</h2>

      <div class="info-table">
        <div class="info-row">
          <span class="info-label">Tên sản phẩm</span>
          <span class="info-value">${product.name}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Tác giả</span>
          <span class="info-value">${product.author}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Mã SKU</span>
          <span class="info-value">${product.sku}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Danh mục</span>
          <span class="info-value">${product.category} › ${product.subcategory
    }</span>
        </div>
        <div class="info-row">
          <span class="info-label">Giá bán</span>
          <span class="info-value">${formatPrice(product.price)}</span>
        </div>
      </div>

      <h2 class="section-title" style="margin-top: 3rem;">📝 Mô tả sản phẩm</h2>

      <div class="description-section">
        <p>${product.desc}</p>
        <p>Sản phẩm chính hãng, chất lượng đảm bảo. Giao hàng nhanh chóng trên toàn quốc.</p>
      </div>
    </div>
  `;
}

function validateQtyInput() {
  const input = document.getElementById("qty");
  if (!input) return;

  const min = parseInt(input.min);
  const max = parseInt(input.max);
  let value = parseInt(input.value);

  // Kiểm tra nếu giá trị không phải là số hoặc nhỏ hơn 1
  if (isNaN(value) || value < min) {
    input.value = min;
    return;
  }

  // Kiểm tra nếu giá trị lớn hơn tồn kho
  if (value > max) {
    input.value = max;
    alert(`Số lượng tồn kho chỉ còn ${max} sản phẩm.`);
    return;
  }

  // Ghi lại giá trị đã làm tròn (nếu người dùng nhập số thập phân)
  input.value = value;
}

// Cập nhật hàm tăng số lượng (increaseQty) để giới hạn theo số lượng tồn kho (max attribute)
function increaseQty() {
  const input = document.getElementById("qty");
  if (!input) return;

  // 1. Lấy giới hạn tối đa (chính là số lượng tồn kho được set bởi renderProductDetail)
  const max = parseInt(input.getAttribute('max'));
  const currentValue = parseInt(input.value);

  // 2. Chỉ tăng nếu số lượng hiện tại nhỏ hơn max
  if (currentValue < max) {
    input.value = currentValue + 1;
  } else {
    // Thông báo cho người dùng biết đã đạt giới hạn tồn kho
    alert(`🚫 Số lượng tối đa có thể mua là ${max} sản phẩm.`);
  }
}

// Giữ nguyên hàm decreaseQty()
function decreaseQty() {
  const input = document.getElementById("qty");
  if (!input) return;
  if (parseInt(input.value) > 1) {
    input.value = parseInt(input.value) - 1;
  }
}

// BẮT ĐẦU PHẦN CHỈNH SỬA LOGIC CHI TIẾT SẢN PHẨM
async function addToCartDetail(productId) {
  const qtyInput = document.getElementById("qty");
  const quantityToAdd = qtyInput ? parseInt(qtyInput.value) : 1;
  const product = findProductById(productId);

  const user = localStorage.getItem("bs_user");
  if (!user) {
    openLoginModal();
    return;
  }

  const cart = getCart();
  const itemInCart = cart.find((i) => i.id === productId);
  const qtyInCart = itemInCart ? itemInCart.qty : 0;
  const stockQty = product.qty;

  if (qtyInCart + quantityToAdd > stockQty) {
    alert(`Số lượng tồn kho của sản phẩm "${product.name}" không đủ.\n\nTồn kho: ${stockQty}\nTrong giỏ: ${qtyInCart}\n\nBạn không thể thêm ${quantityToAdd} sản phẩm nữa.`);
    return;
  }

  const ex = cart.find((i) => i.id === productId);
  if (ex) ex.qty += Number(quantityToAdd);
  else cart.push({ id: productId, qty: Number(quantityToAdd) });
  await saveCart(cart);
  updateCartCount();

  const cartCount = document.getElementById("cartCount");
  if (cartCount) {
    const currentCount = parseInt(cartCount.textContent);
    cartCount.textContent = currentCount + quantityToAdd;
  }

  alert(`Đã thêm ${quantityToAdd} × "${product.name}" vào giỏ hàng!`);
}

async function buyNow(productId) {
  const qtyInput = document.getElementById("qty");
  const quantityToAdd = qtyInput ? parseInt(qtyInput.value) : 1;

  const user = localStorage.getItem("bs_user");
  if (!user) {
    openLoginModal();
    return;
  }

  const cart = getCart();
  const product = findProductById(productId);
  const itemInCart = cart.find((i) => i.id === productId);
  const qtyInCart = itemInCart ? itemInCart.qty : 0;
  const stockQty = product.qty;

  if (qtyInCart + quantityToAdd > stockQty) {
    alert(`Số lượng tồn kho của sản phẩm "${product.name}" không đủ.\n\nTồn kho: ${stockQty}\nTrong giỏ: ${qtyInCart}\n\nBạn không thể thêm ${quantityToAdd} sản phẩm nữa.`);
    return;
  }

  const ex = cart.find((i) => i.id === productId);
  if (ex) ex.qty += Number(quantityToAdd);
  else cart.push({ id: productId, qty: Number(quantityToAdd) });
  await saveCart(cart);

  window.location.href = "cart.php";
}
// KẾT THÚC PHẦN CHỈNH SỬA LOGIC CHI TIẾT SẢN PHẨM

function initProductDetail() {
  const mainContent = document.getElementById("mainContent");
  if (!mainContent) return;
  // Trang chi tiết sản phẩm đã render bằng PHP (user/product-detail.php)
  if (mainContent.getAttribute("data-rendered-by") === "php") return;

  const productId = getProductIdFromURL();

  if (!productId) {
    showError();
    return;
  }

  const product = findProductById(productId);

  if (!product) {
    showError();
    return;
  }

  renderProductDetailPage(product);

  // Update cart count on page load
  const cartCount = document.getElementById("cartCount");
  if (cartCount) {
    const cart = getCart();
    const count = cart.reduce((s, i) => s + i.qty, 0);
    cartCount.textContent = count;
  }
}

document.addEventListener("DOMContentLoaded", async function () {
  // 1. Lấy dữ liệu sản phẩm từ server (MySQL)
  bs_data = await fetchDataFromServer();

  // 2. Render danh sách sản phẩm chỉ khi chưa được PHP render (vd: user/index.php đã render sẵn)
  const productListEl = document.getElementById("product-list");
  if (productListEl && productListEl.getAttribute("data-rendered-by") !== "php") {
    renderProductList(1);
  }

  await loadServerCart();
  updateCartCount();
  if (document.getElementById("buyerInfoForm")) {
    fillBuyerFormFromLocalStorage();

    // Load profiles from server on page init
    await loadBuyerProfilesFromServer();
    const activeIndex = getActiveBuyerProfileIndex();
    await switchBuyerProfile(activeIndex);

    document.querySelectorAll(".buyer-profile-btn").forEach((button) => {
      button.addEventListener("click", function () {
        const profileIndex = Number(this.dataset.profile);
        switchBuyerProfile(profileIndex);
      });
    });

    document.getElementById("buyerInfoForm").addEventListener("submit", async function (event) {
      event.preventDefault();

      const profileIndex = Number(document.getElementById("modalBuyerSaveTo").value || 1);
      const profile = {
        name: document.getElementById("modalBuyerName").value.trim(),
        email: document.getElementById("modalBuyerEmail").value.trim(),
        phone: document.getElementById("modalBuyerPhone").value.trim(),
        address: document.getElementById("modalBuyerAddress").value.trim(),
        note: document.getElementById("modalBuyerNote").value.trim(),
      };

      await saveBuyerProfile(profileIndex, profile);
      window.buyerProfiles = window.buyerProfiles || {};
      window.buyerProfiles[profileIndex] = profile;
      refreshChangeProfileCards();
      applyBuyerProfile(profile);
      updateBuyerInfoDisplay();
      closeBuyerInfoModal();
    });
    updateBuyerInfoDisplay();
  }
  renderSearchResults();
  renderProductDetail();
  renderMenu();
  initProductDetail(); // Init product detail page
  loadCategoriesAndPopulateMenu(); // Cập nhật menu danh mục từ Local Storage
  const categoryBtn = document.querySelector(".category-btn");
  if (categoryBtn) {
    categoryBtn.addEventListener("click", function () {
      document.querySelector(".book-filter").classList.toggle("show");
    });
  }

  window.addEventListener("scroll", function () {
    const menu = document.querySelector(".book-filter");
    if (menu && menu.classList.contains("show")) {
      menu.classList.remove("show");
    }
  });

  // ===== PHẦN SỬA ĐỔI CHÍNH Ở ÂY =====
  const categoryLinks = document.querySelectorAll(
    ".book-filter a, .all-books a"
  );
  const productList = document.getElementById("product-list");

  categoryLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      // Luôn cho phép navigate bình thường — PHP sẽ xử lý lọc
      return;
    });
  });
});

/* Assistant added auth UI renderer */

/* --- Auth UI rendering --- */
function getCurrentUser() {
  try {
    return JSON.parse(localStorage.getItem("bs_user"));
  } catch (e) {
    return null;
  }
}
function renderAuth() {
  const authArea = document.getElementById("authArea");
  if (!authArea) return;
  const userObj = getCurrentUser();
  authArea.innerHTML = "";
  if (userObj && userObj.username) {
    const btnGreet = document.createElement("button");
    btnGreet.className = "btn";
    btnGreet.textContent = "Xin chào, " + userObj.username;
    btnGreet.onclick = function () {
      window.location.href = "profile.php";
    };
    const btnLogout = document.createElement("button");
    btnLogout.className = "btn ghost";
    btnLogout.textContent = "Đăng xuất";
    btnLogout.onclick = function () {
      if (confirm("Bạn muốn đăng xuất?")) {
        localStorage.removeItem("bs_user");
        renderAuth();
        updateCartCount && updateCartCount();
        window.location.reload();
      }
    };
    authArea.appendChild(btnGreet);
    authArea.appendChild(btnLogout);
  } else {
    const btnLogin = document.createElement("button");
    btnLogin.className = "btn";
    btnLogin.textContent = "Đăng nhập";
    btnLogin.onclick = function () {
      window.location.href = "login.php";
    };
    const btnReg = document.createElement("button");
    btnReg.className = "btn ghost";
    btnReg.textContent = "Đăng ký";
    btnReg.onclick = function () {
      window.location.href = "register.php";
    };
    authArea.appendChild(btnLogin);
    authArea.appendChild(btnReg);
  }
}
// call renderAuth when DOM ready if not called elsewhere
document.addEventListener("DOMContentLoaded", function () {
  try {
    renderAuth();
  } catch (e) { }
});

/* Assistant added cart float click handler */

// float cart click handler
document.addEventListener("DOMContentLoaded", function () {
  const cbtn =
    document.getElementById("cartBtnFloat") ||
    document.getElementById("cartBtn");
  if (cbtn)
    cbtn.addEventListener("click", function (e) {
      e.preventDefault();
      window.location.href = "cart.php";
    });
});

// Danh mục sách
// Cập nhật breadcrumb cho trang category
function updateCategoryBreadcrumb() {
  const breadcrumbBtn = document.getElementById("breadcrumb-category");
  if (!breadcrumbBtn) return;

  const params = new URLSearchParams(window.location.search);
  const category = params.get("category");
  const subcategory = params.get("subcategory");

  if (!category) {
    breadcrumbBtn.textContent = "Danh mục sách";
  } else if (subcategory) {
    breadcrumbBtn.textContent = `Danh mục sách > ${category} > ${subcategory}`;
  } else {
    breadcrumbBtn.textContent = `Danh mục sách > ${category}`;
  }
}

// Gọi hàm khi trang load
document.addEventListener("DOMContentLoaded", function () {
  updateCategoryBreadcrumb();
});


// ==================== MODAL FUNCTIONS ====================

// Mở modal đăng nhập
function openLoginModal() {
  document.getElementById("loginModal").classList.add("show");
  document.body.style.overflow = "hidden"; // Ngăn scroll body
}

// Đóng modal đăng nhập
function closeLoginModal() {
  document.getElementById("loginModal").classList.remove("show");
  document.body.style.overflow = "auto";
  clearFormErrors();
}

// Mở modal đăng ký
function openRegisterModal() {
  document.getElementById("registerModal").classList.add("show");
  document.body.style.overflow = "hidden";
}

// Đóng modal đăng ký
function closeRegisterModal() {
  document.getElementById("registerModal").classList.remove("show");
  document.body.style.overflow = "auto";
  clearFormErrors();
}

// Mở modal profile
function openProfileModal() {
  const userStr = localStorage.getItem("bs_user");
  if (!userStr) {
    openLoginModal();
    return;
  }

  const user = JSON.parse(userStr);
  document.getElementById("profile-fullname").textContent =
    "Xin chào, " + user.fullName + "!";
  document.getElementById("profile-name-value").textContent = user.fullName;
  document.getElementById("profile-username-value").textContent = user.username;
  document.getElementById("profile-email-value").textContent = user.email;
  document.getElementById("profile-phone-value").textContent = user.phone;
  document.getElementById("profile-address-value").textContent = user.address;

  document.getElementById("profileModal").classList.add("show");
  document.body.style.overflow = "hidden";
}

// Đóng modal profile
function closeProfileModal() {
  document.getElementById("profileModal").classList.remove("show");
  document.body.style.overflow = "auto";
}

// Chuyển từ login sang register
function switchToRegister() {
  closeLoginModal();
  setTimeout(() => openRegisterModal(), 200);
}

// Chuyển từ register sang login
function switchToLogin() {
  closeRegisterModal();
  setTimeout(() => openLoginModal(), 200);
}

// Xóa lỗi form
function clearFormErrors() {
  document
    .querySelectorAll(".error-msg")
    .forEach((el) => (el.textContent = ""));
}

// Toggle hiển thị mật khẩu
function togglePassword(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon = document.getElementById(iconId);

  if (input.type === "password") {
    input.type = "text";
    icon.textContent = "👁️";
  } else {
    input.type = "password";
    icon.textContent = "👁️‍🗨️";
  }
}

// Validate email
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

// Validate số điện thoại
function validatePhone(phone) {
  const re = /^[0-9]{10}$/;
  return re.test(phone.replace(/\s/g, ""));
}

// Xử lý đăng nhập
function handleLogin(e) {
  e.preventDefault();

  const username = document.getElementById("login-username").value.trim();
  const password = document.getElementById("login-password").value;

  clearFormErrors();

  let hasError = false;

  if (!username) {
    document.getElementById("error-login-username").textContent =
      "Vui lòng nhập tài khoản";
    hasError = true;
  }

  if (!password) {
    document.getElementById("error-login-password").textContent =
      "Vui lòng nhập mật khẩu";
    hasError = true;
  }

  if (hasError) return;

  // Đăng nhập qua API thay vì localStorage
  loginViaApi(username, password)
    .then((resp) => {
      const user = resp.user;
      if (!user) {
        throw new Error("Không nhận được thông tin user từ server");
      }

      localStorage.setItem(
        "bs_user",
        JSON.stringify({
          id: user.id,
          status: user.status,
          username: user.username,
          fullName: user.fullName,
          email: user.email,
          phone: user.phone,
          address: user.address,
        })
      );

      closeLoginModal();
      alert("Đăng nhập thành công!");
      updateAuthUI();
      location.reload();
    })
    .catch((err) => {
      const msg = err.message || "Đăng nhập thất bại";
      if (msg.includes("không tồn tại")) {
        document.getElementById("error-login-username").textContent = msg;
      } else if (msg.includes("Mật khẩu")) {
        document.getElementById("error-login-password").textContent = msg;
      } else {
        alert(msg);
      }
    });
}

// Xử lý đăng ký
function handleRegister(e) {
  e.preventDefault();

  const fullName = document.getElementById("reg-fullname").value.trim();
  const username = document.getElementById("reg-username").value.trim();
  const password = document.getElementById("reg-password").value;
  const confirmPassword = document.getElementById("reg-confirm-password").value;
  const email = document.getElementById("reg-email").value.trim();
  const phone = document.getElementById("reg-phone").value.trim();
  const address = document.getElementById("reg-address").value.trim();

  clearFormErrors();

  let hasError = false;

  if (!fullName) {
    document.getElementById("error-fullname").textContent =
      "Vui lòng nhập họ tên";
    hasError = true;
  }

  if (!username) {
    document.getElementById("error-username").textContent =
      "Vui lòng nhập tài khoản";
    hasError = true;
  } else if (username.length < 4) {
    document.getElementById("error-username").textContent =
      "Tài khoản phải có ít nhất 4 ký tự";
    hasError = true;
  }

  if (!password) {
    document.getElementById("error-password").textContent =
      "Vui lòng nhập mật khẩu";
    hasError = true;
  } else if (password.length < 6) {
    document.getElementById("error-password").textContent =
      "Mật khẩu phải có ít nhất 6 ký tự";
    hasError = true;
  }

  if (password !== confirmPassword) {
    document.getElementById("error-confirm-password").textContent =
      "Mật khẩu không khớp";
    hasError = true;
  }

  if (!email) {
    document.getElementById("error-email").textContent = "Vui lòng nhập email";
    hasError = true;
  } else if (!validateEmail(email)) {
    document.getElementById("error-email").textContent = "Email không hợp lệ";
    hasError = true;
  }

  if (!phone) {
    document.getElementById("error-phone").textContent =
      "Vui lòng nhập số điện thoại";
    hasError = true;
  } else if (!validatePhone(phone)) {
    document.getElementById("error-phone").textContent =
      "Số điện thoại phải có 10 chữ số";
    hasError = true;
  }

  if (!address) {
    document.getElementById("error-address").textContent =
      "Vui lòng nhập địa chỉ";
    hasError = true;
  }

  if (hasError) return;

  // Gửi dữ liệu đăng ký lên server
  registerViaApi({
    fullName,
    username,
    password,
    email,
    phone,
    address,
  })
    .then(() => {
      closeRegisterModal();
      alert("Đăng ký thành công! Vui lòng đăng nhập.");
      setTimeout(() => openLoginModal(), 300);
    })
    .catch((err) => {
      const msg = err.message || "Đăng ký thất bại";
      if (msg.includes("Tài khoản đã tồn tại")) {
        document.getElementById("error-username").textContent = msg;
      } else {
        alert(msg);
      }
    });
}

// ==========================================================
// ✅ ĐIỂM SỬA LỖI 2: Cập nhật hàm handleLogoutModal()
async function handleLogoutModal() {
  if (confirm("Bạn có chắc muốn đăng xuất?")) {
    localStorage.removeItem("bs_user");
    // THÊM: Xóa giỏ hàng khi đăng xuất để reset về 0
    await clearCart();
    closeProfileModal();
    updateAuthUI();
    if (typeof updateCartCount === "function") updateCartCount();
    location.reload();
  }
}
// ==========================================================

// Cập nhật giao diện auth
// CHỖ SỬA: Cập nhật hàm updateAuthUI() để hiển thị dropdown thay vì modal
function updateAuthUI() {
  const authArea = document.getElementById("authArea");
  if (!authArea) return;

  const userStr = localStorage.getItem("bs_user");

  if (userStr) {
    const user = JSON.parse(userStr);
    // SỬA: Thay đổi HTML để tạo dropdown menu
    authArea.innerHTML = `
      <div class="user-profile-dropdown">
        <button class="user-profile-btn">
          <span class="dropdown-icon">👤</span>
          <span>${user.fullName}</span>
          <span class="user-dropdown-icon">▼</span>
        </button>
        
        <ul class="user-dropdown-menu">
          <li>
            <a href="#" onclick="viewProfile(event)">
              <span class="dropdown-icon"></span>
              Thông tin cá nhân
            </a>
          </li>
          <li>
            <a href="#" onclick="viewOrderHistory(event)">
              <span class="dropdown-icon"></span>
               Lịch sử mua hàng
            </a>
          </li>
          <li class="user-submenu">
            <div class="dropdown-item">
              <span class="dropdown-icon"></span>
              Tùy chọn
            </div>
            <ul class="user-submenu-content">
              <li>
                <a href="#" onclick="editProfile(event)">
                  <span class="dropdown-icon"></span>
                  Sửa thông tin cá nhân
                </a>
              </li>
              <li>
                <a href="#" onclick="changePassword(event)">
                  <span class="dropdown-icon"></span>
                  Đổi mật khẩu
                </a>
              </li>
            </ul>
          </li>
          <li>
          <a href="#" onclick="handleLogoutDropdown(event)" class="logout-link">
              <span class="dropdown-icon"></span>
              Đăng xuất
            </a>
          </li>
        </ul>
      </div>
    `;
  } else {
    authArea.innerHTML = `
      <button class="btn-auth" onclick="openLoginModal()">Đăng nhập</button>
      <button class="btn-auth btn-signup" onclick="openRegisterModal()">Đăng ký</button>
    `;
  }
}

// Xem thông tin cá nhân
function viewProfile(e) {
  if (e) e.preventDefault();
  openProfileModal(); // Có thể giữ modal hoặc chuyển sang trang mới
}

// ===================================================================================================================
// Xem lịch sử mua hàng
function viewOrderHistory(e) {
  if (e) e.preventDefault();
  // alert('Chức năng đang phát triển: Lịch sử mua hàng'); // Bỏ dòng này
  window.location.href = "purchase-history.php"; // Bỏ // và sửa tên file
}
//==================================================================================================================
// Sửa thông tin cá nhân
function editProfile(e) {
  if (e) e.preventDefault();
  // Chuyển hướng đến trang sửa thông tin cá nhân
  window.location.href = "update-profile.php";
}
//==================================================================================================================
// Đổi mật khẩu
function changePassword(e) {
  if (e) e.preventDefault();
  // Chuyển hướng đến trang đổi mật khẩu
  window.location.href = "change-password.php";
}
//==================================================================================================================
async function handleLogoutDropdown(e) {
  if (e) e.preventDefault();
  if (confirm("Bạn có chắc muốn đăng xuất?")) {
    localStorage.removeItem("bs_user");
    await clearCart();
    updateAuthUI();
    if (typeof updateCartCount === "function") updateCartCount();
    location.reload();
  }
}
// ==========================================================

// === BẮT ĐẦU: XỬ LÝ CLICK CHO DROPDOWN HỒ SƠ ===
// (Khối này thay thế cho listener trống "click bên ngoài" trước đó)
document.addEventListener("click", function (e) {
  const clickedElement = e.target;
  const mainDropdown = document.querySelector(".user-profile-dropdown");

  // Nếu chưa đăng nhập (không có dropdown), thì không làm gì cả
  if (!mainDropdown) return;

  // 1. Xử lý click vào NÚT CHÍNH (user-profile-btn)
  // .closest() sẽ tìm chính nó hoặc cha gần nhất
  const mainBtn = clickedElement.closest(".user-profile-btn");
  if (mainBtn) {
    // Bật/tắt menu chính
    mainDropdown.classList.toggle("active");

    // Nếu vừa đóng menu chính, đóng luôn menu con
    if (!mainDropdown.classList.contains("active")) {
      document
        .querySelectorAll(".user-submenu.active")
        .forEach((sub) => sub.classList.remove("active"));
    }
    return; // Đã xử lý xong, không làm gì thêm
  }

  // 2. Xử lý click vào NÚT MENU CON (Tùy chọn)
  const submenuTrigger = clickedElement.closest(".user-submenu .dropdown-item");
  if (submenuTrigger) {
    const submenuLi = submenuTrigger.closest(".user-submenu");
    if (submenuLi) {
      // Bật/tắt menu con này
      submenuLi.classList.toggle("active");
    }
    return; // Đã xử lý xong
  }

  // 3. Xử lý click BÊN NGOÀI TOÀN BỘ dropdown
  // Nếu click ra ngoài (không chứa trong mainDropdown), đóng tất cả
  if (!mainDropdown.contains(clickedElement)) {
    mainDropdown.classList.remove("active");
    document
      .querySelectorAll(".user-submenu.active")
      .forEach((sub) => sub.classList.remove("active"));
    return;
  }

  // 4. (Tùy chọn) Xử lý click vào link (ví dụ "Lịch sử mua hàng") để đóng menu
  // Nếu click vào một link (<a>) bên trong menu
  // và nó KHÔNG PHẢI là link của submenu (đã xử lý ở bước 2)
  const clickedLink = clickedElement.closest(
    ".user-dropdown-menu > li > a, .user-submenu-content a"
  );
  if (clickedLink) {
    mainDropdown.classList.remove("active");
    document
      .querySelectorAll(".user-submenu.active")
      .forEach((sub) => sub.classList.remove("active"));
    // (onclick của link sẽ tự chạy)
  }
});
// === KẾT THÚC: XỬ LÝ CLICK CHO DROPDOWN HỒ SƠ ===

// Khởi tạo
document.addEventListener("DOMContentLoaded", function () {
  // Gán sự kiện submit cho form
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", handleLogin);
  }

  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    registerForm.addEventListener("submit", handleRegister);
  }

  // Cập nhật UI
  updateAuthUI();

  // Đóng modal khi nhấn ESC
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      closeLoginModal();
      closeRegisterModal();
      closeProfileModal();
    }
  });
});

// Xử lý tìm kiếm từ thanh search trên header
function handleTopSearch() {
  const searchInput = document.getElementById("topSearch");
  if (!searchInput) return;

  const query = searchInput.value.trim();
  if (!query) {
    alert("Vui lòng nhập từ khóa tìm kiếm");
    return;
  }

  window.location.href = "search-results.php?q=" + encodeURIComponent(query);
}

// Giữ từ khóa tìm kiếm trong ô input
function loadSearchQuery() {
  const topSearch = document.getElementById("topSearch");
  if (!topSearch) return;

  const urlParams = new URLSearchParams(window.location.search);
  const query = urlParams.get("q");

  if (query) {
    topSearch.value = query;
  }
}

// Thêm sự kiện khi DOM load
document.addEventListener("DOMContentLoaded", function () {
  const topSearch = document.getElementById("topSearch");

  if (topSearch) {
    // Xử lý khi nhấn Enter
    topSearch.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();
        handleTopSearch();
      }
    });

    // Giữ từ khóa tìm kiếm trong ô input
    loadSearchQuery();
  }
});
// Các hàm updateProductStock / CRUD sản phẩm cũ dùng localStorage đã bị loại bỏ