<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @yield(
            'title',
            'جامعة إقليم سبأ | نظام الخدمات الطلابية'
        )
    </title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Ionicons -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @stack('styles')
<!-- القائمة الجانبية -->
<div class="navigation" id="sidebar">
    <ul>
        <li class="logo">
            <a href="{{ route('home') }}">
                <span class="icon">
                    <img src="{{ asset('images/logo.jpg') }}" alt="شعار الجامعة">
                </span>
                <span class="title">جامعة إقليم سبأ</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('home')  }}">
            <a href="{{ route('home') }}">
                <span class="icon">
                    <ion-icon name="home-outline"></ion-icon>
                </span>
                <span class="title">الرئيسية</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('services')  }}">
             <a href="{{ route('student.services') }}">
                <span class="icon">
                    <i class="fa-solid fa-book-open"></i>
                </span>
                <span class="title">الخدمات الأكاديمية</span>
            </a>
        </li>
        <li>
            <a href="{{ route('my-requests') }}">
                <span class="icon">
                    <ion-icon name="document-text-outline"></ion-icon>
                </span>
                <span class="title">طلباتي</span>
            </a>
        </li>
<li>
    <a href="{{ route('attachments') }}">
        <span class="icon">
            <i class="fas fa-folder-open"></i>
        </span>
        <span class="title">أرشيف المرفقات</span>
    </a>
</li>

       <li>
    <a href="{{ route('notifications') }}">
        <span class="icon">

            <div class="notification-icon-wrapper">

                <ion-icon name="notifications-outline"></ion-icon>

                @php
                   $unreadCount = \App\Models\Notification::where(
                       'user_id',
                       auth()->id()
                     )
                       ->where('is_read', false)
                       ->count();
                @endphp

                <span id="notificationBadge"
                      class="notification-badge"
                      style="{{ $unreadCount > 0 ? '' : 'display:none' }}">
                      {{ $unreadCount }}
                </span>

            </div>

        </span>

        <span class="title">الإشعارات</span>

    </a>
</li>
        
           
        <li>
            <a href="{{ route('profile') }}">
                <span class="icon">
                    <i class="fa-regular fa-user"></i>
                </span>
                <span class="title">الملف الشخصي</span>
            </a>
        </li>
       <li>
    <a href="{{ route('user-guide') }}">
        <span class="icon">
            <i class="fas fa-book-open-reader"></i>
        </span>
        <span class="title">دليل المستخدم</span>
    </a>
</li>
<li>
    <a href="#"
       onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
        <span class="icon">
            <i class="fas fa-right-from-bracket"></i>
        </span>
        <span class="title">تسجيل الخروج</span>
    </a>
</li>
      
    </ul>
</div>
    <!-- الجزء الرئيسي -->
    <div class="main" id="main">
        <div class="topbar">
            <div class="toggle" onclick="toggleSidebar()">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <div class="search">
                <label>
                    <h3>نظام الخدمات الطلابية</h3>
                    <h3>Student Services System</h3>
                </label>
            </div>
            <div class="user" onclick="toggleUserMenu()">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='45' r='28' fill='%23365E96'/%3E%3Ccircle cx='50' cy='85' r='30' fill='%23365E96'/%3E%3C/svg%3E" alt="User Photo">
            </div>
            <div class="user-dropdown" id="userMenu">
                <p></p>
                <a href="{{ route('profile') }}"><i class="fa-regular fa-user"></i> الملف الشخصي</a>
                <form id="logout-form"
      action="{{ route('logout') }}"
      method="POST"
      style="display:none;">
    @csrf
</form>

<a href="#"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fa-solid fa-arrow-right-from-bracket"></i>
    تسجيل الخروج
</a>
            </div>
        </div>
        
        <!-- المحتوى الديناميكي -->
        @yield('content')
        
        <!-- Footer -->
        <footer>
            <div class="footer" style="text-align: center;">
                <p>&copy; 2026 جامعة إقليم سبأ. جميع الحقوق محفوظة</p>
                <div class="footer-links">
                    <a href="#">سياسة الخصوصية</a>
                    <a href="#">شروط الاستخدام</a>
                    <a href="#">اتصل بنا</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/script.js') }}"></script>
    
    @stack('scripts')
    @stack('styles')

    <audio id="notificationSound">

    <source
        src="{{ asset('sounds/notification.mp3') }}"
        type="audio/mpeg">

    </audio>
    <script>
           window.userId = {{ auth()->id() ?? 0 }};
    </script>
   

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