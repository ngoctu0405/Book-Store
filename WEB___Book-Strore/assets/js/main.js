const SAMPLE = {
  products: [
    // ================= Văn học =================
    {
      id: 1,
      sku: "VH001",
      name: "Đắc Nhân Tâm",
      author: "Dale Carnegie",
      price: 85000,
      category: "Văn học",
      subcategory: "Tiểu thuyết",
      desc: "Tác phẩm kinh điển về nghệ thuật giao tiếp.",
      img: "images/Đắc_Nhân_Tâm.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 2,
      sku: "VH002",
      name: "Tuổi Trẻ Đáng Giá Bao Nhiêu",
      author: "Rosie Nguyễn",
      price: 90000,
      category: "Văn học",
      subcategory: "Tiểu thuyết",
      desc: "Truyện cảm hứng cho bạn trẻ tìm kiếm chính mình.",
      img: "images/Tuoi_tre_dang_gia_bao_nhiêu.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 3,
      sku: "VH003",
      name: "Truyện Kiều",
      author: "Nguyễn Du",
      price: 70000,
      category: "Văn học",
      subcategory: "Thơ",
      desc: "Kiệt tác văn học Việt Nam.",
      img: "images/Truyện_Kiều.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 4,
      sku: "VH004",
      name: "Tắt Đèn",
      author: "Ngô Tất Tố",
      price: 65000,
      category: "Văn học",
      subcategory: "Truyện ngắn",
      desc: "Tác phẩm hiện thực phê phán sâu sắc.",
      img: "images/Tắt_Đèn.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 5,
      sku: "VH005",
      name: "Lão Hạc",
      author: "Nam Cao",
      price: 60000,
      category: "Văn học",
      subcategory: "Truyện ngắn",
      desc: "Câu chuyện đầy nhân văn về thân phận người nông dân.",
      img: "images/Lão_Hạc.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 6,
      sku: "VH006",
      name: "Nhật Ký Trong Tù",
      author: "Hồ Chí Minh",
      price: 80000,
      category: "Văn học",
      subcategory: "Thơ",
      desc: "Tập thơ giàu triết lý và tinh thần cách mạng.",
      img: "images/Nhật_Ký_Trong_Tù.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 7,
      sku: "VH007",
      name: "Số Đỏ",
      author: "Vũ Trọng Phụng",
      price: 95000,
      category: "Văn học",
      subcategory: "Tiểu thuyết",
      desc: "Tác phẩm trào phúng đặc sắc.",
      img: "images/Số_Đỏ.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 8,
      sku: "VH008",
      name: "Chí Phèo",
      author: "Nam Cao",
      price: 60000,
      category: "Văn học",
      subcategory: "Truyện ngắn",
      desc: "Bi kịch của người nông dân trong xã hội cũ.",
      img: "images/Chí_Phèo.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 9,
      sku: "VH009",
      name: "Tôi Thấy Hoa Vàng Trên Cỏ Xanh",
      author: "Nguyễn Nhật Ánh",
      price: 100000,
      category: "Văn học",
      subcategory: "Tiểu thuyết",
      desc: "Câu chuyện tuổi thơ đầy xúc động.",
      img: "images/Tôi_thấy_hoa_vàng_trên_cỏ_xanh.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 10,
      sku: "VH010",
      name: "Người Lái Đò Sông Đà",
      author: "Nguyễn Tuân",
      price: 72000,
      category: "Văn học",
      subcategory: "Truyện ngắn",
      desc: "Tác phẩm tiêu biểu cho phong cách tùy bút độc đáo.",
      img: "images/Người_lái_đò_sông_Đà.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 11,
      sku: "VH011",
      name: "Nhật Ký Đặng Thùy Trâm",
      author: "Đặng Thùy Trâm",
      price: 85000,
      category: "Văn học",
      subcategory: "Tiểu thuyết",
      desc: "Tấm gương sáng của một nữ bác sĩ trong chiến tranh.",
      img: "images/Nhật_ký_Đặng_Thùy_Trâm.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 12,
      sku: "VH012",
      name: "Ánh Trăng",
      author: "Nguyễn Duy",
      price: 55000,
      category: "Văn học",
      subcategory: "Thơ",
      desc: "Tập thơ nổi tiếng với nhiều bài thơ sâu sắc.",
      img: "images/Ánh_Trắng.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 13,
      sku: "VH013",
      name: "Harry Potter và Hòn Đá Phù Thủy",
      author: "J. K. Rowling",
      price: 120000,
      category: "Văn học",
      subcategory: "Tiểu thuyết",
      desc: "Tập đầu tiên của loạt Harry Potter.",
      img: "images/Harry_Potter_và_Hòn_Đá_Phù_Thủy.jpg", // ĐÃ SỬA: Bỏ "/"
    },

    // ================= Kinh tế =================
    {
      id: 14,
      sku: "KT001",
      name: "Cha Giàu Cha Nghèo",
      author: "Robert Kiyosaki",
      price: 120000,
      category: "Kinh tế",
      subcategory: "Tài chính",
      desc: "Sách tài chính cá nhân nổi tiếng.",
      img: "images/Cha_Giàu_Cha_Nghèo.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 15,
      sku: "KT002",
      name: "Quốc Gia Khởi Nghiệp",
      author: "Dan Senor",
      price: 140000,
      category: "Kinh tế",
      subcategory: "Quản trị",
      desc: "Bài học khởi nghiệp từ Israel.",
      img: "images/Quốc_gia_khởi_nghiệp.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 16,
      sku: "KT003",
      name: "7 Thói Quen Hiệu Quả",
      author: "Stephen Covey",
      price: 135000,
      category: "Kinh tế",
      subcategory: "Quản trị",
      desc: "Hướng dẫn kỹ năng lãnh đạo cá nhân.",
      img: "images/7_Thói_Quen_Hiệu_Quả.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 17,
      sku: "KT004",
      name: "Dạy Con Làm Giàu",
      author: "Robert Kiyosaki",
      price: 150000,
      category: "Kinh tế",
      subcategory: "Tài chính",
      desc: "Loạt sách tài chính cá nhân nổi tiếng.",
      img: "images/Dạy_con_làm_giàu_III.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 18,
      sku: "KT005",
      name: "Lợi Thế Cạnh Tranh",
      author: "Michael Porter",
      price: 160000,
      category: "Kinh tế",
      subcategory: "Marketing",
      desc: "Tác phẩm tâm lý học ứng dụng trong kinh tế.",
      img: "images/Lợi_Thế_Cạnh_Tranh.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 19,
      sku: "KT006",
      name: "Tư Duy Phản Biện",
      author: "Richard Paul",
      price: 180000,
      category: "Kinh tế",
      subcategory: "Quản trị",
      desc: "Sách chiến lược kinh doanh kinh điển.",
      img: "images/Tư_duy_phản_biện.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 20,
      sku: "KT007",
      name: "Marketing 4.0",
      author: "Philip Kotler",
      price: 140000,
      category: "Kinh tế",
      subcategory: "Marketing",
      desc: "Xu hướng marketing hiện đại.",
      img: "images/Marketing_4.0.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 21,
      sku: "KT008",
      name: "Kinh Tế Dành Cho Doanh Nhân",
      author: "Nguyễn Đình Cungx`",
      price: 125000,
      category: "Kinh tế",
      subcategory: "Tài chính",
      desc: "Sách làm giàu kinh điển.",
      img: "images/Kinh_doanh.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 22,
      sku: "KT009",
      name: "Chiến Lược Đại Dương Xanh",
      author: "W. Chan Kim",
      price: 170000,
      category: "Kinh tế",
      subcategory: "Quản trị",
      desc: "Mô hình chiến lược kinh doanh đột phá.",
      img: "images/Chiến_lược_đại_dương_xanh.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 23,
      sku: "KT010",
      name: "Những Đoạn Tâm Lý Thuyết Phục",
      author: "Dan Ariely",
      price: 110000,
      category: "Kinh tế",
      subcategory: "Tài chính",
      desc: "Kinh tế học giản lược, dễ hiểu.",
      img: "images/Những_đoàn_tâm_lý_thuyết_phục.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 24,
      sku: "KT011",
      name: "Cách Nghĩ Để Thành Công",
      author: "Dale Carnegie",
      price: 160000,
      category: "Kinh tế",
      subcategory: "Marketing",
      desc: "Cuốn sách kinh điển về nghệ thuật thuyết phục.",
      img: "images/Cách_Nghĩ_Để_Thành_Công.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 25,
      sku: "KT012",
      name: "Lãnh Đạo Không Chức Danh",
      author: "Robin Sharma",
      price: 145000,
      category: "Kinh tế",
      subcategory: "Quản trị",
      desc: "Nghệ thuật lãnh đạo bản thân và tổ chức.",
      img: "images/Nhà_lãnh_đạo_không_chức_danh.png", // ĐÃ SỬA: Bỏ "/"
    },

    // ================= Thiếu nhi =================
    {
      id: 26,
      sku: "TN001",
      name: "Doraemon Tập 29",
      author: "Fujiko F. Fujio",
      price: 25000,
      category: "Thiếu nhi",
      subcategory: "Truyện tranh",
      desc: "Truyện tranh nổi tiếng Nhật Bản.",
      img: "images/Doreamon_tập_29.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 27,
      sku: "TN002",
      name: "Conan Tập 5",
      author: "Gosho Aoyama",
      price: 30000,
      category: "Thiếu nhi",
      subcategory: "Truyện tranh",
      desc: "Thám tử lừng danh Conan.",
      img: "images/Conan_tập_5.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 28,
      sku: "TN004",
      name: "Miko Tập 33",
      author: "Nhiều tác giả",
      price: 85000,
      category: "Thiếu nhi",
      subcategory: "Giáo dục",
      desc: "Câu chuyện giáo dục đầy cảm hứng.",
      img: "images/MIKO_tập_33.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 29,
      sku: "TN005",
      name: "Dragon Ball Tập 19",
      author: "Akira Toriyama",
      price: 35000,
      category: "Thiếu nhi",
      subcategory: "Truyện tranh",
      desc: "Bộ manga nổi tiếng toàn cầu.",
      img: "images/Dragon_Ball_Tập_19.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 30,
      sku: "TN006",
      name: "Thần Đồng Đất Việt Tập 1",
      author: "Lê Linh",
      price: 28000,
      category: "Thiếu nhi",
      subcategory: "Truyện tranh",
      desc: "Truyện tranh Việt Nam nổi bật.",
      img: "images/Thần_đồng_đất_Việt_tập_1.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 31,
      sku: "TN007",
      name: "Shin - cậu bé bút chì ",
      author: "Takahashi Yoshito",
      price: 90000,
      category: "Thiếu nhi",
      subcategory: "Giáo dục",
      desc: "Tác phẩm văn học thiếu nhi nổi bật.",
      img: "images/Cậu_bé_bút_chì.jpg", // ĐÃ SỬA: Bỏ "/"
    },

    // ================= Giáo khoa =================
    {
      id: 32,
      sku: "GK001",
      name: "Toán Lớp 1",
      author: "Nhiều tác giả",
      price: 18000,
      category: "Giáo khoa",
      subcategory: "Cấp 1",
      desc: "Sách giáo khoa Toán lớp 1.",
      img: "images/Toan_Lop_1.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 33,
      sku: "GK002",
      name: "Tiếng Việt Lớp 2",
      author: "Nhiều tác giả",
      price: 20000,
      category: "Giáo khoa",
      subcategory: "Cấp 1",
      desc: "Sách giáo khoa Tiếng Việt lớp 2.",
      img: "images/Tieng_Viet_lớp_2.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 34,
      sku: "GK003",
      name: "Hóa học Lớp 8",
      author: "Nhiều tác giả",
      price: 25000,
      category: "Giáo khoa",
      subcategory: "Cấp 2",
      desc: "Sách giáo khoa Hóa học lớp 8.",
      img: "images/Hóa_học_lớp_8.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 35,
      sku: "GK004",
      name: "Lịch sử Lớp 8",
      author: "Nhiều tác giả",
      price: 28000,
      category: "Giáo khoa",
      subcategory: "Cấp 2",
      desc: "Sách giáo khoa Lịch sử lớp 7.",
      img: "images/Lịch_sử_lớp_8.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 36,
      sku: "GK005",
      name: "Vật lí Lớp 11",
      author: "Nhiều tác giả",
      price: 27000,
      category: "Giáo khoa",
      subcategory: "Cấp 3",
      desc: "Sách giáo khoa Vật lí lớp 11.",
      img: "images/Vật_lí_lớp_11.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 37,
      sku: "GK006",
      name: "Mỹ thuật Lớp 5",
      author: "Nhiều tác giả",
      price: 32000,
      category: "Giáo khoa",
      subcategory: "Cấp 1",
      desc: "Sách giáo khoa Mỹ thuật lớp 5.",
      img: "images/Mĩ_thuật_lớp_5.png", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 38,
      sku: "GK007",
      name: "Hóa Học Lớp 11",
      author: "Nhiều tác giả",
      price: 34000,
      category: "Giáo khoa",
      subcategory: "Cấp 3",
      desc: "Sách giáo khoa Hóa học lớp 11.",
      img: "images/Hóa_học_lớp_11.jpg", // ĐÃ SỬA: Bỏ "/"
    },
    {
      id: 39,
      sku: "GK008",
      name: "Đạo đức Lớp 4",
      author: "Nhiều tác giả",
      price: 36000,
      category: "Giáo khoa",
      subcategory: "Cấp 1",
      desc: "Sách giáo khoa Đạo đức lớp 4.",
      img: "images/Đạo_đức_lớp_4.jpg", // ĐÃ SỬA: Bỏ "/"
    },
  ],
};

if (!localStorage.getItem("bs_data"))
  localStorage.setItem("bs_data", JSON.stringify(SAMPLE));
if (!localStorage.getItem("bs_cart"))
  localStorage.setItem("bs_cart", JSON.stringify([]));
if (!localStorage.getItem("bs_orders"))
  localStorage.setItem("bs_orders", JSON.stringify([]));

function getData() {
  return JSON.parse(localStorage.getItem("bs_data"));
}
function getCart() {
  return JSON.parse(localStorage.getItem("bs_cart"));
}
function saveCart(c) {
  localStorage.setItem("bs_cart", JSON.stringify(c));
}
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
  // Không cần logic tạo mới vì element đã có sẵn trong HTML (từ file cart.html)
}
//-----------------------------------------------------------------------------------------------------------------
let currentPage = 1;
const perPage = 8;
let currentList = getData().products;

function renderProductList(page = 1) {
  const wrap = document.getElementById("product-list");
  if (!wrap) return;
  currentPage = page;

  const all = currentList;
  const start = (page - 1) * perPage;
  const list = all.slice(start, start + perPage);

  wrap.innerHTML = list
    .map(
      (it) => `
  <div class="product-card">
    <img src="${it.img}" alt="">
    <h3>${it.name}</h3>
    <div class="price">${it.price.toLocaleString("vi-VN")}đ</div>
  <div class="button-row">
  <a class="btn btn-small" href="product-detail.html?id=${it.id}">Xem</a>
<button class="btn btn-cart" onclick="addToCart(${
        it.id
      },1)">Thêm vào giỏ</button>
</div>
  </div>`
    )
    .join("");

  renderPagination(Math.ceil(all.length / perPage));
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
    html += `<button class="page-btn" onclick="changePage(${
      currentPage - 1
    })">« Trước</button>`;
  }
  for (let i = 1; i <= totalPages; i++) {
    html += `<button class="page-btn ${
      i === currentPage ? "active" : ""
    }" onclick="changePage(${i})">${i}</button>`;
  }
  if (currentPage < totalPages) {
    html += `<button class="page-btn" onclick="changePage(${
      currentPage + 1
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
  window.location.href = "search-results.html?q=" + encodeURIComponent(q);
}

function renderSearchResults() {
  const wrap = document.getElementById("search-results");
  if (!wrap) return;

  const q = (new URLSearchParams(location.search).get("q") || "").trim();
  if (!q) {
    wrap.innerHTML = '<p class="no-results">Không có từ khóa tìm kiếm</p>';
    return;
  }

  // Tách từ khóa thành mảng và tìm kiếm (AND logic)
  const keywords = q
    .toLowerCase()
    .split(/\s+/)
    .filter((k) => k);

  const res = getData().products.filter((p) =>
    keywords.every((k) => p.name.toLowerCase().includes(k))
  );

  wrap.innerHTML = res.length
    ? res
        .map(
          (it) => `
      <div class="product-card"> 
        <img src="${it.img}" alt="${it.name}"> 
        <h3>${it.name}</h3>
        <div class="price">${it.price.toLocaleString("vi-VN")}đ</div>
        <div class="button-row">
          <a class="btn btn-small" href="product-detail.html?id=${
            it.id
          }">Xem</a>
          <button class="btn btn-cart" onclick="addToCart(${
            it.id
          },1)">Thêm vào giỏ</button>
        </div>
      </div>`
        )
        .join("")
    : `<p class="no-results">Không tìm thấy sản phẩm nào với từ khóa "<strong>${q}</strong>"</p>`;
}

function renderProductDetail() {
  const wrap = document.getElementById("product-detail");
  if (!wrap) return;
  const id = new URLSearchParams(location.search).get("id");
  const p =
    getData().products.find((x) => String(x.id) === String(id)) ||
    getData().products[0];
  wrap.innerHTML = `
    <div class="product-card">
      <img src="${p.img}" alt="">
      <h2>${p.name}</h2>
      <p class="price">${p.price.toLocaleString("vi-VN")}đ</p>
      <p>${p.desc}</p>
      <label>Số lượng 
        <input id="qty" type="number" value="1" min="1" max="${p.stock}">
      </label><br>
      <button class="btn" onclick="addToCart(${
        p.id
      }, document.getElementById('qty').value)">Thêm vào giỏ</button>
    </div>`;
}

// BẮT ĐẦU PHẦN CHỈNH SỬA LOGIC GIỎ HÀNG
// Sửa lại hàm addToCart để yêu cầu đăng nhập trước khi thêm vào giỏ
function addToCart(id, qty = 1) {
  // LOGIC BẮT BUỘC ĐĂNG NHẬP
  const user = localStorage.getItem("bs_user");
  if (!user) {
    // Nếu chưa đăng nhập, HIỆN MODAL ĐĂNG NHẬP
    openLoginModal();
    return;
  }
  // KẾT THÚC LOGIC BẮT BUỘC ĐĂNG NHẬP

  const cart = getCart();

  // Kiểm tra xem sản phẩm đã có trong giỏ chưa
  const ex = cart.find((i) => i.id === id);

  if (ex) {
    // Nếu có, tăng số lượng
    ex.qty += Number(qty);
  } else {
    // Nếu chưa, thêm mới sản phẩm
    cart.push({ id: id, qty: Number(qty) });
  }

  // Lưu giỏ hàng đã cập nhật vào LocalStorage
  saveCart(cart);

  // Cập nhật số lượng hiển thị trên icon giỏ hàng
  if (typeof updateCartCount === "function") updateCartCount();

  alert("✅ Đã thêm sản phẩm vào giỏ hàng thành công!");

  // Nếu bạn đang ở trang giỏ hàng (cart.html), renderCart sẽ cập nhật lại danh sách
  if (typeof renderCart === "function") renderCart();
}
// KẾT THÚC PHẦN CHỈNH SỬA LOGIC GIỎ HÀNG

// SỬA LỖI Ở ĐÂY: Thêm thẻ <img> và loại bỏ lỗi cú pháp
function renderCart() {
  const wrap = document.getElementById("cart-contents");
  if (!wrap) return;
  const cart = getCart();
  if (!cart.length) {
    wrap.innerHTML = "<p>Giỏ hàng rỗng</p>";
    return;
  }
  const data = getData().products;
  wrap.innerHTML =
    cart
      .map((i) => {
        const p = data.find((x) => x.id === i.id);

        // SỬA: Thêm thẻ <img> và loại bỏ x;
        return `<div class="cart-item-card" style="display: flex; gap: 15px; margin-bottom: 15px; border-bottom: 1px dashed #eee; padding-bottom: 10px;">
        <img src="${p.img}" alt="${
          p.name
        }" style="width: 70px; height: 90px; object-fit: cover; border: 1px solid #ddd;">
        <div>
          <h4>${p.name}</h4>
          <p>Số lượng: ${i.qty}</p><p style="font-weight: 700;">Giá: ${(
          p.price * i.qty
        ).toLocaleString("vi-VN")}đ</p>
        </div>
        </div>`;
      })
      .join("") +
    `<p style="font-weight:700;margin-top:12px; border-top: 1px solid #333; padding-top: 10px;">Tổng cộng: ${cart
      .reduce((s, i) => {
        const p = getData().products.find((x) => x.id === i.id);
        return s + p.price * i.qty;
      }, 0)
      .toLocaleString("vi-VN")}đ</p>`;
}

function renderMenu() {
  const menu = document.getElementById("menu");
  if (!menu) return;

  const user = JSON.parse(localStorage.getItem("bs_user"));
  menu.innerHTML = "";

  menu.innerHTML += `<li><a href="index.html">Trang chủ</a></li>`;
  menu.innerHTML += `<li><a href="cart.html">Giỏ hàng</a></li>`;

  if (user) {
    menu.innerHTML += `<li><a href="profile.html">Thông tin</a></li>`;
    menu.innerHTML += `<li><a href="#" onclick="logout()">Đăng xuất</a></li>`;
  } else {
    menu.innerHTML += `<li><a href="register.html">Đăng ký</a></li>`;
    menu.innerHTML += `<li><a href="login.html">Đăng nhập</a></li>`;
  }
}

function login(username) {
  localStorage.setItem("bs_user", JSON.stringify({ username }));
  renderMenu();
}

// ==========================================================
// ✅ ĐIỂM SỬA LỖI 1: Cập nhật hàm logout()
function logout() {
  localStorage.removeItem("bs_user");
  // THÊM: Xóa giỏ hàng khi đăng xuất để reset về 0
  localStorage.setItem("bs_cart", JSON.stringify([])); 
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
  if (document.referrer && document.referrer.includes("category.html")) {
    window.history.back();
  } else {
    window.location.href = "category.html";
  }
}

function showError() {
  const mainContent = document.getElementById("mainContent");
  if (!mainContent) return;

  mainContent.innerHTML = `
    <div class="error-container">
      <h2>❌ Không tìm thấy sản phẩm</h2>
      <p>Sản phẩm bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
      <a href="index.html">← Quay về trang chủ</a>
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
      <a href="index.html">Literary Haven</a>
      <span>›</span>
      <a href="category.html">${product.category}</a>
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
            <span class="shipping-value">${product.category} › ${
    product.subcategory
  }</span>
          </div>
          <div class="shipping-row">
            <span class="shipping-label">Tình trạng:</span>
            <span class="shipping-value">Còn hàng</span>
          </div>
        </div>

        <div class="quantity-selector">
          <span class="shipping-label">Số lượng:</span>
          <div class="quantity-controls">
            <button class="qty-btn" onclick="decreaseQty()">−</button>
            <input type="number" class="qty-input" value="1" id="qty" min="1" max="10" readonly>
            <button class="qty-btn" onclick="increaseQty()">+</button>
          </div>
          <span class="stock-status">Còn hàng</span>
        </div>

        <div class="action-buttons">
          <button class="btn btn-add-cart" onclick="addToCartDetail(${
            product.id
          })">🛒 Thêm vào giỏ hàng</button>
          <button class="btn btn-buy-now" onclick="buyNow(${
            product.id
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
          <span class="info-value">${product.category} › ${
    product.subcategory
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

function increaseQty() {
  const input = document.getElementById("qty");
  if (!input) return;
  const max = parseInt(input.max);
  if (parseInt(input.value) < max) {
    input.value = parseInt(input.value) + 1;
  }
}

function decreaseQty() {
  const input = document.getElementById("qty");
  if (!input) return;
  if (parseInt(input.value) > 1) {
    input.value = parseInt(input.value) - 1;
  }
}

// BẮT ĐẦU PHẦN CHỈNH SỬA LOGIC CHI TIẾT SẢN PHẨM
function addToCartDetail(productId) {
  const qtyInput = document.getElementById("qty");
  const qty = qtyInput ? parseInt(qtyInput.value) : 1;
  const product = findProductById(productId);

  // LOGIC BẮT BUỘC ĐĂNG NHẬP (HIỆN MODAL)
  const user = localStorage.getItem("bs_user");
  if (!user) {
    openLoginModal();
    return;
  }
  // KẾT THÚC LOGIC BẮT BUỘC ĐĂNG NHẬP

  // Add to cart
  const cart = getCart();
  const ex = cart.find((i) => i.id === productId);
  if (ex) ex.qty += Number(qty);
  else cart.push({ id: productId, qty: Number(qty) });
  saveCart(cart);
  updateCartCount();

  // Update cart count display
  const cartCount = document.getElementById("cartCount");
  if (cartCount) {
    const currentCount = parseInt(cartCount.textContent);
    cartCount.textContent = currentCount + qty;
  }

  alert(`Đã thêm ${qty} × "${product.name}" vào giỏ hàng!`);
}

function buyNow(productId) {
  const qtyInput = document.getElementById("qty");
  const qty = qtyInput ? parseInt(qtyInput.value) : 1;

  // LOGIC BẮT BUỘC ĐĂNG NHẬP (HIỆN MODAL)
  const user = localStorage.getItem("bs_user");
  if (!user) {
    openLoginModal();
    return;
  }
  // KẾT THÚC LOGIC BẮT BUỘC ĐĂNG NHẬP

  // Add to cart first
  const cart = getCart();
  const ex = cart.find((i) => i.id === productId);
  if (ex) ex.qty += Number(qty);
  else cart.push({ id: productId, qty: Number(qty) });
  saveCart(cart);

  // Redirect to cart page
  window.location.href = "cart.html";
}
// KẾT THÚC PHẦN CHỈNH SỬA LOGIC CHI TIẾT SẢN PHẨM

function initProductDetail() {
  const mainContent = document.getElementById("mainContent");
  if (!mainContent) return;

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

document.addEventListener("DOMContentLoaded", function () {
  let storedData = JSON.parse(localStorage.getItem("bs_data"));
  if (
    !storedData ||
    !storedData.products ||
    storedData.products.length !== SAMPLE.products.length
  ) {
    localStorage.setItem("bs_data", JSON.stringify(SAMPLE));
  }
  renderProductList(1);
  updateCartCount();
  renderSearchResults();
  renderProductDetail();
  renderCart();
  renderMenu();
  initProductDetail(); // Init product detail page

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
      const category = link.dataset.category;
      const subcategory = link.dataset.subcategory;

      // Kiểm tra xem có đang ở trang category.html không
      const isOnCategoryPage =
        window.location.pathname.includes("category.html");

      // Nếu KHÔNG ở trang category, cho phép link href hoạt động bình thường
      if (!isOnCategoryPage) {
        return; // Không chặn, để chuyển trang
      }

      // Nếu đang ở trang category.html, xử lý filtering tại chỗ
      e.preventDefault();

      const allBooks = getData().products;

      // Cập nhật breadcrumb
      const breadcrumbBtn = document.getElementById("breadcrumb-category");
      if (breadcrumbBtn) {
        if (category === "all") {
          breadcrumbBtn.innerHTML = " Tất cả sách";
          currentList = allBooks;
        } else if (subcategory) {
          breadcrumbBtn.innerHTML = ` Danh mục sách > ${category} > ${subcategory}`;
          currentList = allBooks.filter(
            (b) => b.category === category && b.subcategory === subcategory
          );
        } else {
          breadcrumbBtn.innerHTML = ` Danh mục sách > ${category}`;
          currentList = allBooks.filter((b) => b.category === category);
        }
      }

      renderProductList(1);
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
      window.location.href = "profile.html";
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
      window.location.href = "login.html";
    };
    const btnReg = document.createElement("button");
    btnReg.className = "btn ghost";
    btnReg.textContent = "Đăng ký";
    btnReg.onclick = function () {
      window.location.href = "register.html";
    };
    authArea.appendChild(btnLogin);
    authArea.appendChild(btnReg);
  }
}
// call renderAuth when DOM ready if not called elsewhere
document.addEventListener("DOMContentLoaded", function () {
  try {
    renderAuth();
  } catch (e) {}
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
      window.location.href = "cart.html";
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

const categoryBtnElement = document.querySelector(".category-btn");
if (categoryBtnElement) {
  categoryBtnElement.addEventListener("click", () => {
    window.location.href = "category.html";
  });
}

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

  const users = JSON.parse(localStorage.getItem("bs_users") || "[]");
  const user = users.find((u) => u.username === username);

  if (!user) {
    document.getElementById("error-login-username").textContent =
      "Tài khoản không tồn tại";
    return;
  }

  if (user.password !== password) {
    document.getElementById("error-login-password").textContent =
      "Mật khẩu không chính xác";
    return;
  }

  localStorage.setItem(
    "bs_user",
    JSON.stringify({
      username: user.username,
      fullName: user.fullName,
      email: user.email,
      phone: user.phone,
      address: user.address,
      password: user.password,
    })
  );

  closeLoginModal();
  alert("Đăng nhập thành công!");
  updateAuthUI();
  location.reload();
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

  const existingUsers = JSON.parse(localStorage.getItem("bs_users") || "[]");
  if (existingUsers.some((u) => u.username === username)) {
    document.getElementById("error-username").textContent =
      "Tài khoản đã tồn tại";
    return;
  }

  const newUser = {
    id: Date.now(),
    status: "active",
    fullName,
    username,
    password,
    email,
    phone,
    address,
    createdAt: new Date().toISOString(),
  };

  existingUsers.push(newUser);
  localStorage.setItem("bs_users", JSON.stringify(existingUsers));

  closeRegisterModal();
  alert("Đăng ký thành công! Vui lòng đăng nhập.");
  setTimeout(() => openLoginModal(), 300);
}

// ==========================================================
// ✅ ĐIỂM SỬA LỖI 2: Cập nhật hàm handleLogoutModal()
function handleLogoutModal() {
  if (confirm("Bạn có chắc muốn đăng xuất?")) {
    localStorage.removeItem("bs_user");
    // THÊM: Xóa giỏ hàng khi đăng xuất để reset về 0
    localStorage.setItem("bs_cart", JSON.stringify([])); 
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

//  CHỖ SỬA: Thêm các function mới cho dropdown menu

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
  window.location.href = "purchase-history.html"; // Bỏ // và sửa tên file
}
//==================================================================================================================
// Sửa thông tin cá nhân
function editProfile(e) {
  if (e) e.preventDefault();
  // Chuyển hướng đến trang sửa thông tin cá nhân
  window.location.href = "update-profile.html";
}
//==================================================================================================================
// Đổi mật khẩu
function changePassword(e) {
  if (e) e.preventDefault();
  // Chuyển hướng đến trang đổi mật khẩu
  window.location.href = "change-password.html";
}
//==================================================================================================================

// ==========================================================
// ✅ ĐIỂM SỬA LỖI 3: Cập nhật hàm handleLogoutDropdown()
function handleLogoutDropdown(e) {
  if (e) e.preventDefault();
  if (confirm("Bạn có chắc muốn đăng xuất?")) {
    localStorage.removeItem("bs_user");
    // THÊM: Xóa giỏ hàng khi đăng xuất để reset về 0
    localStorage.setItem("bs_cart", JSON.stringify([])); 
    updateAuthUI();
    if (typeof updateCartCount === "function") updateCartCount();
    location.reload();
  }
}
// ==========================================================

//  CHỖ SỬA: Thêm event listener để đóng dropdown khi click bên ngoài
document.addEventListener("click", function (e) {
  const dropdown = document.querySelector(".user-profile-dropdown");
  if (dropdown && !dropdown.contains(e.target)) {
    // Dropdown sẽ tự đóng khi hover ra ngoài, không cần xử lý thêm
  }
});

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

  window.location.href = "search-results.html?q=" + encodeURIComponent(query);
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

// **********************************
// Tìm kiếm nâng cao
// **********************************
// Hiển thị những gì đã chọn ở tìm kiếm nâng cao
const filterItems = document.querySelectorAll(".filter-item");
const selectedContainer = document.getElementById("selectedFilters");

filterItems.forEach((item) => {
  const btn = item.querySelector(".filter-btn");
  const dropdownLinks = item.querySelectorAll(".filter-dropdown a");

  dropdownLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault(); // tránh link reload

      const value = link.textContent.trim(); // giá trị đã chọn
      const filterName = btn.textContent.replace(" ▾", ""); // tên filter

      // Đổi tên nút và đổi màu
      btn.textContent = `${filterName}: ${value} ▾`;
      btn.classList.add("selected");

      // Kiểm tra filter đã có chưa
      let existingTag = selectedContainer.querySelector(
        `[data-filter="${filterName}"]`
      );
      if (existingTag) {
        existingTag.querySelector("span.value").textContent = value;
      } else {
        // Tạo filter tag mới
        const tag = document.createElement("div");
        tag.className = "selected-filter";
        tag.setAttribute("data-filter", filterName);
        tag.innerHTML = `<span class="name">${filterName}: </span><span class="value">${value}</span>
                         <span class="remove-filter">&times;</span>`;
        selectedContainer.appendChild(tag);

        // Thêm sự kiện xóa filter
        tag.querySelector(".remove-filter").addEventListener("click", () => {
          tag.remove();
          btn.textContent = filterName + " ▾";
          btn.classList.remove("selected");
        });
      }
    });
  });
});

// Hiển thị các card đã tìm kiếm nâng cao
// Dữ liệu mẫu (SAMPLE.products) bạn đã có
const productList = document.getElementById("product-list");

// Lưu filter hiện tại
let currentFilters = {
  "Theo tên truyện": null,
  "Theo tác giả": null,
  "Theo giá": null,
  "Theo năm": null, // nếu có dữ liệu year
};

function renderProducts(products) {
  productList.innerHTML = ""; // Xóa danh sách cũ trước khi hiển thị lại
  products.forEach((prod) => {
    const card = document.createElement("div"); // Tạo thẻ chứa sản phẩm
    card.className = "product-card"; // Gán class cho card
    card.innerHTML = `
      <img src="${prod.img}" alt="${prod.name}"> <!-- Hình sản phẩm -->
      <div class="card-body">
        <h3>${prod.name}</h3> <!-- Tên sản phẩm -->
        <p class="author">${prod.author}</p> <!-- Tác giả -->
        <p class="price">${prod.price.toLocaleString(
          "vi-VN"
        )}₫</p> <!-- Giá VNĐ -->
        <div class="button-row"> <!-- Hàng nút -->
          <a class="btn btn-small" href="product-detail.html?id=${
            prod.id
          }">Xem</a> <!-- Nút xem -->
          <button class="btn btn-cart" onclick="addToCart(${
            prod.id
          },1)">Thêm vào giỏ</button> <!-- Nút thêm vào giỏ -->
        </div>
      </div>
    `;
    productList.appendChild(card); // Thêm card vào danh sách
  });
}

// Hàm áp dụng filter
function applyFilters() {
  let filtered = [...SAMPLE.products];

  // Theo tên truyện
  if (currentFilters["Theo tên truyện"] === "A → Z")
    filtered.sort((a, b) => a.name.localeCompare(b.name));
  if (currentFilters["Theo tên truyện"] === "Z → A")
    filtered.sort((a, b) => b.name.localeCompare(a.name));

  // Theo tác giả
  if (currentFilters["Theo tác giả"] === "A → Z")
    filtered.sort((a, b) => a.author.localeCompare(b.author));
  if (currentFilters["Theo tác giả"] === "Z → A")
    filtered.sort((a, b) => b.author.localeCompare(a.author));

  // Theo giá
  if (currentFilters["Theo giá"] === "Thấp → Cao")
    filtered.sort((a, b) => a.price - b.price);
  if (currentFilters["Theo giá"] === "Cao → Thấp")
    filtered.sort((a, b) => b.price - a.price);

  // Theo năm (nếu có trường year)
  if (currentFilters["Theo năm"] === "Mới → Cũ")
    filtered.sort((a, b) => (b.year || 0) - (a.year || 0));
  if (currentFilters["Theo năm"] === "Cũ → Mới")
    filtered.sort((a, b) => (a.year || 0) - (b.year || 0));

  renderProducts(filtered);
}

// Cập nhật currentFilters khi chọn dropdown
filterItems.forEach((item) => {
  const btn = item.querySelector(".filter-btn");
  const dropdownLinks = item.querySelectorAll(".filter-dropdown a");
  const filterName = btn.textContent.replace(" ▾", "");

  dropdownLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const value = link.textContent.trim();
      currentFilters[filterName] = value; // lưu filter đã chọn
      applyFilters();
    });
  });
});

// Render mặc định
renderProducts(SAMPLE.products);
