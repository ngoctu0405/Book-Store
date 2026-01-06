USE bookstore;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sku VARCHAR(20),
  name VARCHAR(255),
  author VARCHAR(255),
  price INT,
  profitMargin INT,
  category VARCHAR(100),
  subcategory VARCHAR(100),
  description TEXT,
  image VARCHAR(255),
  qty INT
);

INSERT INTO products
(sku, name, author, price, profitMargin, category, subcategory, description, image, qty)
VALUES
('VH001','Đắc Nhân Tâm','Dale Carnegie',85000,0,'Văn học','Tiểu thuyết','Tác phẩm kinh điển về nghệ thuật giao tiếp.','../images/dacNhanTam.jpg',100),
('VH002','Tuổi Trẻ Đáng Giá Bao Nhiêu','Rosie Nguyễn',90000,0,'Văn học','Tiểu thuyết','Truyện cảm hứng cho bạn trẻ tìm kiếm chính mình.','../images/tuoiTreDangGiaBaoNhieu.jpg',100),
('VH003','Truyện Kiều','Nguyễn Du',70000,0,'Văn học','Thơ','Kiệt tác văn học Việt Nam.','../images/truyenKieu.jpg',100),
('VH004','Tắt Đèn','Ngô Tất Tố',65000,0,'Văn học','Truyện ngắn','Tác phẩm hiện thực phê phán sâu sắc.','../images/tatDen.jpg',100),
('VH005','Lão Hạc','Nam Cao',60000,0,'Văn học','Truyện ngắn','Câu chuyện đầy nhân văn về thân phận người nông dân.','../images/laoHac.jpg',100),
('VH006','Nhật Ký Trong Tù','Hồ Chí Minh',80000,0,'Văn học','Thơ','Tập thơ giàu triết lý và tinh thần cách mạng.','../images/nhatKyTrongTu.jpg',100),
('VH007','Số Đỏ','Vũ Trọng Phụng',95000,0,'Văn học','Tiểu thuyết','Tác phẩm trào phúng đặc sắc.','../images/soDo.jpg',100),
('VH008','Chí Phèo','Nam Cao',60000,0,'Văn học','Truyện ngắn','Bi kịch của người nông dân trong xã hội cũ.','../images/chiPheo.jpg',100),
('VH009','Tôi Thấy Hoa Vàng Trên Cỏ Xanh','Nguyễn Nhật Ánh',100000,0,'Văn học','Tiểu thuyết','Câu chuyện tuổi thơ đầy xúc động.','../images/toiThayHoaVangTrenCoXanh.jpg',100),
('VH010','Người Lái Đò Sông Đà','Nguyễn Tuân',72000,0,'Văn học','Truyện ngắn','Tác phẩm tiêu biểu cho phong cách tùy bút độc đáo.','../images/nguoiLaiDoSongDa.jpg',100),
('VH011','Nhật Ký Đặng Thùy Trâm','Đặng Thùy Trâm',85000,0,'Văn học','Tiểu thuyết','Tấm gương sáng của một nữ bác sĩ trong chiến tranh.','../images/nhatKyĐangThuyTram.jpg',100),
('VH012','Ánh Trăng','Nguyễn Duy',55000,0,'Văn học','Thơ','Tập thơ nổi tiếng với nhiều bài thơ sâu sắc.','../images/anhTrang.png',100),
('VH013','Harry Potter và Hòn Đá Phù Thủy','J. K. Rowling',120000,0,'Văn học','Tiểu thuyết','Tập đầu tiên của loạt Harry Potter.','../images/harryPotter.jpg',100),

('KT001','Cha Giàu Cha Nghèo','Robert Kiyosaki',120000,0,'Kinh tế','Tài chính','Sách tài chính cá nhân nổi tiếng.','../images/chaGiauChaNgheo.jpg',100),
('KT002','Quốc Gia Khởi Nghiệp','Dan Senor',140000,0,'Kinh tế','Quản trị','Bài học khởi nghiệp từ Israel.','../images/quocGiaKhoiNghiep.png',100),
('KT003','7 Thói Quen Hiệu Quả','Stephen Covey',135000,0,'Kinh tế','Quản trị','Hướng dẫn kỹ năng lãnh đạo cá nhân.','../images/thoiQuenHieuQua.jpg',100),
('KT004','Dạy Con Làm Giàu','Robert Kiyosaki',150000,0,'Kinh tế','Tài chính','Loạt sách tài chính cá nhân nổi tiếng.','../images/dayConLamGiauIII.png',100),
('KT005','Lợi Thế Cạnh Tranh','Michael Porter',160000,0,'Kinh tế','Marketing','Tác phẩm tâm lý học ứng dụng trong kinh tế.','../images/loiTheCanhTranh.jpg',100),
('KT006','Tư Duy Phản Biện','Richard Paul',180000,0,'Kinh tế','Quản trị','Sách chiến lược kinh doanh kinh điển.','../images/tuDuyPhanBien.jpg',100),
('KT007','Marketing 4.0','Philip Kotler',140000,0,'Kinh tế','Marketing','Xu hướng marketing hiện đại.','../images/marketing.jpg',100),
('KT008','Kinh Tế Dành Cho Doanh Nhân','Nguyễn Đình Cung',125000,0,'Kinh tế','Tài chính','Sách làm giàu kinh điển.','../images/kinhDoanh.png',100),
('KT009','Chiến Lược Đại Dương Xanh','W. Chan Kim',170000,0,'Kinh tế','Quản trị','Mô hình chiến lược kinh doanh đột phá.','../images/chienLuocDaiDuongXanh.png',100),
('KT010','Những Đoạn Tâm Lý Thuyết Phục','Dan Ariely',110000,0,'Kinh tế','Tài chính','Kinh tế học giản lược, dễ hiểu.','../images/nhungDoanTamLyThuyetPhuc.png',100),
('KT011','Cách Nghĩ Để Thành Công','Dale Carnegie',160000,0,'Kinh tế','Marketing','Cuốn sách kinh điển về nghệ thuật thuyết phục.','../images/cachNghiDeThanhCong.jpg',100),
('KT012','Lãnh Đạo Không Chức Danh','Robin Sharma',145000,0,'Kinh tế','Quản trị','Nghệ thuật lãnh đạo bản thân và tổ chức.','../images/nhaLanhDaoKhongChucDanh.png',100),

('TN001','Doraemon Tập 29','Fujiko F. Fujio',25000,0,'Thiếu nhi','Truyện tranh','Truyện tranh nổi tiếng Nhật Bản.','../images/doreamonTap29.jpg',100),
('TN002','Conan Tập 5','Gosho Aoyama',30000,0,'Thiếu nhi','Truyện tranh','Thám tử lừng danh Conan.','../images/conanTap5.jpg',100),
('TN004','Miko Tập 33','Nhiều tác giả',85000,0,'Thiếu nhi','Giáo dục','Câu chuyện giáo dục đầy cảm hứng.','../images/mikoTap33.jpg',100),
('TN005','Dragon Ball Tập 19','Akira Toriyama',35000,0,'Thiếu nhi','Truyện tranh','Bộ manga nổi tiếng toàn cầu.','../images/dragonBallTap19.jpg',100),
('TN006','Thần Đồng Đất Việt Tập 1','Lê Linh',28000,0,'Thiếu nhi','Truyện tranh','Truyện tranh Việt Nam nổi bật.','../images/thanDongDatVietTap1.png',100),
('TN007','Shin - cậu bé bút chì','Takahashi Yoshito',90000,0,'Thiếu nhi','Giáo dục','Tác phẩm văn học thiếu nhi nổi bật.','../images/cauBeButChi.jpg',100),

('GK001','Toán Lớp 1','Nhiều tác giả',18000,0,'Giáo khoa','Cấp 1','Sách giáo khoa Toán lớp 1.','../images/toanLop1.jpg',100),
('GK002','Tiếng Việt Lớp 2','Nhiều tác giả',20000,0,'Giáo khoa','Cấp 1','Sách giáo khoa Tiếng Việt lớp 2.','../images/tiengVietLop2.jpg',100),
('GK003','Hóa học Lớp 8','Nhiều tác giả',25000,0,'Giáo khoa','Cấp 2','Sách giáo khoa Hóa học lớp 8.','../images/hoaHocLop11.jpg',100),
('GK004','Lịch sử Lớp 8','Nhiều tác giả',28000,0,'Giáo khoa','Cấp 2','Sách giáo khoa Lịch sử lớp 7.','../images/lichSuLop8.png',100),
('GK005','Vật lí Lớp 11','Nhiều tác giả',27000,0,'Giáo khoa','Cấp 3','Sách giáo khoa Vật lí lớp 11.','../images/vatLyLop11.png',100),
('GK006','Mỹ thuật Lớp 5','Nhiều tác giả',32000,0,'Giáo khoa','Cấp 1','Sách giáo khoa Mỹ thuật lớp 5.','../images/miThuatLop5.png',100),
('GK007','Hóa Học Lớp 11','Nhiều tác giả',34000,0,'Giáo khoa','Cấp 3','Sách giáo khoa Hóa học lớp 11.','../images/hoaHocLop8.png',100),
('GK008','Đạo đức Lớp 4','Nhiều tác giả',36000,0,'Giáo khoa','Cấp 1','Sách giáo khoa Đạo đức lớp 4.','../images/daoDucLop4.jpg',100);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  status VARCHAR(20),
  fullName VARCHAR(255),
  username VARCHAR(100),
  password VARCHAR(100),
  email VARCHAR(255),
  phone VARCHAR(20),
  address VARCHAR(255),
  createdAt DATETIME
);

INSERT INTO users
(status, fullName, username, password, email, phone, address, createdAt)
VALUES
('active','Giáo Viên (Khách Hàng)','khachhang1','123456',
'teacher@gmail.com','0987654321','123 Đường ABC, Q1, TPHCM',NOW());

