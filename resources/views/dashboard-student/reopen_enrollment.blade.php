@extends('layouts.app')

@section('title', 'طلب إعادة قيد فرصة')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@400;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
      href="{{ asset('css/reopen-enrollment.css') }}">

<div class="stop-container">

    <!-- رأس الصفحة -->

    <div class="page-header">

        <div class="header-content">

            <div class="header-icon">
                <i class="fas fa-redo-alt"></i>
            </div>

            <div>
                <h1>طلب إعادة قيد فرصة</h1>
                <p>نظام الخدمات الطلابية</p>
            </div>

        </div>

    </div>

    <form action="{{ route('reopen-enrollment.store') }}"
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
                بيانات إعادة القيد
            </div>

            <div class="grid">

                <div class="field">

                    <label>العام الجامعي</label>

                    <select name="academic_year"
                            id="academic_year"
                            required>

                        <option value="">
                            اختر العام الجامعي
                        </option>

                        @php

                            $currentYear = date('Y');

                            for($i=0;$i<=3;$i++){

                                $start = $currentYear + $i;
                                $end   = $start + 1;

                                echo "
                                <option value='{$start}/{$end}'>
                                    {$start}/{$end}
                                </option>";
                            }

                        @endphp

                    </select>

                </div>

                <div class="field">

                    <label>تاريخ الطلب</label>

                    <input type="date"
                           name="request_date"
                           id="request_date"
                           required>

                </div>

            </div>

        </div>

        <!-- المرفقات -->

        <div class="card">

            <div class="card-title">
                المرفقات
            </div>

            <div class="upload-box">

                <input type="file"
                       name="attachments[]"
                       multiple>

            </div>

        </div>

        <!-- زر المعاينة -->

        <div class="preview-btn-container">

            <button type="button"
                    id="previewBtn"
                    class="btn-preview">

                معاينة الاستمارة

            </button>

        </div>

        <!-- المعاينة -->

        <div class="card preview-card"
             id="previewCard"
             style="display:none;">

            <div class="official-header">

                <div class="header-top">

                    <div class="header-ar"
                         style="text-align:center">

                        <div>الجمهورية اليمنية</div>

                        <div>جامعة إقليم سبأ</div>

                        <div>نيابة رئاسة الجامعة لشؤون الطلاب</div>

                        <div>كلية تكنولوجيا المعلومات وعلوم الحاسوب</div>

                    </div>

                    <div class="header-middle">

                        <div class="basmala">
                            بسم الله الرحمن الرحيم
                        </div>

                        <img src="{{ asset('images/logo.jpg') }}"
                             class="preview-logo"
                             alt="logo">

                    </div>

                    <div class="header-en"
                         style="text-align:center">

                        <div>Republic Of Yemen</div>

                        <div>Sheba Region University</div>

                        <div>Vice Presidency for Student Affairs</div>

                        <div>Faculty of Information Technology and Computer Science</div>

                    </div>

                </div>

                <div class="official-title">

                     استمارة إعادة قيد فرصة

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

                    أنا الطالب / الطالبة

                    <span class="inline-field">
                        {{ $student->full_name }}
                    </span>

                    أحمل بطاقة جامعية برقم قيد

                    (

                    <span class="inline-field">
                        {{ $student->student_number }}
                    </span>

                    )

                    في تخصص

                    <span class="inline-field">
                        {{ $student->department->department_name ?? '' }}
                    </span>

                    بالمستوى

                    <span class="inline-field">
                        {{ $student->level }}
                    </span>

                    للعام الجامعي

                    <span class="inline-field"
                          id="preview-year">

                        ............

                    </span>

                    أتقدم إليكم بطلب إعادة قيد فرصة
                    للعام الجامعي المذكور أعلاه.

                </p>

                <p class="form-line">
                    <strong>
                   يرجى التكرم بالاطلاع على طلبي واتخاذ ما يلزم.
                    </strong>
                </p>

                <div class="section">

                    <p class="label-text">

                        المرفقات :

                    </p>

                    <div id="preview-attachments">

                    </div>

                </div>

            </div>

        </div>

        <!-- زر الإرسال -->

        <div class="buttons">

            <button type="submit"
                    class="btn-submit">

                إرسال الطلب

            </button>

        </div>

    </form>

</div>

<script src="{{ asset('js/reopen-enrollment.js') }}"></script>

@endsection