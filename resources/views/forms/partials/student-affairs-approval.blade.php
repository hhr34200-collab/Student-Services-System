<div class="approval-section">

    <div class="approval-title">

        إفادة شؤون الطلاب

    </div>

    <div class="approval-content">

        @php

            $studentAffairsApproval =
                $request->approvals
                    ->where('stage','student_affairs')
                    ->first();

        @endphp

        @if($canWriteStudentAffairs && !$studentAffairsApproval)

            <form
               id="approvalForm"
              action="{{ route('employee.request.saveApproval',$request->request_id) }}"
                 method="POST">
                @csrf

              <input
    type="hidden"
    name="approval_text"
    id="approval_text">

<div
    id="approvalEditor"
    class="approval-editor"
    contenteditable="true"
    data-placeholder="اكتب إفادة شؤون الطلاب هنا...">
</div>

            </form>

        @elseif($studentAffairsApproval)

<div class="approval-view">{{ ltrim($studentAffairsApproval->approval_text) }}</div>
        @else

           <p class="approval-text">

    ............................................................

</p>
            

        @endif


    </div>

    <div class="approval-footer">

        <div>

          <strong>الاسم :</strong>  

          {{ optional($studentAffairsApproval?->employee)->full_name ?? '_____________' }}

        </div>

        <div>

        

       <strong> موظف شؤون الطلاب
</strong>    
        </div>

        <div>

           <strong>التاريخ :</strong> 

           {{ optional($studentAffairsApproval)->approved_at?->format('Y-m-d') ?? '_____________' }}

        </div>

        <div>

          
<strong>  التوقيع :</strong>
            __________________

        </div>

    </div>

</div>
<hr class="approval-divider">