@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')

<!-- الرسالة الترحيبية -->
<div class="welcome-container">
    <div class="welcome-card">

        <div class="university-logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="شعار الجامعة">
        </div>

        <h2>مرحباً بك في نظام الخدمات الطلابية</h2>

        <p class="welcome-description">
            منصة متكاملة تتيح لك تقديم جميع الخدمات الطلابية إلكترونياً بكل سهولة ويسر
        </p>

        <div class="services-highlight">
            <div class="highlight-item">
                <i class="fas fa-file-alt"></i>
                <span>تقديم الطلبات</span>
            </div>

            <div class="highlight-item">
                <i class="fas fa-chart-line"></i>
                <span>متابعة الحالة</span>
            </div>

            <div class="highlight-item">
                <i class="fas fa-bell"></i>
                <span>إشعارات فورية</span>
            </div>

        </div>

    </div>
</div>

@endsection