<?php
/**
 * Single Product Hooks - Remove default WooCommerce gallery and customize layout
 */

// Remove default WooCommerce product images
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

// Remove default product thumbnails if any
remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);

// Remove default product sale flash
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

// Clean up product summary hooks but keep essential ones
add_action('init', 'welmacart_v2_customize_single_product_hooks');

function welmacart_v2_customize_single_product_hooks() {
    // Remove elements we don't want in our custom layout
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
    
    // Keep the tabs for our custom section
    // remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
}

// Ensure our custom template is used
add_filter('wc_get_template_part', 'welmacart_v2_override_single_product_template', 10, 3);

function welmacart_v2_override_single_product_template($template, $slug, $name) {
    if ($slug === 'content' && $name === 'single-product') {
        $custom_template = locate_template('woocommerce/content-single-product.php');
        if ($custom_template) {
            return $custom_template;
        }
    }
    return $template;
}

// Hide WooCommerce default styles that might conflict
add_action('wp_enqueue_scripts', 'welmacart_v2_dequeue_woocommerce_styles', 100);

function welmacart_v2_dequeue_woocommerce_styles() {
    if (is_product()) {
        // Remove flexslider if it conflicts
        wp_dequeue_script('flexslider');
        wp_dequeue_style('photoswipe');
        wp_dequeue_style('photoswipe-default-skin');
        wp_dequeue_script('photoswipe');
        wp_dequeue_script('photoswipe-ui-default');
    }
}

// Force enable product tabs and reviews
add_filter('woocommerce_product_tabs', 'welmacart_v2_force_product_tabs', 98);

function welmacart_v2_force_product_tabs($tabs) {
    global $product;
    
    // Ensure $tabs is an array
    if (!is_array($tabs)) {
        $tabs = array();
    }
    
    // Always show description tab
    if (!isset($tabs['description'])) {
        $tabs['description'] = array(
            'title'    => __('Description', 'woocommerce'),
            'priority' => 10,
            'callback' => 'woocommerce_product_description_tab',
        );
    }
    
    // Always show reviews tab if comments are open or we have reviews
    if (!isset($tabs['reviews']) && (comments_open() || get_comments_number())) {
        $tabs['reviews'] = array(
            'title'    => sprintf(__('Reviews (%d)', 'woocommerce'), get_comments_number()),
            'priority' => 30,
            'callback' => 'comments_template',
        );
    }
    
    // Add additional information tab
    if (!isset($tabs['additional_information']) && $product && ($product->has_attributes() || apply_filters('wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions()))) {
        $tabs['additional_information'] = array(
            'title'    => __('Additional information', 'woocommerce'),
            'priority' => 20,
            'callback' => 'woocommerce_product_additional_information_tab',
        );
    }
    
    return $tabs;
}

// Enable comments for products
add_filter('comments_open', 'welmacart_v2_enable_product_comments', 10, 2);

function welmacart_v2_enable_product_comments($open, $post_id) {
    $post = get_post($post_id);
    if ($post && $post->post_type === 'product') {
        return true; // Always enable comments for products
    }
    return $open;
}

// Add support for product reviews
add_theme_support('woocommerce', array(
    'product_grid' => array(
        'default_rows'    => 3,
        'min_rows'        => 2,
        'max_rows'        => 8,
        'default_columns' => 4,
        'min_columns'     => 2,
        'max_columns'     => 5,
    ),
));

// Ensure reviews are enabled for all products
add_action('init', 'welmacart_v2_enable_reviews_for_products');

function welmacart_v2_enable_reviews_for_products() {
    // Enable comments for product post type
    add_post_type_support('product', 'comments');
    
    // Update WooCommerce settings to enable reviews
    update_option('woocommerce_enable_reviews', 'yes');
    update_option('woocommerce_review_rating_verification_required', 'no');
    update_option('woocommerce_review_rating_verification_label', 'yes');
}
