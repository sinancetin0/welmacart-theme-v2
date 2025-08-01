<?php
/**
 * WooCommerce entegrasyonu
 */

// WooCommerce desteğini ekle
add_action('after_setup_theme', function() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
});

// WooCommerce wrapper'ları
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', function() {
    echo '<main class="site-main woocommerce-main"><div class="container">';
}, 10);

add_action('woocommerce_after_main_content', function() {
    echo '</div></main>';
}, 10);

// Mini sepet için ürün sayısını güncelle
add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
});
