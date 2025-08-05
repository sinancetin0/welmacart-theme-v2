/**
 * Footer Newsletter Functionality
 */

// 🚀 GitHub Actions Deployment Test - v1.0
console.log('🎯 WelmaCarte Theme Footer Script Loaded Successfully!');
console.log('📅 Deployment Date:', new Date().toLocaleString('tr-TR'));
console.log('🔧 GitHub Actions Auto-Deployment Working!');

document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.querySelector('.newsletter-form');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('.newsletter-input');
            const submitButton = this.querySelector('.newsletter-button');
            const email = emailInput.value.trim();
            
            // Basic email validation
            if (!isValidEmail(email)) {
                showNotification('Lütfen geçerli bir e-posta adresi girin.', 'error');
                return;
            }
            
            // Disable button and show loading
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="animate-spin">
                    <path d="M21 12a9 9 0 11-6.219-8.56"/>
                </svg>
            `;
            
            // Simulate API call (replace with actual newsletter subscription)
            setTimeout(() => {
                // Reset button
                submitButton.disabled = false;
                submitButton.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                `;
                
                // Clear input and show success
                emailInput.value = '';
                showNotification('Başarılı! Bültenimize kaydoldunuz.', 'success');
                
                // You can add actual AJAX call here
                // Example:
                // fetch('/wp-admin/admin-ajax.php', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/x-www-form-urlencoded',
                //     },
                //     body: new URLSearchParams({
                //         action: 'newsletter_subscribe',
                //         email: email,
                //         nonce: welmacart_ajax.nonce
                //     })
                // })
                // .then(response => response.json())
                // .then(data => {
                //     if (data.success) {
                //         showNotification('Başarılı! Bültenimize kaydoldunuz.', 'success');
                //         emailInput.value = '';
                //     } else {
                //         showNotification(data.message || 'Bir hata oluştu.', 'error');
                //     }
                // })
                // .catch(error => {
                //     showNotification('Bağlantı hatası. Lütfen tekrar deneyin.', 'error');
                // });
                
            }, 1500);
        });
    }
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.newsletter-notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = `newsletter-notification newsletter-notification--${type}`;
    notification.innerHTML = `
        <span class="notification-message">${message}</span>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m18 6-12 12M6 6l12 12"/>
            </svg>
        </button>
    `;
    
    // Add to newsletter section
    const newsletterSection = document.querySelector('.footer-newsletter');
    if (newsletterSection) {
        newsletterSection.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }
}

// Add CSS for notifications and animations
const notificationStyles = `
<style>
.newsletter-notification {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--space-sm) var(--space-md);
    border-radius: 8px;
    font-size: 0.8rem;
    margin-top: var(--space-sm);
    animation: slideInNotification 0.3s ease;
}

.newsletter-notification--success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.newsletter-notification--error {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.newsletter-notification--info {
    background-color: #dbeafe;
    color: #1e40af;
    border: 1px solid #93c5fd;
}

.notification-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 2px;
    border-radius: 4px;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.notification-close:hover {
    opacity: 1;
}

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

@keyframes slideInNotification {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
`;

// Inject styles
document.head.insertAdjacentHTML('beforeend', notificationStyles);
