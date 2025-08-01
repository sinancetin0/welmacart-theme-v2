<?php
/**
 * Custom Post Types
 * 
 * @package WelmaCart
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register custom post types
 */
function welmacart_register_post_types() {
    // Announcement (Anons) Post Type
    register_post_type('anons', array(
        'labels' => array(
            'name'               => __('Duyurular', 'welmacart'),
            'singular_name'      => __('Duyuru', 'welmacart'),
            'menu_name'          => __('Duyurular', 'welmacart'),
            'add_new'            => __('Yeni Ekle', 'welmacart'),
            'add_new_item'       => __('Yeni Duyuru Ekle', 'welmacart'),
            'edit_item'          => __('Duyuru Düzenle', 'welmacart'),
            'new_item'           => __('Yeni Duyuru', 'welmacart'),
            'view_item'          => __('Duyuru Görüntüle', 'welmacart'),
            'search_items'       => __('Duyuru Ara', 'welmacart'),
            'not_found'          => __('Duyuru bulunamadı', 'welmacart'),
            'not_found_in_trash' => __('Çöp kutusunda Duyuru bulunamadı', 'welmacart'),
        ),
        'public'              => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-megaphone',
        'menu_position'      => 26,
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'supports'           => array('title', 'page-attributes'),
        'has_archive'        => false,
        'rewrite'           => false,
        'show_in_rest'      => true,
    ));

    // Hero Banner Post Type
    register_post_type('hero_banner', array(
        'labels' => array(
            'name'               => __('Hero Bannerlar', 'welmacart'),
            'singular_name'      => __('Hero Banner', 'welmacart'),
            'menu_name'          => __('Hero Bannerlar', 'welmacart'),
            'add_new'            => __('Yeni Ekle', 'welmacart'),
            'add_new_item'       => __('Yeni Hero Banner Ekle', 'welmacart'),
            'edit_item'          => __('Hero Banner Düzenle', 'welmacart'),
            'new_item'           => __('Yeni Hero Banner', 'welmacart'),
            'view_item'          => __('Hero Banner Görüntüle', 'welmacart'),
            'search_items'       => __('Hero Banner Ara', 'welmacart'),
            'not_found'          => __('Hero Banner bulunamadı', 'welmacart'),
            'not_found_in_trash' => __('Çöp kutusunda Hero Banner bulunamadı', 'welmacart'),
        ),
        'public'              => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-images-alt2',
        'menu_position'      => 25,
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'supports'           => array('title', 'page-attributes'),
        'has_archive'        => false,
        'rewrite'           => false,
        'show_in_rest'      => true,
    ));
}
add_action('init', 'welmacart_register_post_types');

/**
 * Flush rewrite rules on theme activation
 */
function welmacart_flush_rewrites() {
    welmacart_register_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'welmacart_flush_rewrites');

/**
 * Debug: Check if hero_banner post type is registered
 */
function welmacart_debug_post_types() {
    if (current_user_can('manage_options') && isset($_GET['debug_cpt'])) {
        $post_types = get_post_types(array('public' => true), 'objects');
        echo '<div style="background: #fff; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
        echo '<h3>Registered Post Types:</h3>';
        foreach ($post_types as $post_type) {
            echo '<p>' . $post_type->name . ' - ' . $post_type->label . '</p>';
        }
        echo '</div>';
    }
}
add_action('wp_footer', 'welmacart_debug_post_types');

/**
 * Add custom columns to hero_banner admin list
 */
function welmacart_hero_banner_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['hero_image'] = 'Görsel';
    $new_columns['hero_title'] = 'Ana Başlık';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_hero_banner_posts_columns', 'welmacart_hero_banner_columns');

/**
 * Show custom column content
 */
function welmacart_hero_banner_custom_column($column, $post_id) {
    switch ($column) {
        case 'hero_image':
            if (function_exists('get_field')) {
                $image = get_field('hero_image', $post_id);
                if ($image) {
                    echo '<img src="' . esc_url($image['sizes']['thumbnail']) . '" style="width: 50px; height: 50px; object-fit: cover;" />';
                }
            } else {
                $image_id = get_post_meta($post_id, 'hero_image', true);
                if ($image_id) {
                    echo wp_get_attachment_image($image_id, 'thumbnail', false, array('style' => 'width: 50px; height: 50px; object-fit: cover;'));
                }
            }
            break;
        case 'hero_title':
            if (function_exists('get_field')) {
                $title = get_field('hero_title', $post_id);
            } else {
                $title = get_post_meta($post_id, 'hero_title', true);
            }
            echo esc_html($title ?: '-');
            break;
    }
}
add_action('manage_hero_banner_posts_custom_column', 'welmacart_hero_banner_custom_column', 10, 2);
