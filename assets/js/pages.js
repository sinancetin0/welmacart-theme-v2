/**
 * Style Guide Page Interactions
 * WelmaCart V2 Theme
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Tab Switching for Style Categories
    const tabButtons = document.querySelectorAll('.tab-btn');
    const styleContents = document.querySelectorAll('.style-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetCategory = this.getAttribute('data-category');
            
            // Remove active class from all tabs and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            styleContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Show corresponding content
            const targetContent = document.querySelector(`[data-category="${targetCategory}"].style-content`);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });
    
    // Video Play Button Interactions
    const playButtons = document.querySelectorAll('.play-btn');
    
    playButtons.forEach(button => {
        button.addEventListener('click', function() {
            const videoId = this.getAttribute('data-video');
            
            // Create video modal or redirect to video
            // For now, we'll just show an alert - you can implement actual video playback
            alert(`Video oynatılacak: ${videoId}`);
            
            // You can implement actual video modal here
            // openVideoModal(videoId);
        });
    });
    
    // Contact Form Handling
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const formObject = {};
            
            formData.forEach((value, key) => {
                formObject[key] = value;
            });
            
            // Basic validation
            if (!validateContactForm(formObject)) {
                return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.contact-submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>Gönderiliyor...</span>';
            submitBtn.disabled = true;
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                // Reset form
                this.reset();
                
                // Show success message
                showNotification('Mesajınız başarıyla gönderildi! En kısa sürede size dönüş yapacağız.', 'success');
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }
    
    // Form validation function
    function validateContactForm(data) {
        const errors = [];
        
        if (!data.firstName || data.firstName.trim().length < 2) {
            errors.push('Ad en az 2 karakter olmalıdır.');
        }
        
        if (!data.lastName || data.lastName.trim().length < 2) {
            errors.push('Soyad en az 2 karakter olmalıdır.');
        }
        
        if (!data.email || !isValidEmail(data.email)) {
            errors.push('Geçerli bir e-posta adresi giriniz.');
        }
        
        if (!data.subject) {
            errors.push('Lütfen bir konu seçiniz.');
        }
        
        if (!data.message || data.message.trim().length < 10) {
            errors.push('Mesaj en az 10 karakter olmalıdır.');
        }
        
        if (!data.privacy) {
            errors.push('Gizlilik politikasını kabul etmelisiniz.');
        }
        
        if (errors.length > 0) {
            showNotification(errors.join('<br>'), 'error');
            return false;
        }
        
        return true;
    }
    
    // Email validation
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Notification system
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotification = document.querySelector('.notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <div class="notification-message">${message}</div>
                <button class="notification-close">&times;</button>
            </div>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Show with animation
        setTimeout(() => notification.classList.add('show'), 100);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideNotification(notification);
        }, 5000);
        
        // Close button functionality
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => hideNotification(notification));
    }
    
    // Hide notification
    function hideNotification(notification) {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }
    
    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.value-card, .team-member, .style-card, .tip-card, .video-card, .faq-item');
    
    animateElements.forEach(el => {
        observer.observe(el);
    });
});

// Add CSS for notifications
const notificationStyles = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        border-left: 4px solid #007AFF;
        max-width: 400px;
        transform: translateX(420px);
        transition: transform 0.3s ease;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification-success {
        border-left-color: #22c55e;
    }
    
    .notification-error {
        border-left-color: #ef4444;
    }
    
    .notification-warning {
        border-left-color: #f59e0b;
    }
    
    .notification-content {
        padding: 16px 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    
    .notification-message {
        flex: 1;
        font-size: 14px;
        line-height: 1.5;
        color: #374151;
    }
    
    .notification-close {
        background: none;
        border: none;
        font-size: 20px;
        color: #9ca3af;
        cursor: pointer;
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    .notification-close:hover {
        background: #f3f4f6;
        color: #374151;
    }
    
    /* Animation classes */
    .animate-in {
        animation: slideInUp 0.6s ease forwards;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;

// Inject notification styles
const styleSheet = document.createElement('style');
styleSheet.textContent = notificationStyles;
document.head.appendChild(styleSheet);
