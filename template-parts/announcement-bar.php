<?php
/**
 * Announcement Bar Template Part
 */

$anons_query = new WP_Query([
    'post_type' => 'anons',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
]);

if ($anons_query->have_posts()) : ?>
    <div class="announcement-bar">
        <div class="container">
            <div class="announcement-content">
                <?php 
                while ($anons_query->have_posts()) : 
                    $anons_query->the_post();
                    static $index = 0;
                ?>
                    <div class="announcement-item<?php echo $index === 0 ? ' active' : ''; ?>">
                        <i data-feather="bell"></i>
                        <span><?php the_field('anons_icerik'); ?></span>
                        <?php if (get_field('anons_link')): ?>
                            <a href="<?php echo esc_url(get_field('anons_link')); ?>" class="announcement-link">
                                <?php echo esc_html(get_field('anons_link_text')); ?>
                                <i data-feather="chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php 
                    $index++;
                endwhile; 
                wp_reset_postdata(); 
                ?>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.announcement-item');
        let currentIndex = 0;
        
        function showNext() {
            items[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % items.length;
            items[currentIndex].classList.add('active');
        }
        
        if (items.length > 1) {
            setInterval(showNext, 5000);
        }
    });
    </script>
<?php endif; ?>
