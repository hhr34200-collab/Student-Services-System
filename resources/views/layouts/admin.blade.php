<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
          <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet"
          href="{{ asset('css/admin.css') }}">
          <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">

    @yield('styles')

</head>

<body>

<div class="admin-layout">

    <!-- القائمة الجانبية -->

    <aside class="sidebar">

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

        <ul class="sidebar-menu">

            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-house"></i>
                    <span>الرئيسية</span>
                </a>
            </li>

            <li>
              <a href="{{ route('students.index') }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>إدارة الطلاب</span>
                </a>
            </li>

            <li>
               <a href="{{ route('employees.index') }}">
                    <i class="fas fa-user-tie"></i>
                    <span>إدارة الموظفين</span>
                </a>
            </li>

            <li>
                <a href="{{ route('services.index') }}">
                    <i class="fas fa-cogs"></i>
                    <span>إدارة الخدمات</span>
                </a>
            </li>

            <li>
                <a href="{{ route('requests.index') }}">
                    <i class="fas fa-file-lines"></i>
                    <span>إدارة الطلبات</span>
                </a>
            </li>

          
            <!--
|--------------------------------------------------------------------------
| إدارة الكليات
|--------------------------------------------------------------------------
-->

<li>

    <a href="{{ route('colleges.index') }}">

        <i class="fas fa-building-columns"></i>

        <span>

            إدارة الكليات

        </span>

    </a>

</li>
<!--
|--------------------------------------------------------------------------
| إدارة الأقسام
|--------------------------------------------------------------------------
-->

<li>

    <a href="{{ route('departments.index') }}">

        <i class="fas fa-sitemap"></i>

        <span>

            إدارة الأقسام

        </span>

    </a>

</li>

  <li>

    <a href="{{ route('courses.index') }}">

        <i class="fas fa-book"></i>

        <span>

            إدارة المقررات

        </span>

    </a>

</li>

    </li>

       <li>

    <a href="{{ route('course-assignments.index') }}">

        <i class="fas fa-chalkboard-teacher"></i>

        <span>

            توزيع المقررات

        </span>

    </a>

    </li>

       <li>
   
       <a href="{{ route('admin.reports') }}">
        <i class="fas fa-chart-bar"></i>
        <span>التقارير</span>
            </a>
           </li>

           <li>
                <a href="#">
                    <i class="fas fa-bell"></i>
                    <span>الإشعارات</span>
                </a>
            </li>

            <li>
                <a href="/settings">
                    <i class="fas fa-gear"></i>
                    <span>الإعدادات</span>
                </a>
            </li>

      <li>

    <form action="{{ route('logout') }}" method="POST" class="logout-form">

        @csrf

        <button type="submit" class="logout-btn">

            <i class="fas fa-right-from-bracket"></i>

            <span>تسجيل الخروج</span>

        </button>

    </form>

</li>
     

        </ul>

    </aside>

    <!-- المحتوى -->

    <main class="main-content">

        <!-- الشريط العلوي -->

       <div class="topbar">

    <!-- معلومات المدير -->

    <div class="admin-profile">

        <img
            src="{{ asset('images/logo.jpg') }}"
            class="profile-img">

        <div class="profile-info">

            <h4>مدير النظام</h4>

            <span>Administrator</span>

        </div>

    </div>

    <!-- عنوان الصفحة -->

    <div class="page-title">

        <i class="fas fa-user-shield"></i>

        <span>لوحة مدير النظام</span>

    </div>

    <!-- الأزرار -->

    <div class="topbar-left">

        <button class="icon-btn">
            <i class="fas fa-envelope"></i>
        </button>

        <button class="icon-btn">
            <i class="fas fa-bell"></i>
        </button>

        <button class="icon-btn">
            <i class="fas fa-gear"></i>
        </button>

    </div>

</div>

        <!-- محتوى الصفحات -->

        <div class="page-content">

            @yield('content')

        </div>

    </main>

</div>

<script src="{{ asset('js/admin.js') }}"></script>

@yield('scripts')

    <script>
       window.successMessage = @json(session('success'));
       window.errorMessage = @json(session('error'));
       window.warningMessage = @json(session('warning'));
       window.infoMessage = @json(session('info'));
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>