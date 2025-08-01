<?php
/**
 * My Account navigation - Custom Apple-inspired design
 * 
 * @package WelmaCart
 * @version 2.6.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation">
    <ul>
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
            <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" 
                   <?php echo $endpoint === 'customer-logout' ? 'onclick="return confirm(\'Çıkış yapmak istediğinizden emin misiniz?\')"' : ''; ?>>
                    <?php 
                    // Türkçe çeviriler
                    $turkish_labels = array(
                        'Dashboard' => 'Ana Panel',
                        'Orders' => 'Siparişlerim',
                        'Downloads' => 'İndirilenler',
                        'Addresses' => 'Adreslerim',
                        'Account details' => 'Hesap Bilgileri',
                        'Logout' => 'Çıkış Yap'
                    );
                    
                    echo isset($turkish_labels[$label]) ? esc_html($turkish_labels[$label]) : esc_html($label);
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
