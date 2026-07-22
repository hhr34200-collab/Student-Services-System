document.addEventListener('DOMContentLoaded', function () {
    let loadedCourses = [];


    const addCourseBtn = document.getElementById('addCourse');
    const coursesBody = document.getElementById('coursesBody');
    const previewBtn = document.getElementById('previewBtn');
    const previewCard = document.getElementById('previewCard');
     const semester = document.getElementById('semester');
/*
|--------------------------------------------------------------------------
| جلب المقررات عند اختيار الفصل
|--------------------------------------------------------------------------
*/

semester.addEventListener('change', function () {

    if (this.value === '') {

        return;

    }

    const year = document.getElementById('academic_year').value;

if (year === '') {

    alert('اختر العام الجامعي أولاً.');

    this.value = '';

    return;

}

fetch(
    '/appeal/courses?semester=' +
    this.value +
    '&academic_year=' +
    year
)

        .then(response => response.json())

        .then(courses => {

         loadedCourses = courses;

          document.querySelectorAll('.course-select').forEach(function (select) {

                select.innerHTML =
                    '<option value="">اختر المقرر</option>';

                courses.forEach(function (course) {

                    let teacher = '';

                    if (
                         course.assignments.length > 0 &&
                         course.assignments[0].employee
                       ) {

                         teacher =
                         course.assignments[0].employee?.full_name ?? '';

                         }

                    select.innerHTML +=

                    `<option
                        value="${course.course_id}"
                        data-teacher="${teacher}">
                        ${course.course_name}
                    </option>`;

                });

            });

        });

});
    /*
    |--------------------------------------------------------------------------
    | إضافة مقرر جديد
    |--------------------------------------------------------------------------
    */

    addCourseBtn.addEventListener('click', function () {

        let firstRow = coursesBody.querySelector('tr');

        let newRow = firstRow.cloneNode(true);

        newRow.querySelector('.course-select').selectedIndex = 0;

        newRow.querySelector('.teacher-name').value = '';

        newRow.querySelector('textarea').value = '';
        let textarea = newRow.querySelector('.reason-text');

            textarea.value = '';
           textarea.style.height = "46px";

        let newSelect = newRow.querySelector('.course-select');

newSelect.innerHTML = '<option value="">اختر المقرر</option>';

loadedCourses.forEach(function(course){

    let teacher = '';

    if (
        course.assignments &&
        course.assignments.length > 0 &&
        course.assignments[0].employee
    ) {

        teacher = course.assignments[0].employee.full_name;
    }

    newSelect.innerHTML += `
        <option
            value="${course.course_id}"
            data-teacher="${teacher}">
            ${course.course_name}
        </option>
    `;
});

coursesBody.appendChild(newRow);

    });

    /*
    |--------------------------------------------------------------------------
    | حذف مقرر
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (e) {

        if (e.target.closest('.remove-row')) {

            if (coursesBody.rows.length == 1) {

                alert('يجب أن يحتوي الطلب على مقرر واحد على الأقل.');

                return;

            }

            e.target.closest('tr').remove();

        }

    });

    /*
    |--------------------------------------------------------------------------
    | إظهار اسم المدرس
    |--------------------------------------------------------------------------
    */

    document.addEventListener('change', function (e) {

        if (e.target.classList.contains('course-select')) {

            let option =
                e.target.options[e.target.selectedIndex];

            let teacher =
                option.getAttribute('data-teacher');

            e.target
                .closest('tr')
                .querySelector('.teacher-name')
                .value = teacher ?? '';

        }

    });

    /*
    |--------------------------------------------------------------------------
    | معاينة الطلب
    |--------------------------------------------------------------------------
    */

    previewBtn.addEventListener('click', function () {

        let year =
            document.getElementById('academic_year').value;

        let semester =
            document.getElementById('semester');

        let date =
            document.getElementById('submission_date').value;
            document.getElementById("previewDate").textContent = date;

        if (

            year == '' ||

            semester.value == '' ||

            date == ''

        ) {

            alert(
                'يرجى تعبئة بيانات الطلب أولاً.'
            );

            return;

        }

        let previewCourses =
            document.getElementById('previewCourses');

        previewCourses.innerHTML = '';

        let rows =
            coursesBody.querySelectorAll('tr');

        let counter = 1;

        rows.forEach(function (row) {

            let course =
                row.querySelector('.course-select');

            let courseName =
                course.options[
                    course.selectedIndex
                ].text;

            let teacher =
                row.querySelector('.teacher-name').value;

            let reason =
                row.querySelector('textarea').value;

            previewCourses.innerHTML += `

                <tr>

                    <td>${counter}</td>

                    <td>${courseName}</td>

                    <td>${teacher}</td>

                    <td>${reason}</td>

                </tr>

            `;

            counter++;

        });

        previewCard.style.display = 'block';

          document.getElementById('submitSection').style.display = 'flex';

          previewCard.scrollIntoView({

           behavior: 'smooth'


        });

    });
    /*
    |--------------------------------------------------------------------------
    | معاينة المرفقات
    |--------------------------------------------------------------------------
    */

    const fileInput = document.querySelector(
        'input[name="attachments[]"]'
    );

    const previewAttachments =
        document.getElementById(
            'preview-attachments'
        );

    if (fileInput) {

        fileInput.addEventListener(
            'change',
            function () {

               previewAttachments.innerHTML='';

                 const section =
                 document.getElementById('attachmentsSection');

                  if(this.files.length==0){

                      section.style.display='none';

                      return;
                  }

                 section.style.display='block';

            }

        );

    }

    /*
    |--------------------------------------------------------------------------
    | منع اختيار نفس المقرر أكثر من مرة
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'change',
        function (e) {

            if (!e.target.classList.contains('course-select')) {

                return;

            }

            let selected = [];

            let duplicated = false;

            document.querySelectorAll('.course-select').forEach(function (select) {

                if (select.value == '') {

                    return;

                }

                if (selected.includes(select.value)) {

                    duplicated = true;

                }

                selected.push(select.value);

            });

            if (duplicated) {

                alert(
                    'لا يمكن اختيار نفس المقرر أكثر من مرة.'
                );

                e.target.value = '';

                e.target
                    .closest('tr')
                    .querySelector('.teacher-name')
                    .value = '';

            }

        }

    );

});
document.addEventListener("input", function (e) {

    if (!e.target.classList.contains("reason-text")) {
        return;
    }

    // العودة للحجم الأصلي أولاً
    e.target.style.height = "46px";

    // إذا كان الحقل فارغاً يبقى بالحجم الأصلي
    if (e.target.value.trim() === "") {
        return;
    }

    // يكبر حسب المحتوى
    e.target.style.height = e.target.scrollHeight + "px";

});
