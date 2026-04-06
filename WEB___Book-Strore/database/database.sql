-- Thiết lập Database
CREATE DATABASE IF NOT EXISTS c01_nhahodau;
USE c01_nhahodau;
-- Xóa các bảng cũ theo thứ tự để không bị lỗi khóa ngoại (Foreign Key)
DROP TABLE IF EXISTS goodsReceipts_items;
DROP TABLE IF EXISTS goods_receipt;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS buyer_info;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS categories;
-- 1. Bảng Danh mục sản phẩm
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  status VARCHAR(20) DEFAULT 'active'
);
-- 2. Bảng Sản phẩm (Đã có cột supplier ngay sau author)
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sku VARCHAR(20),
  name VARCHAR(255),
  author VARCHAR(255),
  supplier VARCHAR(255),
  price INT,
  costPrice INT DEFAULT 0,
  profitMargin INT DEFAULT 0,
  category_id INT,
  subcategory VARCHAR(100),
  unit VARCHAR(50) DEFAULT 'Quyển',
  description TEXT,
  image VARCHAR(255),
  qty INT DEFAULT 0,
  LN FLOAT DEFAULT 0.1,
  status VARCHAR(20) DEFAULT 'active',
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
-- 3. Bảng Người dùng
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  status VARCHAR(20) DEFAULT 'active',
  fullName VARCHAR(255),
  username VARCHAR(100),
  password VARCHAR(255),
  email VARCHAR(255),
  phone VARCHAR(20),
  address VARCHAR(255),
  role VARCHAR(20) DEFAULT 'user',
  createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- 4. Bảng Đơn hàng
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userId INT,
  orderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  totalAmount INT,
  status VARCHAR(50) DEFAULT 'Chờ xử lý',
  buyer_name VARCHAR(255) NOT NULL,
  buyer_phone VARCHAR(20) NOT NULL,
  buyer_address TEXT NOT NULL,
  buyer_note TEXT,
  payment_method VARCHAR(50) DEFAULT 'Tiền mặt',
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE
  SET NULL
);
-- 5. Chi tiết Đơn hàng
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  product_name VARCHAR(255) NOT NULL,
  qty INT,
  price INT,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE
  SET NULL
);
-- 6. Bảng Phiếu nhập hàng (Quản lý nhập kho)
CREATE TABLE goods_receipt (
  id INT AUTO_INCREMENT PRIMARY KEY,
  createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
  totalAmount INT DEFAULT 0,
  status VARCHAR(50) DEFAULT 'chưa hoàn thành'
);
-- 7. Chi tiết Phiếu nhập hàng
CREATE TABLE goodsReceipts_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  goods_receipt_id INT,
  product_id INT,
  qty INT,
  price INT,
  FOREIGN KEY (goods_receipt_id) REFERENCES goods_receipt(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
-- 8. Thông tin bổ sung người dùng (Địa chỉ nhận hàng)
CREATE TABLE buyer_info (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userId INT,
  profileIndex INT,
  fullName VARCHAR(255),
  email VARCHAR(255),
  phone VARCHAR(20),
  address VARCHAR(255),
  ward VARCHAR(100),
  district VARCHAR(100),
  city VARCHAR(100),
  note TEXT,
  createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
  updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY unique_profile (userId, profileIndex)
);
-- ==========================================
-- CHÈN DỮ LIỆU MẪU CƠ BẢN
-- ==========================================
INSERT INTO categories (name)
VALUES ('Văn học'),
  ('Kinh tế'),
  ('Thiếu nhi'),
  ('Giáo khoa');
-- Chèn dữ liệu sản phẩm mẫu (ĐÃ THÊM SUPPLIER VÀO TỪNG SẢN PHẨM)
INSERT INTO products (
    sku,
    name,
    author,
    supplier,
    price,
    costPrice,
    profitMargin,
    category_id,
    subcategory,
    description,
    image,
    qty
  )
VALUES -- NHÓM 1: VĂN HỌC (NXB TRẺ)
  (
    'VH001',
    'Đắc Nhân Tâm',
    'Dale Carnegie',
    'NXB Trẻ',
    85000,
    70833,
    20,
    1,
    'Tiểu thuyết',
    'Nghệ thuật giao tiếp.',
    '../images/dacNhanTam.jpg',
    100
  ),
  (
    'VH002',
    'Tuổi Trẻ Đáng Giá Bao Nhiêu',
    'Rosie Nguyễn',
    'NXB Trẻ',
    90000,
    78260,
    15,
    1,
    'Tiểu thuyết',
    'Truyện cảm hứng.',
    '../images/tuoiTreDangGiaBaoNhieu.jpg',
    100
  ),
  (
    'VH003',
    'Truyện Kiều',
    'Nguyễn Du',
    'NXB Trẻ',
    70000,
    56000,
    25,
    1,
    'Thơ',
    'Kiệt tác văn học Việt Nam.',
    '../images/truyenKieu.jpg',
    100
  ),
  (
    'VH004',
    'Tắt Đèn',
    'Ngô Tất Tố',
    'NXB Trẻ',
    65000,
    52000,
    25,
    1,
    'Truyện ngắn',
    'Tác phẩm hiện thực phê phán sâu sắc.',
    '../images/tatDen.jpg',
    100
  ),
  (
    'VH005',
    'Lão Hạc',
    'Nam Cao',
    'NXB Trẻ',
    60000,
    48000,
    25,
    1,
    'Truyện ngắn',
    'Câu chuyện đầy nhân văn về thân phận người nông dân.',
    '../images/laoHac.jpg',
    100
  ),
  (
    'VH006',
    'Nhật Ký Trong Tù',
    'Hồ Chí Minh',
    'NXB Trẻ',
    80000,
    64000,
    25,
    1,
    'Thơ',
    'Tập thơ giàu triết lý và tinh thần cách mạng.',
    '../images/nhatKyTrongTu.jpg',
    100
  ),
  (
    'VH007',
    'Số Đỏ',
    'Vũ Trọng Phụng',
    'NXB Trẻ',
    95000,
    76000,
    25,
    1,
    'Tiểu thuyết',
    'Tác phẩm trào phúng đặc sắc.',
    '../images/soDo.jpg',
    100
  ),
  (
    'VH008',
    'Chí Phèo',
    'Nam Cao',
    'NXB Trẻ',
    60000,
    48000,
    25,
    1,
    'Truyện ngắn',
    'Bi kịch của người nông dân trong xã hội cũ.',
    '../images/chiPheo.jpg',
    100
  ),
  (
    'VH009',
    'Tôi Thấy Hoa Vàng Trên Cỏ Xanh',
    'Nguyễn Nhật Ánh',
    'NXB Trẻ',
    100000,
    80000,
    25,
    1,
    'Tiểu thuyết',
    'Câu chuyện tuổi thơ đầy xúc động.',
    '../images/toiThayHoaVangTrenCoXanh.jpg',
    100
  ),
  (
    'VH010',
    'Người Lái Đò Sông Đà',
    'Nguyễn Tuân',
    'NXB Trẻ',
    72000,
    57600,
    25,
    1,
    'Tiểu thuyết',
    'Tác phẩm văn học nổi tiếng.',
    '../images/nguoiLaiDoSongDa.jpg',
    100
  ),
  (
    'VH011',
    'Nhật Ký Đặng Thùy Trâm',
    'Đặng Thùy Trâm',
    'NXB Trẻ',
    85000,
    68000,
    25,
    1,
    'Tiểu thuyết',
    'Tấm gương sáng của một nữ bác sĩ trong chiến tranh.',
    '../images/nhatKyĐangThuyTram.jpg',
    100
  ),
  (
    'VH012',
    'Ánh Trăng',
    'Nguyễn Duy',
    'NXB Trẻ',
    55000,
    44000,
    25,
    1,
    'Thơ',
    'Tập thơ nổi tiếng với nhiều bài thơ sâu sắc.',
    '../images/anhTrang.png',
    100
  ),
  (
    'VH013',
    'Harry Potter và Hòn Đá Phù Thủy',
    'J. K. Rowling',
    'NXB Trẻ',
    120000,
    96000,
    25,
    1,
    'Tiểu thuyết',
    'Tập đầu tiên của loạt Harry Potter.',
    '../images/HarryPotter.jpg',
    100
  ),
  -- NHÓM 2: KINH TẾ (NXB TỔNG HỢP)
  (
    'KT001',
    'Cha Giàu Cha Nghèo',
    'Robert Kiyosaki',
    'NXB Tổng hợp',
    120000,
    96000,
    25,
    2,
    'Tài chính',
    'Sách tài chính cá nhân nổi tiếng.',
    '../images/chaGiauChaNgheo.jpg',
    100
  ),
  (
    'KT002',
    'Quốc Gia Khởi Nghiệp',
    'Dan Senor',
    'NXB Tổng hợp',
    140000,
    112000,
    25,
    2,
    'Quản trị',
    'Bài học khởi nghiệp từ Israel.',
    '../images/quocGiaKhoiNghiep.png',
    100
  ),
  (
    'KT003',
    '7 Thói Quen Hiệu Quả',
    'Stephen Covey',
    'NXB Tổng hợp',
    135000,
    108000,
    25,
    2,
    'Quản trị',
    'Hướng dẫn kỹ năng lãnh đạo cá nhân.',
    '../images/thoiQuenHieuQua.jpg',
    100
  ),
  (
    'KT004',
    'Dạy Con Làm Giàu',
    'Robert Kiyosaki',
    'NXB Tổng hợp',
    150000,
    120000,
    25,
    2,
    'Tài chính',
    'Loạt sách tài chính cá nhân nổi tiếng.',
    '../images/dayConLamGiauIII.png',
    100
  ),
  (
    'KT005',
    'Lợi Thế Cạnh Tranh',
    'Michael Porter',
    'NXB Tổng hợp',
    160000,
    128000,
    25,
    2,
    'Marketing',
    'Tác phẩm tâm lý học ứng dụng trong kinh tế.',
    '../images/loiTheCanhTranh.jpg',
    100
  ),
  (
    'KT006',
    'Tư Duy Phản Biện',
    'Richard Paul',
    'NXB Tổng hợp',
    180000,
    144000,
    25,
    2,
    'Quản trị',
    'Sách chiến lược kinh doanh kinh điển.',
    '../images/tuDuyPhanBien.jpg',
    100
  ),
  (
    'KT007',
    'Marketing 4.0',
    'Philip Kotler',
    'NXB Tổng hợp',
    140000,
    112000,
    25,
    2,
    'Marketing',
    'Xu hướng marketing hiện đại.',
    '../images/marketing.jpg',
    100
  ),
  (
    'KT008',
    'Kinh Tế Dành Cho Doanh Nhân',
    'Nguyễn Đình Cung',
    'NXB Tổng hợp',
    125000,
    100000,
    25,
    2,
    'Tài chính',
    'Sách làm giàu kinh điển.',
    '../images/kinhDoanh.png',
    100
  ),
  (
    'KT009',
    'Chiến Lược Đại Dương Xanh',
    'W. Chan Kim',
    'NXB Tổng hợp',
    170000,
    136000,
    25,
    2,
    'Quản trị',
    'Mô hình chiến lược kinh doanh đột phá.',
    '../images/chienLuocDaiDuongXanh.png',
    100
  ),
  (
    'KT010',
    'Những Đoạn Tâm Lý Thuyết Phục',
    'Dan Ariely',
    'NXB Tổng hợp',
    110000,
    88000,
    25,
    2,
    'Tài chính',
    'Kinh tế học giản lược, dễ hiểu.',
    '../images/nhungDoanTamLyThuyetPhuc.png',
    100
  ),
  (
    'KT011',
    'Cách Nghĩ Để Thành Công',
    'Dale Carnegie',
    'NXB Tổng hợp',
    160000,
    128000,
    25,
    2,
    'Marketing',
    'Cuốn sách kinh điển về nghệ thuật thuyết phục.',
    '../images/cachNghiDeThanhCong.jpg',
    100
  ),
  (
    'KT012',
    'Lãnh Đạo Không Chức Danh',
    'Robin Sharma',
    'NXB Tổng hợp',
    145000,
    116000,
    25,
    2,
    'Quản trị',
    'Nghệ thuật lãnh đạo bản thân và tổ chức.',
    '../images/nhaLanhDaoKhongChucDanh.png',
    100
  ),
  -- NHÓM 3: THIẾU NHI (NXB KIM ĐỒNG)
  (
    'TN001',
    'Doraemon Tập 29',
    'Fujiko F. Fujio',
    'NXB Kim Đồng',
    25000,
    20000,
    25,
    3,
    'Truyện tranh',
    'Truyện tranh nổi tiếng Nhật Bản.',
    '../images/doreamonTap29.jpg',
    100
  ),
  (
    'TN002',
    'Conan Tập 5',
    'Gosho Aoyama',
    'NXB Kim Đồng',
    30000,
    24000,
    25,
    3,
    'Truyện tranh',
    'Thám tử lừng danh Conan.',
    '../images/conanTap5.jpg',
    100
  ),
  (
    'TN004',
    'Miko Tập 33',
    'Nhiều tác giả',
    'NXB Kim Đồng',
    85000,
    68000,
    25,
    3,
    'Giáo dục',
    'Câu chuyện giáo dục đầy cảm hứng.',
    '../images/mikoTap33.jpg',
    100
  ),
  (
    'TN005',
    'Dragon Ball Tập 19',
    'Akira Toriyama',
    'NXB Kim Đồng',
    35000,
    28000,
    25,
    3,
    'Truyện tranh',
    'Bộ manga nổi tiếng toàn cầu.',
    '../images/dragonBallTap19.jpg',
    100
  ),
  (
    'TN006',
    'Thần Đồng Đất Việt Tập 1',
    'Lê Linh',
    'NXB Kim Đồng',
    28000,
    22400,
    25,
    3,
    'Truyện tranh',
    'Truyện tranh Việt Nam nổi bật.',
    '../images/thanDongDatVietTap1.png',
    100
  ),
  (
    'TN007',
    'Shin - cậu bé bút chì',
    'Takahashi Yoshito',
    'NXB Kim Đồng',
    90000,
    72000,
    25,
    3,
    'Giáo dục',
    'Tác phẩm văn học thiếu nhi nổi bật.',
    '../images/cauBeButChi.jpg',
    100
  ),
  -- NHÓM 4: GIÁO KHOA (NXB GIÁO DỤC)
  (
    'GK001',
    'Toán Lớp 1',
    'Nhiều tác giả',
    'NXB Giáo Dục',
    18000,
    14400,
    25,
    4,
    'Cấp 1',
    'Sách giáo khoa Toán lớp 1.',
    '../images/toanLop1.jpg',
    100
  ),
  (
    'GK002',
    'Tiếng Việt Lớp 2',
    'Nhiều tác giả',
    'NXB Giáo Dục',
    20000,
    16000,
    25,
    4,
    'Cấp 1',
    'Sách giáo khoa Tiếng Việt lớp 2.',
    '../images/tiengVietLop2.jpg',
    100
  ),
  (
    'GK003',
    'Hóa học Lớp 8',
    'Nhiều tác giả',
    'NXB Giáo Dục',
    25000,
    20000,
    25,
    4,
    'Cấp 2',
    'Sách giáo khoa Hóa học lớp 8.',
    '../images/hoaHocLop11.jpg',
    100
  ),
  (
    'GK004',
    'Lịch sử Lớp 8',
    'Nhiều tác giả',
    'NXB Giáo Dục',
    28000,
    22400,
    25,
    4,
    'Cấp 2',
    'Sách giáo khoa Lịch sử lớp 7.',
    '../images/lichSuLop8.png',
    100
  ),
  (
    'GK005',
    'Vật lí Lớp 11',
    'Nhiều tác giả',
    'NXB Giáo Dục',
    27000,
    21600,
    25,
    4,
    'Cấp 3',
    'Sách giáo khoa Vật lí lớp 11.',
    '../images/vatLyLop11.png',
    100
  ),
  (
    'GK006',
    'Mỹ thuật Lớp 5',
    'Nhiều tác giả',
    'NXB Giáo Dục',
    32000,
    25600,
    25,
    4,
    'Cấp 1',
    'Sách giáo khoa Mỹ thuật lớp 5.',
    '../images/miThuatLop5.png',
    100
  ),
  (
    'GK007',
    'Hóa Học Lớp 11',
    'Nhiều tác giả',
    'NXB Giáo Dục',
    34000,
    27200,
    25,
    4,
    'Cấp 3',
    'Sách giáo khoa Hóa học lớp 11.',
    '../images/hoaHocLop8.png',
    100
  ),
  (
    'GK008',
    'Đạo đức Lớp 4',
    'Nhiều tác giả',
    'NXB Giáo Dục',
    36000,
    28800,
    25,
    4,
    'Cấp 1',
    'Sách giáo khoa Đạo đức lớp 4.',
    '../images/daoDucLop4.jpg',
    100
  );
-- Tài khoản Admin mặc định
INSERT INTO users (username, password, role, fullName)
VALUES (
    'quanly1',
    '$2y$10$0x1NtO4C7NrY52SvD4wUueOnXOQWMO9keHm2Nu.fsoMIgcxmCGSgu',
    'admin',
    'Quản trị viên'
  );
-- Tài khoản Khách hàng mặc định
INSERT INTO users (
    status,
    fullName,
    username,
    password,
    email,
    phone,
    address,
    role,
    createdAt
  )
VALUES (
    'active',
    'Giáo Viên (Khách Hàng)',
    'khachhang1',
    '$2y$10$RNKTkguQtaY9RPJGIDp7S.9Bx/u9Z2lLBug.rET9TM.zJR98RZ8j6',
    'teacher@gmail.com',
    '0987654321',
    '123 Đường ABC, Q1, TPHCM',
    'user',
    NOW()
  );