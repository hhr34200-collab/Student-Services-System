@php
    $department = $request->approvals
        ->where('stage','department_head')
        ->first();

    $dean = $request->approvals
        ->where('stage','dean')
        ->first();
@endphp

<table class="print-table">

<tr>

    <th colspan="2">

        رأي عمادة الكلية

    </th>

</tr>

<tr>

    <th>

        رئيس القسم

    </th>

    <th>

        عميد الكلية

    </th>

</tr>

<tr>

<td class="print-text">

{!! nl2br(e($department->approval_text ?? '')) !!}

</td>

<td class="print-text">

{!! nl2br(e($dean->approval_text ?? '')) !!}

</td>

</tr>

<tr>

<td>

الاسم :

{{ $department->employee->full_name ?? '_____________' }}

<br><br>

التاريخ :

{{ optional($department)->created_at?->format('Y-m-d') }}

<br><br>

التوقيع :

_____________

</td>

<td>

الاسم :

{{ $dean->employee->full_name ?? '_____________' }}

<br><br>

التاريخ :

{{ optional($dean)->created_at?->format('Y-m-d') }}

<br><br>

التوقيع :

_____________

</td>

</tr>

</table>