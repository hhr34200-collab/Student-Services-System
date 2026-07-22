@extends('layouts.app')

@section('title', 'طلب وقف القيد')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/stop-enrollment.css') }}">

<div class="stop-container">

    <!-- رأس الصفحة -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-pause-circle"></i>
            </div>
            <div>
                <h1>طلب وقف القيد</h1>
                <p>نظام الخدمات الطلابية</p>
            </div>
        </div>
    </div>

    <form action="{{ route('stop-enrollment.store') }}"
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
                بيانات وقف القيد
            </div>

            <div class="grid">
               <div class="field">
                  <label>العام الجامعي</label>

                  <select name="academic_year" id="academic_year" required>
                        <option value="">اختر العام الجامعي</option>

                         @php
                            $currentYear = date('Y');

                            for($i = 0; $i <= 3; $i++) {
                            $start = $currentYear + $i;
                            $end   = $start + 1;

                            echo "<option value='{$start}/{$end}'>{$start}/{$end}</option>";
                            }
                         @endphp

                    </select>
               </div>

                <div class="field">
                    <label>الفصل الدراسي</label>
                    <select name="semester" required id="semester" required>
                        <option value="">اختر الفصل</option>
                        <option value="first">
                            الفصل الأول
                        </option>
                        <option value="second">
                            الفصل الثاني
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label>مدة الوقف</label>
                    <select name="stop_period" required id="stop_period" required>
                        <option value="">
                            اختر المدة
                        </option>
                        <option value="semester">
                            فصل دراسي
                        </option>
                        <option value="academic_year">
                            عام كامل
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label>تاريخ الطلب</label>
                    <input type="date"
                           id="request_date"
                           name="request_date"
                           required>
                </div>
            </div>

            <div class="field full">
                <label>
                    سبب وقف القيد
                </label>
                <textarea name="reason"
                          id="reason"
                          rows="6"
                          required></textarea>
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

        <div class="preview-btn-container">
            <button type="button" id="previewBtn" class="btn-preview">
                معاينة الاستمارة
            </button>
        </div>

        <div class="card preview-card" id="previewCard" style="display:none;">
            <div class="official-header">
                <div class="header-top">
                    <div class="header-ar" style=" text-align:center">
                        <div>الجمهورية اليمنية</div>
                        <div>جامعة إقليم سبأ</div>
                        <div>نيابة رئاسة الجامعة لشؤون الطلاب</div>
                        <div>كلية تكنولوجيا المعلومات وعلوم الحاسوب</div>
                    </div>

                    <div class="header-middle" style=" text-align:center">
                        <div class="basmala">
                            بسم الله الرحمن الرحيم
                        </div>
                        <img src="{{ asset('images/logo.jpg') }}"
                             class="preview-logo"
                             alt="logo">
                    </div>

                    <div class="header-en" style=" text-align:center">
                        <div>Republic Of Yemen</div>
                        <div>Sheba Region University</div>
                        <div>Vice Presidency for Student Affairs</div>
                        <div>Faculty of Information Technology and Computer Science</div>
                    </div>
                </div>

                <div class="official-title">
                    استمارة وقف قيد للعام
                    <span id="preview-year-title">
                        ............
                    </span>
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

                  <b> أنا الطالب / الطالبة</b>

                <span class="inline-field">{{ $student->full_name }}</span>

                  <b>أحمل بطاقة جامعية برقم قيد</b> 

                <span class="inline-field">{{ $student->student_number }}</span>

                   <b>في تخصص</b> 

                <span class="inline-field">
                 {{ $student->department->department_name ?? '' }}
                </span>

                  <b>بالمستوى</b> 

                <span class="inline-field">
                  {{ $student->level }}
                </span>

                 <b>للعام الجامعي</b> 

                <span class="inline-field" id="preview-year2">
                    ............
                </span>

                 <b>أتقدم إليكم بطلب وقف قيدي عن الدراسة لمدة</b> 

                <span class="inline-field" id="preview-period">
                   ............
                </span>

                </p>


                <p class="form-line">
                    <strong> يرجى الاطلاع على طلبي والموافقة على وقف قيدي.</strong>
                </p>

                <div class="section">
                    <p class="label-text">

                        مرفق لكم أسباب وقف القيد وهي :

                    </p>
                    <div class="reason-box" id="preview-reason">
                    </div>
                </div>

                <div class="section">
                    <p class="label-text">
                        المرفقات :
                    </p>
                    <div id="preview-attachments">
                    </div>
                </div>
            </div>
        </div>

      

        <div class="buttons">
            <!--button type="button"
                    onclick="window.print()"
                    class="btn-print">
                طباعة
            </button>-->

            <button type="submit"
                    class="btn-submit">
                إرسال الطلب
            </button>
        </div>

    </form>

</div>

<script src="{{ asset('js/stop-enrollment.js') }}"></script>
@endsection