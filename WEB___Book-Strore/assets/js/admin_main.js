// =======================================================================
// TỆP JS DÀNH CHO ADMIN (Đã xóa bỏ hoàn toàn LocalStorage)
// =======================================================================

/**
 * Định dạng số thành tiền tệ (vd: 10000 -> "10.000đ")
 * (Giữ lại phòng trường hợp cần dùng cho giao diện Frontend)
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

// --- LOGIC CHÍNH (Chạy khi DOM đã tải) ---
document.addEventListener("DOMContentLoaded", function () {
  const currentPage = window.location.pathname.split("/").pop() || "dashboard.php";

  // --- LOGIC TOÀN CỤC (HIGHLIGHT SIDEBAR) ---
  function initGlobal() {
    const sidebarLinks = document.querySelectorAll(".sidebar .nav-link");
    sidebarLinks.forEach((link) => {
      link.classList.remove("active");
      // So sánh href của link với trang hiện tại
      const linkHref = link.getAttribute("href")?.split("/").pop();
      if (linkHref === currentPage) {
        link.classList.add("active");
      }
    });
  }

  // Khởi chạy các hàm toàn cục
  initGlobal();

  // Mọi logic dữ liệu (Orders, Inventory, Detail...) giờ đây đã được giao cho PHP & MySQL xử lý.
});