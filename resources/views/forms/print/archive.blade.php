@php

$archive = $request->approvals
    ->where('stage','archive')
    ->first();

@endphp

<table class="print-table">

<tr>

<th>

اعتماد قسم الأرشيف

</th>

</tr>

<tr>

<td class="print-text">

{!! nl2br(e($archive->approval_text ?? '')) !!}

</td>

</tr>

<tr>

<td>

الاسم :

{{ $archive->employee->full_name ?? '_____________' }}

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

رئيس قسم الأرشيف

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

التاريخ :

{{ optional($archive)->created_at?->format('Y-m-d') }}

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

التوقيع :

_____________

</td>

</tr>

</table>