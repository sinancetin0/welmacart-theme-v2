<?php
/**
 * ACF alan grupları
 */

// ACF kontrolü ve field group kayıt fonksiyonu
if (!function_exists('welmacart_v2_register_acf_fields')) {
    function welmacart_v2_register_acf_fields() {
        // ACF aktif değilse çık
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

    // Hero Banner Alanları
    acf_add_local_field_group([
        'key' => 'group_hero_banner_fields',
        'title' => 'Hero Banner Ayarları',
        'fields' => [
            [
                'key' => 'field_hero_banner_image',
                'label' => 'Banner Görseli',
                'name' => 'hero_image',
                'type' => 'image',
                'required' => 1,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'mime_types' => 'jpg,jpeg,png,webp',
            ],
            [
                'key' => 'field_hero_banner_title',
                'label' => 'Ana Başlık',
                'name' => 'hero_title',
                'type' => 'text',
                'required' => 1,
                'placeholder' => 'Örn: Welma Eşarp Koleksiyonu',
            ],
            [
                'key' => 'field_hero_banner_subtitle',
                'label' => 'Alt Başlık',
                'name' => 'hero_subtitle',
                'type' => 'textarea',
                'rows' => 2,
                'placeholder' => 'Örn: Zarafet ve şıklığın buluştuğu yer',
            ],
            [
                'key' => 'field_hero_banner_button_text',
                'label' => 'Buton Metni',
                'name' => 'hero_button_text',
                'type' => 'text',
                'placeholder' => 'Örn: Koleksiyonu Keşfet',
            ],
            [
                'key' => 'field_hero_banner_button_link',
                'label' => 'Buton Linki',
                'name' => 'hero_button_link',
                'type' => 'url',
                'placeholder' => 'https://',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'hero_banner',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ]);

    // Duyuru Alanları
    acf_add_local_field_group([
        'key' => 'group_anons_fields',
        'title' => 'Duyuru Ayarları',
        'fields' => [
            [
                'key' => 'field_anons_content',
                'label' => 'Duyuru İçeriği',
                'name' => 'anons_icerik',
                'type' => 'text',
                'required' => 1,
            ],
            [
                'key' => 'field_anons_url',
                'label' => 'Duyuru Linki',
                'name' => 'anons_link',
                'type' => 'url',
            ],
            [
                'key' => 'field_anons_link_text',
                'label' => 'Link Metni',
                'name' => 'anons_link_text',
                'type' => 'text',
                'default_value' => 'Detaylar',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'anons',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ]);
}
}

// ACF aktif olduğunda field'ları kaydet
if (function_exists('acf_add_local_field_group')) {
    add_action('acf/init', 'welmacart_v2_register_acf_fields');
    add_action('init', 'welmacart_v2_register_acf_fields', 15);
} else {
    // ACF aktif değilse uyarı göster
    add_action('admin_notices', function() {
        if (current_user_can('manage_options')) {
            $install_url = admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term');
            echo '<div class="notice notice-error is-dismissible">';
            echo '<p><strong>ACF (Advanced Custom Fields) eklentisi bulunamadı!</strong></p>';
            echo '<p>Hero Banner için özel alanları kullanabilmek için ACF eklentisini yükleyip aktifleştirin.</p>';
            echo '<p><a href="' . esc_url($install_url) . '" class="button button-primary">ACF Eklentisini Yükle</a></p>';
            echo '</div>';
        }
    });
    
    // Dashboard'da widget göster
    add_action('wp_dashboard_setup', function() {
        wp_add_dashboard_widget(
            'welmacart_acf_notice',
            'WelmaCart Tema Bildirimi',
            function() {
                echo '<p>Hero Banner özelliklerini tam olarak kullanabilmek için <strong>Advanced Custom Fields (ACF)</strong> eklentisini yüklemeniz önerilir.</p>';
                echo '<p>ACF olmadan da temel meta box arayüzü kullanılabilir.</p>';
                $install_url = admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term');
                echo '<p><a href="' . esc_url($install_url) . '" class="button button-primary">ACF Eklentisini Yükle</a></p>';
            }
        );
    });
}
