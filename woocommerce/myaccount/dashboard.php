<?php
/**
 * My Account Dashboard - Custom Apple-inspired design
 * 
 * @package WelmaCart
 * @version 2.6.0
 */

defined('ABSPATH') || exit;

$current_user = wp_get_current_user();

// Hide default WooCommerce welcome message
remove_action('woocommerce_account_dashboard', 'woocommerce_account_dashboard', 10);
?>

<div class="account-dashboard">
    <!-- Welcome Message -->
    <div class="dashboard-welcome">
        <h2>Merhaba <?php echo esc_html($current_user->display_name); ?>!</h2>
        <p>Hesabınızda siparişlerinizi takip edebilir, adres bilgilerinizi güncelleyebilir ve hesap ayarlarınızı yönetebilirsiniz.</p>
    </div>

    <!-- Dashboard Stats -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Toplam Sipariş</h3>
                <p class="stat-number">
                    <?php
                    $customer_orders = wc_get_orders(array(
                        'customer' => get_current_user_id(),
                        'status' => array('wc-completed', 'wc-processing', 'wc-on-hold'),
                        'limit' => -1
                    ));
                    echo count($customer_orders);
                    ?>
                </p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Favori Ürünler</h3>
                <p class="stat-number">0</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"/>
                    <path d="M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Kayıtlı Adres</h3>
                <p class="stat-number">
                    <?php
                    $shipping_address = get_user_meta(get_current_user_id(), 'shipping_address_1', true);
                    echo !empty($shipping_address) ? '1' : '0';
                    ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <?php
    $recent_orders = wc_get_orders(array(
        'customer' => get_current_user_id(),
        'limit' => 3,
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    
    if ($recent_orders): ?>
    <div class="dashboard-section">
        <div class="section-header">
            <h3>Son Siparişler</h3>
            <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="view-all-link">
                Tümünü Görüntüle
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </a>
        </div>
        
        <div class="recent-orders">
            <?php foreach ($recent_orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-number">
                            <strong>Sipariş #<?php echo $order->get_order_number(); ?></strong>
                        </div>
                        <div class="order-status status-<?php echo esc_attr($order->get_status()); ?>">
                            <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>
                        </div>
                    </div>
                    <div class="order-details">
                        <div class="order-date">
                            <?php echo $order->get_date_created()->date_i18n('d M Y'); ?>
                        </div>
                        <div class="order-total">
                            <?php echo $order->get_formatted_order_total(); ?>
                        </div>
                    </div>
                    <div class="order-actions">
                        <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="order-action-btn">
                            Detayları Görüntüle
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Actions -->
    <div class="dashboard-section">
        <h3>Hızlı İşlemler</h3>
        <div class="quick-actions">
            <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="quick-action-card">
                <div class="action-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div class="action-content">
                    <h4>Siparişlerim</h4>
                    <p>Tüm siparişlerinizi görüntüleyin</p>
                </div>
            </a>

            <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="quick-action-card">
                <div class="action-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"/>
                        <path d="M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    </svg>
                </div>
                <div class="action-content">
                    <h4>Adreslerim</h4>
                    <p>Teslimat adreslerinizi yönetin</p>
                </div>
            </a>

            <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="quick-action-card">
                <div class="action-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="action-content">
                    <h4>Hesap Bilgileri</h4>
                    <p>Kişisel bilgilerinizi güncelleyin</p>
                </div>
            </a>

            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="quick-action-card">
                <div class="action-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m7 7 10-10"/>
                        <path d="M20.83 14.83l-11-11"/>
                        <path d="M2 12h20"/>
                        <path d="m10 20 2-2 2 2"/>
                    </svg>
                </div>
                <div class="action-content">
                    <h4>Alışverişe Devam</h4>
                    <p>Yeni ürünleri keşfedin</p>
                </div>
            </a>
        </div>
    </div>
</div>
