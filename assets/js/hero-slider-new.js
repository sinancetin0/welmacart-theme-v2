class HeroSlider {
    constructor(element) {
        // Elements
        this.slider = element;
        this.slides = Array.from(this.slider.querySelectorAll('.hero-slide'));
        
        // State
        this.current = 0;
        this.isAnimating = false;
        this.autoplayInterval = null;
        
        // Configuration
        this.autoplayDelay = 5000; // 5 seconds between slides
        
        // Initialize
        this.init();
    }
    
    init() {
        // Create navigation if more than one slide
        if (this.slides.length > 1) {
            this.createNavigation();
            this.createDots();
            this.startAutoplay();
            
            // Add event listeners for hover
            this.slider.addEventListener('mouseenter', () => this.stopAutoplay());
            this.slider.addEventListener('mouseleave', () => this.startAutoplay());
        }
        
        // Show first slide
        this.showSlide(0);
    }
    
    createNavigation() {
        // Create navigation container
        const nav = document.createElement('div');
        nav.className = 'hero-navigation';
        
        // Previous button
        const prev = document.createElement('button');
        prev.className = 'prev-slide';
        prev.setAttribute('aria-label', 'Önceki');
        prev.innerHTML = '<i data-feather="chevron-left"></i>';
        prev.addEventListener('click', () => this.prevSlide());
        
        // Next button
        const next = document.createElement('button');
        next.className = 'next-slide';
        next.setAttribute('aria-label', 'Sonraki');
        next.innerHTML = '<i data-feather="chevron-right"></i>';
        next.addEventListener('click', () => this.nextSlide());
        
        nav.appendChild(prev);
        nav.appendChild(next);
        this.slider.appendChild(nav);
        
        // Feather icons'ları yenile
        setTimeout(() => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }, 100);
    }
    
    createDots() {
        // Create dots container
        const dots = document.createElement('div');
        dots.className = 'hero-dots';
        
        // Create dot for each slide
        this.slides.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.className = 'hero-dot';
            dot.addEventListener('click', () => this.showSlide(index));
            dots.appendChild(dot);
        });
        
        this.slider.appendChild(dots);
        this.dots = Array.from(dots.children);
    }
    
    showSlide(index) {
        if (this.isAnimating) return;
        this.isAnimating = true;
        
        // Remove active class from current slide and dot
        this.slides[this.current].classList.remove('active');
        if (this.dots) this.dots[this.current].classList.remove('active');
        
        // Update current index
        this.current = index;
        
        // Add active class to new slide and dot
        this.slides[this.current].classList.add('active');
        if (this.dots) this.dots[this.current].classList.add('active');
        
        // Reset animation flag after transition
        setTimeout(() => {
            this.isAnimating = false;
        }, 800); // Match this with the CSS transition duration
    }
    
    nextSlide() {
        const next = (this.current + 1) % this.slides.length;
        this.showSlide(next);
    }
    
    prevSlide() {
        const prev = (this.current - 1 + this.slides.length) % this.slides.length;
        this.showSlide(prev);
    }
    
    startAutoplay() {
        if (this.autoplayInterval) return;
        this.autoplayInterval = setInterval(() => this.nextSlide(), this.autoplayDelay);
    }
    
    stopAutoplay() {
        if (!this.autoplayInterval) return;
        clearInterval(this.autoplayInterval);
        this.autoplayInterval = null;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Feather icons'ları başlat
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // Hero slider'ları başlat
    const sliders = document.querySelectorAll('.hero-slider');
    sliders.forEach(slider => {
        new HeroSlider(slider);
    });
});
