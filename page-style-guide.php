<?php
/**
 * Template Name: Stil Rehberi
 * Template for Style Guide Page
 * WelmaCart V2 Theme
 */

get_header(); ?>

<main class="page-content style-guide-page">
    <div class="container">
        
        <!-- Style Guide Hero -->
        <section class="style-hero">
            <div class="style-hero-content">
                <h1 class="page-title">Stil Rehberi</h1>
                <p class="page-subtitle">Eşarplarınızı farklı tarzlarda bağlama teknikleri ve stil önerileri</p>
            </div>
        </section>

        <!-- Style Categories -->
        <section class="style-categories">
            <div class="category-tabs">
                <button class="tab-btn active" data-category="classic">Klasik Tarzlar</button>
                <button class="tab-btn" data-category="modern">Modern Tarzlar</button>
                <button class="tab-btn" data-category="casual">Günlük Tarzlar</button>
                <button class="tab-btn" data-category="formal">Özel Günler</button>
            </div>

            <!-- Classic Styles -->
            <div class="style-content active" data-category="classic">
                <div class="styles-grid">
                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-classic-1.jpg" alt="Klasik Boyun Bağı" />
                            <div class="difficulty-badge easy">Kolay</div>
                        </div>
                        <div class="style-info">
                            <h3>Klasik Boyun Bağı</h3>
                            <p>En temel ve şık eşarp bağlama tekniği. Her ortamda kullanılabilir.</p>
                            <div class="style-steps">
                                <h4>Adımlar:</h4>
                                <ol>
                                    <li>Eşarpı boynunuza dolayın</li>
                                    <li>Uçları eşit uzunlukta tutun</li>
                                    <li>Basit bir düğüm atın</li>
                                    <li>Düğümü merkeze yerleştirin</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-classic-2.jpg" alt="Fransız Düğümü" />
                            <div class="difficulty-badge medium">Orta</div>
                        </div>
                        <div class="style-info">
                            <h3>Fransız Düğümü</h3>
                            <p>Zarif ve sofistike görünüm için ideal. İş ortamına çok uygun.</p>
                            <div class="style-steps">
                                <h4>Adımlar:</h4>
                                <ol>
                                    <li>Eşarpı boynunuza çapraz dolayın</li>
                                    <li>Uzun ucu kısa ucun altından geçirin</li>
                                    <li>Tekrar üstten sarın</li>
                                    <li>Ucu ilmekten geçirerek sıkın</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-classic-3.jpg" alt="İtalyan Tarzı" />
                            <div class="difficulty-badge medium">Orta</div>
                        </div>
                        <div class="style-info">
                            <h3>İtalyan Tarzı</h3>
                            <p>Günlük şıklık için mükemmel. Rahat ve modern görünüm.</p>
                            <div class="style-steps">
                                <h4>Adımlar:</h4>
                                <ol>
                                    <li>Eşarpı katla ve boyna as</li>
                                    <li>Uçları döngüden geçir</li>
                                    <li>Gevşek bırak</li>
                                    <li>Uçları düzenle</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Styles -->
            <div class="style-content" data-category="modern">
                <div class="styles-grid">
                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-modern-1.jpg" alt="Omuz Sarma" />
                            <div class="difficulty-badge easy">Kolay</div>
                        </div>
                        <div class="style-info">
                            <h3>Omuz Sarma</h3>
                            <p>Modern ve rahat tarz. Günlük kıyafetlerle harika uyum sağlar.</p>
                        </div>
                    </div>

                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-modern-2.jpg" alt="Çapraz Bağ" />
                            <div class="difficulty-badge medium">Orta</div>
                        </div>
                        <div class="style-info">
                            <h3>Çapraz Bağ</h3>
                            <p>Sportif ve dinamik görünüm. Genç ve enerjik tarz için ideal.</p>
                        </div>
                    </div>

                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-modern-3.jpg" alt="Katmanlı Sarma" />
                            <div class="difficulty-badge hard">Zor</div>
                        </div>
                        <div class="style-info">
                            <h3>Katmanlı Sarma</h3>
                            <p>Karmaşık ama çok etkileyici. Özel günler için muhteşem.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Casual Styles -->
            <div class="style-content" data-category="casual">
                <div class="styles-grid">
                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-casual-1.jpg" alt="Serbest Stil" />
                            <div class="difficulty-badge easy">Kolay</div>
                        </div>
                        <div class="style-info">
                            <h3>Serbest Stil</h3>
                            <p>Günlük kullanım için rahat ve pratik. Her yaşa uygun.</p>
                        </div>
                    </div>

                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-casual-2.jpg" alt="Plaj Stili" />
                            <div class="difficulty-badge easy">Kolay</div>
                        </div>
                        <div class="style-info">
                            <h3>Plaj Stili</h3>
                            <p>Yaz tatilleri ve sahil gezileri için hafif ve ferah.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formal Styles -->
            <div class="style-content" data-category="formal">
                <div class="styles-grid">
                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-formal-1.jpg" alt="Gala Stili" />
                            <div class="difficulty-badge hard">Zor</div>
                        </div>
                        <div class="style-info">
                            <h3>Gala Stili</h3>
                            <p>Özel davetler ve gala geceleri için lüks ve zarif görünüm.</p>
                        </div>
                    </div>

                    <div class="style-card">
                        <div class="style-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/style-formal-2.jpg" alt="İş Stili" />
                            <div class="difficulty-badge medium">Orta</div>
                        </div>
                        <div class="style-info">
                            <h3>İş Stili</h3>
                            <p>Profesyonel ortamlar için şık ve uygun tarz.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Style Tips -->
        <section class="style-tips">
            <h2 class="section-title">Stil İpuçları</h2>
            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon">
                        <i data-lucide="palette"></i>
                    </div>
                    <h3>Renk Uyumu</h3>
                    <p>Eşarp renginizi kıyafetinizdeki bir renkle uyumlu seçin. Kontrast renkler cesur bir görünüm sağlar.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-icon">
                        <i data-lucide="scissors"></i>
                    </div>
                    <h3>Boyut Seçimi</h3>
                    <p>Büyük eşarplar dramatic efekt, küçük eşarplar ise sofistike görünüm yaratır.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-icon">
                        <i data-lucide="shirt"></i>
                    </div>
                    <h3>Kıyafet Uyumu</h3>
                    <p>Sade kıyafetlerle desenli eşarp, desenli kıyafetlerle düz eşarp kullanın.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-icon">
                        <i data-lucide="sun"></i>
                    </div>
                    <h3>Mevsim Uyumu</h3>
                    <p>Yaz için hafif kumaşlar, kış için kalın ve sıcak tutan kumaşları tercih edin.</p>
                </div>
            </div>
        </section>

        <!-- Video Tutorials -->
        <section class="video-tutorials">
            <h2 class="section-title">Video Rehberler</h2>
            <div class="videos-grid">
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/video-thumb-1.jpg" alt="Temel Eşarp Bağlama" />
                        <button class="play-btn" data-video="temel-esarp-baglama">
                            <i data-lucide="play"></i>
                        </button>
                    </div>
                    <h3>Temel Eşarp Bağlama Teknikleri</h3>
                    <p>5 dakikada öğrenebileceğiniz temel bağlama yöntemleri</p>
                </div>

                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/video-thumb-2.jpg" alt="İleri Seviye" />
                        <button class="play-btn" data-video="ileri-seviye">
                            <i data-lucide="play"></i>
                        </button>
                    </div>
                    <h3>İleri Seviye Stil Teknikleri</h3>
                    <p>Profesyonel görünüm için karmaşık bağlama yöntemleri</p>
                </div>

                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/video-thumb-3.jpg" alt="Kış Stilleri" />
                        <button class="play-btn" data-video="kis-stilleri">
                            <i data-lucide="play"></i>
                        </button>
                    </div>
                    <h3>Kış Eşarp Stilleri</h3>
                    <p>Soğuk havalarda sıcak ve şık kalma teknikleri</p>
                </div>
            </div>
        </section>

    </div>
</main>

<?php get_footer(); ?>
