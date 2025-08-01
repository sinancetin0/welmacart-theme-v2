/**
 * Single Product Gallery - Apple Style Interactions
 * Feminine and elegant image gallery for Welma scarves
 */
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.querySelector('.main-product-image img');
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    
    if (!mainImage || thumbnails.length === 0) return;
    
    // Thumbnail click functionality
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', function() {
            const imageId = this.dataset.imageId;
            const thumbnailImg = this.querySelector('img');
            
            if (thumbnailImg && mainImage) {
                // Remove active class from all thumbnails
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Smooth transition effect
                mainImage.style.opacity = '0.7';
                mainImage.style.transform = 'scale(0.98)';
                
                setTimeout(() => {
                    // Update main image
                    mainImage.src = thumbnailImg.src.replace('-150x150', '-1024x1024');
                    mainImage.alt = thumbnailImg.alt;
                    
                    // Restore image
                    mainImage.style.opacity = '1';
                    mainImage.style.transform = 'scale(1)';
                }, 200);
            }
        });
        
        // Add hover effects
        thumbnail.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'scale(1.05)';
                this.style.opacity = '0.8';
            }
        });
        
        thumbnail.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'scale(1)';
                this.style.opacity = '1';
            }
        });
    });
    
    // Set first thumbnail as active by default
    if (thumbnails[0]) {
        thumbnails[0].classList.add('active');
    }
    
    // Image zoom on hover for main image
    const mainImageContainer = document.querySelector('.main-product-image');
    if (mainImageContainer && mainImage) {
        mainImageContainer.addEventListener('mouseenter', function() {
            mainImage.style.transform = 'scale(1.02)';
        });
        
        mainImageContainer.addEventListener('mouseleave', function() {
            mainImage.style.transform = 'scale(1)';
        });
    }
    
    // Smooth scroll for product features
    const features = document.querySelectorAll('.feature-item');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '50px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    features.forEach((feature, index) => {
        feature.style.opacity = '0';
        feature.style.transform = 'translateY(20px)';
        feature.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(feature);
    });
    
    // Enhanced add to cart button
    const addToCartButton = document.querySelector('.single_add_to_cart_button');
    if (addToCartButton) {
        // Add loading state functionality
        addToCartButton.addEventListener('click', function() {
            if (!this.classList.contains('loading')) {
                this.classList.add('loading');
                this.innerHTML = '<span>Sepete Ekleniyor...</span>';
                
                // Reset after 2 seconds (you might want to listen for actual WooCommerce events)
                setTimeout(() => {
                    this.classList.remove('loading');
                    this.innerHTML = 'Sepete Ekle';
                }, 2000);
            }
        });
        
        // Ripple effect on click
        addToCartButton.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }
    
    // Smooth scrolling for product tabs
    const tabLinks = document.querySelectorAll('.woocommerce-tabs .wc-tabs a');
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Initialize Feather Icons for product features
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

// CSS for ripple effect
const style = document.createElement('style');
style.textContent = `
    .single_add_to_cart_button {
        position: relative;
        overflow: hidden;
    }
    
    .single_add_to_cart_button .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .single_add_to_cart_button.loading {
        opacity: 0.8;
        cursor: not-allowed;
    }
`;
document.head.appendChild(style);
