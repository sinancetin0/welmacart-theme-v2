<?php
/**
 * Template Name: İletişim
 * Template for Contact Page
 * WelmaCart V2 Theme
 */

get_header(); ?>

<main class="page-content contact-page">
    <div class="container">
        
        <!-- Contact Hero -->
        <section class="contact-hero">
            <div class="contact-hero-content">
                <h1 class="page-title">İletişim</h1>
                <p class="page-subtitle">Sorularınız, önerileriniz veya özel talepleriniz için bizimle iletişime geçin</p>
            </div>
        </section>

        <!-- Contact Content -->
        <section class="contact-content">
            <div class="contact-grid">
                
                <!-- Contact Form -->
                <div class="contact-form-section">
                    <h2>Bize Yazın</h2>
                    <form class="contact-form" id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">Ad*</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Soyad*</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">E-posta*</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Telefon</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Konu*</label>
                            <select id="subject" name="subject" required>
                                <option value="">Konu seçin</option>
                                <option value="order">Sipariş Durumu</option>
                                <option value="product">Ürün Bilgisi</option>
                                <option value="return">İade/Değişim</option>
                                <option value="complaint">Şikayet</option>
                                <option value="suggestion">Öneri</option>
                                <option value="other">Diğer</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Mesajınız*</label>
                            <textarea id="message" name="message" rows="5" required placeholder="Mesajınızı buraya yazın..."></textarea>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="privacy" name="privacy" required>
                                <span class="checkmark"></span>
                                <a href="/gizlilik-politikasi" target="_blank">Gizlilik Politikası</a>'nı okudum ve kabul ediyorum.*
                            </label>
                        </div>
                        
                        <button type="submit" class="contact-submit-btn">
                            <span>Gönder</span>
                            <i data-lucide="send"></i>
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="contact-info-section">
                    <h2>İletişim Bilgileri</h2>
                    
                    <div class="contact-info-cards">
                        <div class="info-card">
                            <div class="info-icon">
                                <i data-lucide="map-pin"></i>
                            </div>
                            <div class="info-content">
                                <h3>Adres</h3>
                                <p>Welma Tekstil San. ve Tic. Ltd. Şti.<br>
                                Maslak Mahallesi, Büyükdere Caddesi<br>
                                No: 123, Kat: 5<br>
                                34485 Sarıyer / İstanbul</p>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <div class="info-icon">
                                <i data-lucide="phone"></i>
                            </div>
                            <div class="info-content">
                                <h3>Telefon</h3>
                                <p><a href="tel:+902121234567">+90 (212) 123 45 67</a><br>
                                <a href="tel:+905321234567">+90 (532) 123 45 67</a></p>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <div class="info-icon">
                                <i data-lucide="mail"></i>
                            </div>
                            <div class="info-content">
                                <h3>E-posta</h3>
                                <p><a href="mailto:info@welma.com.tr">info@welma.com.tr</a><br>
                                <a href="mailto:destek@welma.com.tr">destek@welma.com.tr</a></p>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <div class="info-icon">
                                <i data-lucide="clock"></i>
                            </div>
                            <div class="info-content">
                                <h3>Çalışma Saatleri</h3>
                                <p>Pazartesi - Cuma: 09:00 - 18:00<br>
                                Cumartesi: 10:00 - 16:00<br>
                                Pazar: Kapalı</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="social-media">
                        <h3>Sosyal Medya</h3>
                        <div class="social-links">
                            <a href="https://instagram.com/welma" target="_blank" class="social-link">
                                <i data-lucide="instagram"></i>
                                <span>@welma</span>
                            </a>
                            <a href="https://facebook.com/welma" target="_blank" class="social-link">
                                <i data-lucide="facebook"></i>
                                <span>Welma</span>
                            </a>
                            <a href="https://pinterest.com/welma" target="_blank" class="social-link">
                                <i data-lucide="pinterest"></i>
                                <span>Welma</span>
                            </a>
                            <a href="https://youtube.com/welma" target="_blank" class="social-link">
                                <i data-lucide="youtube"></i>
                                <span>Welma</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="contact-faq">
            <h2 class="section-title">Sık Sorulan Sorular</h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <h3>Siparişim ne zaman kargoya verilir?</h3>
                    <p>Siparişleriniz 1-2 iş günü içinde hazırlanarak kargoya verilir. Hafta sonları verilen siparişler pazartesi günü işleme alınır.</p>
                </div>
                
                <div class="faq-item">
                    <h3>İade ve değişim süreci nasıl işler?</h3>
                    <p>Ürünlerinizi 14 gün içinde, etiketli ve kullanılmamış halde iade edebilirsiniz. İade işlemi için müşteri hizmetlerimizle iletişime geçin.</p>
                </div>
                
                <div class="faq-item">
                    <h3>Ürünlerin bakım talimatları var mı?</h3>
                    <p>Her ürünümüzün etiketinde bakım talimatları bulunur. Ayrıca web sitemizde detaylı bakım rehberi mevcuttur.</p>
                </div>
                
                <div class="faq-item">
                    <h3>Özel tasarım hizmeti veriyor musunuz?</h3>
                    <p>Evet, özel etkinlikler ve kurumsal siparişler için özel tasarım hizmeti sunuyoruz. Detaylar için iletişime geçin.</p>
                </div>
            </div>
        </section>

    </div>
</main>

<?php get_footer(); ?>
