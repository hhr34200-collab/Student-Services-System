// ======================================
// Profile Page
// ======================================

document.addEventListener(
"DOMContentLoaded",
function () {


    const verifyBtn =
        document.getElementById(
            "verifyBtn"
        );

    const verifyPassword =
        document.getElementById(
            "verify_password"
        );

    const updateSection =
        document.getElementById(
            "updateSection"
        );

    const hiddenPassword =
        document.getElementById(
            "hidden_current_password"
        );

    // ==================================
    // التحقق من كلمة المرور الحالية
    // ==================================

    if (verifyBtn) {

        verifyBtn.addEventListener(
            "click",
            function () {

                const password =
                    verifyPassword.value.trim();

                if (
                    password === ""
                ) {

                    alert(
                        "يرجى إدخال كلمة المرور الحالية"
                    );

                    return;
                }

                fetch(
                    "/profile/verify-password",
                    {
                        method: "POST",

                        headers: {

                            "Content-Type":
                                "application/json",

                            "X-CSRF-TOKEN":
                                document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                .getAttribute(
                                    "content"
                                )
                        },

                        body: JSON.stringify({

                            current_password:
                                password

                        })

                    }
                )

                .then(
                    response =>
                        response.json()
                )

                .then(data => {

                    if (
                        data.success
                    ) {

                        updateSection
                            .style.display =
                            "block";

                        hiddenPassword
                            .value =
                            password;

                        verifyPassword
                            .disabled =
                            true;

                        verifyBtn
                            .disabled =
                            true;

                        verifyBtn
                            .innerHTML =
                            "✓ تم التحقق";

                    } else {

                        alert(
                            data.message
                        );
                    }

                })

                .catch(() => {

                    alert(
                        "حدث خطأ أثناء التحقق"
                    );

                });

            }
        );
    }

    // ==================================
    // التحقق من قوة كلمة المرور الجديدة
    // ==================================

    const form =
        document.getElementById(
            "profileForm"
        );

    const passwordInput =
        document.getElementById(
            "password"
        );

    const confirmInput =
        document.getElementById(
            "password_confirmation"
        );

    if (form) {

        form.addEventListener(
            "submit",
            function (e) {

                const password =
                    passwordInput.value.trim();

                const confirm =
                    confirmInput.value.trim();

                // إذا لم يغير كلمة المرور

                if (
                    password === ""
                ) {
                    return;
                }

                if (
                    password.length < 8
                ) {

                    e.preventDefault();

                    alert(
                        "كلمة المرور يجب أن تكون 8 أحرف على الأقل"
                    );

                    return;
                }
                if (
                   !/[A-Za-z]/.test(password)
                   )
                {
                    e.preventDefault();


                   alert(
                       "يجب أن تحتوي كلمة المرور على حرف واحد على الأقل"
                    );

                    return;

                }

               if (
                   !/[0-9]/.test(password)
                  )
                {
                    e.preventDefault();


                   alert(
                         "يجب أن تحتوي كلمة المرور على رقم واحد على الأقل"
                        );

                     return;
                }


                if (
                    password !==
                    confirm
                ) {

                    e.preventDefault();

                    alert(
                        "كلمتا المرور غير متطابقتين"
                    );

                    return;
                }

            }
        );
    }

}

);
function togglePassword(fieldId, icon)
{
    const input =
        document.getElementById(fieldId);

    if (input.type === "password")
    {
        input.type = "text";

        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
    else
    {
        input.type = "password";

        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
