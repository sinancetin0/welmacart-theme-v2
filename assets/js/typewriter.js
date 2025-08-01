/**
 * Typewriter Animation for Story Title
 * WelmaCart Theme
 */

document.addEventListener('DOMContentLoaded', function() {
    const storyTitle = document.querySelector('.story-title');
    
    if (!storyTitle) return;
    
    const originalText = storyTitle.textContent;
    const words = ['Welma Hikayesi', 'Zarafet Hikayesi', 'Kadının Hikayesi', 'Şıklık Hikayesi'];
    let currentWordIndex = 0;
    let isAnimating = false;
    
    function typeText(text, callback) {
        if (isAnimating) return;
        isAnimating = true;
        
        storyTitle.textContent = text;
        storyTitle.style.width = '0';
        
        // Kelimenin karakter sayısına göre steps değerini ayarla
        const charCount = text.length;
        console.log(`Typing: "${text}" (${charCount} chars)`);
        storyTitle.style.setProperty('--char-count', charCount);
        storyTitle.classList.add('typing');
        
        setTimeout(() => {
            storyTitle.classList.remove('typing');
            isAnimating = false;
            if (callback) callback();
        }, 3000);
    }
    
    function eraseText(callback) {
        if (isAnimating) return;
        isAnimating = true;
        
        // Mevcut metnin karakter sayısını al
        const currentText = storyTitle.textContent;
        const charCount = currentText.length;
        console.log(`Erasing: "${currentText}" (${charCount} chars)`);
        storyTitle.style.setProperty('--char-count', charCount);
        
        storyTitle.classList.add('erasing');
        
        setTimeout(() => {
            storyTitle.classList.remove('erasing');
            isAnimating = false;
            if (callback) callback();
        }, 1500);
    }
    
    function typewriterCycle() {
        const currentWord = words[currentWordIndex];
        
        // İlk kelime ise direkt yaz, değilse önce sil
        if (currentWordIndex === 0 && storyTitle.textContent === originalText) {
            typeText(currentWord, () => {
                currentWordIndex = (currentWordIndex + 1) % words.length;
                setTimeout(typewriterCycle, 3000);
            });
        } else {
            eraseText(() => {
                typeText(currentWord, () => {
                    currentWordIndex = (currentWordIndex + 1) % words.length;
                    setTimeout(typewriterCycle, 3000);
                });
            });
        }
    }
    
    // Intersection Observer ile animasyonu başlat
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // İlk kez görünür olduğunda animasyonu başlat
                setTimeout(() => {
                    typewriterCycle();
                }, 1000);
                
                // Observer'ı durdur (sadece bir kez çalışsın)
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.7 // Element %70 görünür olduğunda tetikle
    });
    
    observer.observe(storyTitle);
    
    // Hover durumunda animasyonu yavaşlat
    let isHovered = false;
    
    storyTitle.addEventListener('mouseenter', function() {
        isHovered = true;
        this.style.animationDuration = '6s';
    });
    
    storyTitle.addEventListener('mouseleave', function() {
        isHovered = false;
        this.style.animationDuration = '3s';
    });
});
