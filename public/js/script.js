
// ============================================
// إدارة القائمة الجانبية
// ============================================
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main');
    
    if (sidebar && main) {
        sidebar.classList.toggle('active');
        main.classList.toggle('active');
        
        // حفظ حالة القائمة في localStorage
        const isActive = sidebar.classList.contains('active');
        localStorage.setItem('sidebarCollapsed', isActive);
        
        // تحديث حالة الـ footer
        updateFooterMargin();
    }
}

function updateFooterMargin() {
    const footer = document.querySelector('footer');
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main');
    
    if (footer && sidebar && main) {
        if (sidebar.classList.contains('active')) {
            footer.style.marginRight = '80px';
        } else if (window.innerWidth > 768) {
            footer.style.marginRight = '280px';
        } else {
            footer.style.marginRight = '0';
        }
    }
}

// استعادة حالة القائمة الجانبية
function restoreSidebarState() {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main');
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    if (sidebar && main && isCollapsed && window.innerWidth > 768) {
        sidebar.classList.add('active');
        main.classList.add('active');
    }
    
    updateFooterMargin();
}

// ============================================
// إدارة القائمة المنسدلة للمستخدم
// ============================================
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    if (menu) {
        menu.classList.toggle('show');
    }
}

// إغلاق القائمة عند النقر خارجها
document.addEventListener('click', function(event) {
    const menu = document.getElementById('userMenu');
    const userDiv = document.querySelector('.user');
    
    if (menu && userDiv && !userDiv.contains(event.target) && !menu.contains(event.target)) {
        menu.classList.remove('show');
    }
});


function playNotificationSound() {

    const audio =
        document.getElementById(
            'notificationSound'
        );

    if(audio){

        audio.play();

    }
}