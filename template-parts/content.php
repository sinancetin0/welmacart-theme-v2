<?php
/**
 * Varsayılan içerik şablonu
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-article'); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
        endif;
        ?>
    </header>

    <?php if (has_post_thumbnail()) : ?>
        <div class="entry-thumbnail">
            <?php the_post_thumbnail('large'); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if (is_singular()) :
            the_content();
        else :
            the_excerpt();
            echo '<p><a href="' . esc_url(get_permalink()) . '" class="read-more">' . __('Devamını Oku', 'welmacart-v2') . '</a></p>';
        endif;
        ?>
    </div>
</article>
