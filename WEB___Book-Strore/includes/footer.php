<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3>Về Chúng tôi</h3>
            <ul>
                <li><a href="about.php">Giới thiệu</a></li>
                <li><a href="news.php">Tin tức</a></li>
                <li><a href="privacy_policy.php">Chính sách bảo mật</a></li>
                <li><a href="terms-of-use.php">Điều khoản sử dụng</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Hỗ trợ khách hàng</h3>
            <ul>
                <li><a href="shopping_guide.php">Hướng dẫn mua hàng</a></li>
                <li><a href="exchange-policy.php">Chính sách đổi trả</a></li>
                <li><a href="warranty-policy.php">Chính sách bảo hành</a></li>
                <li><a href="frequently-asked-questions.php">Câu hỏi thường gặp</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Chính sách</h3>
            <ul>
                <li><a href="payment-policy.php">Chính sách thanh toán</a></li>
                <li><a href="shipping-policy.php">Chính sách vận chuyển</a></li>
                <li><a href="warranty-policy.php">Chính sách bảo hành</a></li>
                <li><a href="exchange-policy.php">Chính sách đổi trả</a></li>
            </ul>
        </div>
        <div class="footer-section contact-info">
            <h3>Liên hệ</h3>
            <p>📍 123 Nguyễn Văn Linh, Q7, TP.HCM</p>
            <p>📞 Hotline: 1900 xxxx</p>
            <p>✉️ Email: support@bookstore.vn</p>
            <p>🕐 Giờ làm việc: 8:00 - 22:00</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Book Store. All rights reserved. | Designed with ❤️</p>
    </div>
</footer>

<?php include __DIR__ . '/auth_modals.php'; ?>

<script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js?v=<?= time() ?>"></script>

<?= isset($extraJs) ? $extraJs : '' ?>
</body>

</html>