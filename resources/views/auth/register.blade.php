<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>إنشاء حساب | جامعة إقليم سبأ</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<div class="floating-shapes">
    <div class="shape" style="width:150px;height:150px;top:10%;left:-50px;animation-duration:25s;"></div>
    <div class="shape" style="width:80px;height:80px;bottom:15%;right:-30px;animation-duration:18s;"></div>
    <div class="shape" style="width:200px;height:200px;top:60%;left:20%;animation-duration:30s;"></div>
</div>

<div class="register-wrapper">

    <div class="register-card">

        <div class="logo-section">
            <div class="logo-image">
                <img src="{{ asset('images/logo.jpg') }}" alt="جامعة إقليم سبأ">
            </div>

            <h1>جامعة إقليم سبأ</h1>
            <p>إنشاء حساب جديد في النظام</p>
        </div>

        @if(session('success'))
            <div class="message success" style="display:block;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="message error" style="display:block;">
                {{ $errors->first() }}
            </div>
        @endif

        <div id="message" class="message"></div>

        <form id="registerForm"
            method="POST"
            action="{{ route('register.store') }}"
            autocomplete="off">
            @csrf

            <div class="form-grid">

{{-- الرقم الأكاديمي --}}
<div class="input-group">
    <i class="fas fa-id-card"></i>

    <input type="text"
           id="studentId"
           name="student_number"
           placeholder="الرقم الأكاديمي"
           autocomplete="off"
           required>
</div>

{{-- اسم المستخدم --}}
<div class="input-group">
    <i class="fas fa-user"></i>

    <input type="text"
       id="username"
       name="username"
       placeholder="اسم المستخدم"
       autocomplete="new-username"
       required>
</div>
@error('username')
<div class="message error" style="display:block;">
    {{ $message }}
</div>
@enderror

@error('student_number')
<div class="message error" style="display:block;">
    {{ $message }}
</div>
@enderror
{{-- البريد الإلكتروني --}}
<div class="input-group">
    <i class="fas fa-envelope"></i>

    <input type="email"
           id="email"
           name="email"
           placeholder="البريد الإلكتروني"
           autocomplete="new-email"
           required>
</div>

{{-- الهاتف --}}
<div class="input-group">
    <i class="fas fa-phone"></i>

    <input type="tel"
           id="phone"
           name="phone"
           placeholder="رقم الهاتف"
           autocomplete="off"
           required>
</div>
@error('phone')
<div class="message error" style="display:block;">
    {{ $message }}
</div>
@enderror
               <div id="studentInfo" class="student-info" style="display:none;">

                <div class="info-item">
                   <strong>الاسم:</strong>
                   <span id="studentName"></span>
                 </div>

                 <div class="info-item">
                   <strong>الكلية:</strong>
                    <span id="studentCollege"></span>
                 </div>

                  <div class="info-item">
                     <strong>القسم:</strong>
                     <span id="studentDepartment"></span>
                  </div>

                  <div class="info-item">
                     <strong>المستوى:</strong>
                    <span id="studentLevel"></span>
                 </div>

            </div>

                @error('student_number')
                <div class="message error" style="display:block;">
                    {{ $message }}
                </div>
                @enderror


                {{-- كلمة المرور --}}
                <div class="input-group full-width">
                    <i class="fas fa-lock"></i>

                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="كلمة المرور"
                           required>

                    <i class="fas fa-eye toggle-password"
                       onclick="togglePassword('password', this)">
                    </i>
                </div>

                @error('password')
                <div class="message error" style="display:block;">
                    {{ $message }}
                </div>
                @enderror

                {{-- تأكيد كلمة المرور --}}
                <div class="input-group full-width">
                    <i class="fas fa-lock"></i>

                    <input type="password"
                           id="confirmPassword"
                           name="password_confirmation"
                           placeholder="تأكيد كلمة المرور"
                           required>

                    <i class="fas fa-eye toggle-password"
                       onclick="togglePassword('confirmPassword', this)">
                    </i>
                </div>

            </div>

            <div class="password-strength" id="passwordRules">

                <div class="strength-rule" id="ruleLength">
                    <i class="fas fa-circle"></i>
                    <span>8 أحرف على الأقل</span>
                </div>

                <div class="strength-rule" id="ruleNumber">
                    <i class="fas fa-circle"></i>
                    <span>رقم واحد على الأقل</span>
                </div>

                <div class="strength-rule" id="ruleLetter">
                    <i class="fas fa-circle"></i>
                    <span>حرف كبير وحرف صغير</span>
                </div>

            </div>

            <button type="submit"
                    class="register-btn"
                    id="registerBtn">

                <i class="fas fa-user-plus"></i>
                <span>إنشاء حساب</span>

            </button>

        </form>

        <div class="divider">
            <span>لديك حساب بالفعل؟</span>
        </div>

        <div class="login-link">
            <a href="{{ url('/') }}">
                تسجيل الدخول إلى حسابك
            </a>
        </div>

        <div style="text-align:center;margin-top:16px;font-size:11px;color:#94a3b8;">
            <i class="fas fa-shield-alt"></i>
            جميع البيانات محفوظة | جامعة إقليم سبأ
        </div>

    </div>

</div>

<script src="{{ asset('js/register.js') }}"></script>

</body>
</html>