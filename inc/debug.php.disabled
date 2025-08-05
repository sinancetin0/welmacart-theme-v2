<?php
/**
 * Debug ve kontrol fonksiyonları
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ACF durumunu kontrol et
 */
function welmacart_check_acf_status() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_GET['welmacart_debug'])) {
        add_action('wp_loaded', function() {
            echo '<div style="background: #fff; padding: 20px; margin: 20px; border: 1px solid #ddd; position: fixed; top: 32px; right: 20px; z-index: 9999; width: 400px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">';
            
            echo '<h3>WelmaCart Debug Bilgileri</h3>';
            
            // ACF kontrolü
            echo '<h4>ACF Durumu:</h4>';
            if (function_exists('acf_add_local_field_group')) {
                echo '<p style="color: green;">✅ ACF aktif</p>';
                
                // Field gruplarını kontrol et
                if (function_exists('acf_get_field_groups')) {
                    $groups = acf_get_field_groups();
                    echo '<p>Kayıtlı field grupları: ' . count($groups) . '</p>';
                    
                    foreach ($groups as $group) {
                        if (strpos($group['key'], 'hero') !== false) {
                            echo '<p style="color: green;">✅ Hero Banner field grubu: ' . $group['title'] . '</p>';
                        }
                    }
                }
            } else {
                echo '<p style="color: red;">❌ ACF aktif değil</p>';
                echo '<p>Meta box sistemi kullanılıyor</p>';
            }
            
            // Post type kontrolü
            echo '<h4>Post Type Durumu:</h4>';
            if (post_type_exists('hero_banner')) {
                echo '<p style="color: green;">✅ hero_banner post type kayıtlı</p>';
            } else {
                echo '<p style="color: red;">❌ hero_banner post type bulunamadı</p>';
            }
            
            echo '<p><a href="' . remove_query_arg('welmacart_debug') . '" style="text-decoration: none; background: #0073aa; color: white; padding: 5px 10px; border-radius: 3px;">Kapat</a></p>';
            echo '</div>';
        });
    }
}
add_action('init', 'welmacart_check_acf_status');

/**
 * Admin bar'a debug linki ekle
 */
function welmacart_admin_bar_debug($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }

    $wp_admin_bar->add_node(array(
        'id'    => 'welmacart-debug',
        'title' => 'WelmaCart Debug',
        'href'  => add_query_arg('welmacart_debug', '1'),
    ));
}
add_action('admin_bar_menu', 'welmacart_admin_bar_debug', 999);
