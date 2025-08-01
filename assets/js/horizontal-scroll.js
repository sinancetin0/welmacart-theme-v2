/**
 * Horizontal Scroll for Featured Products
 * Apple-style smooth scrolling with momentum
 */
document.addEventListener('DOMContentLoaded', function() {
    const productGrid = document.querySelector('.featured-products-grid');
    
    if (!productGrid) return;
    
    // Smooth scrolling with momentum on touch devices
    let isScrolling = false;
    let scrollPosition = 0;
    
    // Add scroll indicators (optional visual enhancement)
    function addScrollIndicators() {
        const container = productGrid.parentElement;
        
        // Check if we need scroll indicators
        if (productGrid.scrollWidth <= productGrid.clientWidth) return;
        
        const indicatorWrapper = document.createElement('div');
        indicatorWrapper.className = 'scroll-indicators';
        
        const leftIndicator = document.createElement('div');
        leftIndicator.className = 'scroll-indicator left';
        leftIndicator.innerHTML = '<i data-feather="chevron-left"></i>';
        
        const rightIndicator = document.createElement('div');
        rightIndicator.className = 'scroll-indicator right';
        rightIndicator.innerHTML = '<i data-feather="chevron-right"></i>';
        
        indicatorWrapper.appendChild(leftIndicator);
        indicatorWrapper.appendChild(rightIndicator);
        container.appendChild(indicatorWrapper);
        
        // Initialize feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        // Add click handlers
        leftIndicator.addEventListener('click', () => {
            productGrid.scrollBy({
                left: -300,
                behavior: 'smooth'
            });
        });
        
        rightIndicator.addEventListener('click', () => {
            productGrid.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        });
        
        // Update indicator visibility
        function updateIndicators() {
            const isAtStart = productGrid.scrollLeft <= 10;
            const isAtEnd = productGrid.scrollLeft >= (productGrid.scrollWidth - productGrid.clientWidth - 10);
            
            leftIndicator.style.opacity = isAtStart ? '0.3' : '1';
            rightIndicator.style.opacity = isAtEnd ? '0.3' : '1';
            leftIndicator.style.pointerEvents = isAtStart ? 'none' : 'auto';
            rightIndicator.style.pointerEvents = isAtEnd ? 'none' : 'auto';
        }
        
        productGrid.addEventListener('scroll', updateIndicators);
        updateIndicators(); // Initial call
    }
    
    // Enhanced touch scrolling for mobile
    let startX = 0;
    let scrollLeft = 0;
    let isDragging = false;
    
    productGrid.addEventListener('touchstart', (e) => {
        isDragging = true;
        startX = e.touches[0].pageX - productGrid.offsetLeft;
        scrollLeft = productGrid.scrollLeft;
        productGrid.style.scrollBehavior = 'auto';
    });
    
    productGrid.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.touches[0].pageX - productGrid.offsetLeft;
        const walk = (x - startX) * 2; // Adjust scroll speed
        productGrid.scrollLeft = scrollLeft - walk;
    });
    
    productGrid.addEventListener('touchend', () => {
        isDragging = false;
        productGrid.style.scrollBehavior = 'smooth';
    });
    
    // Mouse wheel horizontal scrolling for desktop
    productGrid.addEventListener('wheel', (e) => {
        if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return; // Already horizontal
        
        e.preventDefault();
        productGrid.scrollBy({
            left: e.deltaY > 0 ? 100 : -100,
            behavior: 'smooth'
        });
    });
    
    // Add scroll indicators on load
    addScrollIndicators();
    
    // Responsive adjustments
    function handleResize() {
        // Re-evaluate scroll indicators on resize
        const existingIndicators = productGrid.parentElement.querySelector('.scroll-indicators');
        if (existingIndicators) {
            existingIndicators.remove();
            addScrollIndicators();
        }
    }
    
    window.addEventListener('resize', debounce(handleResize, 250));
});

// Utility function for debouncing
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
