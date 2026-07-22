// دالة إظهار/إخفاء كلمة المرور
function togglePassword(fieldId, icon) {

    const input = document.getElementById(fieldId);

    if (!input) return;

    if (input.type === "password") {

        input.type = "text";

        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");

    } else {

        input.type = "password";

        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

// التحقق من قوة كلمة المرور
function checkPasswordStrength(password) {

    const rules = {
        length: password.length >= 8,
        number: /[0-9]/.test(password),
        letter: /[a-z]/.test(password) && /[A-Z]/.test(password)
    };

    const ruleLength = document.getElementById("ruleLength");
    const ruleNumber = document.getElementById("ruleNumber");
    const ruleLetter = document.getElementById("ruleLetter");

    if (ruleLength) {
        ruleLength.className =
            "strength-rule" + (rules.length ? " valid" : "");
    }

    if (ruleNumber) {
        ruleNumber.className =
            "strength-rule" + (rules.number ? " valid" : "");
    }

    if (ruleLetter) {
        ruleLetter.className =
            "strength-rule" + (rules.letter ? " valid" : "");
    }

    return rules.length && rules.number && rules.letter;
}

// عرض رسالة
function showMessage(text, isError = false) {

    const messageDiv = document.getElementById("message");

    if (!messageDiv) return;

    messageDiv.style.display = "block";

    messageDiv.innerHTML =
        `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${text}`;

    messageDiv.className =
        `message ${isError ? 'error' : 'success'}`;

    setTimeout(() => {

        messageDiv.style.display = "none";
        messageDiv.className = "message";

    }, 4000);
}

// مراقبة قوة كلمة المرور أثناء الكتابة
const passwordInput = document.getElementById("password");

if (passwordInput) {

    passwordInput.addEventListener("input", function () {

        checkPasswordStrength(this.value);

    });
}
const studentNumberInput =
document.getElementById('studentId');

if(studentNumberInput){

    studentNumberInput.addEventListener(
        'blur',
        function(){

            const studentNumber = this.value;

            if(studentNumber === '')
                return;

            fetch('/get-student-data',{

                method:'POST',

                headers:{
                    'Content-Type':'application/json',

                    'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                },

                body:JSON.stringify({
                    student_number:studentNumber
                })

            })

            .then(response => response.json())

            .then(data => {

                if(data.success){

                    document.getElementById(
                        'studentInfo'
                    ).style.display='block';

                    document.getElementById(
                        'studentName'
                    ).textContent=data.full_name;

                    document.getElementById(
                        'studentCollege'
                    ).textContent=data.college;

                    document.getElementById(
                        'studentDepartment'
                    ).textContent=data.department;

                    document.getElementById(
                        'studentLevel'
                    ).textContent=data.level;

                }else{

                    document.getElementById(
                        'studentInfo'
                    ).style.display='none';

                    alert(
                        'الرقم الأكاديمي غير موجود'
                    );
                }

            });

        }
    );
}