@extends('layouts.admin')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/course.css') }}">


<!--
|--------------------------------------------------------------------------
| عنوان الصفحة
|--------------------------------------------------------------------------
-->

<!--
|--------------------------------------------------------------------------
| بطاقة عنوان الصفحة
|--------------------------------------------------------------------------
-->

<div class="header-card">

    <div class="page-header">

        <div>

            <h2>

                إدارة المقررات

            </h2>

            <p>

                إضافة وتعديل وإدارة مقررات الجامعة.

            </p>

        </div>


        <div class="header-icon">

            <i class="fas fa-book-open"></i>

        </div>

    </div>

</div>
<!--
|--------------------------------------------------------------------------
| بطاقات الإحصائيات
|--------------------------------------------------------------------------
-->
<div class="stats-grid">

    <!-- إجمالي المقررات -->

    <div class="stat-card courses">

        <div class="stat-icon">

            <i class="fas fa-book-open"></i>

        </div>

        <h3>

            إجمالي المقررات

        </h3>

        <h2>

            {{ $courses->count() }}

        </h2>

    </div>



    <!-- المقررات النشطة -->

    <div class="stat-card active">

        <div class="stat-icon">

            <i class="fas fa-circle-check"></i>

        </div>

        <h3>

            المقررات النشطة

        </h3>

        <h2>

            {{ $courses->where('status','active')->count() }}

        </h2>

    </div>



    <!-- المقررات الموقوفة -->

    <div class="stat-card inactive">

        <div class="stat-icon">

            <i class="fas fa-circle-xmark"></i>

        </div>

        <h3>

            المقررات الموقوفة

        </h3>

        <h2>

            {{ $courses->where('status','inactive')->count() }}

        </h2>

    </div>



    <!-- عدد الأقسام -->

    <div class="stat-card departments">

        <div class="stat-icon">

            <i class="fas fa-building-columns"></i>

        </div>

        <h3>

            الأقسام

        </h3>

        <h2>

            {{ $departments->count() }}

        </h2>

    </div>

</div>
<!--
|--------------------------------------------------------------------------
| البحث
|--------------------------------------------------------------------------
-->

<!--
|--------------------------------------------------------------------------
| بطاقة البحث والإضافة
|--------------------------------------------------------------------------
-->

<div class="action-card">

    <div class="action-bar">

        <!-- البحث -->

        <form

            method="GET"

            action="{{ route('courses.index') }}"

            class="search-form">

            <input

                type="text"

                name="search"

                placeholder="ابحث باسم المقرر..."

                value="{{ request('search') }}">

            <button type="submit">

                <i class="fas fa-search"></i>

            </button>

        </form>


        <!-- زر إضافة مقرر -->

        <button

            type="button"

            id="openAddModal"

            class="btn-add">

            <i class="fas fa-plus"></i>

            إضافة مقرر

        </button>

    </div>

</div>
<!--
|--------------------------------------------------------------------------
| جدول المقررات
|--------------------------------------------------------------------------
-->

<div class="table-box">

<table>

<thead>

<tr>

<th>

اسم المقرر

</th>

<th>

المستوى

</th>

<th>

الفصل

</th>

<th>

الأقسام

</th>

<th>

الحالة

</th>

<th>

العمليات

</th>

</tr>

</thead>

<tbody>

@forelse($courses as $course)

<tr>

<td>

{{ $course->course_name }}

</td>

<td>

{{ $course->level }}

</td>

<td>

{{ $course->semester }}

</td>

<td>

@foreach($course->departments as $department)

<span class="department-tag">

{{ $department->department_name }}

</span>

@endforeach

</td>

<td>

@if($course->status=='active')

<span class="status-active">

نشط

</span>

@else

<span class="status-inactive">

موقوف

</span>

@endif

</td>

<td>

<button

type="button"

class="btn-edit"

data-id="{{ $course->course_id }}"

data-name="{{ $course->course_name }}"

data-level="{{ $course->level }}"

data-semester="{{ $course->semester }}"

data-status="{{ $course->status }}"

data-departments="{{ $course->departments->pluck('id')->implode(',') }}">

تعديل

</button>


<form

action="{{ route('courses.delete',$course->course_id) }}"

method="POST"

style="display:inline;">

@csrf

<button

class="btn-delete">

حذف

</button>

</form>


<a

href="{{ route('courses.toggleStatus',$course->course_id) }}"

class="btn-status">

الحالة

</a>

</td>

</tr>

@empty

<tr>

<td colspan="6">

لا توجد مقررات.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>
<!--
|--------------------------------------------------------------------------
| نافذة إضافة مقرر جديد
|--------------------------------------------------------------------------
-->

<div class="modal" id="addCourseModal">

    <div class="modal-content">

        <!-- عنوان النافذة -->

        <div class="modal-header">

            <h2>

                إضافة مقرر جديد

            </h2>

            <span
                class="close"
                id="closeAddModal">

                &times;

            </span>

        </div>


        <!-- نموذج إضافة المقرر -->

        <form
            action="{{ route('courses.store') }}"
            method="POST">

            @csrf


            <!-- اسم المقرر -->

            <div class="form-group">

                <label>

                    اسم المقرر

                </label>

                <input

                    type="text"

                    name="course_name"

                    required>

            </div>


            <!-- المستوى -->

            <div class="form-group">

                <label>

                    المستوى

                </label>

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

            </div>


            <!-- الفصل -->

            <div class="form-group">

                <label>

                    الفصل الدراسي

                </label>

                <select
                    name="semester"
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


            <!-- الحالة -->

            <div class="form-group">

                <label>

                    الحالة

                </label>

                <select
                    name="status">

                    <option value="active">

                        نشط

                    </option>

                    <option value="inactive">

                        موقوف

                    </option>

                </select>

            </div>


            <!-- الأقسام -->

            <div class="form-group">

                <label>

                    الأقسام

                </label>

                <div class="checkbox-grid">

                    @foreach($departments as $department)

                    <label class="checkbox-item">

                        <input

                            type="checkbox"

                            name="departments[]"

                            value="{{ $department->id }}">

                        {{ $department->department_name }}

                    </label>

                    @endforeach

                </div>

            </div>


            <!-- زر الحفظ -->

            <div class="modal-footer">

                <button
                    type="submit"
                    class="btn-save">

                    حفظ المقرر

                </button>

            </div>

        </form>

    </div>

</div>
<!--
|--------------------------------------------------------------------------
| نافذة تعديل المقرر
|--------------------------------------------------------------------------
-->

<div class="modal" id="editCourseModal">

    <div class="modal-content">

        <!-- عنوان النافذة -->

        <div class="modal-header">

            <h2>

                تعديل بيانات المقرر

            </h2>

            <span
                class="close"
                id="closeEditModal">

                &times;

            </span>

        </div>


        <!-- نموذج تعديل المقرر -->

        <form

            id="editCourseForm"

            method="POST">

            @csrf


            <!-- اسم المقرر -->

            <div class="form-group">

                <label>

                    اسم المقرر

                </label>

                <input

                    type="text"

                    name="course_name"

                    id="edit_course_name"

                    required>

            </div>


            <!-- المستوى -->

            <div class="form-group">

                <label>

                    المستوى

                </label>

                <select

                    name="level"

                    id="edit_level"

                    required>

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

            </div>


            <!-- الفصل -->

            <div class="form-group">

                <label>

                    الفصل الدراسي

                </label>

                <select

                    name="semester"

                    id="edit_semester"

                    required>

                    <option value="first">

                        الفصل الأول

                    </option>

                    <option value="second">

                        الفصل الثاني

                    </option>

                </select>

            </div>


            <!-- الحالة -->

            <div class="form-group">

                <label>

                    الحالة

                </label>

                <select

                    name="status"

                    id="edit_status">

                    <option value="active">

                        نشط

                    </option>

                    <option value="inactive">

                        موقوف

                    </option>

                </select>

            </div>


            <!-- الأقسام -->

            <div class="form-group">

                <label>

                    الأقسام

                </label>

                <div class="checkbox-grid">

                    @foreach($departments as $department)

                    <label class="checkbox-item">

                        <input

                            type="checkbox"

                            class="edit-department"

                            name="departments[]"

                            value="{{ $department->id }}">

                        {{ $department->department_name }}

                    </label>

                    @endforeach

                </div>

            </div>


            <!-- أزرار النافذة -->

            <div class="modal-footer">

                <button

                    type="submit"

                    class="btn-save">

                    حفظ التعديلات

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
@section('scripts')
    <script src="{{ asset('js/course.js') }}"></script>
@endsection