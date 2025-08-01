<?php
/**
 * Stil ve script dosyalarının yüklenmesi
 */

function welmacart_v2_enqueue_scripts() {
    // JavaScript dosyaları
    wp_enqueue_script('feather-icons', 'https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js', [], '4.29.0', true);
    wp_enqueue_script('lucide', 'https://unpkg.com/lucide@latest/dist/umd/lucide.js', [], 'latest', true);
    wp_enqueue_script('welmacart-v2-header', get_template_directory_uri() . '/assets/js/header.js', ['feather-icons'], welmacart_v2_asset_version('/assets/js/header.js'), true);
    wp_enqueue_script('welmacart-v2-hero', get_template_directory_uri() . '/assets/js/hero-slider.js', ['feather-icons'], welmacart_v2_asset_version('/assets/js/hero-slider.js'), true);
    wp_enqueue_script('welmacart-v2-horizontal-scroll', get_template_directory_uri() . '/assets/js/horizontal-scroll.js', [], welmacart_v2_asset_version('/assets/js/horizontal-scroll.js'), true);
    wp_enqueue_script('welmacart-v2-footer', get_template_directory_uri() . '/assets/js/footer.js', [], welmacart_v2_asset_version('/assets/js/footer.js'), true);
    
    // Ana sayfa için typewriter animasyonu
    if (is_front_page()) {
        wp_enqueue_script('welmacart-v2-typewriter', get_template_directory_uri() . '/assets/js/typewriter.js', ['feather-icons'], welmacart_v2_asset_version('/assets/js/typewriter.js'), true);
    }
    
    // Single product page için özel script
    if (is_product()) {
        wp_enqueue_script('welmacart-v2-single-product', get_template_directory_uri() . '/assets/js/single-product.js', ['feather-icons'], welmacart_v2_asset_version('/assets/js/single-product.js'), true);
    }
    
    // Shop page için özel script ve style
    if (is_shop() || is_product_category() || is_product_tag()) {
        wp_enqueue_script('welmacart-v2-shop', get_template_directory_uri() . '/assets/js/shop.js', [], welmacart_v2_asset_version('/assets/js/shop.js'), true);
        wp_enqueue_style('welmacart-v2-shop', get_template_directory_uri() . '/assets/css/shop.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/shop.css'));
    }
    
    // My Account page için özel style
    if (is_account_page()) {
        wp_enqueue_style('welmacart-v2-account', get_template_directory_uri() . '/assets/css/account.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/account.css'));
    }
    
    // Page templates için script
    if (is_page()) {
        wp_enqueue_script('welmacart-v2-pages', get_template_directory_uri() . '/assets/js/pages.js', [], welmacart_v2_asset_version('/assets/js/pages.js'), true);
        wp_enqueue_style('welmacart-v2-pages', get_template_directory_uri() . '/assets/css/pages.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/pages.css'));
    }
    
    // CSS dosyaları - Sıralama önemli
    wp_enqueue_style('welmacart-v2-base', get_template_directory_uri() . '/assets/css/base.css', [], welmacart_v2_asset_version('/assets/css/base.css'));
    
    // Header CSS - WooCommerce ve diğer plugin'ları ezebilmesi için higher priority
    wp_enqueue_style('welmacart-v2-header', get_template_directory_uri() . '/assets/css/header.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/header.css'), 'all');
    
    wp_enqueue_style('welmacart-v2-announcement', get_template_directory_uri() . '/assets/css/announcement.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/announcement.css'));
    wp_enqueue_style('welmacart-v2-hero', get_template_directory_uri() . '/assets/css/hero.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/hero.css'));
    wp_enqueue_style('welmacart-v2-front-page', get_template_directory_uri() . '/assets/css/front-page.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/front-page.css'));
    wp_enqueue_style('welmacart-v2-single-product', get_template_directory_uri() . '/assets/css/single-product.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/single-product.css'));
    wp_enqueue_style('welmacart-v2-footer', get_template_directory_uri() . '/assets/css/footer.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/footer.css'));
    
    // WooCommerce'den sonra yüklenmesi için content.css'i en sona koyuyoruz
    wp_enqueue_style('welmacart-v2-content', get_template_directory_uri() . '/assets/css/content.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/content.css'), 'all');
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('welmacart-v2-content', get_template_directory_uri() . '/assets/css/content.css', ['welmacart-v2-base', 'woocommerce-general'], welmacart_v2_asset_version('/assets/css/content.css'), 'all');
    }
    
    // Pages CSS (About, Contact, Style Guide)
    if (is_page(['about', 'hakkimizda', 'contact', 'iletisim', 'style-guide', 'stil-rehberi']) || is_page_template(['page-about.php', 'page-contact.php', 'page-style-guide.php'])) {
        wp_enqueue_style('welmacart-v2-pages', get_template_directory_uri() . '/assets/css/pages.css', ['welmacart-v2-base'], welmacart_v2_asset_version('/assets/css/pages.css'));
    }
    
    // Tema ana CSS
    wp_enqueue_style('welmacart-v2-style', get_stylesheet_uri(), ['welmacart-v2-base'], '1.0');
    
    // Feather Icons init
    wp_add_inline_script('feather-icons', '
        window.addEventListener("load", function() {
            if (typeof feather !== "undefined") {
                feather.replace();
                console.log("Feather icons initialized");
            }
        });
    ');
    
    // Lucide Icons init
    wp_add_inline_script('lucide', '
        window.addEventListener("load", function() {
            if (typeof lucide !== "undefined") {
                lucide.createIcons();
                console.log("Lucide icons initialized");
            }
        });
    ');
    
    // Pages JavaScript (About, Contact, Style Guide)
    if (is_page(['about', 'hakkimizda', 'contact', 'iletisim', 'style-guide', 'stil-rehberi']) || is_page_template(['page-about.php', 'page-contact.php', 'page-style-guide.php'])) {
        wp_enqueue_script('welmacart-v2-pages', get_template_directory_uri() . '/assets/js/pages.js', ['lucide'], welmacart_v2_asset_version('/assets/js/pages.js'), true);
    }
    
    // AJAX nonce for header script
    wp_localize_script('welmacart-v2-header', 'welmacartAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('welmacart_ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'welmacart_v2_enqueue_scripts');
