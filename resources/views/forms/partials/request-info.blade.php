<div class="service-section">

    <p class="service-paragraph">

        أتقدم إلى سعادتكم بطلب

        <strong>وقف قيدي</strong>

        عن الدراسة لمدة

        <span class="inline-field">

            {{ $request->stopEnrollment->stop_period ?? '____________' }}

        </span>

        خلال الفصل الدراسي

        {{

    $request->stopEnrollment->semester == 'first'

        ? 'الفصل الأول'

        : 'الفصل الثاني'

}}

        للعام الجامعي

        <span class="inline-field">

            {{ $request->stopEnrollment->academic_year ?? '____________' }}

        </span>.

    </p>

    <p class="service-paragraph">

        راجياً من سعادتكم الاطلاع على طلبي والموافقة على وقف قيدي.

    </p>

    <p class="service-paragraph">

        ومرفق لكم أسباب وقف القيد وهي:

    </p>

    <div class="reason-box">

        {{ $request->stopEnrollment->reason ?? 'لا توجد أسباب.' }}

    </div>

</div>