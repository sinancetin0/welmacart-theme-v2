<?php
/**
 * Template debug ve cache temizleme
 * Bu dosyayı geçici olarak functions.php'ye include edebilirsiniz
 */

// Template cache'ini temizle
add_action('admin_init', function() {
    if (isset($_GET['clear_template_cache'])) {
        wp_cache_delete('page_templates-' . get_option('stylesheet'), 'themes');
        delete_transient('theme_page_templates');
        
        // Template dosyalarını tekrar kontrol et
        $templates = wp_get_theme()->get_page_templates();
        
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p>Template cache temizlendi! Mevcut template\'ler: ' . implode(', ', array_keys($templates)) . '</p>';
        echo '</div>';
    }
});

// Admin bar'a cache temizleme linki ekle
add_action('admin_bar_menu', function($wp_admin_bar) {
    if (current_user_can('manage_options')) {
        $wp_admin_bar->add_node([
            'id' => 'clear_template_cache',
            'title' => 'Template Cache Temizle',
            'href' => admin_url('?clear_template_cache=1'),
        ]);
    }
}, 100);

// Template debug bilgisi
add_action('wp_footer', function() {
    if (current_user_can('manage_options') && isset($_GET['template_debug'])) {
        $templates = wp_get_theme()->get_page_templates();
        echo '<div style="background: black; color: white; padding: 20px; position: fixed; bottom: 0; left: 0; z-index: 9999; max-width: 500px;">';
        echo '<h4>Template Debug</h4>';
        echo '<p><strong>Aktif Template:</strong> ' . get_page_template_slug() . '</p>';
        echo '<p><strong>Mevcut Template\'ler:</strong></p>';
        echo '<ul>';
        foreach ($templates as $file => $name) {
            echo '<li>' . $file . ' → ' . $name . '</li>';
        }
        echo '</ul>';
        echo '<p><a href="?" style="color: yellow;">Debug\'ı Kapat</a></p>';
        echo '</div>';
    }
});
?>
