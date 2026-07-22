<div class="service-section">

    <p class="official-text">

        <strong>أتقدم إلى سعادتكم بطلب</strong>

        <strong>وقف قيدي</strong>

        <strong>عن الدراسة لمدة</strong>

        <span class="inline-field">
            {{ $request->stopEnrollment->stop_period == 'semester' ? 'فصل دراسي' : 'عام دراسي' }}
        </span>

        <strong>للعام الجامعي</strong>

        <span class="inline-field">
            {{ $request->stopEnrollment->academic_year }}
        </span>

     
    </p>
    <p class="official-text" >
      <strong> راجياً من سعادتكم الاطلاع على طلبي والموافقة على وقف قيدي.
</strong> 
    </p>
<p class="official-text">

    <strong>مرفق لكم أسباب وقف القيد وهي :</strong>

    <span class="reason-inline">

        {{ $request->stopEnrollment->reason ?? '................................' }}

    </span>

</p>

</div>