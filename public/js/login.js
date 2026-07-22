// تأثيرات حقول الإدخال عند التركيز
const inputs = document.querySelectorAll('.input-group input');

inputs.forEach(input => {
    input.addEventListener('focus', function () {
        this.parentElement.style.transform = 'scale(1.01)';
    });

    input.addEventListener('blur', function () {
        this.parentElement.style.transform = 'scale(1)';
    });
});

// منع إرسال النموذج أكثر من مرة
let isSubmitting = false;

const loginForm = document.getElementById("loginForm");

if (loginForm) {

    loginForm.addEventListener("submit", function (e) {

        if (isSubmitting) {
            e.preventDefault();
            return;
        }

        isSubmitting = true;

        const loginBtn = document.getElementById("loginBtn");

        if (loginBtn) {

            loginBtn.innerHTML =
                '<span class="loading"></span> جاري التحقق...';

            loginBtn.disabled = true;
        }
    });
}

// تسجيل الدخول الاجتماعي مستقبلاً
window.socialLogin = function (provider) {

    console.log(`Redirecting to social login: ${provider}`);

};