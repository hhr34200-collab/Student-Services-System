document.addEventListener("DOMContentLoaded", function () {

    function showAlert(type, title, message) {

        let icon = "";
        let popupClass = "";

        switch (type) {

            case "success":
                icon = "✔";
                popupClass = "success-popup";
                break;

            case "error":
                icon = "✖";
                popupClass = "error-popup";
                break;

            case "warning":
                icon = "⚠";
                popupClass = "warning-popup";
                break;

            case "info":
                icon = "ℹ";
                popupClass = "info-popup";
                break;
        }

        Swal.fire({

            html: `
            <div class="alert-card">
              <div class="alert-header">
                    <div class="alert-icon">
                      ${icon}
                    </div>
                    <div class="alert-title">
                      ${title}
                     </div>
                 </div>
                    <div class="alert-message">
                       ${message}
                    </div>
            </div>
            `,

            confirmButtonText: "حسناً",

            customClass: {
                popup: `custom-alert ${popupClass}`
            },

            showClass: {
                popup: "animate__animated animate__zoomIn"
            },

            hideClass: {
                popup: "animate__animated animate__zoomOut"
            }

        });

    }

    // تصدير الدالة للنطاق العالمي لتتمكن واجهة الـ Blade من رؤيتها واستدعائها
    window.showAlert = showAlert;

    if (window.successMessage) {
        showAlert(
            "success",
            "تمت العملية بنجاح",
            window.successMessage
        );
    }

    if (window.errorMessage) {
        showAlert(
            "error",
            "تنبيه",
            window.errorMessage
        );
    }

    if (window.warningMessage) {
        showAlert(
            "warning",
            "تحذير",
            window.warningMessage
        );
    }

    if (window.infoMessage) {
        showAlert(
            "info",
            "معلومة",
            window.infoMessage
        );
    }

    window.confirmDelete = function (url, message = "هل أنت متأكد من الحذف؟") {
        Swal.fire({

            html: `
        <div class="alert-card">
            <div class="alert-header">
                <div class="alert-icon">
                    ⚠
                </div>
                <div class="alert-title">
                    تأكيد الحذف
                </div>
            </div>
            <div class="alert-message">
                ${message}
            </div>
        </div>
        `,

            showCancelButton: true,

            confirmButtonText: "حذف",

            cancelButtonText: "إلغاء",

            reverseButtons: true,

            customClass: {
                popup: "custom-alert warning-popup"
            }

        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = url;
            }

        });

        return false;
    }

});