<div class="approval-section">

    <div class="approval-title">
        رأي رئيس القسم
    </div>

    <div class="approval-content">

        @php
            $approval = $request->approvals
                ->where('stage','department_head')
                ->first();
        @endphp

        @if($canWriteDepartmentHead && !$approval)

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
                    data-placeholder="اكتب رأي رئيس القسم هنا...">
                </div>

            </form>

        @elseif($approval)

            <div class="approval-view">
                {{ ltrim($approval->approval_text) }}
            </div>
@else

<div class="approval-view">&nbsp;</div>
@endif

    </div>

    <div class="approval-footer">

        <div>
            <strong>الاسم :</strong>
            {{ $approval->employee->full_name ?? '_____________' }}
        </div>

        <div>
            <strong>رئيس القسم</strong>
        </div>

        <div>
            <strong>التاريخ :</strong>
            {{ optional($approval)->approved_at?->format('Y-m-d') ?? now()->format('Y-m-d') }}
        </div>

        <div>
            <strong>التوقيع :</strong>
            __________________
        </div>

    </div>

</div>

<hr class="approval-divider">