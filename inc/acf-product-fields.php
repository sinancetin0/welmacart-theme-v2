<?php
/**
 * ACF Product Features Fields
 * WelmaCart Theme - Product Custom Fields
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add ACF Product Features Fields
 */
function welmacart_add_product_features_fields() {
    
    // Check if ACF function exists
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_product_features',
        'title' => 'Product Features',
        'fields' => array(
            array(
                'key' => 'field_material_type',
                'label' => 'Malzeme Türü',
                'name' => 'material_type',
                'type' => 'text',
                'instructions' => 'Ürünün ana malzeme türünü belirtin (örn: İpek, Pamuk, Kaşmir)',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'örn: %100 İpek',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_material_composition',
                'label' => 'Malzeme Bileşimi',
                'name' => 'material_composition',
                'type' => 'textarea',
                'instructions' => 'Malzeme bileşimi detaylarını yazın',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'örn: %80 İpek, %20 Kaşmir karışımı',
                'maxlength' => '',
                'rows' => 3,
                'new_lines' => 'br',
            ),
            array(
                'key' => 'field_dimensions',
                'label' => 'Boyutlar',
                'name' => 'dimensions',
                'type' => 'text',
                'instructions' => 'Ürün boyutlarını belirtin',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'örn: 180cm x 70cm',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_care_instructions',
                'label' => 'Bakım Talimatları',
                'name' => 'care_instructions',
                'type' => 'textarea',
                'instructions' => 'Ürün bakım talimatlarını yazın',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'örn: Kuru temizleme önerilir, ılık suyla elde yıkanabilir',
                'maxlength' => '',
                'rows' => 4,
                'new_lines' => 'br',
            ),
            array(
                'key' => 'field_styling_suggestions',
                'label' => 'Stil Önerileri',
                'name' => 'styling_suggestions',
                'type' => 'textarea',
                'instructions' => 'Bu ürün için stil önerilerini yazın',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'örn: Blazer ile ofiste, trençkot ile günlük kullanım için idealdir',
                'maxlength' => '',
                'rows' => 4,
                'new_lines' => 'br',
            ),
            array(
                'key' => 'field_seasonal_collection',
                'label' => 'Sezonsal Koleksiyon',
                'name' => 'seasonal_collection',
                'type' => 'select',
                'instructions' => 'Bu ürünün hangi sezona ait olduğunu belirtin',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'spring' => 'İlkbahar',
                    'summer' => 'Yaz',
                    'autumn' => 'Sonbahar',
                    'winter' => 'Kış',
                    'all-season' => 'Tüm Sezonlar',
                ),
                'default_value' => array(
                ),
                'allow_null' => 1,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ),
            array(
                'key' => 'field_pattern_type',
                'label' => 'Desen Türü',
                'name' => 'pattern_type',
                'type' => 'text',
                'instructions' => 'Ürünün desen türünü belirtin',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'örn: Çiçek deseni, Geometrik, Düz renk',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
}

add_action('acf/init', 'welmacart_add_product_features_fields');
