<div class="service-section">

    <p class="official-text">

        <strong>أتقدم إلى سعادتكم بطلب</strong>

        <strong>إعادة قيدي</strong>

        <strong>لمواصلة الدراسة بعد وقفها لمدة</strong>

        <span class="inline-field">
            {{ $request->reopenEnrollment->stop_duration }}
        </span>

        <strong>للعام الجامعي</strong>

        <span class="inline-field">
            {{ $request->reopenEnrollment->stopped_academic_year }}
        </span>

    </p>

    <p class="official-text">

        <strong>
            راجياً من سعادتكم الاطلاع على طلبي والموافقة على إعادة قيدي لاستكمال دراستي.
        </strong>

    </p>

    <p class="official-text">

        <strong>مرفق لكم أسباب طلب إعادة القيد وهي :</strong>

        <span class="reason-inline">

            {{ $request->reopenEnrollment->reason ?? '................................' }}

        </span>

    </p>

</div>