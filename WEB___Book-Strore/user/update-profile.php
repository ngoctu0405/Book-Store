<?php
session_start();
require_once __DIR__ . '/../api/db.php';

// 1. Kiểm tra đăng nhập
if (empty($_SESSION['user_id'])) {
  header("Location: index.php?require_login=true");
  exit;
}

$userId = (int)$_SESSION['user_id'];
$successMsg = '';
$errorMsg = '';

// 2. Xử lý khi người dùng bấm nút Cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullName = trim($_POST['fullname'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $phone    = trim($_POST['phone'] ?? '');
  $address  = trim($_POST['address'] ?? ''); // Nhận chuỗi địa chỉ đã được JS nối lại

  // Xác thực dữ liệu cơ bản
  if (empty($fullName) || empty($email) || empty($phone) || empty($address)) {
    $errorMsg = "Vui lòng nhập đầy đủ các thông tin bắt buộc.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMsg = "Email không hợp lệ.";
  } elseif (!preg_match('/^(0|84)(3|5|7|8|9)[0-9]{8}$/', $phone)) {
    $errorMsg = "Số điện thoại không hợp lệ (Chuẩn VN, 10 số).";
  } else {
    // Cập nhật vào CSDL
    $stmt = $conn->prepare("UPDATE users SET fullName = ?, email = ?, phone = ?, address = ? WHERE id = ?");
    $stmt->bind_param('ssssi', $fullName, $email, $phone, $address, $userId);

    if ($stmt->execute()) {
      $successMsg = "Cập nhật thông tin thành công!";
    } else {
      $errorMsg = "Lỗi hệ thống khi cập nhật: " . $conn->error;
    }
  }
}

// 3. Lấy thông tin hiện tại của người dùng để hiển thị ra form
$userCurrentInfo = [];
$stmtInfo = $conn->prepare("SELECT username, fullName, email, phone, address FROM users WHERE id = ?");
$stmtInfo->bind_param('i', $userId);
$stmtInfo->execute();
$resInfo = $stmtInfo->get_result();
if ($resInfo && $resInfo->num_rows > 0) {
  $userCurrentInfo = $resInfo->fetch_assoc();
}

function h($str)
{
  return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// ==================== CHUẨN BỊ GIAO DIỆN ====================
$pageTitle = "Thông tin tài khoản - Literary Haven";

// Gói CSS riêng của trang
ob_start();
?>
<style>
  body {
    background: linear-gradient(135deg, #f5f2e8 0%, #e8d5b7 50%, #7fb3d3 100%);
    color: #2c3e50;
    min-height: 100vh;
  }

  .container {
    position: relative;
    max-width: 1400px;
    margin: 5rem auto;
    margin-top: 8rem;
  }

  .page-heading {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-top: 20px;
    margin-bottom: 2rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
  }

  .history-container {
    background: white;
    border-radius: 24px;
    padding: 3rem;
    box-shadow: 0 10px 40px rgba(79, 157, 166, 0.15);
    border: 1px solid rgba(130, 192, 154, 0.2);
    min-height: 400px;
    max-width: 800px;
    margin: 0 auto;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
  }

  .input-with-icon {
    display: flex;
    align-items: center;
    border: 2px solid #ddd;
    border-radius: 12px;
    background: #f8f8f8;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .input-with-icon:focus-within {
    border-color: #4f9da6;
    box-shadow: 0 0 0 3px rgba(79, 157, 166, 0.2);
  }

  .input-icon {
    padding: 0.8rem 1rem;
    font-size: 1.2rem;
    color: #7f8c8d;
    background: transparent;
  }

  .input-with-icon input {
    border: none;
    outline: none;
    padding: 0.8rem 1rem 0.8rem 0;
    flex: 1;
    background: transparent;
    font-size: 1rem;
  }

  .input-with-icon input:read-only {
    color: #7f8c8d;
    cursor: not-allowed;
  }

  /* Style riêng cho Thẻ Select (Dropdown) địa chỉ */
  .custom-select {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 2px solid #ddd;
    border-radius: 12px;
    background: #f8f8f8;
    font-size: 1rem;
    color: #2c3e50;
    outline: none;
    transition: all 0.3s ease;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%237f8c8d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 16px 12px;
  }

  .custom-select:focus {
    border-color: #4f9da6;
    box-shadow: 0 0 0 3px rgba(79, 157, 166, 0.2);
  }

  .custom-select:disabled {
    background-color: #e9ecef;
    cursor: not-allowed;
  }

  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
  }

  .btn-action {
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    text-decoration: none;
  }

  .btn-detail {
    background: linear-gradient(135deg, #82c09a 0%, #4f9da6 100%);
    color: white;
  }

  .btn-detail:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(79, 157, 166, 0.4);
    color: white;
  }

  .btn-reorder {
    background: linear-gradient(135deg, #ff7f50 0%, #ff4500 100%);
    color: white;
  }

  .btn-reorder:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(255, 99, 71, 0.4);
    color: white;
  }

  .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 12px;
    font-weight: 500;
  }

  .alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
  }

  .alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
  }

  /* ---------------- CSS BÁO LỖI INLINE ---------------- */
  .input-error,
  .input-with-icon.input-error {
    border-color: #e74c3c !important;
    background-color: #fdf0ed !important;
    box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, .1) !important;
  }

  .error-msg-inline {
    color: #e74c3c;
    font-size: 0.85rem;
    margin-top: 0.4rem;
    display: none;
    font-weight: 600;
  }
</style>
<?php
$extraCss = ob_get_clean();
include '../includes/header.php';
?>

<main class="container">
  <h2 class="page-heading">
    <i class="bi bi-person-lines-fill"></i> Thông tin tài khoản
  </h2>

  <div class="history-container">
    <?php if ($successMsg): ?>
      <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i> <?= h($successMsg) ?>
      </div>
      <script>
        try {
          let userCache = JSON.parse(localStorage.getItem('bs_user') || '{}');
          userCache.fullName = <?= json_encode($fullName ?? $userCurrentInfo['fullName']) ?>;
          localStorage.setItem('bs_user', JSON.stringify(userCache));
        } catch (e) {}
      </script>
    <?php endif; ?>

    <?php if ($errorMsg): ?>
      <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill"></i> <?= h($errorMsg) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="update-profile.php" id="profileForm">
      <div class="form-group">
        <label for="username">Tên đăng nhập (Không thể thay đổi)</label>
        <div class="input-with-icon">
          <span class="input-icon"><i class="bi bi-person-badge"></i></span>
          <input type="text" id="username" value="<?= h($userCurrentInfo['username'] ?? '') ?>" readonly />
        </div>
      </div>

      <div class="form-group">
        <label for="fullname">Họ và Tên *</label>
        <div class="input-with-icon">
          <span class="input-icon"><i class="bi bi-person"></i></span>
          <input type="text" id="fullname" name="fullname" value="<?= h($userCurrentInfo['fullName'] ?? '') ?>" required />
        </div>
      </div>

      <div class="form-group">
        <label for="email">Email *</label>
        <div class="input-with-icon">
          <span class="input-icon"><i class="bi bi-envelope"></i></span>
          <input type="email" id="email" name="email" value="<?= h($userCurrentInfo['email'] ?? '') ?>" required />
        </div>
      </div>

      <div class="form-group">
        <label for="phone">Số điện thoại *</label>
        <div class="input-with-icon" id="wrapper-phone">
          <span class="input-icon"><i class="bi bi-telephone"></i></span>
          <input type="tel" id="phone" name="phone" value="<?= h($userCurrentInfo['phone'] ?? '') ?>" required />
        </div>
        <div id="err-phone" class="error-msg-inline"></div>
      </div>

      <div class="form-group">
        <label>Địa chỉ giao hàng mặc định *</label>
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <select id="edit-city" class="custom-select" required>
            <option value="">Đang tải dữ liệu Tỉnh/Thành phố...</option>
          </select>
          <select id="edit-dist" class="custom-select" required disabled>
            <option value="">Chọn Quận/Huyện</option>
          </select>
          <select id="edit-ward" class="custom-select" required disabled>
            <option value="">Chọn Phường/Xã</option>
          </select>
          <div class="input-with-icon" id="wrapper-street">
            <span class="input-icon"><i class="bi bi-house-door"></i></span>
            <input type="text" id="edit-street" placeholder="Nhập Số nhà, Tên đường, Hẻm..." required />
          </div>
        </div>
        <input type="hidden" name="address" id="hidden-address" value="<?= h($userCurrentInfo['address'] ?? '') ?>">
        <div id="err-address" class="error-msg-inline"></div>
      </div>

      <div class="form-actions">
        <a href="change-password.php" class="btn-action btn-reorder">
          <i class="bi bi-key"></i> Đổi mật khẩu
        </a>
        <button type="submit" class="btn-action btn-detail">
          <i class="bi bi-save"></i> Cập nhật thông tin
        </button>
      </div>
    </form>
  </div>
</main>

<?php
ob_start();
?>
<script>
  document.addEventListener("DOMContentLoaded", async function() {

    const fullAddress = document.getElementById('hidden-address').value;
    const citySel = document.getElementById('edit-city');
    const distSel = document.getElementById('edit-dist');
    const wardSel = document.getElementById('edit-ward');
    const streetInp = document.getElementById('edit-street');
    const wrapperPhone = document.getElementById('wrapper-phone');
    const wrapperStreet = document.getElementById('wrapper-street');
    const errPhone = document.getElementById('err-phone');
    const errAddress = document.getElementById('err-address');

    let cityText = '',
      distText = '',
      wardText = '',
      streetText = fullAddress;

    if (fullAddress && fullAddress.includes(' - ')) {
      const parts = fullAddress.split(' - ');
      streetText = parts.pop();
      const locs = parts.join(' - ').split(', ');
      if (locs.length >= 3) {
        wardText = locs[0].trim();
        distText = locs[1].trim();
        cityText = locs[2].trim();
      } else {
        streetText = fullAddress;
      }
    }
    streetInp.value = streetText;

    // Load API Local
    try {
      const res = await fetch('../assets/data/provinces.json');
      const data = await res.json();

      citySel.innerHTML = '<option value="">Chọn Tỉnh/Thành phố</option>';
      let cityObj = null;

      data.forEach(c => {
        const opt = new Option(c.name, c.code);
        if (c.name === cityText) {
          opt.selected = true;
          cityObj = c;
        }
        citySel.add(opt);
      });

      if (cityObj && cityObj.districts) {
        distSel.disabled = false;
        distSel.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        let distObj = null;
        cityObj.districts.forEach(d => {
          const opt = new Option(d.name, d.code);
          if (d.name === distText) {
            opt.selected = true;
            distObj = d;
          }
          distSel.add(opt);
        });

        if (distObj && distObj.wards) {
          wardSel.disabled = false;
          wardSel.innerHTML = '<option value="">Chọn Phường/Xã</option>';
          distObj.wards.forEach(w => {
            const opt = new Option(w.name, w.code);
            if (w.name === wardText) opt.selected = true;
            wardSel.add(opt);
          });
        }
      }

      citySel.addEventListener('change', function() {
        distSel.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        wardSel.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        distSel.disabled = true;
        wardSel.disabled = true;
        this.classList.remove('input-error');
        errAddress.style.display = 'none';

        if (this.value) {
          const c = data.find(item => item.code == this.value);
          if (c && c.districts) {
            c.districts.forEach(x => distSel.add(new Option(x.name, x.code)));
            distSel.disabled = false;
          }
        }
      });

      distSel.addEventListener('change', function() {
        wardSel.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        wardSel.disabled = true;
        this.classList.remove('input-error');
        errAddress.style.display = 'none';

        if (this.value) {
          const c = data.find(item => item.code == citySel.value);
          const d = c ? c.districts.find(item => item.code == this.value) : null;
          if (d && d.wards) {
            d.wards.forEach(w => wardSel.add(new Option(w.name, w.code)));
            wardSel.disabled = false;
          }
        }
      });

    } catch (e) {
      console.error("Lỗi tải file provinces.json: ", e);
    }

    // Xóa lỗi khi người dùng bắt đầu sửa
    document.getElementById('phone').addEventListener('input', function() {
      wrapperPhone.classList.remove('input-error');
      errPhone.style.display = 'none';
    });
    streetInp.addEventListener('input', function() {
      wrapperStreet.classList.remove('input-error');
      errAddress.style.display = 'none';
    });
    wardSel.addEventListener('change', function() {
      this.classList.remove('input-error');
      errAddress.style.display = 'none';
    });


    // --- 2. XỬ LÝ KIỂM TRA LỖI (VALIDATION) KHI ẤN NÚT LƯU ---
    const form = document.getElementById('profileForm');
    if (form) {
      form.addEventListener('submit', function(e) {

        // Reset toàn bộ lỗi trước khi kiểm tra
        document.querySelectorAll('.error-msg-inline').forEach(n => n.style.display = 'none');
        document.querySelectorAll('.input-error').forEach(n => n.classList.remove('input-error'));
        let hasError = false;

        const phone = document.getElementById('phone').value.trim();
        const street = streetInp.value.trim();

        // 1. Validate Số điện thoại
        if (!/^(0|84)(3|5|7|8|9)[0-9]{8}$/.test(phone)) {
          wrapperPhone.classList.add('input-error');
          errPhone.textContent = 'Số điện thoại không hợp lệ (Cần 10 số bắt đầu bằng 03, 05, 07, 08, 09).';
          errPhone.style.display = 'block';
          hasError = true;
        }

        // 2. Validate Địa chỉ
        if (!citySel.value || !distSel.value || !wardSel.value || !street) {
          if (!citySel.value) citySel.classList.add('input-error');
          if (!distSel.value) distSel.classList.add('input-error');
          if (!wardSel.value) wardSel.classList.add('input-error');
          if (!street) wrapperStreet.classList.add('input-error');

          errAddress.textContent = 'Vui lòng chọn đầy đủ cấp Tỉnh, Quận, Phường và nhập số nhà.';
          errAddress.style.display = 'block';
          hasError = true;
        }

        // 3. Nếu có lỗi thì chặn, không gửi về Server
        if (hasError) {
          e.preventDefault();
          return;
        }

        // Nếu hợp lệ, gộp chuỗi và Submit
        const cityName = citySel.options[citySel.selectedIndex].text;
        const distName = distSel.options[distSel.selectedIndex].text;
        const wardName = wardSel.options[wardSel.selectedIndex].text;

        document.getElementById('hidden-address').value = `${wardName}, ${distName}, ${cityName} - ${street}`;
      });
    }
  });
</script>
<?php
$extraJs = ob_get_clean();

// Gọi Footer chung
include '../includes/footer.php';
?>