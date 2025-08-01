<?php
/**
 * İçerik bulunamadığında gösterilecek şablon
 */
?>

<div class="no-results">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('İçerik Bulunamadı', 'welmacart-v2'); ?></h1>
    </header>

    <div class="page-content">
        <?php if (is_search()) : ?>
            <p><?php esc_html_e('Aradığınız kriterlere uygun sonuç bulunamadı. Farklı anahtar kelimelerle tekrar deneyebilirsiniz.', 'welmacart-v2'); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php esc_html_e('İstediğiniz içeriğe ulaşılamadı. Arama yaparak bulmak istediğiniz içeriği arayabilirsiniz.', 'welmacart-v2'); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</div>
