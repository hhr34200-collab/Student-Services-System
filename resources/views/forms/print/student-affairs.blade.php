<table class="print-table">

    <tr>

        <th colspan="4">

            إفادة شؤون الطلاب

        </th>

    </tr>

    <tr>

        <td colspan="4" class="print-text">

            @php
                $approval = $request->approvals
                    ->where('stage','student_affairs')
                    ->first();
            @endphp

            {!! nl2br(e($approval->approval_text ?? '')) !!}

        </td>

    </tr>

    <tr>

        <td width="30%">

            الاسم :
            {{ $approval->employee->full_name ?? '______________' }}

        </td>

        <td width="25%">

            موظف شؤون الطلاب

        </td>

        <td width="20%">

            {{ optional($approval)->created_at?->format('Y-m-d') }}

        </td>

        <td width="25%">

            التوقيع :
            ____________

        </td>

    </tr>

</table>