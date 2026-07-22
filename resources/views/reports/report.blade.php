@extends('layouts.admin')

@section('title','التقارير والإحصائيات')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/report.css') }}">
@endsection

@section('content')

<div class="report-header">

    <h1>
        <i class="fas fa-chart-bar"></i>
        التقارير والإحصائيات
    </h1>

    <p>
        عرض الإحصائيات العامة للنظام ومتابعة أداء الخدمات والطلبات
        والطلاب والموظفين.
    </p>

</div>

<!-- ===============================
        بطاقات الإحصائيات
================================ -->

<div class="statistics-grid">

    <!-- الطلاب -->

    <div class="stat-card">

        <div class="stat-info">

            <span>إجمالي الطلاب</span>

            <h2>{{ $studentsCount }}</h2>

        </div>

        <div class="stat-icon blue">

            <i class="fas fa-user-graduate"></i>

        </div>

    </div>

    <!-- الموظفون -->

    <div class="stat-card">

        <div class="stat-info">

            <span>إجمالي الموظفين</span>

            <h2>{{ $employeesCount }}</h2>

        </div>

        <div class="stat-icon green">

            <i class="fas fa-user-tie"></i>

        </div>

    </div>

    <!-- الخدمات -->

    <div class="stat-card">

        <div class="stat-info">

            <span>الخدمات الإلكترونية</span>

            <h2>{{ $servicesCount }}</h2>

        </div>

        <div class="stat-icon purple">

            <i class="fas fa-concierge-bell"></i>

        </div>

    </div>

    <!-- الطلبات -->

    <div class="stat-card">

        <div class="stat-info">

            <span>إجمالي الطلبات</span>

            <h2>{{ $requestsCount }}</h2>

        </div>

        <div class="stat-icon orange">

            <i class="fas fa-file-alt"></i>

        </div>

    </div>

</div>

<!-- ===============================
      إحصائيات الطلبات
================================ -->

<div class="section-title">

    <h2>
        إحصائيات الطلبات حسب الحالة
    </h2>

    <p>
        توزيع الطلبات حسب حالة المعالجة داخل النظام.
    </p>

</div>

<div class="statistics-grid">

    <div class="stat-card">

        <div class="stat-info">

            <span>قيد المراجعة</span>

            <h2>{{ $reviewCount }}</h2>

        </div>

        <div class="stat-icon blue">

            <i class="fas fa-spinner"></i>

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-info">

            <span>تمت الموافقة</span>

            <h2>{{ $approvedCount }}</h2>

        </div>

        <div class="stat-icon green">

            <i class="fas fa-check-circle"></i>

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-info">

            <span>تم رفضها</span>

            <h2>{{ $rejectedCount }}</h2>

        </div>

        <div class="stat-icon red">

            <i class="fas fa-times-circle"></i>

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-info">

            <span>تحتاج استكمال</span>

            <h2>{{ $returnedCount }}</h2>

        </div>
        

        <div class="stat-icon purple">

            <i class="fas fa-undo-alt"></i>

        </div>

    </div>

</div>
<!-- =======================================================
                مؤشرات الأداء
======================================================= -->

<div class="section-title">

    <h2>

        مؤشرات أداء النظام

    </h2>

    <p>

        نظرة سريعة على أداء الخدمات الإلكترونية.

    </p>

</div>

<div class="statistics-grid">

    <div class="stat-card">

        <div class="stat-info">

            <span>

                نسبة الإنجاز

            </span>

            <h2>

                {{ $approvalRate }}%

            </h2>

        </div>

        <div class="stat-icon green">

            <i class="fas fa-chart-line"></i>

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-info">

            <span>

                نسبة الرفض

            </span>

            <h2>

                {{ $rejectionRate }}%

            </h2>

        </div>

        <div class="stat-icon red">

            <i class="fas fa-times"></i>

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-info">

            <span>

                طلبات تحتاج متابعة

            </span>

            <h2>

                {{ $returnedRate }}%

            </h2>

        </div>

        <div class="stat-icon purple">

            <i class="fas fa-exclamation-circle"></i>

        </div>

    </div>

</div>
<!-- =======================================================
                    الرسم البياني
======================================================= -->
<div class="chart-card">

    <h3>
        <i class="fas fa-chart-pie"></i>
        الطلبات حسب الحالة
    </h3>

    <div class="chart-container">

        <canvas id="requestsChart"></canvas>

    </div>

</div>

<!-- =======================================================
                    جدول التقرير للطباعة
======================================================= -->

<div class="report-table">

    <table>

        <thead>

            <tr>

                <th>الحالة</th>

                <th>عدد الطلبات</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>قيد المراجعة</td>

                <td>{{ $reviewCount }}</td>

            </tr>

            <tr>

                <td>تمت الموافقة</td>

                <td>{{ $approvedCount }}</td>

            </tr>

            <tr>

                <td>تم رفضها</td>

                <td>{{ $rejectedCount }}</td>

            </tr>

            <tr>

                <td>تحتاج استكمال</td>

                <td>{{ $returnedCount }}</td>

            </tr>

        </tbody>

    </table>

</div>
<!-- =======================================================
            أكثر الخدمات استخداماً
======================================================= -->

<div class="section-title">

    <h2>

        أكثر الخدمات استخداماً

    </h2>

</div>

<div class="report-table">

    <table>

        <thead>

            <tr>

                <th>

                    الخدمة

                </th>

                <th>

                    عدد الطلبات

                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($topServices as $service)

                <tr>

                    <td>

                        {{ $service->service->service_name }}

                    </td>

                    <td>

                        {{ $service->total }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="2">

                        لا توجد بيانات

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<!-- =======================================================
                    الأزرار
======================================================= -->


    <div class="report-actions">

    <button
        onclick="window.print()"
        class="report-btn">

        <i class="fas fa-print"></i>
        طباعة التقرير

    </button>

    <a
        href="{{ route('admin.reports.report-pdf') }}"
        class="report-btn pdf-btn">

        <i class="fas fa-file-pdf"></i>
        تصدير PDF

    </a>

</div>

</div>
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

window.reportData = {

    review: {{ $reviewCount }},

    approved: {{ $approvedCount }},

    rejected: {{ $rejectedCount }},

    returned: {{ $returnedCount }}

};

</script>

<script src="{{ asset('js/report.js') }}"></script>

@endsection
@endsection