const SAMPLE = {
  products: [ 
  // ================= Văn học =================
  { id: 1, sku: "VH001", name: "Đắc Nhân Tâm", author: "Dale Carnegie", price: 85000, category: "Văn học", subcategory: "Tiểu thuyết", desc: "Tác phẩm kinh điển về nghệ thuật giao tiếp.", img: "https://picsum.photos/300/420?random=27" },
  { id: 2, sku: "VH002", name: "Tuổi Trẻ Đáng Giá Bao Nhiêu", author: "Rosie Nguyễn", price: 90000, category: "Văn học", subcategory: "Tiểu thuyết", desc: "Truyện cảm hứng cho bạn trẻ tìm kiếm chính mình.", img: "https://picsum.photos/300/420?random=28" },
  { id: 3, sku: "VH003", name: "Truyện Kiều", author: "Nguyễn Du", price: 70000, category: "Văn học", subcategory: "Thơ", desc: "Kiệt tác văn học Việt Nam.", img: "https://picsum.photos/300/420?random=29" },
  { id: 4, sku: "VH004", name: "Tắt Đèn", author: "Ngô Tất Tố", price: 65000, category: "Văn học", subcategory: "Truyện ngắn", desc: "Tác phẩm hiện thực phê phán sâu sắc.", img: "https://picsum.photos/300/420?random=30" },
  { id: 5, sku: "VH005", name: "Lão Hạc", author: "Nam Cao", price: 60000, category: "Văn học", subcategory: "Truyện ngắn", desc: "Câu chuyện đầy nhân văn về thân phận người nông dân.", img: "https://picsum.photos/300/420?random=31" },
  { id: 6, sku: "VH006", name: "Nhật Ký Trong Tù", author: "Hồ Chí Minh", price: 80000, category: "Văn học", subcategory: "Thơ", desc: "Tập thơ giàu triết lý và tinh thần cách mạng.", img: "https://picsum.photos/300/420?random=32" },
  { id: 7, sku: "VH007", name: "Số Đỏ", author: "Vũ Trọng Phụng", price: 95000, category: "Văn học", subcategory: "Tiểu thuyết", desc: "Tác phẩm trào phúng đặc sắc.", img: "https://picsum.photos/300/420?random=33" },
  { id: 8, sku: "VH008", name: "Chí Phèo", author: "Nam Cao", price: 60000, category: "Văn học", subcategory: "Truyện ngắn", desc: "Bi kịch của người nông dân trong xã hội cũ.", img: "https://picsum.photos/300/420?random=34" },
  { id: 9, sku: "VH009", name: "Tôi Thấy Hoa Vàng Trên Cỏ Xanh", author: "Nguyễn Nhật Ánh", price: 100000, category: "Văn học", subcategory: "Tiểu thuyết", desc: "Câu chuyện tuổi thơ đầy xúc động.", img: "https://picsum.photos/300/420?random=35" },
  { id: 10, sku: "VH010", name: "Người Lái Đò Sông Đà", author: "Nguyễn Tuân", price: 72000, category: "Văn học", subcategory: "Truyện ngắn", desc: "Tác phẩm tiêu biểu cho phong cách tùy bút độc đáo.", img: "https://picsum.photos/300/420?random=36" },
  { id: 11, sku: "VH011", name: "Nhật Ký Đặng Thùy Trâm", author: "Đặng Thùy Trâm", price: 85000, category: "Văn học", subcategory: "Tiểu thuyết", desc: "Tấm gương sáng của một nữ bác sĩ trong chiến tranh.", img: "https://picsum.photos/300/420?random=37" },
  { id: 12, sku: "VH012", name: "Ánh Trăng", author: "Nguyễn Duy", price: 55000, category: "Văn học", subcategory: "Thơ", desc: "Tập thơ nổi tiếng với nhiều bài thơ sâu sắc.", img: "https://picsum.photos/300/420?random=38" },
  { id: 13, sku: "VH013", name: "Harry Potter và Hòn Đá Phù Thủy", author: "J. K. Rowling", price: 120000, category: "Văn học", subcategory: "Tiểu thuyết", desc: "Tập đầu tiên của loạt Harry Potter.", img: "https://picsum.photos/300/420?random=53" },

  // ================= Kinh tế =================
  { id: 14, sku: "KT001", name: "Cha Giàu Cha Nghèo", author: "Robert Kiyosaki", price: 120000, category: "Kinh tế", subcategory: "Tài chính", desc: "Sách tài chính cá nhân nổi tiếng.", img: "https://picsum.photos/300/420?random=39" },
  { id: 15, sku: "KT002", name: "Quốc Gia Khởi Nghiệp", author: "Dan Senor", price: 140000, category: "Kinh tế", subcategory: "Quản trị", desc: "Bài học khởi nghiệp từ Israel.", img: "https://picsum.photos/300/420?random=40" },
  { id: 16, sku: "KT003", name: "7 Thói Quen Hiệu Quả", author: "Stephen Covey", price: 135000, category: "Kinh tế", subcategory: "Quản trị", desc: "Hướng dẫn kỹ năng lãnh đạo cá nhân.", img: "https://picsum.photos/300/420?random=41" },
  { id: 17, sku: "KT004", name: "Dạy Con Làm Giàu", author: "Robert Kiyosaki", price: 150000, category: "Kinh tế", subcategory: "Tài chính", desc: "Loạt sách tài chính cá nhân nổi tiếng.", img: "https://picsum.photos/300/420?random=42" },
  { id: 18, sku: "KT005", name: "Tư Duy Nhanh Và Chậm", author: "Daniel Kahneman", price: 160000, category: "Kinh tế", subcategory: "Marketing", desc: "Tác phẩm tâm lý học ứng dụng trong kinh tế.", img: "https://picsum.photos/300/420?random=43" },
  { id: 19, sku: "KT006", name: "Cạnh Tranh Bằng Chiến Lược", author: "Michael Porter", price: 180000, category: "Kinh tế", subcategory: "Quản trị", desc: "Sách chiến lược kinh doanh kinh điển.", img: "https://picsum.photos/300/420?random=44" },
  { id: 20, sku: "KT007", name: "Marketing 4.0", author: "Philip Kotler", price: 140000, category: "Kinh tế", subcategory: "Marketing", desc: "Xu hướng marketing hiện đại.", img: "https://picsum.photos/300/420?random=45" },
  { id: 21, sku: "KT008", name: "Nghĩ Giàu Làm Giàu", author: "Napoleon Hill", price: 125000, category: "Kinh tế", subcategory: "Tài chính", desc: "Sách làm giàu kinh điển.", img: "https://picsum.photos/300/420?random=46" },
  { id: 22, sku: "KT009", name: "Chiến Lược Đại Dương Xanh", author: "W. Chan Kim", price: 170000, category: "Kinh tế", subcategory: "Quản trị", desc: "Mô hình chiến lược kinh doanh đột phá.", img: "https://picsum.photos/300/420?random=47" },
  { id: 23, sku: "KT010", name: "Kinh Tế Học Dành Cho Người Bận Rộn", author: "Tyler Cowen", price: 110000, category: "Kinh tế", subcategory: "Tài chính", desc: "Kinh tế học giản lược, dễ hiểu.", img: "https://picsum.photos/300/420?random=48" },
  { id: 24, sku: "KT011", name: "Influence - Tâm Lý Học Thuyết Phục", author: "Robert Cialdini", price: 160000, category: "Kinh tế", subcategory: "Marketing", desc: "Cuốn sách kinh điển về nghệ thuật thuyết phục.", img: "https://picsum.photos/300/420?random=49" },
  { id: 25, sku: "KT012", name: "Lãnh Đạo Không Chức Danh", author: "Robin Sharma", price: 145000, category: "Kinh tế", subcategory: "Quản trị", desc: "Nghệ thuật lãnh đạo bản thân và tổ chức.", img: "https://picsum.photos/300/420?random=50" },

  // ================= Thiếu nhi =================
  { id: 26, sku: "TN001", name: "Doraemon Tập 1", author: "Fujiko F. Fujio", price: 25000, category: "Thiếu nhi", subcategory: "Truyện tranh", desc: "Truyện tranh nổi tiếng Nhật Bản.", img: "https://picsum.photos/300/420?random=51" },
  { id: 27, sku: "TN002", name: "Conan Tập 1", author: "Gosho Aoyama", price: 30000, category: "Thiếu nhi", subcategory: "Truyện tranh", desc: "Thám tử lừng danh Conan.", img: "https://picsum.photos/300/420?random=52" },
  { id: 28, sku: "TN004", name: "Totto-chan Bên Cửa Sổ", author: "Kuroyanagi Tetsuko", price: 85000, category: "Thiếu nhi", subcategory: "Giáo dục", desc: "Câu chuyện giáo dục đầy cảm hứng.", img: "https://picsum.photos/300/420?random=54" },
  { id: 29, sku: "TN005", name: "Dragon Ball Tập 1", author: "Akira Toriyama", price: 35000, category: "Thiếu nhi", subcategory: "Truyện tranh", desc: "Bộ manga nổi tiếng toàn cầu.", img: "https://picsum.photos/300/420?random=55" },
  { id: 30, sku: "TN006", name: "Thần Đồng Đất Việt Tập 1", author: "Lê Linh", price: 28000, category: "Thiếu nhi", subcategory: "Truyện tranh", desc: "Truyện tranh Việt Nam nổi bật.", img: "https://picsum.photos/300/420?random=56" },
  { id: 31, sku: "TN007", name: "Búp Sen Xanh", author: "Sơn Tùng", price: 90000, category: "Thiếu nhi", subcategory: "Giáo dục", desc: "Tác phẩm văn học thiếu nhi nổi bật.", img: "https://picsum.photos/300/420?random=57" },

  // ================= Giáo khoa =================
  { id: 32, sku: "GK001", name: "Toán Lớp 1", author: "Nhiều tác giả", price: 18000, category: "Giáo khoa", subcategory: "Cấp 1", desc: "Sách giáo khoa Toán lớp 1.", img: "https://picsum.photos/300/420?random=58" },
  { id: 33, sku: "GK002", name: "Tiếng Việt Lớp 2", author: "Nhiều tác giả", price: 20000, category: "Giáo khoa", subcategory: "Cấp 1", desc: "Sách giáo khoa Tiếng Việt lớp 2.", img: "https://picsum.photos/300/420?random=59" },
  { id: 34, sku: "GK003", name: "Toán Lớp 6", author: "Nhiều tác giả", price: 25000, category: "Giáo khoa", subcategory: "Cấp 2", desc: "Sách giáo khoa Toán lớp 6.", img: "https://picsum.photos/300/420?random=60" },
  { id: 35, sku: "GK004", name: "Ngữ Văn Lớp 7", author: "Nhiều tác giả", price: 28000, category: "Giáo khoa", subcategory: "Cấp 2", desc: "Sách giáo khoa Ngữ văn lớp 7.", img: "https://picsum.photos/300/420?random=61" },
  { id: 36, sku: "GK005", name: "Lịch Sử Lớp 8", author: "Nhiều tác giả", price: 27000, category: "Giáo khoa", subcategory: "Cấp 2", desc: "Sách giáo khoa Lịch sử lớp 8.", img: "https://picsum.photos/300/420?random=62" },
  { id: 37, sku: "GK006", name: "Toán Lớp 10", author: "Nhiều tác giả", price: 32000, category: "Giáo khoa", subcategory: "Cấp 3", desc: "Sách giáo khoa Toán lớp 10.", img: "https://picsum.photos/300/420?random=63" },
  { id: 38, sku: "GK007", name: "Hóa Học Lớp 11", author: "Nhiều tác giả", price: 34000, category: "Giáo khoa", subcategory: "Cấp 3", desc: "Sách giáo khoa Hóa học lớp 11.", img: "https://picsum.photos/300/420?random=64" },
  { id: 39, sku: "GK008", name: "Ngữ Văn Lớp 12", author: "Nhiều tác giả", price: 36000, category: "Giáo khoa", subcategory: "Cấp 3", desc: "Sách giáo khoa Ngữ văn lớp 12.", img: "https://picsum.photos/300/420?random=65" },
  ]
};

if(!localStorage.getItem('bs_data')) localStorage.setItem('bs_data', JSON.stringify(SAMPLE));
if(!localStorage.getItem('bs_cart')) localStorage.setItem('bs_cart', JSON.stringify([]));
if(!localStorage.getItem('bs_orders')) localStorage.setItem('bs_orders', JSON.stringify([]));

function getData(){ return JSON.parse(localStorage.getItem('bs_data')) }
function getCart(){ return JSON.parse(localStorage.getItem('bs_cart')) }
function saveCart(c){ localStorage.setItem('bs_cart', JSON.stringify(c)) }

function updateCartCount(){
  const nav = document.querySelector('.nav');
  if(!nav) return;
  const count = getCart().reduce((s,i)=>s + i.qty,0);
  let span = document.getElementById('cart-count');
  if(!span){ 
    span = document.createElement('span'); 
    span.id='cart-count'; 
    span.style.marginLeft='6px'; 
    const a = nav.querySelector('a[href="cart.html"]'); 
    if(a) a.appendChild(span); 
  }
  span.textContent = count;
}

let currentPage = 1; 
const perPage = 8;
let currentList = getData().products; 

function renderProductList(page=1){
  const wrap = document.getElementById('product-list'); 
  if(!wrap) return;
  currentPage = page;

  const all = currentList; 
  const start=(page-1)*perPage; 
  const list = all.slice(start, start+perPage);

  wrap.innerHTML = list.map(it=>`
  <div class="product-card">
    <img src="${it.img}" alt="">
    <h3>${it.name}</h3>
    <div class="price">${it.price.toLocaleString('vi-VN')}đ</div>
  <div class="button-row">
  <a class="btn btn-small" href="product-detail.html?id=${it.id}">Xem</a>
  <button class="btn btn-cart" onclick="addToCart(${it.id},1)">Thêm vào giỏ</button>
</div>
  </div>`).join('');

  renderPagination(Math.ceil(all.length/perPage));
}

function renderPagination(totalPages){
  const pag = document.getElementById('pagination'); 
  if(!pag) return;
  if(totalPages <= 1) { pag.innerHTML = ""; return; } 

  let html = '<div class="pagination-wrap">';
  if(currentPage > 1) {
    html += `<button class="page-btn" onclick="changePage(${currentPage-1})">« Trước</button>`;
  }
  for(let i=1;i<=totalPages;i++){ 
    html += `<button class="page-btn ${i===currentPage?'active':''}" onclick="changePage(${i})">${i}</button>`; 
  }
  if(currentPage < totalPages) {
    html += `<button class="page-btn" onclick="changePage(${currentPage+1})">Sau »</button>`;
  }
  html += '</div>';
  pag.innerHTML = html;
}

function changePage(p){ renderProductList(p) }

// ===== CHỈNH LẠI LOGIC PHẦN TÌM KIẾM =================================================================================================
function doSearch(){ 
  const q=(document.getElementById('q')?.value||'').trim(); 
  if(!q){ alert('Nhập từ khóa'); return; } 
  window.location.href='search-results.html?q='+encodeURIComponent(q); 
}

function renderSearchResults(){ 
  const wrap=document.getElementById('search-results'); 
  if(!wrap) return; 
// ========================================================================================================================================
  const q=new URLSearchParams(location.search).get('q')||''; 
  const res = getData().products.filter(p=>p.name.toLowerCase().includes(q.toLowerCase())); 

  wrap.innerHTML = res.length 
    ? res.map(it =>`
      <div class="product-card"> 
        <img src="${it.img}" alt=""> 
        <h3>${it.name}</h3>
        <div class="price">${it.price.toLocaleString('vi-VN')}đ</div>
        <div class="button-row">
          <a class="btn btn-small" href="product-detail.html?id=${it.id}">Xem</a>
          <button class="btn btn-cart" onclick="addToCart(${it.id},1)">Thêm vào giỏ</button>
        </div>
      </div>`).join('') 
    : '<p>Không tìm thấy</p>'; 
}

function renderProductDetail(){  
  const wrap=document.getElementById('product-detail'); if(!wrap) return; 
  const id=new URLSearchParams(location.search).get('id'); 
  const p = getData().products.find(x=>String(x.id)===String(id))||getData().products[0]; 
  wrap.innerHTML = `
    <div class="product-card">
      <img src="${p.img}" alt="">
      <h2>${p.name}</h2>
      <p class="price">${p.price.toLocaleString('vi-VN')}đ</p>
      <p>${p.desc}</p>
      <label>Số lượng 
        <input id="qty" type="number" value="1" min="1" max="${p.stock}">
      </label><br>
      <button class="btn" onclick="addToCart(${p.id}, document.getElementById('qty').value)">Thêm vào giỏ</button>
    </div>`; 
}

function addToCart(id, qty=1){ 
  // require login
  const user = localStorage.getItem('bs_user');
  if(!user){ window.location.href = "login.html?next=product-"+id; return; }
  const cart = getCart(); 
  const ex = cart.find(i=>i.id===id); 
  if(ex) ex.qty += Number(qty); 
  else cart.push({id:id, qty:Number(qty)}); 
  saveCart(cart); updateCartCount(); alert('Đã thêm vào giỏ'); renderCart(); 
}

function renderCart(){ 
  const wrap=document.getElementById('cart-contents'); if(!wrap) return; 
  const cart=getCart(); if(!cart.length){ wrap.innerHTML='<p>Giỏ hàng rỗng</p>'; return; } 
  const data=getData().products; 
  wrap.innerHTML = cart.map(i=>{ 
    const p = data.find(x=>x.id===i.id); 
    return `<div class="cart-item-card"><h4>${p.name}</h4><p>Số lượng: ${i.qty}</p><p>Giá: ${(p.price*i.qty).toLocaleString('vi-VN')}đ</p></div>` 
  }).join('') + `<p style="font-weight:700;margin-top:12px">Tổng: ${cart.reduce((s,i)=>{const p=getData().products.find(x=>x.id===i.id);return s + p.price*i.qty},0).toLocaleString('vi-VN')}đ</p>`; 
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

function logout() {
  localStorage.removeItem("bs_user");
  renderMenu();
}

// ===== PRODUCT DETAIL PAGE FUNCTIONS =====
function getProductIdFromURL() {
  const urlParams = new URLSearchParams(window.location.search);
  return parseInt(urlParams.get('id'));
}

function formatPrice(price) {
  return price.toLocaleString('vi-VN') + 'đ';
}

function findProductById(id) {
  return getData().products.find(p => p.id === id);
}

function goBack() {
  if (document.referrer && document.referrer.includes('category.html')) {
    window.history.back();
  } else {
    window.location.href = 'category.html';
  }
}

function showError() {
  const mainContent = document.getElementById('mainContent');
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
  const mainContent = document.getElementById('mainContent');
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
            <span class="shipping-value">${product.category} › ${product.subcategory}</span>
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
          <button class="btn btn-add-cart" onclick="addToCartDetail(${product.id})">🛒 Thêm vào giỏ hàng</button>
          <button class="btn btn-buy-now" onclick="buyNow(${product.id})">⚡ Mua ngay</button>
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
          <span class="info-value">${product.category} › ${product.subcategory}</span>
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
  const input = document.getElementById('qty');
  if (!input) return;
  const max = parseInt(input.max);
  if (parseInt(input.value) < max) {
    input.value = parseInt(input.value) + 1;
  }
}

function decreaseQty() {
  const input = document.getElementById('qty');
  if (!input) return;
  if (parseInt(input.value) > 1) {
    input.value = parseInt(input.value) - 1;
  }
}

function addToCartDetail(productId) {
  const qtyInput = document.getElementById('qty');
  const qty = qtyInput ? parseInt(qtyInput.value) : 1;
  const product = findProductById(productId);

  // Check if user is logged in
  const user = localStorage.getItem('bs_user');
  if(!user){ 
    window.location.href = "login.html?next=product-"+productId; 
    return; 
  }

  // Add to cart
  const cart = getCart(); 
  const ex = cart.find(i=>i.id===productId); 
  if(ex) ex.qty += Number(qty); 
  else cart.push({id:productId, qty:Number(qty)}); 
  saveCart(cart); 
  updateCartCount(); 

  // Update cart count display
  const cartCount = document.getElementById('cartCount');
  if (cartCount) {
    const currentCount = parseInt(cartCount.textContent);
    cartCount.textContent = currentCount + qty;
  }

  alert(`Đã thêm ${qty} × "${product.name}" vào giỏ hàng!`);
}

function buyNow(productId) {
  const qtyInput = document.getElementById('qty');
  const qty = qtyInput ? parseInt(qtyInput.value) : 1;

  // Check if user is logged in
  const user = localStorage.getItem('bs_user');
  if(!user){ 
    window.location.href = "login.html?next=product-"+productId; 
    return; 
  }

  // Add to cart first
  const cart = getCart(); 
  const ex = cart.find(i=>i.id===productId); 
  if(ex) ex.qty += Number(qty); 
  else cart.push({id:productId, qty:Number(qty)}); 
  saveCart(cart); 

  // Redirect to cart page
  window.location.href = 'cart.html';
}

function initProductDetail() {
  const mainContent = document.getElementById('mainContent');
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
  const cartCount = document.getElementById('cartCount');
  if (cartCount) {
    const cart = getCart();
    const count = cart.reduce((s,i)=>s + i.qty, 0);
    cartCount.textContent = count;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  let storedData = JSON.parse(localStorage.getItem('bs_data'));
  if (!storedData || !storedData.products || storedData.products.length !== SAMPLE.products.length) {
    localStorage.setItem('bs_data', JSON.stringify(SAMPLE));
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
    categoryBtn.addEventListener("click", function() {
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
  const categoryLinks = document.querySelectorAll(".book-filter a, .all-books a");
  const productList = document.getElementById("product-list");
    
  categoryLinks.forEach(link => {
    link.addEventListener("click", e => {
      const category = link.dataset.category;
      const subcategory = link.dataset.subcategory;

      // Kiểm tra xem có đang ở trang category.html không
      const isOnCategoryPage = window.location.pathname.includes('category.html');
      
      // Nếu KHÔNG ở trang category, cho phép link href hoạt động bình thường
      if (!isOnCategoryPage) {
        return; // Không chặn, để chuyển trang
      }

      // Nếu đang ở trang category.html, xử lý filtering tại chỗ
      e.preventDefault(); 
      
      const allBooks = getData().products;

      // Cập nhật breadcrumb
      const breadcrumbBtn = document.getElementById('breadcrumb-category');
      if (breadcrumbBtn) {
        if (category === "all") {
          breadcrumbBtn.innerHTML = ' Tất cả sách';
          currentList = allBooks;
        } else if (subcategory) {
          breadcrumbBtn.innerHTML = ` Danh mục sách > ${category} > ${subcategory}`;
          currentList = allBooks.filter(
            b => b.category === category && b.subcategory === subcategory
          );
        } else {
          breadcrumbBtn.innerHTML = ` Danh mục sách > ${category}`;
          currentList = allBooks.filter(b => b.category === category);
        }
      }

      renderProductList(1); 
    });
  });
});


/* Assistant added auth UI renderer */

/* --- Auth UI rendering --- */
function getCurrentUser() {
  try { return JSON.parse(localStorage.getItem('bs_user')); } catch(e){ return null; }
}
function renderAuth() {
  const authArea = document.getElementById('authArea');
  if(!authArea) return;
  const userObj = getCurrentUser();
  authArea.innerHTML = '';
  if(userObj && userObj.username) {
    const btnGreet = document.createElement('button'); btnGreet.className='btn'; btnGreet.textContent = 'Xin chào, ' + userObj.username;
    btnGreet.onclick = function(){ window.location.href = 'profile.html'; };
    const btnLogout = document.createElement('button'); btnLogout.className='btn ghost'; btnLogout.textContent = 'Đăng xuất';
    btnLogout.onclick = function(){ if(confirm('Bạn muốn đăng xuất?')){ localStorage.removeItem('bs_user'); renderAuth(); updateCartCount && updateCartCount(); window.location.reload(); } };
    authArea.appendChild(btnGreet); authArea.appendChild(btnLogout);
  } else {
    const btnLogin = document.createElement('button'); btnLogin.className='btn'; btnLogin.textContent='Đăng nhập';
    btnLogin.onclick = function(){ window.location.href = 'login.html'; };
    const btnReg = document.createElement('button'); btnReg.className='btn ghost'; btnReg.textContent='Đăng ký';
    btnReg.onclick = function(){ window.location.href = 'register.html'; };
    authArea.appendChild(btnLogin); authArea.appendChild(btnReg);
  }
}
// call renderAuth when DOM ready if not called elsewhere
document.addEventListener('DOMContentLoaded', function(){ try{ renderAuth(); }catch(e){} });


/* Assistant added cart float click handler */

// float cart click handler
document.addEventListener('DOMContentLoaded', function(){
  const cbtn = document.getElementById('cartBtnFloat') || document.getElementById('cartBtn');
  if(cbtn) cbtn.addEventListener('click', function(e){ e.preventDefault(); window.location.href = 'cart.html'; });
});

// Danh mục sách 
// Cập nhật breadcrumb cho trang category
function updateCategoryBreadcrumb() { 
  const breadcrumbBtn = document.getElementById('breadcrumb-category');
  if (!breadcrumbBtn) return;
  
  const params = new URLSearchParams(window.location.search);
  const category = params.get('category');
  const subcategory = params.get('subcategory');
    
  if (!category) {
    breadcrumbBtn.textContent = 'Danh mục sách';
  } else if (subcategory) {
    breadcrumbBtn.textContent = `Danh mục sách > ${category} > ${subcategory}`;
  } else {
    breadcrumbBtn.textContent = `Danh mục sách > ${category}`;
  }
}

// Gọi hàm khi trang load
document.addEventListener('DOMContentLoaded', function() {
  updateCategoryBreadcrumb();
});

const categoryBtnElement = document.querySelector('.category-btn');
if (categoryBtnElement) {
  categoryBtnElement.addEventListener('click', () => {
    window.location.href = 'category.html';
  });
}