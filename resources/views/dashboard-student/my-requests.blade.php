@extends('layouts.app')

@section('title','طلباتي')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link rel="stylesheet"
      href="{{ asset('css/my-requests.css') }}">

<div class="stop-container">

    <div class="page-header">

        <div class="header-content">

            <div class="header-icon">
                <i class="fas fa-file-alt"></i>
            </div>

            <div>
                <h1>طلباتي</h1>
                <p>جميع الطلبات التي قمت بإرسالها</p>
            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-title">
            قائمة الطلبات
        </div>

        @if($requests->count())

        <div class="table-responsive">

            <table class="requests-table">

                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>الرقم الأكاديمي</th>
                        <th>الخدمة</th>
                        <th>تاريخ الإرسال</th>
                        <th>الحالة</th>
                        <th>التفاصيل</th>
                        <th>الطباعة</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($requests as $request)

                    <tr>

                        <td>{{ $request->request_id }}</td>

                        <td>
                            {{ $request->student->student_number }}
                        </td>

                        <td>
                            {{ $request->service->service_name }}
                        </td>

                        <td>
                            {{ $request->created_at->format('Y-m-d') }}
                        </td>

                        <td>

                            @switch($request->status)

                                @case('submitted')
                                    <span class="badge warning">تم الإرسال</span>
                                @break

                                @case('student_affairs_review')
                                    <span class="badge orange">قيد المراجعة</span>
                                @break

                                @case('department_head_review')
                                    <span class="badge blue">رئيس القسم</span>
                                @break

                                @case('dean_review')
                                    <span class="badge purple">العميد</span>
                                @break

                                @case('approved')
                                    <span class="badge success">تمت الموافقة</span>
                                @break

                                @case('rejected')
                                    <span class="badge danger">مرفوض</span>
                                @break
                                @case('returned_to_student')
                                        <span class="badge warning">مطلوب استكمال</span>

                                @break

                            @endswitch

                        </td>

                        <td>

                            <button
                                class="btn-details"
                                data-id="{{ $request->request_id }}">

                                عرض

                            </button>

                        </td>

                        <td>

                            @if($request->status == 'approved')

                                <a href="{{ route('my-requests.print',$request->request_id) }}"
                                   class="btn-print">

                                    طباعة

                                </a>

                            @else

                                <button
                                    class="btn-disabled"
                                    onclick="processingAlert()">

                                    طباعة

                                </button>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

        @else

            <div class="empty-box">
                لا توجد طلبات مرسلة حالياً
            </div>

        @endif

    </div>

</div>

<div id="detailsModal" class="modal">

    <div class="modal-box">

        <div class="modal-header">

            <h2>تفاصيل الطلب</h2>

            <span id="closeModal">
                <i class="fas fa-xmark"></i>
            </span>

        </div>

        <div id="modalContent"></div>

    </div>

</div>

<script src="{{ asset('js/my-requests.js') }}"></script>

@endsection