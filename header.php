<?php
/**
 * Header template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <?php get_template_part('template-parts/announcement-bar'); ?>
    
    <nav class="main-nav">
        <div class="container">
            <div class="nav-wrapper">
                <!-- Logo -->
                <div class="site-branding">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" 
                             alt="<?php bloginfo('name'); ?>" 
                             class="logo-image">
                    </a>
                </div>

                <!-- Ana Menü -->
                <div class="nav-menu-wrapper">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'menu_class' => 'nav-menu',
                            'container' => false,
                            'fallback_cb' => false,
                        ]);
                    } else {
                        // Fallback menü - admin menüsü oluşturmadığında
                        echo '<ul class="nav-menu">';
                        echo '<li><a href="' . home_url('/') . '">Ana Sayfa</a></li>';
                        echo '<li><a href="' . home_url('/shop/') . '">Koleksiyon</a></li>';
                        echo '<li><a href="' . home_url('/hakkimizda/') . '">Hakkımızda</a></li>';
                        echo '<li><a href="' . home_url('/stil-rehberi/') . '">Stil Rehberi</a></li>';
                        echo '<li><a href="' . home_url('/iletisim/') . '">İletişim</a></li>';
                        echo '</ul>';
                    }
                    ?>
                    
                    <!-- Menü stillerini güçlendirmek için inline CSS -->
                    <style>
                    .nav-menu-wrapper .nav-menu, .nav-menu-wrapper ul {
                        display: flex !important;
                        list-style: none !important;
                        gap: 1.5rem !important;
                        margin: 0 !important;
                        padding: 0 !important;
                        align-items: center !important;
                    }
                    .nav-menu-wrapper .nav-menu li, .nav-menu-wrapper ul li {
                        margin: 0 !important;
                        padding: 0 !important;
                        list-style: none !important;
                        position: relative !important;
                    }
                    .nav-menu-wrapper .nav-menu a, .nav-menu-wrapper ul li a {
                        font-size: 0.875rem !important;
                        font-weight: 500 !important;
                        color: #1d1d1f !important;
                        padding: 0.5rem 0.75rem !important;
                        border-radius: 25px !important;
                        text-decoration: none !important;
                        display: block !important;
                        transition: all 0.3s ease !important;
                        white-space: nowrap !important;
                    }
                    .nav-menu-wrapper .nav-menu a:hover, .nav-menu-wrapper ul li a:hover {
                        color: #ff3e03 !important;
                        background-color: #f5f5f7 !important;
                    }
                    
                    /* Dropdown styles - Hide WordPress default arrows first */
                    .nav-menu-wrapper .menu-item-has-children > a .wp-menu-arrow,
                    .nav-menu-wrapper .menu-item-has-children > a .dropdown-toggle {
                        display: none !important;
                    }
                    .nav-menu-wrapper .menu-item-has-children > a::after {
                        content: '▼' !important;
                        font-size: 0.7rem !important;
                        margin-left: 0.5rem !important;
                        transition: transform 0.3s ease !important;
                        opacity: 0.6 !important;
                    }
                    .nav-menu-wrapper .menu-item-has-children:hover > a::after {
                        transform: rotate(180deg) !important;
                        opacity: 1 !important;
                    }
                    .nav-menu-wrapper .sub-menu {
                        position: absolute !important;
                        top: 100% !important;
                        left: 50% !important;
                        transform: translateX(-50%) !important;
                        background: white !important;
                        border-radius: 12px !important;
                        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15) !important;
                        border: 1px solid #dddddd !important;
                        padding: 0.5rem 0 !important;
                        margin: 0.25rem 0 0 0 !important;
                        min-width: 200px !important;
                        opacity: 0 !important;
                        visibility: hidden !important;
                        pointer-events: none !important;
                        transition: opacity 0.2s ease, visibility 0.2s ease !important;
                        transition-delay: 0.15s !important;
                        z-index: 1000 !important;
                        display: block !important;
                        list-style: none !important;
                    }
                    /* Hover bridge */
                    .nav-menu-wrapper .menu-item-has-children::before {
                        content: '';
                        position: absolute;
                        top: 100%;
                        left: 0;
                        right: 0;
                        height: 0.25rem;
                        background: transparent;
                        z-index: 999;
                    }
                    .nav-menu-wrapper .menu-item-has-children:hover > .sub-menu,
                    .nav-menu-wrapper .sub-menu:hover {
                        opacity: 1 !important;
                        visibility: visible !important;
                        pointer-events: auto !important;
                        transition-delay: 0s !important;
                    }
                    .nav-menu-wrapper .sub-menu li {
                        margin: 0 !important;
                        padding: 0 !important;
                        width: 100% !important;
                    }
                    .nav-menu-wrapper .sub-menu a {
                        padding: 0.75rem 1rem !important;
                        border-radius: 0 !important;
                        font-weight: 400 !important;
                    }
                    .nav-menu-wrapper .sub-menu a:hover {
                        background-color: #f5f5f7 !important;
                        padding-left: 1.25rem !important;
                    }
                    </style>
                </div>

                <!-- Sağ İkonlar -->
                <div class="nav-actions">
                    <!-- Arama -->
                    <button class="nav-action search-toggle" aria-label="<?php esc_attr_e('Ara', 'welmacart-v2'); ?>">
                        <i data-feather="search"></i>
                    </button>

                    <!-- Hesap -->
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" class="nav-action">
                        <i data-feather="user"></i>
                    </a>

                    <!-- Sepet -->
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="nav-action cart-link">
                        <i data-feather="shopping-bag"></i>
                        <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0): ?>
                            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- Mobil Menü -->
                    <button class="nav-action menu-toggle d-lg-none" aria-label="<?php esc_attr_e('Menü', 'welmacart-v2'); ?>">
                        <i data-feather="menu"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Arama Overlay -->
    <div class="search-overlay">
        <div class="container">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="search-input-wrapper">
                    <i data-feather="search"></i>
                    <input type="search" 
                           class="search-input" 
                           placeholder="<?php esc_attr_e('Ne aramıştınız?', 'welmacart-v2'); ?>" 
                           value="<?php echo get_search_query(); ?>" 
                           name="s" 
                           autocomplete="off" />
                    <input type="hidden" name="post_type" value="product">
                    <button type="button" class="search-close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                
                <!-- Search Results -->
                <div class="search-results" style="display: none;"></div>
            </form>
        </div>
    </div>
</header>

<!-- Mobil Menü -->
<div class="mobile-menu">
    <div class="mobile-menu-header">
        <button class="mobile-menu-close">
            <i data-feather="x"></i>
        </button>
    </div>
    <div class="mobile-menu-content">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class' => 'mobile-nav-menu',
            'container' => false,
            'fallback_cb' => false,
        ]);
        ?>
    </div>
</div>
