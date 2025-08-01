<?php
/**
 * The template for displaying product content within loops
 * 
 * Custom Product Card - Apple-inspired design
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}

// Get product categories for filtering
$product_cats = wp_get_post_terms($product->get_id(), 'product_cat');
$category_slugs = array();
if (!empty($product_cats) && !is_wp_error($product_cats)) {
    foreach ($product_cats as $cat) {
        $category_slugs[] = $cat->slug;
    }
}
$categories_string = implode(',', $category_slugs);
?>
<div <?php wc_product_class('product-card', $product); ?> 
     data-product-id="<?php echo esc_attr($product->get_id()); ?>"
     data-product-categories="<?php echo esc_attr($categories_string); ?>">
    <div class="product-card-inner">
        
        <!-- Product Image -->
        <div class="product-card-image">
            <a href="<?php echo esc_url(get_permalink()); ?>" class="product-image-link">
                <?php
                /**
                 * Hook: woocommerce_before_shop_loop_item_title.
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                // Remove default hooks
                remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
                remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
                
                // Custom product image
                $image_size = apply_filters('single_product_archive_thumbnail_size', 'woocommerce_thumbnail');
                $image_id = $product->get_image_id();
                
                if ($image_id) {
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    $image_title = get_the_title($image_id);
                    
                    echo wp_get_attachment_image(
                        $image_id,
                        $image_size,
                        false,
                        array(
                            'alt' => $image_alt ? $image_alt : $product->get_name(),
                            'title' => $image_title ? $image_title : $product->get_name(),
                            'class' => 'product-image'
                        )
                    );
                } else {
                    echo wc_placeholder_img($image_size, 'product-image');
                }
                ?>
                
                <!-- Sale Badge -->
                <?php if ($product->is_on_sale()): ?>
                    <span class="sale-badge">
                        <?php
                        if ($product->get_type() === 'variable') {
                            echo esc_html__('İndirim', 'woocommerce');
                        } else {
                            $regular_price = (float) $product->get_regular_price();
                            $sale_price = (float) $product->get_sale_price();
                            if ($regular_price > 0) {
                                $percentage = round(((($regular_price - $sale_price) / $regular_price) * 100));
                                echo '-' . $percentage . '%';
                            } else {
                                echo esc_html__('İndirim', 'woocommerce');
                            }
                        }
                        ?>
                    </span>
                <?php endif; ?>
                
                <!-- Quick View Button -->
                <button class="quick-view-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>" title="Hızlı Görünüm">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </a>
            
            <!-- Wishlist Button -->
            <button class="wishlist-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>" title="Favorilere Ekle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
            </button>
        </div>

        <!-- Product Info -->
        <div class="product-card-content">
            
            <!-- Product Category -->
            <?php
            $product_cats = wp_get_post_terms($product->get_id(), 'product_cat');
            if (!empty($product_cats) && !is_wp_error($product_cats)):
            ?>
                <div class="product-category">
                    <a href="<?php echo esc_url(get_term_link($product_cats[0])); ?>">
                        <?php echo esc_html($product_cats[0]->name); ?>
                    </a>
                </div>
            <?php endif; ?>

            <!-- Product Title -->
            <h3 class="product-title">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <?php echo esc_html($product->get_name()); ?>
                </a>
            </h3>

            <!-- Product Rating -->
            <div class="product-rating">
                <?php
                $rating_count = $product->get_rating_count();
                $review_count = $product->get_review_count();
                $average = $product->get_average_rating();

                if ($rating_count > 0):
                ?>
                    <div class="star-rating" title="<?php echo sprintf(__('Rated %s out of 5', 'woocommerce'), $average); ?>">
                        <div class="star-rating-inner" style="width: <?php echo ($average / 5) * 100; ?>%;">
                            <span class="sr-only"><?php echo sprintf(__('Rated %s out of 5', 'woocommerce'), $average); ?></span>
                        </div>
                    </div>
                    <span class="rating-count">(<?php echo esc_html($review_count); ?>)</span>
                <?php else: ?>
                    <div class="no-rating">
                        <span class="rating-text">Henüz değerlendirilmemiş</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Price -->
            <div class="product-price">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item_title.
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                echo $product->get_price_html();
                ?>
            </div>

            <!-- Product Short Description -->
            <?php if ($product->get_short_description()): ?>
                <div class="product-excerpt">
                    <?php echo wp_trim_words($product->get_short_description(), 15, '...'); ?>
                </div>
            <?php endif; ?>

            <!-- Add to Cart Button -->
            <div class="product-actions">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item.
                 *
                 * @hooked woocommerce_template_loop_product_link_close - 5
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                
                // Custom add to cart button
                $button_text = $product->add_to_cart_text();
                $button_class = 'add-to-cart-btn';
                
                if ($product->is_type('simple')) {
                    $button_class .= ' ajax-add-to-cart';
                }
                
                if (!$product->is_purchasable() || !$product->is_in_stock()) {
                    $button_class .= ' disabled';
                    $button_text = __('Stokta Yok', 'woocommerce');
                }
                ?>
                
                <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" 
                   class="<?php echo esc_attr($button_class); ?>"
                   data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                   data-product_sku="<?php echo esc_attr($product->get_sku()); ?>"
                   data-quantity="1"
                   rel="nofollow">
                    <span class="btn-text"><?php echo esc_html($button_text); ?></span>
                    <div class="btn-loader">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="animate-spin">
                            <path d="M21 12a9 9 0 11-6.219-8.56"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
