<?php
/**
 * My Account page - Custom Apple-inspired design
 * 
 * @package WelmaCart
 * @version 3.5.0
 */

defined('ABSPATH') || exit;
?>

<div class="my-account-wrapper">
    <!-- Account Header -->
    <div class="account-header">
        <div class="account-header-content">
            <h1 class="account-title">Hesabım</h1>
            <p class="account-subtitle">Siparişlerinizi yönetin ve hesap bilgilerinizi güncelleyin</p>
        </div>
    </div>

    <!-- Account Content -->
    <div class="account-content">
        <div class="container">
            <div class="account-layout">
                <!-- Account Navigation -->
                <aside class="account-navigation">
                    <div class="account-nav-header">
                        <div class="account-user-info">
                            <?php $current_user = wp_get_current_user(); ?>
                            <div class="user-avatar">
                                <?php echo get_avatar($current_user->ID, 48); ?>
                            </div>
                            <div class="user-details">
                                <h3 class="user-name"><?php echo esc_html($current_user->display_name); ?></h3>
                                <p class="user-email"><?php echo esc_html($current_user->user_email); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <nav class="account-nav-menu">
                        <?php
                        /**
                         * My Account navigation.
                         */
                        do_action('woocommerce_account_navigation');
                        ?>
                    </nav>
                </aside>

                <!-- Account Main Content -->
                <main class="account-main">
                    <div class="woocommerce-MyAccount-content">
                        <?php
                        /**
                         * My Account content.
                         */
                        do_action('woocommerce_account_content');
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
