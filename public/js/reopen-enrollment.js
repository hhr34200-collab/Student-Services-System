document.addEventListener('DOMContentLoaded', function () {

    const previewBtn =
        document.getElementById('previewBtn');

    if (!previewBtn) return;

    previewBtn.addEventListener('click', function () {

        const academicYear =
            document.getElementById('academic_year').value;

        const requestDate =
            document.getElementById('request_date').value;

        if (
            academicYear === '' ||
            requestDate === ''
        ) {

            alert(
                'يرجى تعبئة جميع الحقول المطلوبة قبل معاينة الاستمارة'
            );

            return;
        }

        // تعبئة العام الجامعي داخل الاستمارة

        const previewYear =
            document.getElementById('preview-year');

        if (previewYear) {

            previewYear.innerText =
                academicYear;
        }

        // تعبئة عنوان الاستمارة

        const previewYearTitle =
            document.getElementById('preview-year-title');

        if (previewYearTitle) {

            previewYearTitle.innerText =
                academicYear;
        }

        // إظهار بطاقة المعاينة

        document.getElementById(
            'previewCard'
        ).style.display = 'block';

        // الانتقال إليها

        document.getElementById(
            'previewCard'
        ).scrollIntoView({
            behavior: 'smooth'
        });

    });

});

/*
|--------------------------------------------------------------------------
| معاينة المرفقات
|--------------------------------------------------------------------------
*/

const fileInput =
document.querySelector(
    'input[name="attachments[]"]'
);

const previewAttachments =
document.getElementById(
    'preview-attachments'
);

if (fileInput && previewAttachments) {

    fileInput.addEventListener(
        'change',
        function () {

            previewAttachments.innerHTML = '';

            Array.from(this.files)
                .forEach(file => {

                    previewAttachments.innerHTML += `
                        <div class="attachment-item">
                            📎 ${file.name}
                        </div>
                    `;

                });

        }
    );

}