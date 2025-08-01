<?php
/**
 * Custom Meta Boxes (ACF Fallback)
 * Hero Banner için custom meta box'lar
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ACF yoksa custom meta box ekle
 */
function welmacart_add_hero_meta_boxes() {
    // ACF varsa bu meta box'ları ekleme
    if (function_exists('acf_add_local_field_group')) {
        return;
    }

    add_meta_box(
        'hero_banner_fields',
        'Hero Banner Ayarları',
        'welmacart_hero_banner_meta_box_callback',
        'hero_banner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'welmacart_add_hero_meta_boxes');

/**
 * Meta box için admin notice ekle
 */
function welmacart_meta_box_notice() {
    global $post;
    if (isset($post) && $post->post_type === 'hero_banner' && !function_exists('acf_add_local_field_group')) {
        echo '<div class="notice notice-info"><p><strong>Bilgi:</strong> ACF eklentisi yüklü değil. Basit meta box arayüzü kullanılıyor. Daha gelişmiş özellikler için ACF eklentisini yükleyebilirsiniz.</p></div>';
    }
}
add_action('admin_notices', 'welmacart_meta_box_notice');

/**
 * Meta box callback function
 */
function welmacart_hero_banner_meta_box_callback($post) {
    // Nonce field ekle
    wp_nonce_field('welmacart_hero_banner_meta_box', 'welmacart_hero_banner_nonce');

    // Mevcut değerleri al
    $hero_image = get_post_meta($post->ID, 'hero_image', true);
    $hero_title = get_post_meta($post->ID, 'hero_title', true);
    $hero_subtitle = get_post_meta($post->ID, 'hero_subtitle', true);
    $hero_button_text = get_post_meta($post->ID, 'hero_button_text', true);
    $hero_button_link = get_post_meta($post->ID, 'hero_button_link', true);
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="hero_image">Banner Görseli</label>
            </th>
            <td>
                <input type="hidden" id="hero_image" name="hero_image" value="<?php echo esc_attr($hero_image); ?>" />
                <div id="hero_image_preview">
                    <?php if ($hero_image): ?>
                        <?php echo wp_get_attachment_image($hero_image, 'medium'); ?>
                    <?php endif; ?>
                </div>
                <p>
                    <button type="button" class="button" id="upload_hero_image">Görsel Seç</button>
                    <button type="button" class="button" id="remove_hero_image" <?php echo !$hero_image ? 'style="display:none;"' : ''; ?>>Görseli Kaldır</button>
                </p>
                <p class="description">Önerilen boyut: 1920x1080px</p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_title">Ana Başlık *</label>
            </th>
            <td>
                <input type="text" id="hero_title" name="hero_title" value="<?php echo esc_attr($hero_title); ?>" class="regular-text" required />
                <p class="description">Banner'da gösterilecek ana başlık</p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_subtitle">Alt Başlık</label>
            </th>
            <td>
                <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" class="regular-text" />
                <p class="description">Banner'da gösterilecek açıklama metni</p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_button_text">Buton Metni</label>
            </th>
            <td>
                <input type="text" id="hero_button_text" name="hero_button_text" value="<?php echo esc_attr($hero_button_text); ?>" class="regular-text" />
                <p class="description">CTA butonunun metni</p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_button_link">Buton Linki</label>
            </th>
            <td>
                <input type="url" id="hero_button_link" name="hero_button_link" value="<?php echo esc_attr($hero_button_link); ?>" class="regular-text" />
                <p class="description">CTA butonunun yönlendireceği link</p>
            </td>
        </tr>
    </table>

    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;

        $('#upload_hero_image').click(function(e) {
            e.preventDefault();
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Banner Görseli Seç',
                button: { text: 'Seç' },
                multiple: false
            });
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#hero_image').val(attachment.id);
                $('#hero_image_preview').html('<img src="' + attachment.sizes.medium.url + '" style="max-width: 300px;" />');
                $('#remove_hero_image').show();
            });
            mediaUploader.open();
        });

        $('#remove_hero_image').click(function(e) {
            e.preventDefault();
            $('#hero_image').val('');
            $('#hero_image_preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

/**
 * Save meta box data
 */
function welmacart_save_hero_banner_meta_box_data($post_id) {
    // ACF varsa bu fonksiyonu çalıştırma
    if (function_exists('acf_add_local_field_group')) {
        return;
    }

    // Nonce kontrolü
    if (!isset($_POST['welmacart_hero_banner_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['welmacart_hero_banner_nonce'], 'welmacart_hero_banner_meta_box')) {
        return;
    }

    // Autosave kontrolü
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Yetki kontrolü
    if (isset($_POST['post_type']) && 'hero_banner' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Verileri kaydet
    $fields = array('hero_image', 'hero_title', 'hero_subtitle', 'hero_button_text', 'hero_button_link');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'welmacart_save_hero_banner_meta_box_data');

/**
 * Enqueue media uploader
 */
function welmacart_enqueue_admin_scripts($hook) {
    global $post;

    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if (isset($post) && 'hero_banner' === $post->post_type) {
            wp_enqueue_media();
        }
    }
}
add_action('admin_enqueue_scripts', 'welmacart_enqueue_admin_scripts');
