<?php
/**
 * WelmaCart v2 functions and definitions - Safe Version
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function welmacart_v2_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'welmacart_v2_setup');

/**
 * Enqueue scripts and styles
 */
function welmacart_v2_scripts() {
    // Main stylesheet
    wp_enqueue_style('welmacart-v2-style', get_stylesheet_uri(), array(), '2.0.0');
    
    // Base CSS
    wp_enqueue_style('welmacart-v2-base', get_template_directory_uri() . '/assets/css/base.css', array(), '2.0.0');
    wp_enqueue_style('welmacart-v2-header', get_template_directory_uri() . '/assets/css/header.css', array(), '2.0.0');
    wp_enqueue_style('welmacart-v2-footer', get_template_directory_uri() . '/assets/css/footer.css', array(), '2.0.0');
    
    // Page specific CSS
    if (is_front_page()) {
        wp_enqueue_style('welmacart-v2-front-page', get_template_directory_uri() . '/assets/css/front-page.css', array(), '2.0.0');
        wp_enqueue_style('welmacart-v2-hero', get_template_directory_uri() . '/assets/css/hero.css', array(), '2.0.0');
    }
    
    if (is_shop() || is_product_category() || is_product_tag()) {
        wp_enqueue_style('welmacart-v2-shop', get_template_directory_uri() . '/assets/css/shop.css', array(), '2.0.0');
    }
    
    if (is_product()) {
        wp_enqueue_style('welmacart-v2-single-product', get_template_directory_uri() . '/assets/css/single-product.css', array(), '2.0.0');
    }
    
    if (is_account_page()) {
        wp_enqueue_style('welmacart-v2-account', get_template_directory_uri() . '/assets/css/account.css', array(), '2.0.0');
    }
    
    // JavaScript
    wp_enqueue_script('welmacart-v2-header', get_template_directory_uri() . '/assets/js/header.js', array('jquery'), '2.0.0', true);
    
    if (is_front_page()) {
        wp_enqueue_script('welmacart-v2-hero', get_template_directory_uri() . '/assets/js/hero-slider.js', array('jquery'), '2.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'welmacart_v2_scripts');

/**
 * Custom Image Sizes (Safe version)
 */
function welmacart_v2_add_image_sizes() {
    // Hero banner için optimize edilmiş boyutlar
    add_image_size('hero-banner', 1920, 1080, true);
    add_image_size('hero-banner-mobile', 768, 768, true);
    add_image_size('hero-banner-tablet', 1366, 768, true);
}
add_action('after_setup_theme', 'welmacart_v2_add_image_sizes');

/**
 * Image quality optimization
 */
function welmacart_v2_image_quality($quality, $mime_type) {
    if ($mime_type === 'image/jpeg') {
        return 85;
    }
    return $quality;
}
add_filter('wp_editor_set_quality', 'welmacart_v2_image_quality', 10, 2);

/**
 * Memory limit for image processing
 */
function welmacart_v2_increase_image_memory($limit) {
    return '512M';
}
add_filter('image_memory_limit', 'welmacart_v2_increase_image_memory');

/**
 * WooCommerce customizations
 */
if (class_exists('WooCommerce')) {
    // Remove default WooCommerce styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Custom WooCommerce hooks
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    
    add_action('woocommerce_before_main_content', 'welmacart_v2_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'welmacart_v2_wrapper_end', 10);
}

function welmacart_v2_wrapper_start() {
    echo '<main id="main" class="site-main">';
}

function welmacart_v2_wrapper_end() {
    echo '</main>';
}

/**
 * Navigation menus
 */
function welmacart_v2_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'welmacart-v2'),
        'footer' => __('Footer Navigation', 'welmacart-v2'),
    ));
}
add_action('init', 'welmacart_v2_menus');

/**
 * Include additional files only if they exist
 */
$includes = array(
    'inc/setup.php',
    'inc/enqueue.php',
    'inc/woocommerce.php',
    'inc/helpers.php'
);

foreach ($includes as $include) {
    $file_path = get_template_directory() . '/' . $include;
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}

/**
 * Error handling for missing ACF
 */
if (!function_exists('get_field')) {
    function get_field($field_name, $post_id = null) {
        return get_post_meta($post_id ?: get_the_ID(), $field_name, true);
    }
}

/**
 * Safe template loading
 */
function welmacart_v2_get_template_part($slug, $name = null) {
    $template = $slug;
    if ($name) {
        $template .= '-' . $name;
    }
    $template .= '.php';
    
    $located = locate_template($template);
    if ($located) {
        load_template($located, false);
    }
}

/**
 * Theme activation hook
 */
function welmacart_v2_activation() {
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Set default options
    update_option('welmacart_v2_activated', true);
}
register_activation_hook(__FILE__, 'welmacart_v2_activation');
