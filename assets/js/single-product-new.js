/**
 * Single Product Gallery & Interactions - Apple Style
 * Feminine and elegant interactions for Welma scarves
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize gallery functionality
    initializeGallery();
    
    // Initialize quantity controls
    initializeQuantityControls();
    
    // Initialize add to cart enhancements
    initializeAddToCart();
    
    // Initialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

function initializeGallery() {
    const mainImage = document.getElementById('main-product-image');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    if (!mainImage || thumbnails.length === 0) return;
    
    // Thumbnail click functionality
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', function() {
            const largeImageUrl = this.dataset.large;
            
            if (largeImageUrl && mainImage) {
                // Remove active class from all thumbnails
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Smooth transition effect
                mainImage.style.opacity = '0.7';
                mainImage.style.transform = 'scale(0.98)';
                
                setTimeout(() => {
                    // Update main image
                    mainImage.src = largeImageUrl;
                    mainImage.alt = this.alt;
                    
                    // Restore image
                    mainImage.style.opacity = '1';
                    mainImage.style.transform = 'scale(1)';
                }, 200);
            }
        });
        
        // Keyboard navigation
        thumbnail.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
}

function initializeQuantityControls() {
    const quantityInputs = document.querySelectorAll('.qty, input[name*="quantity"]');
    
    quantityInputs.forEach(function(input) {
        if (input.closest('.quantity-controls')) return; // Already processed
        
        const quantityDiv = input.closest('.quantity');
        if (!quantityDiv) return;
        
        // Create wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'quantity-controls';
        
        // Create minus button
        const minusBtn = document.createElement('button');
        minusBtn.type = 'button';
        minusBtn.className = 'quantity-btn minus-btn';
        minusBtn.innerHTML = '−';
        minusBtn.setAttribute('aria-label', 'Decrease quantity');
        
        // Create plus button
        const plusBtn = document.createElement('button');
        plusBtn.type = 'button';
        plusBtn.className = 'quantity-btn plus-btn';
        plusBtn.innerHTML = '+';
        plusBtn.setAttribute('aria-label', 'Increase quantity');
        
        // Wrap the input
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(minusBtn);
        wrapper.appendChild(input);
        wrapper.appendChild(plusBtn);
        
        // Get min and max values
        const min = parseInt(input.getAttribute('min')) || 1;
        const max = parseInt(input.getAttribute('max')) || 999;
        
        // Minus button functionality
        minusBtn.addEventListener('click', function() {
            const currentValue = parseInt(input.value) || min;
            if (currentValue > min) {
                input.value = currentValue - 1;
                triggerChange(input);
            }
        });
        
        // Plus button functionality
        plusBtn.addEventListener('click', function() {
            const currentValue = parseInt(input.value) || min;
            if (currentValue < max) {
                input.value = currentValue + 1;
                triggerChange(input);
            }
        });
        
        // Input validation
        input.addEventListener('change', function() {
            let value = parseInt(this.value) || min;
            if (value < min) value = min;
            if (value > max) value = max;
            this.value = value;
        });
        
        function triggerChange(input) {
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        }
    });
}

function initializeAddToCart() {
    const addToCartBtn = document.querySelector('.single_add_to_cart_button');
    const wishlistBtn = document.querySelector('.wishlist-btn');
    
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(e) {
            // Add ripple effect
            createRipple(e, this);
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i data-feather="loader" style="animation: spin 1s linear infinite;"></i> Adding...';
            this.disabled = true;
            
            // Re-enable after a delay (WooCommerce will handle the actual submission)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }, 2000);
        });
    }
    
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function(e) {
            createRipple(e, this);
            
            // Toggle wishlist state
            const icon = this.querySelector('i');
            const span = this.querySelector('span');
            
            if (this.classList.contains('added')) {
                this.classList.remove('added');
                this.style.background = 'transparent';
                this.style.color = '#007AFF';
                span.textContent = 'Add to Wishlist';
            } else {
                this.classList.add('added');
                this.style.background = '#007AFF';
                this.style.color = 'white';
                span.textContent = 'Added to Wishlist';
            }
        });
    }
}

function createRipple(event, button) {
    const circle = document.createElement('span');
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;
    
    const rect = button.getBoundingClientRect();
    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - rect.left - radius}px`;
    circle.style.top = `${event.clientY - rect.top - radius}px`;
    circle.classList.add('ripple');
    
    const ripple = button.querySelector('.ripple');
    if (ripple) {
        ripple.remove();
    }
    
    button.appendChild(circle);
}

// CSS for spinning loader animation
const style = document.createElement('style');
style.textContent = `
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
`;
document.head.appendChild(style);
