/*============================================================================
   Premium User Guide Engine - Modular RTL Framework
============================================================================*/

document.addEventListener("DOMContentLoaded", function () {
    initScrollProgressBar();
    initStatsCounter();
    initScrollToTop();
    initCardsStaggerDelay();
});

/**
 * 1. شريط تتبع مدى تقدم القراءة والتمرير العلوي
 */
function initScrollProgressBar() {
    const progressBar = document.getElementById("scroll-progress");
    if (!progressBar) return;

    window.addEventListener("scroll", function () {
        const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrollPercent = (scrollTop / scrollHeight) * 100;
        progressBar.style.width = scrollPercent + "%";
    });
}

/**
 * 2. محرك الأكورديون الطولي مع الإغلاق الذاتي للبطاقات الأخرى لمنع الازدحام
 */
function toggleCard(currentCard) {
    const allCards = document.querySelectorAll(".premium-card");
    
    allCards.forEach(card => {
        // إذا كانت هناك بطاقة أخرى مفتوحة، يتم إغلاقها تلقائياً
        if (card !== currentCard && card.classList.contains("active")) {
            card.classList.remove("active");
        }
    });
    
    currentCard.classList.toggle("active");
}

/**
 * 3. عداد الأرقام الإحصائية التفاعلي من (0) إلى الهدف المحدد
 */
function initStatsCounter() {
    const counters = document.querySelectorAll(".stat-numbers h3");
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute("data-target"), 10);
        let current = 0;
        const steps = 25; // عدد الخطوات الانتقالية للحركة
        const increment = target / steps;
        
        const updateCounter = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.innerText = target + (target === 25 ? "+" : ""); // إضافة إشارة + لأعلى قيمة إرشادية
                clearInterval(updateCounter);
            } else {
                counter.innerText = Math.floor(current);
            }
        }, 30);
    });
}

/**
 * 4. مراقبة التمرير لإظهار/إخفاء زر العودة الذكي للأعلى
 */
function initScrollToTop() {
    const topButton = document.getElementById("scroll-to-top");
    if (!topButton) return;

    window.addEventListener("scroll", () => {
        if (window.scrollY > 350) {
            topButton.classList.add("reveal");
        } else {
            topButton.classList.remove("reveal");
        }
    });

    topButton.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
}

/**
 * 5. محاكي الـ Stagger لتوزيع أوقات ظهور البطاقات تدريجياً وبشكل متتابع
 */
function initCardsStaggerDelay() {
    const cards = document.querySelectorAll(".premium-card");
    cards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.08) + "s";
    });
}