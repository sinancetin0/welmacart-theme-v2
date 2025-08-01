/**
 * Shop Page Functionality
 * Apple-inspired interactions and features
 */

document.addEventListener('DOMContentLoaded', function() {
    initShopPage();
});

function initShopPage() {
    // Initialize all shop features
    initViewModeToggle();
    initCategoryFilters();
    initQuickView();
    initWishlist();
    initAjaxAddToCart();
    initInfiniteScroll();
    initProductHover();
}

/**
 * View Mode Toggle (Grid/List)
 */
function initViewModeToggle() {
    const viewModeButtons = document.querySelectorAll('.view-mode-btn');
    const productsContainer = document.querySelector('.shop-products');
    
    if (!viewModeButtons.length || !productsContainer) return;
    
    viewModeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const viewMode = this.dataset.view;
            
            // Update button states
            viewModeButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update products container
            productsContainer.setAttribute('data-view', viewMode);
            
            // Save preference
            localStorage.setItem('shop_view_mode', viewMode);
            
            // Trigger resize event for any layout adjustments
            window.dispatchEvent(new Event('resize'));
        });
    });
    
    // Load saved preference
    const savedViewMode = localStorage.getItem('shop_view_mode');
    if (savedViewMode && productsContainer) {
        const targetButton = document.querySelector(`[data-view="${savedViewMode}"]`);
        if (targetButton) {
            targetButton.click();
        }
    }
}

/**
 * Category Filters
 */
function initCategoryFilters() {
    const categoryButtons = document.querySelectorAll('.category-filter');
    
    if (!categoryButtons.length) return;
    
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update button states
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter products
            filterProductsByCategory(category);
        });
    });
}

function filterProductsByCategory(category) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const productCategories = product.dataset.productCategories || '';
        const shouldShow = category === 'all' || productCategories.includes(category);
        
        if (shouldShow) {
            product.style.display = '';
            product.style.opacity = '0';
            product.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                product.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                product.style.opacity = '1';
                product.style.transform = 'translateY(0)';
            }, 50);
        } else {
            product.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            product.style.opacity = '0';
            product.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                product.style.display = 'none';
            }, 300);
        }
    });
    
    // Update result count
    updateResultCount();
}

function updateResultCount() {
    const visibleProducts = document.querySelectorAll('.product-card[style*="display: none"]').length;
    const totalProducts = document.querySelectorAll('.product-card').length;
    const showingProducts = totalProducts - visibleProducts;
    
    const resultCountElement = document.querySelector('.shop-result-count');
    if (resultCountElement) {
        resultCountElement.textContent = `${showingProducts} üründen ${showingProducts} tanesi gösteriliyor`;
    }
}

/**
 * Quick View Modal
 */
function initQuickView() {
    const quickViewButtons = document.querySelectorAll('.quick-view-btn');
    
    quickViewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            openQuickView(productId);
        });
    });
}

function openQuickView(productId) {
    // Show loading state
    showQuickViewModal();
    
    // In a real implementation, you would fetch product data via AJAX
    // For now, we'll show a placeholder
    setTimeout(() => {
        loadQuickViewContent(productId);
    }, 500);
}

function showQuickViewModal() {
    // Create modal if it doesn't exist
    let modal = document.getElementById('quick-view-modal');
    if (!modal) {
        modal = createQuickViewModal();
        document.body.appendChild(modal);
    }
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function createQuickViewModal() {
    const modal = document.createElement('div');
    modal.id = 'quick-view-modal';
    modal.className = 'quick-view-modal';
    modal.innerHTML = `
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="modal-close" aria-label="Kapat">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m18 6-12 12M6 6l12 12"/>
                </svg>
            </button>
            <div class="modal-body">
                <div class="quick-view-loader">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="animate-spin">
                        <path d="M21 12a9 9 0 11-6.219-8.56"/>
                    </svg>
                    <p>Ürün yükleniyor...</p>
                </div>
            </div>
        </div>
    `;
    
    // Add event listeners
    modal.querySelector('.modal-overlay').addEventListener('click', closeQuickViewModal);
    modal.querySelector('.modal-close').addEventListener('click', closeQuickViewModal);
    
    return modal;
}

function closeQuickViewModal() {
    const modal = document.getElementById('quick-view-modal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

function loadQuickViewContent(productId) {
    const modalBody = document.querySelector('#quick-view-modal .modal-body');
    if (modalBody) {
        modalBody.innerHTML = `
            <div class="quick-view-content">
                <p>Hızlı görünüm özelliği yakında eklenecek!</p>
                <p>Ürün ID: ${productId}</p>
            </div>
        `;
    }
}

/**
 * Wishlist Functionality
 */
function initWishlist() {
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    
    // Load saved wishlist on page load
    loadSavedWishlist();
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            toggleWishlist(productId, this);
        });
    });
}

function loadSavedWishlist() {
    const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
    
    wishlist.forEach(productId => {
        const button = document.querySelector(`[data-product-id="${productId}"].wishlist-btn`);
        if (button) {
            button.classList.add('in-wishlist');
            button.title = 'Favorilerden Kaldır';
        }
    });
}

function toggleWishlist(productId, button) {
    const isInWishlist = button.classList.contains('in-wishlist');
    
    // Add loading state
    button.style.transform = 'scale(0.9)';
    
    setTimeout(() => {
        if (isInWishlist) {
            // Remove from wishlist
            button.classList.remove('in-wishlist');
            button.title = 'Favorilere Ekle';
            showNotification('Favorilerden kaldırıldı', 'info');
        } else {
            // Add to wishlist
            button.classList.add('in-wishlist');
            button.title = 'Favorilerden Kaldır';
            showNotification('Favorilere eklendi ❤️', 'success');
            
            // Add bounce animation
            button.style.animation = 'wishlistBounce 0.6s ease';
            setTimeout(() => {
                button.style.animation = '';
            }, 600);
        }
        
        button.style.transform = '';
        
        // Save to localStorage
        updateWishlistStorage(productId, !isInWishlist);
    }, 150);
}

function updateWishlistStorage(productId, inWishlist) {
    let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
    
    if (inWishlist) {
        if (!wishlist.includes(productId)) {
            wishlist.push(productId);
        }
    } else {
        wishlist = wishlist.filter(id => id !== productId);
    }
    
    localStorage.setItem('wishlist', JSON.stringify(wishlist));
}

/**
 * AJAX Add to Cart
 */
function initAjaxAddToCart() {
    const addToCartButtons = document.querySelectorAll('.ajax-add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (this.classList.contains('loading') || this.classList.contains('disabled')) {
                return;
            }
            
            const productId = this.dataset.product_id;
            const quantity = this.dataset.quantity || 1;
            
            addToCartAjax(productId, quantity, this);
        });
    });
}

function addToCartAjax(productId, quantity, button) {
    // Show loading state
    button.classList.add('loading');
    
    // Simulate AJAX request (replace with actual WooCommerce AJAX)
    setTimeout(() => {
        button.classList.remove('loading');
        button.classList.add('added');
        
        const originalText = button.querySelector('.btn-text').textContent;
        button.querySelector('.btn-text').textContent = 'Eklendi!';
        
        // Show success notification
        showNotification('Ürün sepete eklendi', 'success');
        
        // Reset button after 2 seconds
        setTimeout(() => {
            button.classList.remove('added');
            button.querySelector('.btn-text').textContent = originalText;
        }, 2000);
        
        // Update cart counter (if exists)
        updateCartCounter();
        
    }, 1000);
}

/**
 * Product Hover Effects
 */
function initProductHover() {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        const image = card.querySelector('.product-image');
        const quickViewBtn = card.querySelector('.quick-view-btn');
        const wishlistBtn = card.querySelector('.wishlist-btn');
        
        card.addEventListener('mouseenter', function() {
            // Add subtle parallax effect to image
            if (image) {
                image.style.transform = 'scale(1.03) translateY(-2px)';
            }
            
            // Stagger button animations
            if (quickViewBtn) {
                setTimeout(() => {
                    quickViewBtn.style.transform = 'translateY(0) scale(1)';
                }, 50);
            }
            
            if (wishlistBtn) {
                setTimeout(() => {
                    wishlistBtn.style.transform = 'translateY(0) scale(1)';
                }, 100);
            }
        });
        
        card.addEventListener('mouseleave', function() {
            if (image) {
                image.style.transform = 'scale(1) translateY(0)';
            }
            
            // Reset buttons with stagger
            if (quickViewBtn) {
                quickViewBtn.style.transform = 'translateY(-8px) scale(0.8)';
            }
            
            if (wishlistBtn) {
                wishlistBtn.style.transform = 'translateY(-8px) scale(0.8)';
            }
        });
        
        // Add touch support for mobile
        card.addEventListener('touchstart', function() {
            this.classList.add('touch-active');
        });
        
        card.addEventListener('touchend', function() {
            setTimeout(() => {
                this.classList.remove('touch-active');
            }, 300);
        });
    });
}

/**
 * Infinite Scroll (Optional)
 */
function initInfiniteScroll() {
    const loadMoreButton = document.querySelector('.load-more-products');
    if (!loadMoreButton) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadMoreProducts();
            }
        });
    }, {
        threshold: 0.1
    });
    
    observer.observe(loadMoreButton);
}

function loadMoreProducts() {
    // Implementation for loading more products
    console.log('Loading more products...');
}

/**
 * Utility Functions
 */
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.shop-notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = `shop-notification shop-notification--${type}`;
    notification.innerHTML = `
        <span class="notification-message">${message}</span>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m18 6-12 12M6 6l12 12"/>
            </svg>
        </button>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 4000);
}

function updateCartCounter() {
    // Update cart counter in header
    const cartCounter = document.querySelector('.cart-count');
    if (cartCounter) {
        const currentCount = parseInt(cartCounter.textContent) || 0;
        cartCounter.textContent = currentCount + 1;
        
        // Add bounce animation
        cartCounter.style.transform = 'scale(1.2)';
        setTimeout(() => {
            cartCounter.style.transform = 'scale(1)';
        }, 200);
    }
}

// CSS for notifications and modal
const shopStyles = `
<style>
/* Quick View Modal */
.quick-view-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.quick-view-modal.active {
    opacity: 1;
    visibility: visible;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    max-width: 800px;
    width: 90%;
    max-height: 90%;
    overflow-y: auto;
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 10;
}

.modal-body {
    padding: 2rem;
}

.quick-view-loader {
    text-align: center;
    padding: 3rem;
    color: var(--color-text-muted);
}

.quick-view-loader svg {
    margin-bottom: 1rem;
}

/* Shop Notifications */
.shop-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 8px;
    padding: 1rem 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e5e7;
    display: flex;
    align-items: center;
    gap: 1rem;
    z-index: 9998;
    animation: slideInNotification 0.3s ease;
    max-width: 300px;
}

.shop-notification--success {
    border-left: 4px solid #10b981;
}

.shop-notification--error {
    border-left: 4px solid #ef4444;
}

.shop-notification--info {
    border-left: 4px solid #3b82f6;
}

.notification-close {
    background: none;
    border: none;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.notification-close:hover {
    opacity: 1;
}

/* Wishlist States */
.wishlist-btn.in-wishlist {
    background: var(--color-primary);
    color: white;
}

.wishlist-btn.in-wishlist svg {
    fill: currentColor;
}

/* Add to Cart States */
.add-to-cart-btn.added {
    background: #10b981;
}

/* Wishlist Animation */
@keyframes wishlistBounce {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

@keyframes slideInNotification {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
`;

// Inject styles
document.head.insertAdjacentHTML('beforeend', shopStyles);
