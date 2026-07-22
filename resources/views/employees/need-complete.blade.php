@extends('layouts.employees')

@section('title','الطلبات التي تحتاج استكمال')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/employee-tables.css') }}">

@endsection


@section('content')

<div class="employee-table-page">

    {{-- عنوان الصفحة ويحتوي على الكرت في الجهة اليسرى --}}
    <div class="page-header">
        <div>
            <h2>
                <i class="fas fa-file-circle-exclamation"></i>
                الطلبات التي تحتاج استكمال
            </h2>
            <p>
                جميع الطلبات التي تحتاج إلى معالجة أو استكمال.
            </p>
        </div>

        {{-- البطاقات انتقلت إلى هنا لتصبح في اليسار تلقائياً --}}
        <div class="statistics-row">
            <div class="stat-card blue">
                <div>
                    <h3>
                        {{ $requests->count() }}
                    </h3>
                    <span>
                        إجمالي الطلبات
                    </span>
                </div>
                <i class="fas fa-folder-open"></i>
            </div>
        </div>
    </div>

    {{-- صندوق البحث --}}
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input
            type="text"
            id="tableSearch"
            placeholder="ابحث برقم الطلب أو اسم الطالب أو الخدمة ...">
    </div>

    {{-- جدول البيانات --}}
    <div class="table-card">
        <table id="requestsTable">
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>اسم الطالب</th>
                    <th>الخدمة</th>
                    <th>الموظف الحالي</th>
                    <th>الحالة</th>
                    <th>الإجراء</th>
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
                            {{ $request->currentEmployee->full_name }}
                        </td>
                        <td>
                            <span class="status-badge
                            @if($request->status=='student_affairs_review')
                                status-student
                            @elseif($request->status=='department_head_review')
                                status-department
                            @elseif($request->status=='archive_review')
                                status-archive
                            @elseif($request->status=='approved')
                                status-approved
                            @else
                                status-return
                            @endif">
                            
                            @switch($request->status)
                                @case('returned_to_student')
                                    أعيد إلى الطالب
                                    @break
                                @case('returned_to_student_affairs')
                                    أعيد إلى شؤون الطلاب
                                    @break
                                @case('returned_to_department_head')
                                    أعيد إلى رئيس القسم
                                    @break
                                @case('student_affairs_review')
                                    قيد مراجعة شؤون الطلاب
                                    @break
                                @case('department_head_review')
                                    قيد مراجعة رئيس القسم
                                    @break
                                @case('archive_review')
                                    قيد مراجعة الأرشيف
                                    @break
                                @case('approved')
                                    مؤرشف
                                    @break
                                @default
                                    {{ $request->status }}
                            @endswitch
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('employee.request.show',$request->request_id) }}" class="btn-view">
                                <i class="fas fa-eye"></i>
                                عرض
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-table">
                            لا توجد طلبات.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@section('scripts')

<script src="{{ asset('js/employee-table.js') }}"></script>

@endsection

@endsection