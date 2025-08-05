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

/**
 * Custom Post Types
 */
function welmacart_v2_register_post_types() {
    // Hero Banners CPT
    register_post_type('hero_banner', array(
        'labels' => array(
            'name' => 'Hero Banners',
            'singular_name' => 'Hero Banner',
            'menu_name' => 'Hero Banners',
            'add_new' => 'Add New Banner',
            'add_new_item' => 'Add New Hero Banner',
            'edit_item' => 'Edit Hero Banner',
            'new_item' => 'New Hero Banner',
            'view_item' => 'View Hero Banner',
            'search_items' => 'Search Hero Banners',
            'not_found' => 'No hero banners found',
            'not_found_in_trash' => 'No hero banners found in trash'
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-format-image',
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => false,
        'rewrite' => false
    ));

    // Collections CPT
    register_post_type('collection', array(
        'labels' => array(
            'name' => 'Collections',
            'singular_name' => 'Collection',
            'menu_name' => 'Collections',
            'add_new' => 'Add New Collection',
            'add_new_item' => 'Add New Collection',
            'edit_item' => 'Edit Collection',
            'new_item' => 'New Collection',
            'view_item' => 'View Collection',
            'search_items' => 'Search Collections',
            'not_found' => 'No collections found',
            'not_found_in_trash' => 'No collections found in trash'
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'collections'),
        'show_in_rest' => true
    ));
}
add_action('init', 'welmacart_v2_register_post_types');

/**
 * ACF Fields for Hero Banners (Fallback)
 */
function welmacart_v2_hero_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_hero_banner',
            'title' => 'Hero Banner Fields',
            'fields' => array(
                array(
                    'key' => 'field_hero_image',
                    'label' => 'Hero Image',
                    'name' => 'hero_image',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium'
                ),
                array(
                    'key' => 'field_hero_title',
                    'label' => 'Hero Title',
                    'name' => 'hero_title',
                    'type' => 'text'
                ),
                array(
                    'key' => 'field_hero_subtitle',
                    'label' => 'Hero Subtitle',
                    'name' => 'hero_subtitle',
                    'type' => 'textarea'
                ),
                array(
                    'key' => 'field_hero_button_text',
                    'label' => 'Button Text',
                    'name' => 'hero_button_text',
                    'type' => 'text'
                ),
                array(
                    'key' => 'field_hero_button_link',
                    'label' => 'Button Link',
                    'name' => 'hero_button_link',
                    'type' => 'url'
                )
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'hero_banner'
                    )
                )
            )
        ));
    }
}
add_action('acf/init', 'welmacart_v2_hero_fields');

/**
 * Meta boxes for Hero Banners (ACF Alternative)
 */
function welmacart_v2_add_hero_meta_boxes() {
    add_meta_box(
        'hero_banner_fields',
        'Hero Banner Settings',
        'welmacart_v2_hero_meta_box_callback',
        'hero_banner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'welmacart_v2_add_hero_meta_boxes');

function welmacart_v2_hero_meta_box_callback($post) {
    wp_nonce_field('hero_banner_meta_box', 'hero_banner_meta_box_nonce');
    
    $hero_title = get_post_meta($post->ID, 'hero_title', true);
    $hero_subtitle = get_post_meta($post->ID, 'hero_subtitle', true);
    $hero_button_text = get_post_meta($post->ID, 'hero_button_text', true);
    $hero_button_link = get_post_meta($post->ID, 'hero_button_link', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="hero_title">Hero Title</label></th>';
    echo '<td><input type="text" id="hero_title" name="hero_title" value="' . esc_attr($hero_title) . '" style="width: 100%;" /></td></tr>';
    
    echo '<tr><th><label for="hero_subtitle">Hero Subtitle</label></th>';
    echo '<td><textarea id="hero_subtitle" name="hero_subtitle" rows="3" style="width: 100%;">' . esc_textarea($hero_subtitle) . '</textarea></td></tr>';
    
    echo '<tr><th><label for="hero_button_text">Button Text</label></th>';
    echo '<td><input type="text" id="hero_button_text" name="hero_button_text" value="' . esc_attr($hero_button_text) . '" style="width: 100%;" /></td></tr>';
    
    echo '<tr><th><label for="hero_button_link">Button Link</label></th>';
    echo '<td><input type="url" id="hero_button_link" name="hero_button_link" value="' . esc_attr($hero_button_link) . '" style="width: 100%;" /></td></tr>';
    echo '</table>';
}

function welmacart_v2_save_hero_meta_box($post_id) {
    if (!isset($_POST['hero_banner_meta_box_nonce'])) return;
    if (!wp_verify_nonce($_POST['hero_banner_meta_box_nonce'], 'hero_banner_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    $fields = array('hero_title', 'hero_subtitle', 'hero_button_text', 'hero_button_link');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'welmacart_v2_save_hero_meta_box');

/**
 * Get Hero Banners for front page
 */
function welmacart_v2_get_hero_banners() {
    $args = array(
        'post_type' => 'hero_banner',
        'posts_per_page' => 5,
        'post_status' => 'publish',
        'orderby' => 'menu_order date',
        'order' => 'ASC'
    );
    
    return get_posts($args);
}
