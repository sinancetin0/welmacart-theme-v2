<?php
/**
 * Generic Page Template
 * WelmaCart V2 Theme
 */

get_header(); ?>

<main class="page-content">
    <div class="container">
        
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <article class="page-article">
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    
                    <?php if (has_excerpt()) : ?>
                        <div class="page-subtitle"><?php the_excerpt(); ?></div>
                    <?php endif; ?>
                </header>
                
                <div class="page-body">
                    <?php the_content(); ?>
                    
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">',
                        'after'  => '</div>',
                        'link_before' => '<span class="page-link">',
                        'link_after'  => '</span>',
                    ));
                    ?>
                </div>
            </article>
            
        <?php endwhile; endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>
