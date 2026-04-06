<!-- Modal Đăng Nhập -->
<div id="loginModal" class="auth-modal">
    <div class="auth-modal-overlay" onclick="closeLoginModal()"></div>
    <div class="auth-modal-content">
        <button class="auth-modal-close" onclick="closeLoginModal()">
            &times;
        </button>

        <div class="auth-modal-header">
            <h2>Đăng Nhập</h2>
            <p>Chào mừng bạn trở lại!</p>
        </div>

        <form id="login-form" class="auth-modal-form">
            <div class="form-group">
                <label for="login-username">Tài khoản</label>
                <div class="input-with-icon">
                    <span class="input-icon">👤</span>
                    <input
                        type="text"
                        id="login-username"
                        placeholder="Nhập tài khoản" />
                </div>
                <span id="error-login-username" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label for="login-password">Mật khẩu</label>
                <div class="input-with-icon">
                    <span class="input-icon">🔐</span>
                    <input
                        type="password"
                        id="login-password"
                        placeholder="Nhập mật khẩu" />
                    <span
                        class="password-toggle"
                        id="toggle-login-password"
                        onclick="togglePassword('login-password', 'toggle-login-password')">👁️‍🗨️</span>
                </div>
                <span id="error-login-password" class="error-msg"></span>
            </div>

            <button type="submit" class="btn-auth-submit">Đăng Nhập</button>
        </form>

        <div class="auth-modal-footer">
            Chưa có tài khoản?
            <a href="#" onclick="switchToRegister()">Đăng ký ngay</a>
        </div>
    </div>
</div>

<!-- Modal Đăng Ký -->
<div id="registerModal" class="auth-modal">
    <div class="auth-modal-overlay" onclick="closeRegisterModal()"></div>
    <div class="auth-modal-content">
        <button class="auth-modal-close" onclick="closeRegisterModal()">
            &times;
        </button>

        <div class="auth-modal-header">
            <h2>Đăng Ký</h2>
            <p>Tạo tài khoản mới của bạn</p>
        </div>

        <form id="register-form" class="auth-modal-form">
            <div class="form-group">
                <label for="reg-fullname">Họ và tên</label>
                <div class="input-with-icon">
                    <span class="input-icon">👤</span>
                    <input type="text" id="reg-fullname" placeholder="Nhập họ và tên" />
                </div>
                <span id="error-fullname" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label for="reg-username">Tên tài khoản</label>
                <div class="input-with-icon">
                    <span class="input-icon">🔑</span>
                    <input
                        type="text"
                        id="reg-username"
                        placeholder="Nhập tên tài khoản" />
                </div>
                <span id="error-username" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label for="reg-password">Mật khẩu</label>
                <div class="input-with-icon">
                    <span class="input-icon">🔐</span>
                    <input
                        type="password"
                        id="reg-password"
                        placeholder="Nhập mật khẩu" />
                    <span
                        class="password-toggle"
                        id="toggle-reg-password"
                        onclick="togglePassword('reg-password', 'toggle-reg-password')">👁️‍🗨️</span>
                </div>
                <span id="error-password" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label for="reg-confirm-password">Nhập lại mật khẩu</label>
                <div class="input-with-icon">
                    <span class="input-icon">🔐</span>
                    <input
                        type="password"
                        id="reg-confirm-password"
                        placeholder="Nhập lại mật khẩu" />
                    <span
                        class="password-toggle"
                        id="toggle-reg-confirm-password"
                        onclick="togglePassword('reg-confirm-password', 'toggle-reg-confirm-password')">👁️‍🗨️</span>
                </div>
                <span id="error-confirm-password" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label for="reg-email">Email</label>
                <div class="input-with-icon">
                    <span class="input-icon">📧</span>
                    <input type="email" id="reg-email" placeholder="Nhập email" />
                </div>
                <span id="error-email" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label for="reg-phone">Số điện thoại</label>
                <div class="input-with-icon">
                    <span class="input-icon">📱</span>
                    <input type="tel" id="reg-phone" placeholder="Nhập số điện thoại" />
                </div>
                <span id="error-phone" class="error-msg"></span>
            </div>

            <div class="form-group">
                <label for="reg-address">Địa chỉ</label>
                <div class="input-with-icon">
                    <span class="input-icon">📍</span>
                    <input type="text" id="reg-address" placeholder="Nhập địa chỉ" />
                </div>
                <span id="error-address" class="error-msg"></span>
            </div>

            <button type="submit" class="btn-auth-submit">Đăng Ký</button>
        </form>

        <div class="auth-modal-footer">
            Đã có tài khoản?
            <a href="#" onclick="switchToLogin()">Đăng nhập ngay</a>
        </div>
    </div>
</div>

<!-- Modal Profile (Hiển thị khi đã đăng nhập) -->
<div id="profileModal" class="auth-modal">
    <div class="auth-modal-overlay" onclick="closeProfileModal()"></div>
    <div class="auth-modal-content">
        <button class="auth-modal-close" onclick="closeProfileModal()">
            &times;
        </button>
        <div class="auth-modal-header">
            <div class="profile-avatar-small">👤</div>
            <h2 id="profile-fullname">Xin chào!</h2>
            <p>Thông tin tài khoản của bạn</p>
        </div>
        <div class="profile-info-modal">
            <div class="info-row">
                <span class="info-label">👤 Họ và tên:</span>
                <span class="info-value" id="profile-name-value"></span>
            </div>
            <div class="info-row">
                <span class="info-label">🔐 Tài khoản:</span>
                <span class="info-value" id="profile-username-value"></span>
            </div>
            <div class="info-row">
                <span class="info-label">📧 Email:</span>
                <span class="info-value" id="profile-email-value"></span>
            </div>
            <div class="info-row">
                <span class="info-label">📱 Số điện thoại:</span>
                <span class="info-value" id="profile-phone-value"></span>
            </div>
            <div class="info-row">
                <span class="info-label">📍 Địa chỉ:</span>
                <span class="info-value" id="profile-address-value"></span>
            </div>
        </div>

        <button class="btn-logout-modal" onclick="handleLogoutModal()">
            Đăng xuất
        </button>
    </div>
</div>