<?php
/**
 * Özel post tipleri ve taksonomiler
 */

if (!function_exists('welmacart_v2_register_post_types')) {
    function welmacart_v2_register_post_types() {
        // Duyurular post tipi
        register_post_type('anons', [
            'labels' => [
                'name' => __('Duyurular', 'welmacart-v2'),
                'singular_name' => __('Duyuru', 'welmacart-v2'),
                'add_new' => __('Yeni Ekle', 'welmacart-v2'),
                'add_new_item' => __('Yeni Duyuru Ekle', 'welmacart-v2'),
                'edit_item' => __('Duyuruyu Düzenle', 'welmacart-v2'),
                'new_item' => __('Yeni Duyuru', 'welmacart-v2'),
                'view_item' => __('Duyuruyu Görüntüle', 'welmacart-v2'),
                'search_items' => __('Duyuru Ara', 'welmacart-v2'),
                'not_found' => __('Duyuru bulunamadı', 'welmacart-v2'),
                'not_found_in_trash' => __('Çöp kutusunda duyuru bulunamadı', 'welmacart-v2'),
            ],
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-megaphone',
            'hierarchical' => false,
            'supports' => ['title'],
            'has_archive' => false,
            'rewrite' => false,
            'can_export' => true,
        ]);

        // Hero Banner post tipi
        register_post_type('hero_banner', [
            'labels' => [
                'name' => __('Hero Bannerlar', 'welmacart-v2'),
                'singular_name' => __('Hero Banner', 'welmacart-v2'),
                'add_new' => __('Yeni Ekle', 'welmacart-v2'),
                'add_new_item' => __('Yeni Banner Ekle', 'welmacart-v2'),
                'edit_item' => __('Banner Düzenle', 'welmacart-v2'),
                'new_item' => __('Yeni Banner', 'welmacart-v2'),
                'view_item' => __('Banner Görüntüle', 'welmacart-v2'),
                'search_items' => __('Banner Ara', 'welmacart-v2'),
                'not_found' => __('Banner bulunamadı', 'welmacart-v2'),
                'not_found_in_trash' => __('Çöp kutusunda banner bulunamadı', 'welmacart-v2'),
            ],
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-format-image',
            'hierarchical' => false,
            'supports' => ['title'],
            'has_archive' => false,
            'rewrite' => false,
            'can_export' => true,
        ]);
    }
}
add_action('init', 'welmacart_v2_register_post_types');
