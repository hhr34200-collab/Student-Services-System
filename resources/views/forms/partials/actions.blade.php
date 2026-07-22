{{--=========================================================
                    شريط العمليات
==========================================================--}}

<div class="form-actions-container">

    {{-- حفظ الإفادة --}}
    <button
        type="button"
        class="btn-action btn-primary"
        onclick="confirmSaveApproval()">

        <i class="fas fa-save"></i>

        حفظ الإفادة

    </button>


    {{-- اعتماد وتحويل --}}
    <form
        id="approveForm"
        action="{{ route('employee.request.approve',$request->request_id) }}"
        method="POST"
        style="display:inline;">

        @csrf

        <button
            type="button"
            class="btn-action btn-success"
            onclick="confirmApprove()">

            <i class="fas fa-check-circle"></i>

            اعتماد وتحويل

        </button>

    </form>


    {{-- إعادة --}}
    <button
        type="button"
        class="btn-action btn-warning"
        onclick="openFormModal('returnModal')">

        <i class="fas fa-rotate-left"></i>

        إعادة

    </button>


    {{-- رفض --}}
    <button
        type="button"
        class="btn-action btn-danger"
        onclick="openFormModal('rejectModal')">

        <i class="fas fa-times-circle"></i>

        رفض

    </button>

   <button
    type="button"
    class="btn-action btn-secondary"
    onclick="window.location.href='{{ route('employee.dashboard') }}'">

    <i class="fas fa-arrow-right"></i>
    رجوع

</button>



</div>



{{--=========================================================
                    مودال رفض الطلب
==========================================================--}}

<div id="rejectModal" class="custom-modal-backdrop">

    <div class="custom-modal-content">

        <form
            method="POST"
            action="{{ route('employee.request.reject',$request->request_id) }}">

            @csrf

            <div class="custom-modal-header">

                <h3>

                    سبب رفض الطلب

                </h3>

                <span
                    class="close-modal-btn"
                    onclick="closeFormModal('rejectModal')">

                    &times;

                </span>

            </div>

            <div class="custom-modal-body">

                <textarea
                    name="reason"
                    class="modal-textarea"
                    rows="5"
                    placeholder="اكتب سبب رفض الطلب..."
                    required></textarea>

            </div>

            <div class="custom-modal-footer">

                <button
                    type="button"
                    class="btn-modal-cancel"
                    onclick="closeFormModal('rejectModal')">

                    إلغاء

                </button>

                <button
                    type="submit"
                    class="btn-modal-confirm btn-danger-confirm">

                    تأكيد الرفض

                </button>

            </div>

    </button>


        </form>

    </div>

</div>



{{--=========================================================
                    مودال إعادة الطلب
==========================================================--}}

<div id="returnModal" class="custom-modal-backdrop">

    <div class="custom-modal-content">

        <form
            method="POST"
            action="{{ route('employee.request.return',$request->request_id) }}">

            @csrf

            <div class="custom-modal-header">

                <h3>

                    سبب إعادة الطلب

                </h3>

                <span
                    class="close-modal-btn"
                    onclick="closeFormModal('returnModal')">

                    &times;

                </span>

            </div>

            <div class="custom-modal-body">

                <textarea
                    name="reason"
                    class="modal-textarea"
                    rows="5"
                    placeholder="اكتب سبب إعادة الطلب..."
                    required></textarea>

            </div>

            <div class="custom-modal-footer">

                <button
                    type="button"
                    class="btn-modal-cancel"
                    onclick="closeFormModal('returnModal')">

                    إلغاء

                </button>

                <button
                    type="submit"
                    class="btn-modal-confirm btn-warning-confirm">

                    تأكيد الإعادة

                </button>

            </div>

        </form>

    </div>

</div>



<script>

/*=========================================================
            فتح وإغلاق النوافذ
=========================================================*/

function openFormModal(modalId)
{
    document.getElementById(modalId).style.display = "flex";
}

function closeFormModal(modalId)
{
    document.getElementById(modalId).style.display = "none";
}

window.onclick = function(event)
{
    if(event.target.classList.contains('custom-modal-backdrop'))
    {
        event.target.style.display = "none";
    }
};


/*=========================================================
                حفظ الإفادة
=========================================================*/
function confirmSaveApproval()
{
    // نقل النص من المحرر إلى الحقل المخفي
    document.getElementById('approval_text').value =
        document.getElementById('approvalEditor').innerHTML.trim();

    Swal.fire({

        title: 'حفظ الإفادة',

        text: 'بعد حفظ الإفادة لن تتمكن من تعديلها مرة أخرى.',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'حفظ',

        cancelButtonText: 'إلغاء',

        reverseButtons: true

    }).then((result)=>{

        if(result.isConfirmed)
        {
            document.getElementById('approvalForm').submit();
        }

    });

}


/*=========================================================
            اعتماد وتحويل الطلب
=========================================================*/

function confirmApprove()
{

    Swal.fire({

        title:'اعتماد الطلب',

        text:'سيتم اعتماد الطلب وتحويله إلى المرحلة التالية.',

        icon:'question',

        showCancelButton:true,

        confirmButtonText:'اعتماد',

        cancelButtonText:'إلغاء',

        reverseButtons:true

    }).then((result)=>{

        if(result.isConfirmed)
        {

            document
                .getElementById('approveForm')
                .submit();

        }

    });

}

function goBack()
{
    window.history.back();
}
</script>