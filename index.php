<?php
/**
 * Ana şablon dosyası
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', get_post_type());
            endwhile;
            
            the_posts_pagination([
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
            ]);
        else :
            get_template_part('template-parts/content', 'none');
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
