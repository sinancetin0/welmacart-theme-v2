<?php
/**
 * Front page template
 */

get_header();
?>

<main class="site-main front-page">
    <!-- Hero Banner Section -->
    <section class="hero-section">
        <div class="hero-slider">
            <?php
            $hero_query = new WP_Query([
                'post_type' => 'hero_banner',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ]);

            if ($hero_query->have_posts()) :
                while ($hero_query->have_posts()) : $hero_query->the_post();
                    // ACF alanlarını al, yoksa meta değerlerini al
                    if (function_exists('get_field')) {
                        $image = get_field('hero_image');
                        $title = get_field('hero_title');
                        $subtitle = get_field('hero_subtitle');
                        $button_text = get_field('hero_button_text');
                        $button_link = get_field('hero_button_link');
                    } else {
                        $image_id = get_post_meta(get_the_ID(), 'hero_image', true);
                        $image = $image_id ? array('id' => $image_id, 'url' => wp_get_attachment_url($image_id), 'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true)) : null;
                        $title = get_post_meta(get_the_ID(), 'hero_title', true);
                        $subtitle = get_post_meta(get_the_ID(), 'hero_subtitle', true);
                        $button_text = get_post_meta(get_the_ID(), 'hero_button_text', true);
                        $button_link = get_post_meta(get_the_ID(), 'hero_button_link', true);
                    }
            ?>
                <div class="hero-slide">
                    <?php if ($image) : ?>
                        <div class="hero-image">
                            <?php 
                            // Hero image için özel responsive image output
                            if (is_array($image) && isset($image['id'])) {
                                $image_id = $image['id'];
                            } elseif (is_numeric($image)) {
                                $image_id = $image;
                            } else {
                                $image_id = attachment_url_to_postid($image['url']);
                            }
                            
                            if ($image_id) {
                                // Farklı boyutlarda resim URL'leri al
                                $desktop_img = wp_get_attachment_image_src($image_id, 'hero-banner');
                                $tablet_img = wp_get_attachment_image_src($image_id, 'hero-banner-tablet');
                                $mobile_img = wp_get_attachment_image_src($image_id, 'hero-banner-mobile');
                                $full_img = wp_get_attachment_image_src($image_id, 'large'); // Retina yerine large kullan
                                
                                // Alt text al
                                $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                
                                // Srcset oluştur
                                $srcset = [];
                                if ($mobile_img) $srcset[] = esc_url($mobile_img[0]) . ' 768w';
                                if ($tablet_img) $srcset[] = esc_url($tablet_img[0]) . ' 1366w';
                                if ($desktop_img) $srcset[] = esc_url($desktop_img[0]) . ' 1920w';
                                if ($full_img && !in_array($full_img[1], [768, 1366, 1920])) {
                                    $srcset[] = esc_url($full_img[0]) . ' ' . $full_img[1] . 'w';
                                }
                                
                                $src_url = $desktop_img ? $desktop_img[0] : ($full_img ? $full_img[0] : '');
                                ?>
                                <img src="<?php echo esc_url($src_url); ?>" 
                                     alt="<?php echo esc_attr($alt_text ?: 'Hero Image'); ?>"
                                     width="1920"
                                     height="1080"
                                     loading="eager"
                                     fetchpriority="high"
                                     decoding="async"
                                     sizes="100vw"
                                     srcset="<?php echo implode(', ', $srcset); ?>">
                                <?php
                            } else {
                                // Fallback - wp_get_attachment_image kullan
                                echo wp_get_attachment_image($image, 'hero-banner', false, [
                                    'loading' => 'eager',
                                    'fetchpriority' => 'high',
                                    'decoding' => 'async',
                                    'sizes' => '100vw'
                                ]);
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="hero-content">
                        <div class="container">
                            <h1 class="hero-title"><?php echo esc_html($title); ?></h1>
                            <?php if ($subtitle) : ?>
                                <p class="hero-subtitle"><?php echo esc_html($subtitle); ?></p>
                            <?php endif; ?>
                            <?php if ($button_text && $button_link) : ?>
                                <a href="<?php echo esc_url($button_link); ?>" class="hero-button">
                                    <?php echo esc_html($button_text); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Öne Çıkan Koleksiyon</h2>
                <p class="section-subtitle">Welma'nın en sevilen eşarp modellerini keşfedin</p>
            </div>
            
            <div class="featured-products-grid">
                <?php
                $featured_query = welmacart_v2_get_featured_products(12);

                if ($featured_query && $featured_query->have_posts()) :
                    while ($featured_query->have_posts()) : $featured_query->the_post();
                        global $product;
                ?>
                        <div class="featured-product-card">
                            <div class="product-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php 
                                    if (has_post_thumbnail()) {
                                        echo woocommerce_get_product_thumbnail('large');
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder-product.svg" alt="' . get_the_title() . '" />';
                                    }
                                    ?>
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php if (get_the_excerpt() || $product->get_short_description()) : ?>
                                <div class="product-excerpt">
                                    <?php 
                                    $excerpt = get_the_excerpt() ?: $product->get_short_description();
                                    echo wp_trim_words($excerpt, 15, '...');
                                    ?>
                                </div>
                                <?php endif; ?>
                                
                                <div class="product-price">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                                
                                <div class="product-actions">
                                    <?php echo do_shortcode('[add_to_cart id="' . get_the_ID() . '" style="" show_price="false" class="featured-add-to-cart"]'); ?>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    // Fallback: En son ürünleri göster
                    $recent_products = new WP_Query(array(
                        'post_type' => 'product',
                        'posts_per_page' => 12,
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));
                    
                    if ($recent_products->have_posts()) :
                        echo '<div class="fallback-notice"><p><em>Öne çıkan ürün bulunamadı. En yeni ürünlerimizi gösteriyoruz:</em></p></div>';
                        while ($recent_products->have_posts()) : $recent_products->the_post();
                            global $product;
                ?>
                            <div class="featured-product-card">
                                <div class="product-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php 
                                        if (has_post_thumbnail()) {
                                            echo woocommerce_get_product_thumbnail('large');
                                        } else {
                                            echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder-product.svg" alt="' . get_the_title() . '" />';
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <?php if (get_the_excerpt() || $product->get_short_description()) : ?>
                                    <div class="product-excerpt">
                                        <?php 
                                        $excerpt = get_the_excerpt() ?: $product->get_short_description();
                                        echo wp_trim_words($excerpt, 15, '...');
                                        ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="product-price">
                                        <?php echo $product->get_price_html(); ?>
                                    </div>
                                    
                                    <div class="product-actions">
                                        <?php echo do_shortcode('[add_to_cart id="' . get_the_ID() . '" style="" show_price="false" class="featured-add-to-cart"]'); ?>
                                    </div>
                                </div>
                            </div>
                <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                ?>
                        <div class="no-products-message">
                            <p>Henüz ürün eklenmemiş. <a href="<?php echo admin_url('edit.php?post_type=product'); ?>">Ürün eklemek için tıklayın</a>.</p>
                            <?php if (current_user_can('manage_options')) : ?>
                                <p><a href="<?php echo add_query_arg('debug_featured', '1'); ?>">Debug Featured Products</a></p>
                            <?php endif; ?>
                        </div>
                <?php
                    endif;
                endif;
                ?>
            </div>
            
            <div class="section-cta">
                <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="cta-button">
                    Tüm Koleksiyonu Görüntüle
                </a>
            </div>
        </div>
    </section>

    <!-- Brand Story Section -->
    <section class="brand-story-section">
        <div class="container">
            <div class="brand-story-content">
                <div class="story-text">
                    <h2 class="story-title">Welma Hikayesi</h2>
                    <p class="story-description">
                        Her eşarp, özenle seçilmiş kumaşlar ve zamansız tasarımlarla hayat buluyor. 
                        Welma, kadının günlük yaşamına zarafet katmak için tasarlanmış, 
                        minimalist ve şık eşarp koleksiyonları sunar.
                    </p>
                    <ul class="story-features">
                        <li>
                            <i data-feather="check-circle"></i>
                            Premium kalite kumaşlar
                        </li>
                        <li>
                            <i data-feather="check-circle"></i>
                            Zamansız tasarımlar
                        </li>
                        <li>
                            <i data-feather="check-circle"></i>
                            Sürdürülebilir üretim
                        </li>
                    </ul>
                </div>
                <div class="story-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/welma-story.jpg" 
                         alt="Welma Hikayesi" 
                         loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Collections Section -->
    <section class="collections-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Koleksiyonlar</h2>
                <p class="section-subtitle">Mevsime özel tasarlanmış eşarp koleksiyonlarımız</p>
            </div>
            
            <div class="collections-grid">
                <div class="collection-card">
                    <div class="collection-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/spring-collection.jpg" 
                             alt="Bahar Koleksiyonu" 
                             loading="lazy">
                    </div>
                    <div class="collection-content">
                        <h3 class="collection-title">Bahar Koleksiyonu</h3>
                        <p class="collection-description">Hafif dokular ve pastel renklerle baharın enerjisi</p>
                        <a href="#" class="collection-link">Koleksiyonu İncele</a>
                    </div>
                </div>
                
                <div class="collection-card">
                    <div class="collection-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/classic-collection.jpg" 
                             alt="Klasik Koleksiyon" 
                             loading="lazy">
                    </div>
                    <div class="collection-content">
                        <h3 class="collection-title">Klasik Koleksiyon</h3>
                        <p class="collection-description">Zamansız desenler ve sade renkler</p>
                        <a href="#" class="collection-link">Koleksiyonu İncele</a>
                    </div>
                </div>
                
                <div class="collection-card">
                    <div class="collection-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/premium-collection.jpg" 
                             alt="Premium Koleksiyon" 
                             loading="lazy">
                    </div>
                    <div class="collection-content">
                        <h3 class="collection-title">Premium Koleksiyon</h3>
                        <p class="collection-description">Lüks kumaşlar ve özel tasarımlar</p>
                        <a href="#" class="collection-link">Koleksiyonu İncele</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <?php welmacart_v2_newsletter_message(); ?>
                <h2 class="newsletter-title">Welma'dan Haberdar Olun</h2>
                <p class="newsletter-description">
                    Yeni koleksiyonlar ve özel fırsatlardan ilk siz haberdar olun
                </p>
                <form class="newsletter-form" action="<?php echo esc_url(home_url('/')); ?>" method="post">
                    <div class="form-group">
                        <input type="email" 
                               name="newsletter_email" 
                               placeholder="E-posta adresiniz" 
                               required>
                        <button type="submit" class="newsletter-button">
                            Abone Ol
                        </button>
                    </div>
                    <?php wp_nonce_field('newsletter_signup', 'newsletter_nonce'); ?>
                </form>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
