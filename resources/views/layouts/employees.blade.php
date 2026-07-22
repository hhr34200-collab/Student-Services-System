<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    {{-- ==========================================================
        معلومات الصفحة
        ==========================================================
        يتم تحديد الترميز ودعم اللغة العربية
        كما يتم ربط ملفات CSS العامة الخاصة بالموظف.
    =========================================================== --}}

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>@yield('title','لوحة الموظف')</title>

    {{-- ==========================================================
        أيقونات Font Awesome
    =========================================================== --}}

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- ==========================================================
        ملف تنسيق الهيكل العام للموظف
        يحتوي على:
        - القائمة الجانبية
        - الشريط العلوي
        - توزيع الصفحة
    =========================================================== --}}

    <link rel="stylesheet"
          href="{{ asset('css/employee-layout.css') }}">

    {{-- ==========================================================
        يسمح لكل صفحة بإضافة CSS خاص بها
    =========================================================== --}}

    @yield('styles')

</head>

<body>

{{-- ==========================================================
    بداية واجهة الموظف
========================================================== --}}

<div class="employee-layout">
{{-- ==========================================================
    القائمة الجانبية للموظف
    ==========================================================
    تحتوي على جميع الصفحات التي يستطيع الموظف الوصول إليها
    حسب صلاحياته.
========================================================== --}}

<aside class="sidebar">

    {{-- ======================================================
        شعار الجامعة واسم النظام
    ======================================================= --}}

    <div class="sidebar-header">

        <img
            src="{{ asset('images/logo.jpg') }}"
            alt="شعار الجامعة"
            class="logo">

        <h2>
            جامعة إقليم سبأ
        </h2>

        <p>
            نظام الخدمات الطلابية
        </p>

    </div>

    {{-- ======================================================
        عناصر القائمة الجانبية
    ======================================================= --}}

    <ul class="sidebar-menu">

        {{-- ==============================================
            الصفحة الرئيسية للموظف
        =============================================== --}}

        <li>

            <a href="{{ route('employee.dashboard') }}">

                <i class="fas fa-house"></i>

                <span>

                    لوحة الموظف

                </span>

            </a>

        </li>

        {{-- ==============================================
            الطلبات التي ما زالت قيد المراجعة
        =============================================== --}}

       <li>

    <a href="{{ route('employee.review') }}">

        <i class="fas fa-clock"></i>

        <span>

            قيد المراجعة

        </span>

    </a>

</li>

        {{-- ==============================================
            الطلبات التي طلب الموظف استكمالها
        =============================================== --}}

        <li>
                  <a href="{{ route('employee.need-complete') }}">

                <i class="fas fa-file-circle-exclamation"></i>

                <span>

                    تحتاج استكمال

                </span>

            </a>

        </li>

        {{-- ==============================================
            الطلبات التي انتهى الموظف من معالجتها
        =============================================== --}}

        <li>

          <a href="{{ route('employee.archive') }}">

                <i class="fas fa-circle-check"></i>

                <span>

                  الأرشيف الإلكتروني

                </span>

            </a>

        </li>

        {{-- ==============================================
            صفحة الإشعارات
        =============================================== --}}

        <li>

    <a href="{{ route('employee.notifications') }}">

        <i class="fas fa-bell"></i>

        <span>

            الإشعارات

        </span>

    </a>

     </li>

        {{-- ==============================================
            الملف الشخصي
        =============================================== --}}
<li>
    <a href="{{ route('employee.profile') }}">

        <i class="fas fa-user"></i>

        <span>
            الملف الشخصي
        </span>

    </a>
</li>
<li>

    <form
        action="{{ route('logout') }}"
        method="POST"
        id="logoutForm"
    >
        @csrf

        <button
            type="submit"
            class="menu-link logout-link"
        >

            <i class="fas fa-sign-out-alt"></i>

            <span>
                تسجيل الخروج
            </span>

        </button>

    </form>

</li>

    </ul>

    {{-- ======================================================
        زر تسجيل الخروج
        وضعناه أسفل القائمة لأنه عملية مستقلة
        عن التنقل داخل النظام.
    ======================================================= --}}

   
</aside>

    {{-- ==========================================================
        المحتوى الرئيسي
========================================================== --}}

    <main class="main-content">

        {{-- ======================================================
            الشريط العلوي
            سيتم تصميمه بعد الانتهاء من القائمة الجانبية
        ======================================================= --}}

       {{-- ==========================================================
    الشريط العلوي للموظف
    ==========================================================
    يحتوي على عنوان الصفحة، بيانات الموظف، وجرس الإشعارات.
========================================================== --}}

<header class="topbar">

    {{-- ======================================================
        عنوان الصفحة ورسالة ترحيبية
    ======================================================= --}}

    <div class="page-title">

        <h2>

            لوحة الموظف

        </h2>

        <p>

            مرحباً بك

            <strong>

                {{ auth()->user()->employee->full_name }}

            </strong>

        </p>

    </div>


    {{-- ======================================================
        أدوات الشريط العلوي
    ======================================================= --}}

    <div class="topbar-tools">


        {{-- ==============================================
            جرس الإشعارات
            سيتم ربطه لاحقاً بالإشعارات الفورية
        =============================================== --}}
      <div class="notification-box">

    <button
        class="icon-btn"
        id="notificationBtn">

        <i class="fas fa-bell"></i>

        <span class="notification-count">

            {{ \App\Models\Notification::where('user_id',auth()->id())->where('is_read',false)->count() }}

        </span>

    </button>


    <div
        class="notification-dropdown"
        id="notificationDropdown">

        @php

            $lastNotifications =
            \App\Models\Notification::where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->take(5)
            ->get();

        @endphp


        @forelse($lastNotifications as $notification)

            <a
                href="{{ $notification->action_url ?? route('employee.notifications') }}"
                class="dropdown-item">

                <strong>

                    {{ $notification->title }}

                </strong>

                <small>

                    {{ $notification->message }}

                </small>

            </a>

        @empty

            <div class="dropdown-empty">

                لا توجد إشعارات

            </div>

        @endforelse


        <a
            href="{{ route('employee.notifications') }}"
            class="view-all">

            عرض جميع الإشعارات

        </a>

    </div>

</div>


        {{-- ==============================================
            معلومات الموظف الحالي
        =============================================== --}}

        <div class="employee-info">

            <img
                src="{{ asset('images/logo.jpg') }}"
                alt="صورة الموظف"
                class="profile-img">


            <div>

                <h4>

                    {{ auth()->user()->employee->full_name }}

                </h4>

                <span>

                    {{ auth()->user()->employee->job_title }}

                </span>

            </div>

        </div>

    </div>

</header>

        {{-- ======================================================
            محتوى الصفحة
            أي صفحة تستخدم هذا Layout
            سيتم عرضها هنا تلقائياً.
        ======================================================= --}}

        <div class="page-content">

            @yield('content')

        </div>

    </main>

</div>

<script>

const notificationBtn =
document.getElementById("notificationBtn");

const notificationDropdown =
document.getElementById("notificationDropdown");

if(notificationBtn){

    notificationBtn.onclick=function(e){

        e.stopPropagation();

        notificationDropdown.classList.toggle("show");

    }

    document.onclick=function(e){

        if(!notificationDropdown.contains(e.target)){

            notificationDropdown.classList.remove("show");

        }

    }

}

</script>
@yield('scripts')

</body>

</html>