<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 * 
 * Custom WooCommerce Shop Page Template - Apple-inspired design
 */

defined('ABSPATH') || exit;

get_header('shop'); ?>

<div class="shop-page-wrapper">
    <!-- Shop Header -->
    <header class="shop-header">
        <div class="shop-header-container">
            <div class="shop-header-content">
                <h1 class="shop-title"><?php woocommerce_page_title(); ?></h1>
                <div class="shop-description">
                    <?php if (is_shop() && get_option('woocommerce_shop_page_id')): ?>
                        <div class="shop-page-content">
                            <?php echo wp_kses_post(wpautop(get_post_field('post_content', get_option('woocommerce_shop_page_id')))); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!is_shop()): ?>
                        <div class="archive-description">
                            <?php do_action('woocommerce_archive_description'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Breadcrumbs -->
            <nav class="shop-breadcrumbs">
                <?php woocommerce_breadcrumb(); ?>
            </nav>
        </div>
    </header>

    <!-- Shop Content -->
    <div class="shop-content">
        <div class="shop-container">
            
            <?php if (woocommerce_product_loop()): ?>
                
                <!-- Shop Toolbar -->
                <div class="shop-toolbar">
                    <div class="shop-toolbar-left">
                        <div class="shop-result-count">
                            <?php woocommerce_result_count(); ?>
                        </div>
                    </div>
                    
                    <div class="shop-toolbar-center">
                        <!-- Categories Filter -->
                        <div class="shop-categories-filter">
                            <?php
                            $product_categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => 0,
                                'number' => 6
                            ));
                            
                            if (!empty($product_categories) && !is_wp_error($product_categories)):
                            ?>
                                <div class="category-filters">
                                    <button class="category-filter active" data-category="all">
                                        Tümü
                                    </button>
                                    <?php foreach ($product_categories as $category): ?>
                                        <button class="category-filter" data-category="<?php echo esc_attr($category->slug); ?>">
                                            <?php echo esc_html($category->name); ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="shop-toolbar-right">
                        <div class="shop-ordering">
                            <?php woocommerce_catalog_ordering(); ?>
                        </div>
                        
                        <!-- View Mode Toggle -->
                        <div class="view-mode-toggle">
                            <button class="view-mode-btn active" data-view="grid" title="Grid View">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7"/>
                                    <rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/>
                                    <rect x="3" y="14" width="7" height="7"/>
                                </svg>
                            </button>
                            <button class="view-mode-btn" data-view="list" title="List View">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="8" y1="6" x2="21" y2="6"/>
                                    <line x1="8" y1="12" x2="21" y2="12"/>
                                    <line x1="8" y1="18" x2="21" y2="18"/>
                                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <?php
                /**
                 * Hook: woocommerce_before_shop_loop.
                 * We're removing default hooks to avoid duplication
                 */
                // Remove default result count and ordering since we have custom ones
                remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
                remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                
                do_action('woocommerce_before_shop_loop');
                ?>

                <!-- Products Grid -->
                <div class="shop-products" data-view="grid">
                    <?php woocommerce_product_loop_start(); ?>

                    <?php if (wc_get_loop_prop('is_shortcode')): ?>
                        <?php
                        $columns = wc_get_loop_prop('columns');
                        while (have_posts()):
                            the_post();
                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action('woocommerce_shop_loop');
                            
                            wc_get_template_part('content', 'product');
                        endwhile;
                        ?>
                    <?php else: ?>
                        <?php
                        while (have_posts()):
                            the_post();
                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action('woocommerce_shop_loop');
                            
                            wc_get_template_part('content', 'product');
                        endwhile;
                        ?>
                    <?php endif; ?>

                    <?php woocommerce_product_loop_end(); ?>
                </div>

                <?php
                /**
                 * Hook: woocommerce_after_shop_loop.
                 * We're removing default pagination to use our custom one
                 */
                remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
                do_action('woocommerce_after_shop_loop');
                ?>

                <!-- Custom Pagination -->
                <div class="shop-pagination-wrapper">
                    <?php
                    /**
                     * Custom pagination with Apple-style design
                     */
                    global $wp_query;
                    
                    $big = 999999999; // need an unlikely integer
                    $pagination_links = paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $wp_query->max_num_pages,
                        'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>',
                        'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>',
                        'type' => 'array'
                    ));
                    
                    if ($pagination_links):
                    ?>
                        <nav class="shop-pagination" aria-label="Shop pagination">
                            <?php foreach ($pagination_links as $link): ?>
                                <?php echo $link; ?>
                            <?php endforeach; ?>
                        </nav>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- No Products Found -->
                <div class="shop-no-products">
                    <div class="no-products-content">
                        <div class="no-products-icon">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="8" cy="21" r="1"/>
                                <circle cx="19" cy="21" r="1"/>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                            </svg>
                        </div>
                        <h2 class="no-products-title">Ürün Bulunamadı</h2>
                        <p class="no-products-text">
                            Aradığınız kriterlere uygun ürün bulunamadı. Filtreleri temizleyip tekrar deneyin.
                        </p>
                        <div class="no-products-actions">
                            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-primary">
                                Tüm Ürünleri Görüntüle
                            </a>
                        </div>
                    </div>
                </div>

                <?php
                /**
                 * Hook: woocommerce_no_products_found.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action('woocommerce_no_products_found');
                ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action('woocommerce_sidebar'); // Sidebar'ı gizliyoruz
?>

<?php get_footer('shop'); ?>
