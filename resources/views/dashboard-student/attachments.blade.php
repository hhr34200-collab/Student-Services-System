@extends('layouts.app')

@section('title','أرشيف المرفقات ')

@section('content')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<div class="profile-container">

    <div class="page-header">
        <h2>
            <i class="fas fa-paperclip"></i>
            أرشيف المرفقات
        </h2>

        <p>
            جميع الملفات والمرفقات التي قمت برفعها مع طلباتك
        </p>
    </div>


    <!-- أرشيف المرفقات -->

    <div class="profile-card">

        <div class="card-header">
            <i class="fas fa-paperclip"></i>
            أرشيف المرفقات
        </div>

        <div class="table-wrapper">

            <table class="profile-table">

                <thead>

                <tr>

                    <th>اسم الملف</th>

                    <th>النوع</th>

                    <th>الخدمة</th>

                    <th>التاريخ</th>

                    <th>تحميل</th>

                </tr>

                </thead>

                <tbody>

                @forelse($attachments as $file)

                    <tr>

                        <td>{{ $file->file_name }}</td>

                        <td>{{ strtoupper($file->file_type) }}</td>

                        <td>
                            {{ $file->request->service->service_name }}
                        </td>

                        <td>
                            {{ $file->created_at->format('Y-m-d') }}
                        </td>

                        <td>
                <div class="file-actions">

                         <a
                               href="{{ asset('storage/'.$file->file_path) }}"
                               target="_blank"
                               class="view-btn"
                               title="عرض"
                         >
                              <i class="fas fa-eye"></i>
                         </a>

                         <a
                               href="{{ asset('storage/'.$file->file_path) }}"
                               download
                               class="download-btn"
                               title="تحميل"
                         >
                                <i class="fas fa-download"></i>
                         </a>

                </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5">
                            لا توجد مرفقات
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
<script src="{{ asset('js/profile.js') }}"></script>

@endsection