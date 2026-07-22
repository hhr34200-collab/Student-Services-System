<div class="print-approval-section">

    @php

        $approval = $request->approvals
            ->where('stage','dean')
            ->first();

    @endphp

    <div class="print-approval-title">

        اعتماد عميد الكلية

    </div>

    <div class="print-approval-body">

        {!! nl2br(e($approval->approval_text ?? '')) !!}

    </div>

    <div class="print-approval-footer">

        <span>

            الاسم :

            {{ $approval->employee->full_name ?? '_____________' }}

        </span>

        <span>

            عميد الكلية

        </span>

        <span>

            {{ optional($approval)->created_at?->format('Y-m-d') ?? '_____________' }}

        </span>

        <span>

            التوقيع :

            _______________

        </span>

    </div>

</div>