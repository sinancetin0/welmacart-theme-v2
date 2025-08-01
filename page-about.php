<?php
/**
 * Template Name: Hakkımızda
 * Template for About Page
 * WelmaCart V2 Theme
 */

get_header(); ?>

<main class="page-content about-page">
    <div class="container">
        
        <!-- Hero Section -->
        <section class="about-hero">
            <div class="about-hero-content">
                <h1 class="page-title">Welma Hikayesi</h1>
                <p class="page-subtitle">Her kadının içindeki zarafeti ortaya çıkaran, zamansız eşarp koleksiyonları</p>
            </div>
            <div class="about-hero-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-hero.jpg" alt="Welma Hikayesi" />
            </div>
        </section>

        <!-- Story Section -->
        <section class="about-story">
            <div class="story-grid">
                <div class="story-content">
                    <h2>Bir Tutkunun Doğuşu</h2>
                    <p>Welma'nın hikayesi, güzelliğin ve zarafetin evrensel bir dil olduğuna dair güçlü bir inançla başladı. Kurucu Elif Demir'in tekstil dünyasına olan tutkusu, Milano'daki moda okulu yıllarında şekillendi.</p>
                    
                    <p>2018 yılında İstanbul'da kurulan Welma, her kadının kendini özel hissetmesi gerektiği felsefesi ile yola çıktı. Markamızın adı, "Well made" (iyi yapılmış) kavramından türetilmiş ve her ürünümüzde bu mükemmellik arayışını yansıtıyoruz.</p>
                </div>
                <div class="story-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/founder.jpg" alt="Elif Demir - Kurucu" />
                    <div class="image-caption">Elif Demir, Kurucu</div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="about-values">
            <h2 class="section-title">Değerlerimiz</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i data-lucide="heart"></i>
                    </div>
                    <h3>Tutku</h3>
                    <p>Her ürünümüzü, kadının güzelliğini ortaya çıkarma tutkusu ile tasarlıyoruz.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i data-lucide="award"></i>
                    </div>
                    <h3>Kalite</h3>
                    <p>Sadece en iyi kumaşları ve en titiz işçiliği kullanarak üretim yapıyoruz.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i data-lucide="users"></i>
                    </div>
                    <h3>Topluluk</h3>
                    <p>Her kadını güçlendiren, destekleyen bir topluluk oluşturuyoruz.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i data-lucide="leaf"></i>
                    </div>
                    <h3>Sürdürülebilirlik</h3>
                    <p>Doğaya saygılı, etik ve sürdürülebilir üretim süreçlerini benimseriz.</p>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="about-team">
            <h2 class="section-title">Ekibimiz</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-elif.jpg" alt="Elif Demir" />
                    </div>
                    <h3>Elif Demir</h3>
                    <p class="member-role">Kurucu & Kreatif Direktör</p>
                    <p class="member-bio">Milano Moda Akademisi mezunu. 10 yıllık tekstil deneyimi.</p>
                </div>
                
                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-ayse.jpg" alt="Ayşe Kaya" />
                    </div>
                    <h3>Ayşe Kaya</h3>
                    <p class="member-role">Tasarım Direktörü</p>
                    <p class="member-bio">Parsons School of Design mezunu. Sürdürülebilir moda uzmanı.</p>
                </div>
                
                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-mehmet.jpg" alt="Mehmet Öz" />
                    </div>
                    <h3>Mehmet Öz</h3>
                    <p class="member-role">Üretim Direktörü</p>
                    <p class="member-bio">25 yıllık tekstil üretim deneyimi ve kalite kontrolü uzmanı.</p>
                </div>
            </div>
        </section>

        <!-- Numbers Section -->
        <section class="about-numbers">
            <div class="numbers-grid">
                <div class="number-card">
                    <div class="number">50K+</div>
                    <div class="number-label">Mutlu Müşteri</div>
                </div>
                <div class="number-card">
                    <div class="number">1M+</div>
                    <div class="number-label">Satılan Ürün</div>
                </div>
                <div class="number-card">
                    <div class="number">25+</div>
                    <div class="number-label">Ülkeye İhracat</div>
                </div>
                <div class="number-card">
                    <div class="number">6</div>
                    <div class="number-label">Yıllık Deneyim</div>
                </div>
            </div>
        </section>

    </div>
</main>

<?php get_footer(); ?>
