@extends('layouts.app')

@section('title', 'طلب تظلم')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@400;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/appeal.css') }}">

<div class="stop-container">

    <!-- رأس الصفحة -->

    <div class="page-header">

        <div class="header-content">

            <div class="header-icon">

                <i class="fas fa-file-signature"></i>

            </div>

            <div>

                <h1>طلب تظلم</h1>

                <p>نظام الخدمات الطلابية</p>

            </div>

        </div>

    </div>
    

    <form action="{{ route('appeal.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <!-- بيانات الطالب -->

        <div class="card">

            <div class="card-title">

                بيانات الطالب

            </div>

            <div class="grid">

                <div class="field">

                    <label>اسم الطالب</label>

                    <input type="text"
                           value="{{ $student->full_name }}"
                           readonly>

                </div>

                <div class="field">

                    <label>الرقم الجامعي</label>

                    <input type="text"
                           value="{{ $student->student_number }}"
                           readonly>

                </div>

                <div class="field">

                    <label>الكلية</label>

                    <input type="text"
                           value="{{ $student->college->college_name ?? '' }}"
                           readonly>

                </div>

                <div class="field">

                    <label>القسم</label>

                    <input type="text"
                           value="{{ $student->department->department_name ?? '' }}"
                           readonly>

                </div>

                <div class="field">

                    <label>المستوى</label>

                    <input type="text"
                           value="{{ $student->level }}"
                           readonly>

                </div>

            </div>

        </div>

        <!-- بيانات الطلب -->

        <div class="card">

            <div class="card-title">

                بيانات طلب التظلم

            </div>

            <div class="grid">

                <div class="field">

                    <label>

                        العام الجامعي

                    </label>

                    <select
                        name="academic_year"
                        id="academic_year"
                        required>

                        <option value="">

                            اختر العام الجامعي

                        </option>

                        @php

                            $currentYear = date('Y');

                            for($i = 0; $i <= 3; $i++) {

                                $start = $currentYear + $i;

                                $end = $start + 1;

                                echo "<option value='{$start}/{$end}'>{$start}/{$end}</option>";

                            }

                        @endphp

                    </select>

                </div>

                <div class="field">

                    <label>

                        الفصل الدراسي

                    </label>

                    <select
                        name="semester"
                        id="semester"
                        required>

                        <option value="">

                            اختر الفصل

                        </option>

                        <option value="first">

                            الفصل الأول

                        </option>

                        <option value="second">

                            الفصل الثاني

                        </option>

                    </select>

                </div>

                <div class="field">

                    <label>

                        تاريخ التقديم

                    </label>

                    <input
                        type="date"
                        name="submission_date"
                        id="submission_date"
                        required>

                </div>

            </div>

        </div>

        <!-- جدول المقررات -->

        <div class="card">

            <div class="card-title">

                المقررات المطلوب التظلم عليها

            </div>

            <table class="table table-bordered text-center" id="coursesTable">

                <thead>

                    <tr>

                        <th style="width:25%">
                            المقرر
                        </th>

                        <th style="width:25%">
                            مدرس المقرر
                        </th>

                        <th>
                            سبب التظلم
                        </th>

                        <th style="width:80px">

                            حذف

                        </th>

                    </tr>

                </thead>

                <tbody id="coursesBody">
<tr>

    <td>

       <select
    name="course_id[]"
    class="form-control course-select"
    required>

    <option value="">
        اختر الفصل الدراسي أولاً
    </option>

</select>
    </td>

    <td>

        <input
            type="text"
            class="form-control teacher-name"
            readonly
            placeholder="سيظهر اسم المدرس">

    </td>

    <td>

      

    <textarea
        name="reason[]"
        class="form-control reason-text"
        rows="1"
        required
        placeholder="اكتب سبب التظلم">
    </textarea>

</td>
    </td>

    <td>

        <button

            type="button"

            class="btn btn-danger remove-row">

            <i class="fas fa-trash"></i>

        </button>

    </td>

</tr>

</tbody>

</table>

<div style="margin-top:20px;">

    <button

        type="button"

        id="addCourse"

        class="btn btn-primary">

        <i class="fas fa-plus-circle"></i>

        إضافة مقرر آخر

    </button>

</div>

</div>

<!-- المرفقات -->

<div class="card">

    <div class="card-title">

        المرفقات

    </div>

    <div class="upload-box">

        <input

            type="file"

            name="attachments[]"

            multiple>

    </div>

</div>

<div class="preview-btn-container">

    <button

        type="button"

        id="previewBtn"

        class="btn-preview">

        معاينة الاستمارة

    </button>

</div>
<!-- بداية المعاينة -->

<div class="card preview-card"
     id="previewCard"
     style="display:none;">

    <div class="official-header">

        <div class="header-top">

            <div class="header-ar" style="text-align:center">

                <div>الجمهورية اليمنية</div>
                <div>جامعة إقليم سبأ</div>
                <div>نيابة رئاسة الجامعة لشؤون الطلاب</div>
                <div>كلية تكنولوجيا المعلومات وعلوم الحاسوب</div>

            </div>

            <div class="header-middle" style="text-align:center">

                <div class="basmala">
                    بسم الله الرحمن الرحيم
                </div>

                <img src="{{ asset('images/logo.jpg') }}"
                     class="preview-logo"
                     alt="logo">

            </div>

            <div class="header-en" style="text-align:center">

                <div>Republic Of Yemen</div>
                <div>Sheba Region University</div>
                <div>Vice Presidency for Student Affairs</div>
                <div>Faculty of Information Technology</div>

            </div>

        </div>

        <div class="official-title">
            استمارة طلب تظلم
        </div>

        <hr class="official-divider">

    </div>

    <div class="section">

        <p class="dean-title">

            الدكتور / عميد الكلية

            <span class="dean-space"></span>

            المحترم

        </p>

        <p class="official-text">

            <b>أنا الطالب / الطالبة</b>

            <span class="inline-field">
                {{ $student->full_name }}
            </span>

            <b>أحمل الرقم الجامعي</b>

            <span class="inline-field">
                {{ $student->student_number }}
            </span>

            <b>من قسم</b>

            <span class="inline-field">
                {{ $student->department->department_name }}
            </span>

            <b>بالمستوى</b>

            <span class="inline-field">
                {{ $student->level }}
            </span>

            <b>
                ألتمس منكم التكرم بالنظر في طلبي وإعادة مراجعة نتيجة المقررات الموضحة أدناه.
            </b>

        </p>

    </div>

    <div class="section">

        <table id="previewTable">

            <thead>

                <tr>

                    <th style="width:5%">م</th>

                    <th style="width:25%">اسم المقرر</th>

                    <th style="width:20%">مدرس المقرر</th>

                    <th>سبب التظلم</th>

                </tr>

            </thead>

            <tbody id="previewCourses">

            </tbody>

        </table>

    </div>

    <div class="section">

        <p class="official-text">

            <b>تاريخ تقديم التظلم</b>

            <span class="inline-field" id="previewDate"></span>

        </p>

    </div>

    <div class="section">

        <p class="label-text">
            المرفقات :
        </p>

        <div id="preview-attachments"></div>

    </div>

</div>

<!-- زر الإرسال خارج بطاقة المعاينة -->

<div class="buttons" style="margin-top:20px;">

    <button
        type="submit"
        class="btn-submit">

        إرسال الطلب

    </button>

</div>

</form>

<script src="{{ asset('js/appeal.js') }}"></script>

@endsection