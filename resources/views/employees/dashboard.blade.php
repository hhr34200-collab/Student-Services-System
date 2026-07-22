@extends('layouts.employees')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="employee-page">


    <div class="page-header">

        <h1>
            لوحة الموظف
        </h1>

        <p>
            {{ $employee->full_name }}
            |
            {{ $employee->job_title }}
        </p>

    </div>


    <!-- الكروت -->
    <div class="cards">

        <div class="info-card">

            <h3>
                الطلبات الواردة
            </h3>

            <span>
                {{ $requests->count() }}
            </span>

        </div>


        <div class="info-card">

            <h3>
                قيد المراجعة
            </h3>

            <span>
                {{ $requests->where('status','!=','approved')->count() }}
            </span>

        </div>


        <div class="info-card">

            <h3>
                المكتملة
            </h3>

            <span>
                {{ $requests->where('status','approved')->count() }}
            </span>

        </div>

    </div>



    <!-- جدول الطلبات -->

    <div class="table-box">

        <table>

            <thead>

            <tr>

                <th>رقم الطلب</th>

                <th>الطالب</th>

                <th>الخدمة</th>

                <th>الحالة</th>

                <th>العمليات</th>

            </tr>

            </thead>


            <tbody>

            @foreach($requests as $request)

            <tr>


                <td>
                    {{ $request->request_number }}
                </td>


                <td>
                    {{ $request->student->full_name ?? '-' }}
                </td>


                <td>
                    {{ $request->service->service_name ?? '-' }}
                </td>


                <td>
                    {{ $request->status_name}}
                </td>


                <td>

    <a href="{{ route('employee.request.show', $request->request_id) }}"
   class="btn-show">
    عرض
</a>
                </td>


            </tr>

            @endforeach


            </tbody>

        </table>

    </div>


</div>


@endsection