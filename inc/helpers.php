<?php
/**
 * Yardımcı fonksiyonlar
 */

if (!function_exists('welmacart_v2_asset_version')) {
    /**
     * Dosya değişiklik zamanına göre versiyon numarası üret
     */
    function welmacart_v2_asset_version($file) {
        $file_path = get_template_directory() . $file;
        return file_exists($file_path) ? filemtime($file_path) : '1.0';
    }
}

if (!function_exists('welmacart_v2_truncate')) {
    /**
     * Metni belirli bir uzunlukta kes
     */
    function welmacart_v2_truncate($text, $length = 55, $more = '...') {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $more;
    }
}

if (!function_exists('welmacart_v2_is_blog')) {
    /**
     * Blog sayfalarını kontrol et
     */
    function welmacart_v2_is_blog() {
        return (is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
    }
}

if (!function_exists('welmacart_v2_handle_newsletter')) {
    /**
     * Newsletter abonelik işlemi
     */
    function welmacart_v2_handle_newsletter() {
        if (isset($_POST['newsletter_email']) && !empty($_POST['newsletter_email'])) {
            $email = sanitize_email($_POST['newsletter_email']);
            
            if (is_email($email)) {
                // Newsletter e-posta adresini kaydet (basit bir opsiyon olarak)
                $subscribers = get_option('welmacart_newsletter_subscribers', array());
                
                if (!in_array($email, $subscribers)) {
                    $subscribers[] = $email;
                    update_option('welmacart_newsletter_subscribers', $subscribers);
                    
                    wp_redirect(add_query_arg('newsletter', 'success', home_url()));
                    exit;
                } else {
                    wp_redirect(add_query_arg('newsletter', 'exists', home_url()));
                    exit;
                }
            } else {
                wp_redirect(add_query_arg('newsletter', 'invalid', home_url()));
                exit;
            }
        }
    }
}
add_action('init', 'welmacart_v2_handle_newsletter');

if (!function_exists('welmacart_v2_newsletter_message')) {
    /**
     * Newsletter mesajlarını göster
     */
    function welmacart_v2_newsletter_message() {
        if (isset($_GET['newsletter'])) {
            $status = $_GET['newsletter'];
            $messages = array(
                'success' => 'Teşekkürler! Newsletter aboneliğiniz başarıyla oluşturuldu.',
                'exists' => 'Bu e-posta adresi zaten kayıtlı.',
                'invalid' => 'Lütfen geçerli bir e-posta adresi girin.'
            );
            
            if (isset($messages[$status])) {
                echo '<div class="newsletter-message newsletter-' . esc_attr($status) . '">';
                echo esc_html($messages[$status]);
                echo '</div>';
            }
        }
    }
}

if (!function_exists('welmacart_v2_get_featured_products')) {
    /**
     * Öne çıkan ürünleri getir
     */
    function welmacart_v2_get_featured_products($limit = 4) {
        if (!class_exists('WooCommerce')) {
            return false;
        }
        
        // WooCommerce 3.0+ için featured products query
        $featured_ids = wc_get_featured_product_ids();
        
        if (empty($featured_ids)) {
            // Fallback: eski yöntemle dene
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $limit,
                'meta_query' => array(
                    array(
                        'key' => '_featured',
                        'value' => 'yes'
                    )
                ),
                'post_status' => 'publish'
            );
        } else {
            // Yeni yöntem: featured product ID'leri kullan
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $limit,
                'post__in' => $featured_ids,
                'post_status' => 'publish',
                'orderby' => 'post__in'
            );
        }
        
        return new WP_Query($args);
    }
}

if (!function_exists('welmacart_v2_debug_featured_products')) {
    /**
     * Featured products debug fonksiyonu
     */
    function welmacart_v2_debug_featured_products() {
        if (!current_user_can('manage_options') || !isset($_GET['debug_featured'])) {
            return;
        }
        
        if (class_exists('WooCommerce')) {
            echo '<div style="background: #fff; padding: 20px; margin: 20px; border: 1px solid #ddd; position: fixed; top: 100px; right: 20px; z-index: 9999; width: 400px;">';
            echo '<h3>Featured Products Debug</h3>';
            
            // WooCommerce featured products
            $featured_ids = wc_get_featured_product_ids();
            echo '<p>WC Featured IDs: ' . implode(', ', $featured_ids) . '</p>';
            
            // Meta query ile kontrol
            $meta_products = get_posts(array(
                'post_type' => 'product',
                'numberposts' => -1,
                'meta_query' => array(
                    array(
                        'key' => '_featured',
                        'value' => 'yes'
                    )
                )
            ));
            echo '<p>Meta Featured Count: ' . count($meta_products) . '</p>';
            
            // Tüm ürünleri listele
            $all_products = get_posts(array(
                'post_type' => 'product',
                'numberposts' => 10,
                'post_status' => 'publish'
            ));
            echo '<p>Total Products: ' . count($all_products) . '</p>';
            foreach ($all_products as $product) {
                $is_featured = get_post_meta($product->ID, '_featured', true);
                echo '<p>' . $product->post_title . ' - Featured: ' . ($is_featured === 'yes' ? 'YES' : 'NO') . '</p>';
            }
            
            echo '<p><a href="' . remove_query_arg('debug_featured') . '">Kapat</a></p>';
            echo '</div>';
        }
    }
}
add_action('wp_footer', 'welmacart_v2_debug_featured_products');

if (!function_exists('welmacart_v2_live_search')) {
    /**
     * AJAX Live Search
     */
    function welmacart_v2_live_search() {
        // Debug: Log the request
        error_log('Live search request received');
        error_log('POST data: ' . print_r($_POST, true));
        
        // Nonce verification
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'welmacart_ajax_nonce')) {
            error_log('Nonce verification failed');
            wp_send_json_error('Security check failed');
        }
        
        $query = sanitize_text_field($_POST['query']);
        error_log('Search query: ' . $query);
        
        if (empty($query) || strlen($query) < 2) {
            wp_send_json_error('Query too short');
        }
        
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 6,
            's' => $query,
            'meta_query' => array(
                array(
                    'key' => '_stock_status',
                    'value' => 'instock'
                )
            )
        );
        
        $search_query = new WP_Query($args);
        $results = array();
        
        error_log('Found posts: ' . $search_query->found_posts);
        
        if ($search_query->have_posts()) {
            while ($search_query->have_posts()) {
                $search_query->the_post();
                global $product;
                
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                $image_url = $image ? $image[0] : wc_placeholder_img_src('thumbnail');
                
                $results[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'url' => get_permalink(),
                    'price' => $product->get_price_html(),
                    'image' => $image_url,
                    'excerpt' => wp_trim_words(get_the_excerpt(), 15)
                );
            }
            wp_reset_postdata();
        }
        
        error_log('Results count: ' . count($results));
        wp_send_json_success($results);
    }
}
add_action('wp_ajax_welmacart_live_search', 'welmacart_v2_live_search');
add_action('wp_ajax_nopriv_welmacart_live_search', 'welmacart_v2_live_search');
