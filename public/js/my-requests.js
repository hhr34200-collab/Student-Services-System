/*==========================================================
    تنبيه عند محاولة الطباعة قبل اعتماد الطلب
==========================================================*/

function processingAlert() {

    alert(
        'المعاملة لا تزال قيد المعالجة ولا يمكن طباعة الاستمارة حالياً'
    );

}


/*==========================================================
    فتح نافذة تفاصيل الطلب
==========================================================*/

document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('detailsModal');

    const modalContent = document.getElementById('modalContent');

    const closeModal = document.getElementById('closeModal');


    /*
    |----------------------------------------------------------
    | عرض تفاصيل الطلب
    |----------------------------------------------------------
    */

    document.querySelectorAll('.btn-details').forEach(btn => {

        btn.addEventListener('click', function () {

            const requestId = this.dataset.id;

            fetch('/my-requests/' + requestId)

                .then(response => {

                    if (!response.ok) {

                        throw new Error(
                            'فشل في جلب البيانات'
                        );

                    }

                    return response.json();

                })

                .then(data => {

                    const serviceName =
                        data.service?.service_name ?? '';

                    switch (serviceName) {

                        /*
                        |--------------------------------------------------
                        | وقف القيد
                        |--------------------------------------------------
                        */

                        case 'وقف القيد':

                            modalContent.innerHTML =

                                data.status ===
                                'returned_to_student'

                                ?

                                stopEnrollmentCompletion(data)

                                :

                                stopEnrollmentView(data);

                        break;


                        /*
                        |--------------------------------------------------
                        | إعادة القيد
                        |--------------------------------------------------
                        */

                        case 'إعادة القيد':

                            modalContent.innerHTML =

                                data.status ===
                                'returned_to_student'

                                ?

                                reopenEnrollmentCompletion(data)

                                :

                                reopenEnrollmentView(data);

                        break;


                        /*
                        |--------------------------------------------------
                        | التظلم
                        |--------------------------------------------------
                        */

                        case 'التظلم':

                            modalContent.innerHTML =

                                data.status ===
                                'returned_to_student'

                                ?

                                appealCompletion(data)

                                :

                                appealView(data);

                        break;


                        /*
                        |--------------------------------------------------
                        | خدمة غير معروفة
                        |--------------------------------------------------
                        */

                        default:

                            modalContent.innerHTML = `

                                <div class="empty-box">

                                    لا توجد تفاصيل متاحة لهذه الخدمة.

                                </div>

                            `;

                    }

                    modal.style.display = 'block';

                })

                .catch(error => {

                    console.error(error);

                    alert(
                        'حدث خطأ أثناء جلب البيانات'
                    );

                });

        });

    });


    /*
    |----------------------------------------------------------
    | إغلاق النافذة
    |----------------------------------------------------------
    */

    closeModal.addEventListener('click', function () {

        modal.style.display = 'none';

    });

    window.addEventListener('click', function (e) {

        if (e.target === modal) {

            modal.style.display = 'none';

        }

    });

});
/*==========================================================
    واجهات عرض التفاصيل
==========================================================*/


/*==========================================================
    تفاصيل وقف القيد
==========================================================*/

function stopEnrollmentView(data) {

    const semesterMap = {

        first: 'الفصل الأول',

        second: 'الفصل الثاني'

    };

    const stopPeriodMap = {

        semester: 'فصل دراسي',

        academic_year: 'عام كامل'

    };

    return `

        <div class="detail-grid">

          

            <div class="detail-item">
                <span class="detail-label">اسم الطالب</span>
                ${data.student?.full_name ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">الرقم الجامعي</span>
                ${data.student?.student_number ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">الكلية</span>
                ${data.student?.college?.college_name ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">القسم</span>
                ${data.student?.department?.department_name ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">الخدمة</span>
                ${data.service?.service_name ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">العام الجامعي</span>
                ${data.stop_enrollment?.academic_year ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">الفصل الدراسي</span>
                ${semesterMap[data.stop_enrollment?.semester] ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">مدة الإيقاف</span>
                ${stopPeriodMap[data.stop_enrollment?.stop_period] ?? '-'}
            </div>


        </div>

        <div class="reason-box">

            <span class="detail-label">

                سبب وقف القيد

            </span>

            <div class="reason-text">

                ${data.stop_enrollment?.reason ?? '-'}

            </div>

        </div>


    `;

}


/*==========================================================
    تفاصيل إعادة القيد
==========================================================*/

function reopenEnrollmentView(data) {

    return `

        <div class="detail-grid">


            <div class="detail-item">
                <span class="detail-label">اسم الطالب</span>
                ${data.student?.full_name ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">الرقم الجامعي</span>
                ${data.student?.student_number ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">الكلية</span>
                ${data.student?.college?.college_name ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">القسم</span>
                ${data.student?.department?.department_name ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">الخدمة</span>
                ${data.service?.service_name ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">العام الجامعي</span>
                ${data.reopen_enrollment?.academic_year ?? '-'}
            </div>

            <div class="detail-item">
                <span class="detail-label">تاريخ الطلب</span>
                ${data.reopen_enrollment?.request_date ?? '-'}
            </div>

        </div>

    `;

}


/*==========================================================
    تفاصيل التظلم
==========================================================*/
function appealView(data) {

    const semesterMap = {

        first: 'الفصل الأول',

        second: 'الفصل الثاني'

    };

    let coursesHtml = '';

    if (
        data.appeal?.items &&
        data.appeal.items.length
    ) {

        data.appeal.items.forEach((item, index) => {

            coursesHtml += `

                <div class="course-card">

                    <div class="detail-item">

                        <span class="detail-label">

                            المقرر ${index + 1}

                        </span>

                        ${item.course?.course_name ?? '-'}

                    </div>

                    <div class="reason-box">

                        <span class="detail-label">

                            سبب التظلم

                        </span>

                        <div class="reason-text">

                            ${item.reason ?? '-'}

                        </div>

                    </div>

                </div>

            `;

        });

    } else {

        coursesHtml = `

            <p class="empty-text">

                لا توجد مقررات.

            </p>

        `;

    }

    return `

        <div class="detail-grid">

        

            <div class="detail-item">

                <span class="detail-label">

                    اسم الطالب

                </span>

                ${data.student?.full_name ?? '-'}

            </div>

            <div class="detail-item">

                <span class="detail-label">

                    الرقم الجامعي

                </span>

                ${data.student?.student_number ?? '-'}

            </div>

            <div class="detail-item">

                <span class="detail-label">

                    الكلية

                </span>

                ${data.student?.college?.college_name ?? '-'}

            </div>

            <div class="detail-item">

                <span class="detail-label">

                    القسم

                </span>

                ${data.student?.department?.department_name ?? '-'}

            </div>

            <div class="detail-item">

                <span class="detail-label">

                    الخدمة

                </span>

                ${data.service?.service_name ?? '-'}

            </div>

            <div class="detail-item">

                <span class="detail-label">

                    العام الجامعي

                </span>

                ${data.appeal?.academic_year ?? '-'}

            </div>

            <div class="detail-item">

                <span class="detail-label">

                    الفصل الدراسي

                </span>

                ${semesterMap[data.appeal?.semester] ?? '-'}

            </div>

            <div class="detail-item">

                <span class="detail-label">

                    تاريخ التقديم

                </span>

                ${data.appeal?.submission_date ?? '-'}

            </div>

        </div>

        <div class="attachments-box">

            <h3>

                المقررات المتظلم عليها

            </h3>

            ${coursesHtml}


    `;

}
function  stopEnrollmentCompletion(data){

    const semesterMap = {
        first: 'الفصل الأول',
        second: 'الفصل الثاني'
    };

    const stopPeriodMap = {
        semester: 'فصل دراسي',
        academic_year: 'عام كامل'
    };

    let attachmentsHtml = '';

    if (data.attachments && data.attachments.length > 0) {

        data.attachments.forEach(file => {

            attachmentsHtml += `
                <div class="attachment-item">

                    <i class="fas fa-paperclip"></i>

                    ${file.file_name}

                </div>
            `;

        });

    } else {

        attachmentsHtml =
        '<p class="empty-text">لا توجد مرفقات.</p>';

    }

    return `


<div class="reason-box">

    <span class="detail-label">

        ملاحظة الموظف

    </span>

    <div class="reason-text">

        ${data.notes ?? 'لا توجد ملاحظات'}

    </div>

</div>


<div class="reason-box">

    <span class="detail-label">

        رد الطالب

    </span>

    <textarea
        id="studentReply"
        class="reply-textarea"
        placeholder="اكتب ردك هنا...">${data.student_reply ?? ''}</textarea>

</div>




<div class="attachments-box">

    <h3>

        المرفقات الحالية

    </h3>

    ${
        data.attachments.length ?

        data.attachments.map(file => `

            <div class="attachment-item">

                <i class="fas fa-paperclip"></i>

                ${file.file_name}

            </div>

        `).join('')

        :

        '<p>لا توجد مرفقات.</p>'
    }

</div>




<div class="attachments-box">

    <h3>

        استكمال المرفقات

    </h3>

    <input

        type="file"

        id="newAttachments"

        multiple>

</div>


<div style="margin-top:20px;text-align:center;">

    <button

        class="btn-save"

        id="sendCompletion"

        data-request="${data.request_id}">

        إرسال الاستكمال

    </button>

</div>

    `;

}
function reopenEnrollmentCompletion(data){

    return `

        <div class="reason-box">

            <span class="detail-label">

                ملاحظة الموظف

            </span>

            <div class="reason-text">

                ${data.notes ?? 'لا توجد ملاحظات'}

            </div>

        </div>

        <div class="reason-box">

            <span class="detail-label">

                رد الطالب

            </span>

            <textarea
                id="studentReply"
                class="reply-textarea"
                placeholder="اكتب ردك هنا...">${data.student_reply ?? ''}</textarea>

        </div>

        <div class="attachments-box">

            <h3>

                المرفقات الحالية

            </h3>

            ${
                data.attachments.length

                ?

                data.attachments.map(file => `

                    <div class="attachment-item">

                        <i class="fas fa-paperclip"></i>

                        ${file.file_name}

                    </div>

                `).join('')

                :

                '<p>لا توجد مرفقات.</p>'
            }

        </div>

        <div class="attachments-box">

            <h3>

                استكمال المرفقات

            </h3>

            <input
                type="file"
                id="newAttachments"
                multiple>

        </div>

        <div style="margin-top:20px;text-align:center;">

            <button
                class="btn-save"
                id="sendCompletion"
                data-request="${data.request_id}">

                إرسال الاستكمال

            </button>

        </div>

    `;

}
function appealCompletion(data){

    return `

        <div class="reason-box">

            <span class="detail-label">

                ملاحظة الموظف

            </span>

            <div class="reason-text">

                ${data.notes ?? 'لا توجد ملاحظات'}

            </div>

        </div>

        <div class="reason-box">

            <span class="detail-label">

                رد الطالب

            </span>

            <textarea
                id="studentReply"
                class="reply-textarea"
                placeholder="اكتب ردك هنا...">${data.student_reply ?? ''}</textarea>

        </div>

        <div class="attachments-box">

            <h3>

                المرفقات الحالية

            </h3>

            ${
                data.attachments.length

                ?

                data.attachments.map(file => `

                    <div class="attachment-item">

                        <i class="fas fa-paperclip"></i>

                        ${file.file_name}

                    </div>

                `).join('')

                :

                '<p>لا توجد مرفقات.</p>'
            }

        </div>

        <div class="attachments-box">

            <h3>

                استكمال المرفقات

            </h3>

            <input
                type="file"
                id="newAttachments"
                multiple>

        </div>

        <div style="margin-top:20px;text-align:center;">

            <button
                class="btn-save"
                id="sendCompletion"
                data-request="${data.request_id}">

                إرسال الاستكمال

            </button>

        </div>

    `;

}



document.addEventListener('click', function (e) {

   

    if (!e.target.matches('#sendCompletion')) {

        return;

    }

   

    const requestId = e.target.dataset.request;

    const formData = new FormData();

    formData.append(

        'student_reply',

        document
            .getElementById('studentReply')
            .value

    );

    const files =

        document
            .getElementById('newAttachments')
            .files;

    for (let i = 0; i < files.length; i++) {

        formData.append(

            'attachments[]',

            files[i]

        );

    }

   
    

    fetch(

        `/my-requests/${requestId}/complete`,

        {

            method: 'POST',

            headers: {

                'X-CSRF-TOKEN':

                document
                    .querySelector(
                        'meta[name="csrf-token"]'
                    )
                    .content

            },

            body: formData

        }

    )

    .then(response => response.json())

    .then(data => {

    if (data.success) {

        document.getElementById('detailsModal').style.display = 'none';

        showAlert(
            "success",
            "تم إرسال الاستكمال",
            "تم إرسال استكمال الطلب بنجاح إلى موظف شؤون الطلاب."
        );

        setTimeout(() => {
            location.reload();
        }, 1800);

    } else {

        showAlert(
            "error",
            "تعذر الإرسال",
            data.message ?? "حدث خطأ أثناء إرسال الاستكمال."
        );

    }

})
.catch(error => {

    console.error(error);

    showAlert(
        "error",
        "خطأ",
        error.message
    );

});
});