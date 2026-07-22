<header class="official-header">

    <div class="header-top">

        <!-- العربية -->
        <div class="header-ar">
            <div>الجمهورية اليمنية</div>
            <div>جامعة إقليم سبأ</div>
            <div>نيابة رئيس الجامعة لشؤون الطلاب</div>
            <div>{{ optional($request->student->college)->college_name }}</div>
        </div>

        <!-- الوسط -->
        <div class="header-middle">

            <div class="basmala">
                بسم الله الرحمن الرحيم
            </div>

            <img src="{{ asset('images/logo.jpg') }}"
                 class="preview-logo"
                 alt="logo">
                 
<div class="service-title">
    استمارة {{ $request->service->service_name }}
    <span class="academic-year-inline">
        ({{ $request->stopEnrollment->academic_year ?? '' }})
    </span>
</div>

        </div>

        <!-- الإنجليزية -->
        <div class="header-en">
            <div>Republic Of Yemen</div>
            <div>Sheba Region University</div>
            <div>Vice Presidency for Student Affairs</div>
            <div>Faculty of Information Technology and Computer Science</div>
        </div>

    </div>

    <hr class="header-divider">

    <div class="request-info">

        <div>
            <strong>رقم الطلب :</strong>
            {{ $request->request_number }}
        </div>

        <div>
            <strong>تاريخ الطلب :</strong>
            {{ optional($request->created_at)->format('Y-m-d') }}
        </div>

    </div>
     <p class="dean-title">
        الأستاذ الدكتور / عميد الكلية
        <span class="dean-space"></span>
        المحترم
    </p>

    <div class="greeting-center">
        تحية طيبة،، وبعد:
    </div>

</header>