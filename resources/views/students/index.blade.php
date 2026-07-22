{{-- يرث هذا الملف التصميم العام للموقع (الهيكل الخارجي والـ Navbar) من مجلد الـ layouts --}}
@extends('layouts.admin')

{{-- تحديد عنوان الصفحة الذي يظهر في علامة تبويب المتصفح --}}
@section('title','إدارةالطلاب')

{{-- فتح قسم خاص بإضافة ملفات الستايل (CSS) الخاصة بهذه الصفحة فقط --}}
@section('styles')
    {{-- استدعاء ملف التنسيق الخاص بصفحة الطلاب ديناميكياً باستخدام مساعد asset --}}
    <link rel="stylesheet" href="{{ asset('css/students.css') }}">
@endsection

{{-- فتح القسم الرئيسي لمحتوى الصفحة --}}
@section('content')

<div class="header">

    <h1>
        <i class="fas fa-user-graduate"></i>
        إدارة الطلاب
    </h1>

    <p>
        إدارة بيانات الطلاب وإضافة وتعديل وحذف السجلات
    </p>

</div>

{{-- رسالة نجاح --}}
@if(session('success'))

<div class="success-message">

    <i class="fas fa-check-circle"></i>

    {{ session('success') }}

</div>

@endif

{{-- رسالة خطأ --}}
@if(session('error'))

<div class="error-message">

    <i class="fas fa-times-circle"></i>

    {{ session('error') }}

</div>

@endif

<div class="top-bar">

    <form >
       <input
        id="searchInput"
       class="search"
       type="text"
       placeholder="بحث بالاسم أو الرقم الجامعي">
    </form>

    <div class="card">
        <strong>
            عدد الطلاب: {{ $students->count() }}
        </strong>
    </div>

</div>

<!-- نقل الزر إلى هنا وإضافة كلاس wrapper للتحكم بالمسافة -->
<div class="action-button-container">
    <button class="btn add" onclick="openModal()">
        <i class="fas fa-user-plus"></i>
        إضافة طالب
    </button>
</div>

<div class="table-box">

<table>

<thead>

<tr>

<th>الاسم</th>

<th>الرقم الجامعي</th>

<th>الكلية</th>

<th>التخصص</th>

<th>المستوى</th>

<th>الحالة</th>

<th>العمليات</th>

</tr>

</thead>

<tbody id="studentsTable">

@foreach($students as $student)

<tr class="student-row">

<td>

{{ $student->full_name }}

</td>

<td>

{{ $student->student_number }}

</td>

<td>

{{ $student->college->college_name ?? '-' }}

</td>

<td>

{{ $student->department->department_name ?? '-' }}

</td>

<td>

{{ $student->level }}

</td>

<td>

<a href="{{ route('students.toggleStatus', $student->student_id) }}">
@if($student->academic_status == 'active')

<span class="status-badge active">

🟢 مفعل

</span>

@else

<span class="status-badge inactive">

🔴 موقوف

</span>

@endif

</a>

</td>

<td>

<button
class="action-icon edit-btn"

onclick="openEditModal(
'{{ $student->student_id }}',
'{{ $student->full_name }}',
'{{ $student->college_id }}',
'{{ $student->department_id }}',
'{{ $student->level }}'
)">
<i class="fas fa-edit"></i>

</button>

<button
class="action-icon delete-btn"

onclick="confirmDeleteStudent(
'{{ $student->student_id }}'
)">

<i class="fas fa-trash"></i>

</button>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="actions">




</div>
<!-- نافذة إضافة طالب -->

<!-- نافذة إضافة طالب -->

<div id="studentModal" class="modal">

    <div class="modal-content">

        <span
            class="close"
            onclick="closeModal()">
            &times;
        </span>

        <h2>إضافة طالب جديد</h2>

        <form
            method="POST"
            action="{{ route('students.store') }}">

            @csrf

            <!-- اسم الطالب -->
            <input
                type="text"
                name="full_name"
                value="{{ old('full_name') }}"
                placeholder="اسم الطالب"
                required>

            <!-- الكلية -->
            <select
                name="college_id"
                required>

                <option value="">
                    اختر الكلية
                </option>

                @foreach($colleges as $college)

                    <option
                        value="{{ $college->id }}">

                        {{ $college->college_name }}

                    </option>

                @endforeach

            </select>

            <!-- القسم -->
            <select
                name="department_id"
                required>

                <option value="">
                    اختر القسم
                </option>

                @foreach($departments as $department)

                    <option
                        value="{{ $department->id }}">

                        {{ $department->department_name }}

                    </option>

                @endforeach

            </select>

            <!-- المستوى -->
            <select
                name="level"
                required>

                <option value="">
                    اختر المستوى
                </option>

                <option value="المستوى الأول">
                    المستوى الأول
                </option>

                <option value="المستوى الثاني">
                    المستوى الثاني
                </option>

                <option value="المستوى الثالث">
                    المستوى الثالث
                </option>

                <option value="المستوى الرابع">
                    المستوى الرابع
                </option>

            </select>

            <button
                type="submit"
                class="btn add">

                حفظ الطالب

            </button>

        </form>

    </div>

</div><!-- نافذة تعديل الطالب -->
<!-- نافذة تعديل الطالب -->

<div id="editModal" class="modal">

    <div class="modal-content">

        <span
            class="close"
            onclick="closeEditModal()">
            &times;
        </span>

        <h2>تعديل بيانات الطالب</h2>

        <form
            id="editForm"
            method="POST">

            @csrf

            <!-- اسم الطالب -->
            <input
                type="text"
                id="edit_name"
                name="full_name"
                placeholder="اسم الطالب"
                required>

            <!-- الكلية -->
            <select
                id="edit_college"
                name="college_id"
                required>

                <option value="">اختر الكلية</option>

                @foreach($colleges as $college)

                    <option value="{{ $college->id }}">

                        {{ $college->college_name }}

                    </option>

                @endforeach

            </select>

            <!-- القسم -->
            <select
                id="edit_major"
                name="department_id"
                required>

                <option value="">اختر القسم</option>

                @foreach($departments as $department)

                    <option value="{{ $department->id }}">

                        {{ $department->department_name }}

                    </option>

                @endforeach

            </select>

            <!-- المستوى -->
            <select
                id="edit_level"
                name="level"
                required>

                <option value="">اختر المستوى</option>

                <option value="المستوى الأول">
                    المستوى الأول
                </option>

                <option value="المستوى الثاني">
                    المستوى الثاني
                </option>

                <option value="المستوى الثالث">
                    المستوى الثالث
                </option>

                <option value="المستوى الرابع">
                    المستوى الرابع
                </option>

            </select>

            <button
                type="submit"
                class="btn add">

                حفظ التعديل

            </button>

        </form>

    </div>

</div>

@endsection {{-- نهاية محتوى الصفحة الرئيسي --}}

{{-- فتح قسم خاص بإضافة ملفات الـ JavaScript الخاصة بهذه الصفحة فقط --}}
@section('scripts')
    {{-- استدعاء ملف الجافا سكريبت الخاص بالتحكم بالنوافذ المنبثقة والتعديل ديناميكياً --}}
    <script src="{{ asset('js/students.js') }}"></script>
@endsection