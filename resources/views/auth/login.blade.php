<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | جامعة إقليم سبأ</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="floating-shapes">
    <div class="shape shape1"></div>
    <div class="shape shape2"></div>
    <div class="shape shape3"></div>
</div>

<div class="login-wrapper">

    <div class="login-card">

        <div class="logo-section">

            <div class="logo-image">
                <img src="{{ asset('images/logo.jpg') }}" alt="جامعة إقليم سبأ">
            </div>

            <h1>جامعة إقليم سبأ</h1>
            <p>بوابة الخدمات الطلابية</p>

        </div>

        @if(session('success'))
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login.submit') }}">

            @csrf

            <div class="input-group">
                <i class="fas fa-user"></i>

                
           <input type="text"
                  name="username"
                  placeholder="اسم المستخدم أو البريد الإلكتروني"
                  value="{{ old('username') }}"
                  required
                  autocomplete="username">


            </div>

            @error('username')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group">
                <i class="fas fa-lock"></i>

                <input type="password"
                       name="password"
                       placeholder="كلمة المرور"
                       required>
            </div>

            @error('password')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

            <div class="options">

                <label class="checkbox">
                    <input type="checkbox" name="remember">
                    <span>تذكرني</span>
                </label>

                <a href="javascript:void(0)" class="forgot-link">
                    نسيت كلمة المرور؟
                </a>

            </div>

            <button type="submit"
                    class="login-btn"
                    id="loginBtn">

                <i class="fas fa-sign-in-alt"></i>

                <span>تسجيل الدخول</span>

            </button>

        </form>

        <div class="divider">
            <span>أو</span>
        </div>

        <div class="social-login">

            <div class="social-btn">
                <i class="fab fa-google"></i>
            </div>

            <div class="social-btn">
                <i class="fab fa-microsoft"></i>
            </div>

            <div class="social-btn">
                <i class="fab fa-apple"></i>
            </div>

        </div>

        <div class="register-link">
            ليس لديك حساب؟
            <a href="{{ route('register') }}">
                إنشاء حساب جديد
            </a>
        </div>

        <div class="footer-note">
            <i class="fas fa-shield-alt"></i>
            نظام آمن | جامعة إقليم سبأ
        </div>

    </div>

</div>

<script src="{{ asset('js/login.js') }}"></script>

</body>
</html>