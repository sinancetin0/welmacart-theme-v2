<?php
/**
 * WelmaCart v2 functions and definitions
 */

// Debug mode - remove in production
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}

// Tema setup
require get_template_directory() . '/inc/setup.php';

// Stil ve script dosyalarının yüklenmesi
require get_template_directory() . '/inc/enqueue.php';

// Özel post tipleri ve taksonomiler
require get_template_directory() . '/inc/custom-post-types.php';

// ACF alanları
require get_template_directory() . '/inc/acf-fields.php';

// ACF Product Features
require get_template_directory() . '/inc/acf-product-fields.php';

// Custom Meta Boxes (ACF fallback)
require get_template_directory() . '/inc/meta-boxes.php';

// WooCommerce entegrasyonu
require get_template_directory() . '/inc/woocommerce.php';

// Single product customizations
require get_template_directory() . '/inc/single-product-hooks.php';

// Yardımcı fonksiyonlar
require get_template_directory() . '/inc/helpers.php';

// Debug fonksiyonları (development için)
if (defined('WP_DEBUG') && WP_DEBUG) {
    require get_template_directory() . '/inc/debug.php';
    require get_template_directory() . '/template-debug.php';
}

/**
 * Page Templates için özel fonksiyonlar
 */

// Page Template'lerin düzgün çalışması için
add_filter('theme_page_templates', 'welmacart_v2_add_page_templates');
function welmacart_v2_add_page_templates($templates) {
    $templates['page-about.php'] = 'Hakkımızda';
    $templates['page-contact.php'] = 'İletişim';
    $templates['page-style-guide.php'] = 'Stil Rehberi';
    return $templates;
}

// Template cache temizleme
add_action('wp_insert_post', 'welmacart_v2_flush_template_cache');
function welmacart_v2_flush_template_cache() {
    wp_cache_delete('page_templates-' . get_option('stylesheet'), 'themes');
}

/**
 * WooCommerce My Account Customizations
 */

// Remove default dashboard content to prevent duplicate titles
add_action('init', 'welmacart_v2_remove_wc_dashboard_content');
function welmacart_v2_remove_wc_dashboard_content() {
    remove_action('woocommerce_account_dashboard', 'woocommerce_account_dashboard', 10);
}

// Hide WooCommerce default messages on account pages
add_filter('woocommerce_my_account_my_orders_title', '__return_empty_string');
add_filter('woocommerce_my_account_my_address_title', '__return_empty_string');
add_filter('woocommerce_my_account_my_orders_actions', '__return_empty_array');

/**
 * Custom Image Sizes for Hero Banner (Optimized)
 */
add_action('after_setup_theme', 'welmacart_v2_add_image_sizes');
function welmacart_v2_add_image_sizes() {
    // Hero banner için optimize edilmiş boyutlar
    add_image_size('hero-banner', 1920, 1080, true); // Desktop
    add_image_size('hero-banner-mobile', 768, 768, true); // Mobile - kare format
    add_image_size('hero-banner-tablet', 1366, 768, true); // Tablet
    // Retina size kaldırıldı - memory sorunları için
}

// Admin'de custom image size'ları göster
add_filter('image_size_names_choose', 'welmacart_v2_custom_image_sizes');
function welmacart_v2_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'hero-banner' => 'Hero Banner (1920x1080)',
        'hero-banner-mobile' => 'Hero Banner Mobile (768x768)',
        'hero-banner-tablet' => 'Hero Banner Tablet (1366x768)',
    ));
}

/**
 * Image quality optimization with memory management
 */
add_filter('wp_editor_set_quality', 'welmacart_v2_image_quality', 10, 2);
function welmacart_v2_image_quality($quality, $mime_type) {
    if ($mime_type === 'image/jpeg') {
        return 85; // Dengeli kalite - memory friendly
    }
    return $quality;
}

/**
 * Increase memory limit for image processing
 */
add_filter('image_memory_limit', 'welmacart_v2_increase_image_memory');
function welmacart_v2_increase_image_memory($limit) {
    return '512M'; // Image processing için yeterli memory
}

/**
 * Error handling for image processing
 */
add_action('wp_handle_upload_prefilter', 'welmacart_v2_handle_upload_errors');
function welmacart_v2_handle_upload_errors($file) {
    // Dosya boyutu kontrolü
    $max_size = 15 * 1024 * 1024; // 15MB limit (daha düşük)
    if ($file['size'] > $max_size) {
        $file['error'] = 'Dosya çok büyük. Maksimum 15MB yükleyebilirsiniz.';
        return $file;
    }
    
    // Image boyutları kontrolü
    if (strpos($file['type'], 'image/') === 0) {
        $image_info = getimagesize($file['tmp_name']);
        if ($image_info && ($image_info[0] > 2560 || $image_info[1] > 2560)) {
            $file['error'] = 'Resim boyutları çok büyük. Maksimum 2560x2560 pixel olmalıdır.';
        }
    }
    
    return $file;
}

/**
 * Conditional image size generation
 */
add_filter('intermediate_image_sizes_advanced', 'welmacart_v2_conditional_image_sizes', 10, 2);
function welmacart_v2_conditional_image_sizes($sizes, $image_meta) {
    // Eğer orijinal resim çok küçükse mobile size oluşturma
    if (isset($image_meta['width']) && $image_meta['width'] < 768) {
        unset($sizes['hero-banner-mobile']);
    }
    
    // Eğer orijinal resim çok küçükse tablet size oluşturma
    if (isset($image_meta['width']) && $image_meta['width'] < 1366) {
        unset($sizes['hero-banner-tablet']);
    }
    
    return $sizes;
}

/**
 * WebP format support (conditional)
 */
add_filter('wp_image_mime_transforms', 'welmacart_v2_webp_support');
function welmacart_v2_webp_support($transforms) {
    // Sadece WebP desteği varsa aktif et
    if (function_exists('imagewebp')) {
        $transforms['image/jpeg'] = ['image/webp'];
        $transforms['image/png'] = ['image/webp'];
    }
    return $transforms;
}

/**
 * Regenerate hero image thumbnails on theme activation (safe version)
 */
add_action('after_switch_theme', 'welmacart_v2_regenerate_hero_images');
function welmacart_v2_regenerate_hero_images() {
    // Sadece küçük resimleri güncelle - memory-safe
    $attachments = get_posts([
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'numberposts' => 10, // Sadece 10 resim
        'orderby' => 'date',
        'order' => 'DESC'
    ]);
    
    foreach ($attachments as $attachment) {
        $file_path = get_attached_file($attachment->ID);
        if ($file_path && file_exists($file_path)) {
            // Dosya boyutu kontrolü
            $file_size = filesize($file_path);
            if ($file_size < 5 * 1024 * 1024) { // 5MB'dan küçükse işle
                wp_update_attachment_metadata($attachment->ID, wp_generate_attachment_metadata($attachment->ID, $file_path));
            }
        }
    }
}
