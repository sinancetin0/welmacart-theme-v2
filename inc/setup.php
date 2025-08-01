<?php
/**
 * Tema setup fonksiyonları
 */

if (!function_exists('welmacart_v2_setup')):
    function welmacart_v2_setup() {
        // Theme support özelliklerini ekle
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo', [
            'height' => 60,
            'width' => 200,
            'flex-height' => true,
            'flex-width' => true,
        ]);
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        
        // Menüleri kaydet
        register_nav_menus([
            'primary' => esc_html__('Ana Menü', 'welmacart-v2'),
            'footer' => esc_html__('Footer Menü', 'welmacart-v2'),
        ]);
        
        // İçerik genişliği
        if (!isset($content_width)) {
            $content_width = 1280;
        }
    }
endif;
add_action('after_setup_theme', 'welmacart_v2_setup');
