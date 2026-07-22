@extends('layouts.employees')

@section('title','الملف الشخصي')

@section('content')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="profile-container">

    <div class="page-header">
        <h2>
            <i class="fas fa-user-circle"></i>
            الملف الشخصي
        </h2>

        <p>
            يمكنك الاطلاع على بياناتك الوظيفية وتحديث معلومات حسابك
        </p>
    </div>

    <!-- البيانات الوظيفية -->

    <div class="profile-card">

        <div class="card-header">
            <i class="fas fa-id-badge"></i>
            البيانات الوظيفية
        </div>

        <div class="card-body">

            <div class="info-grid">

                <div class="info-item">
                    <span>الاسم الكامل</span>
                    <strong>{{ $employee->full_name }}</strong>
                </div>

                <div class="info-item">
                    <span>الرقم الوظيفي</span>
                    <strong>{{ $employee->employee_number }}</strong>
                </div>

                <div class="info-item">
                    <span>المسمى الوظيفي</span>
                    <strong>{{ $employee->job_title }}</strong>
                </div>

                <div class="info-item">
                    <span>القسم</span>
                    <strong>
                        {{ $employee->department->department_name ?? 'غير محدد' }}
                    </strong>
                </div>

                <div class="info-item">
                    <span>الحالة</span>
                    <strong>
                        {{ $employee->status == 'active' ? 'نشط' : 'موقوف' }}
                    </strong>
                </div>

            </div>

        </div>

    </div>

    <!-- بيانات الحساب -->

    <div class="profile-card">

        <div class="card-header">
            <i class="fas fa-user-lock"></i>
            بيانات الحساب
        </div>

        <div class="card-body">

            <div class="info-grid">

                <div class="info-item">
                    <span>اسم المستخدم</span>
                    <strong>{{ $user->username }}</strong>
                </div>

                <div class="info-item">
                    <span>البريد الإلكتروني</span>
                    <strong>{{ $user->email }}</strong>
                </div>

                <div class="info-item">
                    <span>رقم الهاتف</span>
                    <strong>{{ $user->phone }}</strong>
                </div>

                <div class="info-item">
                    <span>تاريخ إنشاء الحساب</span>
                    <strong>
                        {{ $user->created_at->format('Y-m-d') }}
                    </strong>
                </div>

            </div>

        </div>

    </div>

    <!-- تعديل بيانات الحساب -->

    <div class="profile-card">

        <div class="card-header">
            <i class="fas fa-user-edit"></i>
            تعديل بيانات الحساب
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- التحقق من كلمة المرور -->

            <div id="verify-section">

                <div class="input-group">

                    <label>
                        أدخل كلمة المرور الحالية للمتابعة
                    </label>

                    <input
                        type="password"
                        id="verify_password"
                        placeholder="كلمة المرور الحالية"
                    >

                </div>

                <button
                    type="button"
                    id="verifyBtn"
                    class="save-btn"
                >
                    تحقق
                </button>

            </div>

            <!-- نموذج التعديل -->

            <div
                id="updateSection"
                style="display:none;margin-top:25px;"
            >

                <form
                    id="profileForm"
                    action="{{ route('profile.update') }}"
                    method="POST"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="current_password"
                        id="hidden_current_password"
                    >

                    <div class="info-grid">

                        <div class="input-group">

                            <label>
                                اسم المستخدم
                            </label>

                            <input
                                type="text"
                                name="username"
                                value="{{ old('username',$user->username) }}"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>
                                البريد الإلكتروني الجديد
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email',$user->email) }}"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>
                                رقم الهاتف الجديد
                            </label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone',$user->phone) }}"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>
                                كلمة المرور الجديدة
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                >

                                <i
                                    class="fas fa-eye password-toggle"
                                    onclick="togglePassword('password',this)"
                                ></i>

                            </div>

                        </div>

                        <div class="input-group">

                            <label>
                                تأكيد كلمة المرور الجديدة
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                >

                                <i
                                    class="fas fa-eye password-toggle"
                                    onclick="togglePassword('password_confirmation',this)"
                                ></i>

                            </div>

                        </div>

                    </div>

                    <button
                        type="submit"
                        class="save-btn"
                    >
                        حفظ التعديلات
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script src="{{ asset('js/profile.js') }}"></script>

@endsection