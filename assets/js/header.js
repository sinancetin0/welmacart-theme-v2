/**
 * Header JavaScript Functionality
 */

class HeaderManager {
    constructor() {
        this.searchOverlay = document.querySelector('.search-overlay');
        this.searchToggle = document.querySelector('.search-toggle');
        this.searchClose = document.querySelector('.search-close');
        this.searchInput = document.querySelector('.search-input');
        this.searchResults = document.querySelector('.search-results');
        this.mobileMenu = document.querySelector('.mobile-menu');
        this.menuToggle = document.querySelector('.menu-toggle');
        this.mobileMenuClose = document.querySelector('.mobile-menu-close');
        
        this.searchTimeout = null;
        this.isSearching = false;
        
        this.init();
    }
    
    init() {
        console.log('Initializing HeaderManager');
        console.log('Search toggle:', this.searchToggle);
        console.log('Search overlay:', this.searchOverlay);
        this.bindEvents();
        this.initFeatherIcons();
    }
    
    bindEvents() {
        // Search toggle
        if (this.searchToggle && this.searchOverlay) {
            this.searchToggle.addEventListener('click', () => this.toggleSearch());
        }
        
        // Search close
        if (this.searchClose && this.searchOverlay) {
            this.searchClose.addEventListener('click', () => this.closeSearch());
        }
        
        // Search input
        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => this.handleSearchInput(e));
            this.searchInput.addEventListener('keydown', (e) => this.handleSearchKeydown(e));
        }
        
        // Mobile menu toggle
        if (this.menuToggle && this.mobileMenu) {
            this.menuToggle.addEventListener('click', () => this.toggleMobileMenu());
        }
        
        // Mobile menu close
        if (this.mobileMenuClose && this.mobileMenu) {
            this.mobileMenuClose.addEventListener('click', () => this.closeMobileMenu());
        }
        
        // ESC key closes overlays
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeSearch();
                this.closeMobileMenu();
            }
        });
        
        // Click outside closes overlays
        document.addEventListener('click', (e) => {
            if (this.searchOverlay && this.searchOverlay.classList.contains('active') && 
                !this.searchOverlay.contains(e.target) && 
                !this.searchToggle.contains(e.target)) {
                this.closeSearch();
            }
            
            if (this.mobileMenu && this.mobileMenu.classList.contains('active') && 
                !this.mobileMenu.contains(e.target) && 
                !this.menuToggle.contains(e.target)) {
                this.closeMobileMenu();
            }
        });
    }
    
    toggleSearch() {
        console.log('Search toggle clicked');
        if (this.searchOverlay.classList.contains('active')) {
            this.closeSearch();
        } else {
            this.openSearch();
        }
    }
    
    openSearch() {
        this.searchOverlay.classList.add('active');
        document.body.classList.add('search-active');
        
        // Focus search input after animation
        setTimeout(() => {
            if (this.searchInput) {
                this.searchInput.focus();
            }
        }, 300);
    }
    
    closeSearch() {
        this.searchOverlay.classList.remove('active');
        document.body.classList.remove('search-active');
    }
    
    toggleMobileMenu() {
        if (this.mobileMenu.classList.contains('active')) {
            this.closeMobileMenu();
        } else {
            this.openMobileMenu();
        }
    }
    
    openMobileMenu() {
        this.mobileMenu.classList.add('active');
        document.body.classList.add('mobile-menu-active');
    }
    
    closeMobileMenu() {
        this.mobileMenu.classList.remove('active');
        document.body.classList.remove('mobile-menu-active');
    }
    
    handleSearchInput(e) {
        const query = e.target.value.trim();
        
        // Clear previous timeout
        if (this.searchTimeout) {
            clearTimeout(this.searchTimeout);
        }
        
        // Clear results if query is empty
        if (query.length === 0) {
            this.clearSearchResults();
            return;
        }
        
        // Wait for user to stop typing
        this.searchTimeout = setTimeout(() => {
            this.performSearch(query);
        }, 300);
    }
    
    handleSearchKeydown(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const query = this.searchInput.value.trim();
            if (query.length > 0) {
                // Redirect to search results page
                window.location.href = `${window.location.origin}/?s=${encodeURIComponent(query)}&post_type=product`;
            }
        }
    }
    
    async performSearch(query) {
        if (this.isSearching || query.length < 2) return;
        
        // Check if AJAX variables are available
        if (typeof welmacartAjax === 'undefined') {
            console.error('welmacartAjax is not defined');
            this.showSearchError();
            return;
        }
        
        console.log('Performing search for:', query);
        this.isSearching = true;
        this.showSearchLoader();
        
        try {
            const formData = new FormData();
            formData.append('action', 'welmacart_live_search');
            formData.append('query', query);
            formData.append('nonce', welmacartAjax.nonce);
            
            console.log('AJAX URL:', welmacartAjax.ajax_url);
            console.log('Nonce:', welmacartAjax.nonce);
            
            const response = await fetch(welmacartAjax.ajax_url, {
                method: 'POST',
                body: formData
            });
            
            console.log('Response status:', response.status);
            const data = await response.json();
            console.log('Response data:', data);
            
            if (data.success) {
                this.displaySearchResults(data.data);
            } else {
                console.error('Search failed:', data);
                this.showSearchError();
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showSearchError();
        }
        
        this.isSearching = false;
    }
    
    displaySearchResults(results) {
        if (!this.searchResults) return;
        
        if (results.length === 0) {
            this.searchResults.innerHTML = `
                <div class="search-no-results">
                    <p>Aradığınız kriterlere uygun ürün bulunamadı.</p>
                </div>
            `;
        } else {
            const resultHtml = results.map(product => `
                <div class="search-result-item">
                    <div class="search-result-image">
                        <img src="${product.image}" alt="${product.title}" loading="lazy">
                    </div>
                    <div class="search-result-content">
                        <h4 class="search-result-title">
                            <a href="${product.url}">${product.title}</a>
                        </h4>
                        <div class="search-result-price">${product.price}</div>
                        ${product.excerpt ? `<p class="search-result-excerpt">${product.excerpt}</p>` : ''}
                    </div>
                </div>
            `).join('');
            
            this.searchResults.innerHTML = `
                <div class="search-results-list">
                    ${resultHtml}
                </div>
                <div class="search-results-footer">
                    <a href="/?s=${encodeURIComponent(this.searchInput.value)}&post_type=product" class="view-all-results">
                        Tüm Sonuçları Görüntüle (${results.length}+)
                    </a>
                </div>
            `;
        }
        
        this.searchResults.style.display = 'block';
    }
    
    showSearchLoader() {
        if (!this.searchResults) return;
        
        this.searchResults.innerHTML = `
            <div class="search-loader">
                <div class="search-loader-spinner"></div>
                <p>Aranıyor...</p>
            </div>
        `;
        this.searchResults.style.display = 'block';
    }
    
    showSearchError() {
        if (!this.searchResults) return;
        
        this.searchResults.innerHTML = `
            <div class="search-error">
                <p>Arama sırasında bir hata oluştu. Lütfen tekrar deneyin.</p>
            </div>
        `;
    }
    
    clearSearchResults() {
        if (this.searchResults) {
            this.searchResults.style.display = 'none';
            this.searchResults.innerHTML = '';
        }
    }
    
    initFeatherIcons() {
        // Feather icons'ı yeniden başlat
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }
}

// DOM yüklendiğinde başlat
document.addEventListener('DOMContentLoaded', () => {
    console.log('Header script loading...');
    console.log('welmacartAjax:', typeof welmacartAjax !== 'undefined' ? welmacartAjax : 'undefined');
    const headerManager = new HeaderManager();
    console.log('Header script loaded successfully');
});

// WooCommerce cart update için
document.addEventListener('wc_fragments_refreshed', () => {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
