<?php
/**
 * Footer template - Apple-inspired professional design
 */
?>

<footer class="site-footer">
    <div class="footer-container">
        <!-- Main Footer Content -->
        <div class="footer-main">
            <div class="footer-grid">
                <!-- Brand Section -->
                <div class="footer-brand">
                    <?php if (has_custom_logo()): ?>
                        <div class="footer-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-brand-link">
                            <span class="brand-name"><?php bloginfo('name'); ?></span>
                        </a>
                    <?php endif; ?>
                    <p class="brand-tagline"><?php bloginfo('description'); ?></p>
                    
                    <!-- Social Links -->
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Instagram">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Facebook">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Pinterest">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.747 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation Columns -->
                <div class="footer-nav-section">
                    <h3 class="footer-title">Mağaza</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Tüm Ürünler</a></li>
                        <li><a href="#">Yeni Gelenler</a></li>
                        <li><a href="#">Sezon Önerileri</a></li>
                        <li><a href="#">İndirimli Ürünler</a></li>
                        <li><a href="#">Hediye Kartları</a></li>
                    </ul>
                </div>

                <div class="footer-nav-section">
                    <h3 class="footer-title">Destek</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo get_permalink(get_page_by_path('contact')); ?>">İletişim</a></li>
                        <li><a href="#">Size Rehberi</a></li>
                        <li><a href="#">Bakım Talimatları</a></li>
                        <li><a href="#">Kargo & İade</a></li>
                        <li><a href="#">SSS</a></li>
                    </ul>
                </div>

                <div class="footer-nav-section">
                    <h3 class="footer-title">Hakkımızda</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo get_permalink(get_page_by_path('about')); ?>">Hikayemiz</a></li>
                        <li><a href="#">Sürdürülebilirlik</a></li>
                        <li><a href="#">Basın</a></li>
                        <li><a href="#">Kariyer</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>

                <!-- Newsletter Section -->
                <div class="footer-newsletter">
                    <h3 class="footer-title">Bülten</h3>
                    <p class="newsletter-text">Yeni koleksiyonlar ve özel tekliflerden haberdar olun.</p>
                    <form class="newsletter-form" action="#" method="post">
                        <div class="newsletter-input-group">
                            <input type="email" name="email" placeholder="E-posta adresiniz" class="newsletter-input" required>
                            <button type="submit" class="newsletter-button">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m9 18 6-6-6-6"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <div class="newsletter-privacy">
                        <small>E-posta adresinizi gizli tutuyoruz. <a href="#">Gizlilik Politikası</a></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="footer-legal">
                    <p class="copyright">
                        &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Tüm hakları saklıdır.
                    </p>
                    <div class="legal-links">
                        <a href="#">Gizlilik Politikası</a>
                        <a href="#">Kullanım Şartları</a>
                        <a href="#">Çerez Politikası</a>
                    </div>
                </div>
                
                <div class="footer-payments">
                    <span class="payment-text">Güvenli Ödeme:</span>
                    <div class="payment-icons">
                        <span class="payment-icon visa">VISA</span>
                        <span class="payment-icon mastercard">MC</span>
                        <span class="payment-icon paypal">PayPal</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
