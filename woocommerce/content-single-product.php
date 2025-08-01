<?php
/**
 * The template for displaying product content in the single-product.php template
 * Apple-style minimalist design for WelmaCart
 */

defined('ABSPATH') || exit;

global $product;

do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();
    return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('single-product-container', $product); ?>>
    
    <!-- Breadcrumb -->
    <div class="product-breadcrumb">
        <?php woocommerce_breadcrumb(); ?>
    </div>

    <div class="product-layout">
        
        <!-- Product Gallery -->
        <div class="product-gallery">
            <?php
            // Custom gallery - no WooCommerce hooks
            $attachment_ids = $product->get_gallery_image_ids();
            $main_image_id = $product->get_image_id();
            
            // Add main image to the beginning
            if ($main_image_id) {
                array_unshift($attachment_ids, $main_image_id);
            }
            
            if (!empty($attachment_ids)) :
            ?>
                <div class="gallery-main">
                    <img 
                        id="main-product-image" 
                        src="<?php echo wp_get_attachment_image_url($attachment_ids[0], 'large'); ?>" 
                        alt="<?php echo get_the_title(); ?>"
                        class="main-image"
                    >
                </div>
                
                <?php if (count($attachment_ids) > 1) : ?>
                <div class="gallery-thumbnails">
                    <?php foreach ($attachment_ids as $index => $attachment_id) : ?>
                        <img 
                            src="<?php echo wp_get_attachment_image_url($attachment_id, 'medium'); ?>" 
                            alt="<?php echo get_the_title(); ?>"
                            class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>"
                            data-large="<?php echo wp_get_attachment_image_url($attachment_id, 'large'); ?>"
                            tabindex="0"
                        >
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            
            <?php else : ?>
                <div class="gallery-main">
                    <img 
                        src="<?php echo wc_placeholder_img_src('large'); ?>" 
                        alt="<?php echo get_the_title(); ?>"
                        class="main-image placeholder"
                    >
                </div>
            <?php endif; ?>
        </div>

        <!-- Product Details -->
        <div class="product-details">
            
            <!-- Product Title -->
            <h1 class="product-title"><?php the_title(); ?></h1>
            
            <!-- Product Price -->
            <div class="product-price">
                <?php echo $product->get_price_html(); ?>
            </div>
            
            <!-- Product Excerpt/Description -->
            <?php if ($product->get_short_description()) : ?>
            <div class="product-description">
                <?php echo apply_filters('woocommerce_short_description', $product->get_short_description()); ?>
            </div>
            <?php endif; ?>
            
            <!-- Product Features -->
            <div class="product-features">
                <?php
                // Get ACF fields for product features - get raw values to avoid wpautop issues
                $material_type = get_field('material_type', false, false);
                $material_composition = get_field('material_composition', false, false);
                $dimensions = get_field('dimensions', false, false);
                $care_instructions = get_field('care_instructions', false, false);
                $pattern_type = get_field('pattern_type', false, false);
                $seasonal_collection = get_field('seasonal_collection', false, false);
                
                // Clean up HTML tags and just keep text content
                if ($material_type) {
                    $material_type = strip_tags($material_type);
                }
                if ($material_composition) {
                    $material_composition = strip_tags($material_composition);
                }
                if ($dimensions) {
                    $dimensions = strip_tags($dimensions);
                }
                if ($care_instructions) {
                    $care_instructions = strip_tags($care_instructions);
                }
                if ($pattern_type) {
                    $pattern_type = strip_tags($pattern_type);
                }
                
                // Check if any features exist
                $has_features = $material_type || $material_composition || $dimensions || $care_instructions || $pattern_type || $seasonal_collection;
                ?>
                
                <?php if ($has_features) : ?>
                    
                    <?php if ($material_type) : ?>
                    <div class="feature-item">
                        <i data-feather="layers"></i>
                        <div class="feature-content">
                            <span class="feature-label">Malzeme</span>
                            <span class="feature-value"><?php echo esc_html($material_type); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($material_composition) : ?>
                    <div class="feature-item">
                        <i data-feather="info"></i>
                        <div class="feature-content">
                            <span class="feature-label">Bileşim</span>
                            <span class="feature-value"><?php echo esc_html($material_composition); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($dimensions) : ?>
                    <div class="feature-item">
                        <i data-feather="maximize"></i>
                        <div class="feature-content">
                            <span class="feature-label">Boyutlar</span>
                            <span class="feature-value"><?php echo esc_html($dimensions); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($pattern_type) : ?>
                    <div class="feature-item">
                        <i data-feather="grid"></i>
                        <div class="feature-content">
                            <span class="feature-label">Desen</span>
                            <span class="feature-value"><?php echo esc_html($pattern_type); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($seasonal_collection) : ?>
                    <div class="feature-item">
                        <i data-feather="calendar"></i>
                        <div class="feature-content">
                            <span class="feature-label">Sezon</span>
                            <span class="feature-value">
                                <?php 
                                $seasons = array(
                                    'spring' => 'İlkbahar',
                                    'summer' => 'Yaz',
                                    'autumn' => 'Sonbahar',
                                    'winter' => 'Kış',
                                    'all-season' => 'Tüm Sezonlar'
                                );
                                echo isset($seasons[$seasonal_collection]) ? $seasons[$seasonal_collection] : esc_html($seasonal_collection);
                                ?>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($care_instructions) : ?>
                    <div class="feature-item">
                        <i data-feather="droplet"></i>
                        <div class="feature-content">
                            <span class="feature-label">Bakım</span>
                            <span class="feature-value"><?php echo esc_html($care_instructions); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                <?php else : ?>
                    <!-- Fallback content when no features are set -->
                    <div class="feature-item">
                        <i data-feather="star"></i>
                        <div class="feature-content">
                            <span class="feature-label">Kalite</span>
                            <span class="feature-value">Premium kalite ürün</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i data-feather="truck"></i>
                        <div class="feature-content">
                            <span class="feature-label">Kargo</span>
                            <span class="feature-value">Ücretsiz kargo</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i data-feather="refresh-cw"></i>
                        <div class="feature-content">
                            <span class="feature-label">İade</span>
                            <span class="feature-value">30 gün iade garantisi</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Purchase Section -->
            <div class="purchase-section">
                <?php
                // Custom add to cart form with proper styling
                woocommerce_template_single_add_to_cart();
                ?>
                
                <!-- Add to Wishlist (if plugin available) -->
                <button class="wishlist-btn" type="button">
                    <i data-feather="heart"></i>
                    <span>Add to Wishlist</span>
                </button>
            </div>
            
            <!-- Styling Suggestions -->
            <?php 
            $styling_suggestions = get_field('styling_suggestions', false, false);
            if ($styling_suggestions) : 
                // Clean HTML tags but keep line breaks
                $styling_suggestions = strip_tags($styling_suggestions);
            ?>
            <div class="styling-suggestions">
                <h3>Stil Önerileri</h3>
                <div class="suggestions-content">
                    <?php echo nl2br(esc_html($styling_suggestions)); ?>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
        
    </div>
    
    <!-- Product Description & Reviews Tabs -->
    <div class="product-tabs-section">
        <?php
        // Force show product tabs
        $tabs = apply_filters('woocommerce_product_tabs', array());
        
        if (!empty($tabs)) :
            woocommerce_output_product_data_tabs();
        else :
            // Fallback: Manual tabs if WooCommerce tabs don't work
        ?>
        <div class="woocommerce-tabs wc-tabs-wrapper">
            <ul class="tabs wc-tabs" role="tablist">
                <li class="description_tab active" id="tab-title-description" role="tab" aria-controls="tab-description">
                    <a href="#tab-description">Açıklama</a>
                </li>
                <li class="reviews_tab" id="tab-title-reviews" role="tab" aria-controls="tab-reviews">
                    <a href="#tab-reviews">Değerlendirmeler (<?php echo get_comments_number(); ?>)</a>
                </li>
            </ul>
            
            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab" id="tab-description" role="tabpanel" aria-labelledby="tab-title-description">
                <h2>Açıklama</h2>
                <?php 
                global $product;
                if ($product->get_description()) {
                    echo apply_filters('the_content', $product->get_description());
                } else {
                    echo '<p>Bu ürün için henüz açıklama eklenmemiş.</p>';
                }
                ?>
            </div>
            
            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--reviews panel entry-content wc-tab" id="tab-reviews" role="tabpanel" aria-labelledby="tab-title-reviews" style="display: none;">
                <div id="reviews" class="woocommerce-Reviews">
                    <div id="comments">
                        <h2 class="woocommerce-Reviews-title">
                            Değerlendirmeler
                            <?php
                            $count = get_comments_number();
                            if ($count > 0) {
                                echo '<span class="count">(' . $count . ')</span>';
                            }
                            ?>
                        </h2>
                        
                        <?php if (have_comments()) : ?>
                            <ol class="commentlist">
                                <?php wp_list_comments(array('callback' => 'woocommerce_comments')); ?>
                            </ol>
                            
                            <?php
                            if (get_comment_pages_count() > 1 && get_option('page_comments')) :
                                echo '<nav class="woocommerce-pagination">';
                                paginate_comments_links(array(
                                    'prev_text' => __('&larr;', 'woocommerce'),
                                    'next_text' => __('&rarr;', 'woocommerce'),
                                    'type'      => 'list',
                                ));
                                echo '</nav>';
                            endif;
                            ?>
                        <?php else : ?>
                            <p class="woocommerce-noreviews">Bu ürün için henüz değerlendirme yapılmamış.</p>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (comments_open()) : ?>
                        <div id="review_form_wrapper">
                            <div id="review_form">
                                <?php
                                $commenter = wp_get_current_commenter();
                                $comment_form = array(
                                    'title_reply'          => have_comments() ? __('Add a review', 'woocommerce') : sprintf(__('Be the first to review &ldquo;%s&rdquo;', 'woocommerce'), get_the_title()),
                                    'title_reply_to'       => __('Leave a Reply to %s', 'woocommerce'),
                                    'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
                                    'title_reply_after'    => '</span>',
                                    'comment_notes_after'  => '',
                                    'fields'               => array(
                                        'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__('Name', 'woocommerce') . '&nbsp;<span class="required">*</span></label> ' .
                                                    '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" required /></p>',
                                        'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__('Email', 'woocommerce') . '&nbsp;<span class="required">*</span></label> ' .
                                                    '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" required /></p>',
                                    ),
                                    'label_submit'  => __('Submit', 'woocommerce'),
                                    'logged_in_as'  => '',
                                    'comment_field' => ''
                                );
                                
                                $comment_form['comment_field'] = '<div class="comment-form-rating"><select name="rating" id="rating" required>
                                    <option value="">' . esc_html__('Rate&hellip;', 'woocommerce') . '</option>
                                    <option value="5">' . esc_html__('Perfect', 'woocommerce') . '</option>
                                    <option value="4">' . esc_html__('Good', 'woocommerce') . '</option>
                                    <option value="3">' . esc_html__('Average', 'woocommerce') . '</option>
                                    <option value="2">' . esc_html__('Not that bad', 'woocommerce') . '</option>
                                    <option value="1">' . esc_html__('Very poor', 'woocommerce') . '</option>
                                </select></div><p class="comment-form-comment"><label for="comment">' . esc_html__('Your review', 'woocommerce') . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';
                                
                                comment_form($comment_form);
                                ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <p class="woocommerce-verification-required">Bu ürün için yorum yapılması kapalı.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced tab functionality
            const tabsContainer = document.querySelector('.wc-tabs, .tabs');
            const tabs = document.querySelectorAll('.wc-tabs li a, .tabs li a');
            const panels = document.querySelectorAll('.wc-tab, .woocommerce-Tabs-panel');
            
            if (tabs.length > 0 && panels.length > 0) {
                // Initialize first tab as active
                if (tabs[0] && panels[0]) {
                    tabs[0].parentElement.classList.add('active');
                    panels[0].style.display = 'block';
                }
                
                tabs.forEach(function(tab, index) {
                    tab.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Remove active class from all tabs and hide all panels
                        tabs.forEach(function(t) {
                            t.parentElement.classList.remove('active');
                            t.setAttribute('aria-selected', 'false');
                            t.setAttribute('tabindex', '-1');
                        });
                        
                        panels.forEach(function(p) {
                            p.style.display = 'none';
                        });
                        
                        // Add active class to current tab
                        this.parentElement.classList.add('active');
                        this.setAttribute('aria-selected', 'true');
                        this.setAttribute('tabindex', '0');
                        
                        // Show corresponding panel
                        const targetPanel = document.querySelector(this.getAttribute('href'));
                        if (targetPanel) {
                            targetPanel.style.display = 'block';
                        } else if (panels[index]) {
                            panels[index].style.display = 'block';
                        }
                        
                        // Focus the tab for accessibility
                        this.focus();
                    });
                    
                    // Keyboard navigation
                    tab.addEventListener('keydown', function(e) {
                        let newIndex = -1;
                        
                        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                            newIndex = (index + 1) % tabs.length;
                        } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                            newIndex = (index - 1 + tabs.length) % tabs.length;
                        } else if (e.key === 'Home') {
                            newIndex = 0;
                        } else if (e.key === 'End') {
                            newIndex = tabs.length - 1;
                        }
                        
                        if (newIndex !== -1) {
                            e.preventDefault();
                            tabs[newIndex].click();
                        }
                    });
                });
            }
            
            // Also handle WooCommerce default tabs if they exist
            if (typeof jQuery !== 'undefined') {
                jQuery(document).ready(function($) {
                    // Override WooCommerce tab switching
                    $('.woocommerce-tabs .panel').hide();
                    $('.woocommerce-tabs .panel:first').show();
                    $('.woocommerce-tabs ul.tabs li:first').addClass('active');
                    
                    $('.woocommerce-tabs ul.tabs li a').click(function(e) {
                        e.preventDefault();
                        var panel = $(this).attr('href');
                        
                        $('.woocommerce-tabs ul.tabs li').removeClass('active');
                        $(this).parent().addClass('active');
                        
                        $('.woocommerce-tabs .panel').hide();
                        $(panel).show();
                    });
                });
            }
        });
        </script>
        <?php endif; ?>
    </div>
    
    <!-- Related Products -->
    <div class="related-products-section">
        <?php
        // Get related products
        $related_ids = wc_get_related_products($product->get_id(), 4);
        if (!empty($related_ids)) :
        ?>
        <h2>İlgili Ürünler</h2>
        <div class="related-products-grid">
            <?php
            foreach ($related_ids as $related_id) :
                $related_product = wc_get_product($related_id);
                if ($related_product) :
            ?>
            <div class="related-product-card">
                <a href="<?php echo get_permalink($related_id); ?>">
                    <div class="related-product-image">
                        <?php echo $related_product->get_image('medium'); ?>
                    </div>
                    <h4><?php echo $related_product->get_name(); ?></h4>
                    <div class="related-product-price">
                        <?php echo $related_product->get_price_html(); ?>
                    </div>
                </a>
            </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>
        <?php endif; ?>
    </div>

</div>

<?php do_action('woocommerce_after_single_product'); ?>
