<?php
/**
 * The Template for displaying single product page
 * Apple-style feminine design for Welma scarf company
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<main class="site-main single-product-main">
    <div class="product-single-wrapper">
        <?php while (have_posts()) : the_post(); ?>
            <?php wc_get_template_part('content', 'single-product'); ?>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer();
