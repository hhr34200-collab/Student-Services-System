document.addEventListener('DOMContentLoaded', function () {

    const previewBtn = document.getElementById('previewBtn');

    if (!previewBtn) return;

    previewBtn.addEventListener('click', function () {

        let academicYear = document.getElementById('academic_year').value;
        let semester = document.getElementById('semester').value;
        let stopPeriod = document.getElementById('stop_period').value;
        let requestDate = document.getElementById('request_date').value;
        let reason = document.getElementById('reason').value.trim();

        // التحقق من الحقول الإلزامية

        if (
            academicYear === '' ||
            semester === '' ||
            stopPeriod === '' ||
            requestDate === '' ||
            reason === ''
        ) {

            alert('يرجى تعبئة جميع الحقول المطلوبة قبل معاينة الاستمارة');

            return;
        }

        // تعبئة بيانات المعاينة

        document.getElementById('preview-period').innerText =
            document.getElementById('stop_period')
                    .options[
                        document.getElementById('stop_period').selectedIndex
                    ].text;

        document.getElementById('preview-year2').innerText =
            academicYear;

        document.getElementById('preview-reason').innerText =
            reason;

        // عنوان الاستمارة

        const titleYear =
            document.getElementById('preview-year-title');

        if (titleYear) {
            titleYear.innerText = academicYear;
        }

        // إظهار الاستمارة

        document.getElementById('previewCard').style.display = 'block';

        // الانتقال للمعاينة

        document.getElementById('previewCard').scrollIntoView({
            behavior: 'smooth'
        });

    });

});
const fileInput = document.querySelector('input[name="attachments[]"]');
const previewAttachments = document.getElementById('preview-attachments');

fileInput.addEventListener('change', function () {

    previewAttachments.innerHTML = '';

    Array.from(this.files).forEach(file => {

        previewAttachments.innerHTML += `
            <div class="attachment-item">
                📎 ${file.name}
            </div>
        `;

    });

});