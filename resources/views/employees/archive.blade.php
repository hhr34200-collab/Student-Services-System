@extends('layouts.employees')

@section('title','الأرشيف الإلكتروني')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/employee-tables.css') }}">

@endsection

@section('content')

<div class="employee-table-page">

    {{-- عنوان الصفحة --}}
    <div class="page-header">

        <div>

            <h2>

                <i class="fas fa-box-archive"></i>

                الأرشيف الإلكتروني

            </h2>

            <p>

                جميع الطلبات التي تم اعتمادها وأرشفتها نهائياً.

            </p>

        </div>

        {{-- البطاقة --}}
        <div class="statistics-row">

            <div class="stat-card blue">

                <div>

                    <h3>

                        {{ $requests->count() }}

                    </h3>

                    <span>

                        إجمالي المعاملات المؤرشفة

                    </span>

                </div>

                <i class="fas fa-box-archive"></i>

            </div>

        </div>

    </div>

    {{-- البحث --}}
    <div class="search-box">

        <i class="fas fa-search"></i>

        <input
            type="text"
            id="tableSearch"
            placeholder="ابحث برقم الطلب أو اسم الطالب أو الخدمة ...">

    </div>

    {{-- الجدول --}}
    <div class="table-card">

        <table id="requestsTable">

            <thead>

                <tr>

                    <th>رقم الطلب</th>

                    <th>اسم الطالب</th>

                    <th>الخدمة</th>

                    <th>تاريخ الاعتماد</th>

                    <th>الحالة</th>

                    <th>عرض</th>

                    <th>طباعة</th>

                </tr>

            </thead>

            <tbody>

                @forelse($requests as $request)

                    <tr>

                        <td>

                            {{ $request->request_number }}

                        </td>

                        <td>

                            {{ $request->student->full_name }}

                        </td>

                        <td>

                            {{ $request->service->service_name }}

                        </td>

                        <td>

                            {{ $request->approved_at
                                ? \Carbon\Carbon::parse($request->approved_at)->format('Y-m-d')
                                : '-' }}

                        </td>

                        <td>

                            <span class="status-badge status-approved">

                                مؤرشف

                            </span>

                        </td>

                        <td>

                            <a
                                href="{{ route('employee.request.show',$request->request_id) }}"
                                class="btn-view">

                                <i class="fas fa-eye"></i>

                                عرض

                            </a>

                        </td>

                        <td>

                            <a
                                href="{{ route('employee.request.print',$request->request_id) }}"
                                target="_blank"
                                class="btn-view btn-print">

                                <i class="fas fa-print"></i>

                                طباعة

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="empty-table">

                            لا توجد معاملات مؤرشفة.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- ترقيم الصفحات --}}
    <div class="pagination-wrapper">

        {{ $requests->links() }}

    </div>

</div>

@endsection

@section('scripts')

<script src="{{ asset('js/employee-table.js') }}"></script>

@endsection