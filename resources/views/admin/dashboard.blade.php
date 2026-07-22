@extends('layouts.admin')

@section('title','لوحة مدير النظام')

@section('styles')
<link rel="stylesheet"
href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')

<!-- بطاقة الترحيب -->



<!-- بطاقات الإحصائيات -->

<div class="stats-grid">

    <div class="stat-card students">

        <div class="stat-icon">
            <i class="fas fa-user-graduate"></i>
        </div>

        <h3>عدد الطلاب</h3>

        <h2>{{ $studentsCount }}</h2>

        <p>طالب مسجل</p>

    </div>

    <div class="stat-card employees">

        <div class="stat-icon">
            <i class="fas fa-user-tie"></i>
        </div>

        <h3>عدد الموظفين</h3>

        <h2>{{ $employeesCount }}</h2>

        <p>موظف</p>

    </div>

    <div class="stat-card requests">

        <div class="stat-icon">
            <i class="fas fa-file-alt"></i>
        </div>

        <h3>عدد الطلبات</h3>

        <h2>{{ $requestsCount }}</h2>

        <p>طلب خدمة</p>

    </div>

    <div class="stat-card services">

        <div class="stat-icon">
            <i class="fas fa-cogs"></i>
        </div>

        <h3>عدد الخدمات</h3>

        <h2>{{ $servicesCount }}</h2>

        <p>خدمة متاحة</p>

    </div>

</div>
<div class="progress-box">

    <h3>
        <i class="fas fa-chart-line"></i>
        إحصائيات الطلبات
    </h3>

    <div class="progress-item">

        <div class="progress-info">
            <span>قيد المراجعة</span>
            <span>{{ $reviewRate }}%</span>
        </div>

        <div class="progress">
            <div class="progress-fill review"
                 style="width: {{ $reviewRate }}%"></div>
        </div>

    </div>

    <div class="progress-item">

        <div class="progress-info">
            <span>تمت الموافقة</span>
            <span>{{ $approvedRate }}%</span>
        </div>

        <div class="progress">
            <div class="progress-fill approved"
                 style="width: {{ $approvedRate }}%"></div>
        </div>

    </div>

    <div class="progress-item">

        <div class="progress-info">
            <span>مرفوضة</span>
            <span>{{ $rejectedRate }}%</span>
        </div>

        <div class="progress">
            <div class="progress-fill rejected"
                 style="width: {{ $rejectedRate }}%"></div>
        </div>

    </div>

    <div class="progress-item">

        <div class="progress-info">
            <span>تحتاج استكمال</span>
            <span>{{ $returnedRate }}%</span>
        </div>

        <div class="progress">
            <div class="progress-fill returned"
                 style="width: {{ $returnedRate }}%"></div>
        </div>

    </div>

</div>
@endsection