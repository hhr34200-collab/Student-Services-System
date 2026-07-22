@extends('layouts.admin')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/course-assignment.css') }}">

<!--
|--------------------------------------------------------------------------
| بطاقة عنوان الصفحة
|--------------------------------------------------------------------------
-->

<div class="header-card">

    <div class="page-header">

        <div>

            <h2>

                توزيع المقررات

            </h2>

            <p>

                توزيع المقررات على أعضاء هيئة التدريس.

            </p>

        </div>

        <div class="header-icon">

            <i class="fas fa-chalkboard-teacher"></i>

        </div>

    </div>

</div>

<!--
|--------------------------------------------------------------------------
| بطاقات الإحصائيات
|--------------------------------------------------------------------------
-->

<div class="stats-grid">

    <!-- إجمالي التوزيعات -->

    <div class="stat-card courses">

        <div class="stat-icon">

            <i class="fas fa-book-open"></i>

        </div>

        <h3>

            إجمالي التوزيعات

        </h3>

        <h2>

            {{ $assignments->count() }}

        </h2>

    </div>

    <!-- أعضاء هيئة التدريس -->

    <div class="stat-card active">

        <div class="stat-icon">

            <i class="fas fa-user-tie"></i>

        </div>

        <h3>

            أعضاء هيئة التدريس

        </h3>

        <h2>

            {{ $employees->count() }}

        </h2>

    </div>

    <!-- المقررات -->

    <div class="stat-card inactive">

        <div class="stat-icon">

            <i class="fas fa-book"></i>

        </div>

        <h3>

            المقررات

        </h3>

        <h2>

            {{ $courses->count() }}

        </h2>

    </div>

    <!-- الأقسام -->

    <div class="stat-card departments">

        <div class="stat-icon">

            <i class="fas fa-sitemap"></i>

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
| البحث والإضافة
|--------------------------------------------------------------------------
-->

<div class="action-card">

    <div class="action-bar">

        <form

            method="GET"

            action="{{ route('course-assignments.index') }}"

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

        <button

            type="button"

            id="openAddModal"

            class="btn-add">

            <i class="fas fa-plus"></i>

            إضافة توزيع

        </button>

    </div>

</div>
<!--
|--------------------------------------------------------------------------
| جدول توزيع المقررات
|--------------------------------------------------------------------------
-->

<div class="table-box">

<table>

<thead>

<tr>

<th>

المقرر

</th>

<th>

القسم

</th>

<th>

عضو هيئة التدريس

</th>

<th>

السنة الدراسية

</th>

<th>

الفصل الدراسي

</th>

<th>

العمليات

</th>

</tr>

</thead>

<tbody>

@forelse($assignments as $assignment)

<tr>

<!-- المقرر -->

<td>

{{ $assignment->course->course_name }}

</td>

<!-- القسم -->

<td>

{{ $assignment->department->department_name }}

</td>

<!-- الموظف -->

<td>

{{ $assignment->employee->full_name }}

</td>

<!-- السنة -->

<td>

{{ $assignment->academic_year }}

</td>

<!-- الفصل -->

<td>

@if($assignment->semester == 'first')

الفصل الأول

@else

الفصل الثاني

@endif

</td>

<!-- العمليات -->

<td>

<button

type="button"

class="btn-edit"

title="تعديل"

data-id="{{ $assignment->assignment_id }}"

data-course="{{ $assignment->course_id }}"

data-department="{{ $assignment->department_id }}"

data-employee="{{ $assignment->employee_id }}"

data-year="{{ $assignment->academic_year }}"

data-semester="{{ $assignment->semester }}">

<i class="fas fa-pen"></i>

<span>

تعديل

</span>

</button>

<form

action="{{ route('course-assignments.delete',$assignment->assignment_id) }}"

method="POST"

style="display:inline;">

@csrf

<button

type="submit"

class="btn-delete"

title="حذف">

<i class="fas fa-trash"></i>

<span>

حذف

</span>

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="6">

لا توجد عمليات توزيع حتى الآن.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>
<!--
|--------------------------------------------------------------------------
| نافذة إضافة توزيع مقرر
|--------------------------------------------------------------------------
-->

<div class="modal" id="addAssignmentModal">

    <div class="modal-content">

        <!-- عنوان النافذة -->

        <div class="modal-header">

            <h2>

                إضافة توزيع جديد

            </h2>

            <span

                class="close"

                id="closeAddModal">

                &times;

            </span>

        </div>



        <!-- نموذج الإضافة -->

        <form

            action="{{ route('course-assignments.store') }}"

            method="POST">

            @csrf



            <!-- المقرر -->

            <div class="form-group">

                <label>

                    المقرر

                </label>

                <select

                    name="course_id"

                    id="course_id"

                    required>

                    <option value="">

                        اختر المقرر

                    </option>

                    @foreach($courses as $course)

                    <option value="{{ $course->course_id }}">

                        {{ $course->course_name }}

                    </option>

                    @endforeach

                </select>

            </div>



            <!-- القسم -->

            <div class="form-group">

                <label>

                    القسم

                </label>

                <select

                    name="department_id"

                    id="department_id"

                    required>

                    <option value="">

                        اختر القسم

                    </option>

                    @foreach($departments as $department)

                    <option value="{{ $department->id }}">

                        {{ $department->department_name }}

                    </option>

                    @endforeach

                </select>

            </div>



            <!-- الموظف -->

            <div class="form-group">

                <label>

                    عضو هيئة التدريس

                </label>

                <select

                    name="employee_id"

                    required>

                    <option value="">

                        اختر الموظف

                    </option>

                    @foreach($employees as $employee)

                    <option value="{{ $employee->employee_id }}">

                        {{ $employee->full_name }}

                    </option>

                    @endforeach

                </select>

            </div>



            <!-- السنة الدراسية -->
<div class="form-group">

    <label>
        السنة الدراسية
    </label>

    <select
        name="academic_year"
        required>

        <option value="">
            اختر السنة الدراسية
        </option>

        @php
            $currentYear = date('Y');

            for ($i = 0; $i <= 3; $i++) {

                $start = $currentYear + $i;
                $end   = $start + 1;

                echo "<option value='{$start}/{$end}'>{$start}/{$end}</option>";
            }
        @endphp

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

                    <option value="first">

                        الفصل الأول

                    </option>

                    <option value="second">

                        الفصل الثاني

                    </option>

                </select>

            </div>



            <!-- زر الحفظ -->

            <div class="modal-footer">

                <button

                    type="submit"

                    class="btn-save">

                    حفظ التوزيع

                </button>

            </div>

        </form>

    </div>

</div>
<!--
|--------------------------------------------------------------------------
| نافذة تعديل توزيع مقرر
|--------------------------------------------------------------------------
-->

<div class="modal" id="editAssignmentModal">

    <div class="modal-content">

        <!-- عنوان النافذة -->

        <div class="modal-header">

            <h2>

                تعديل توزيع المقرر

            </h2>

            <span

                class="close"

                id="closeEditModal">

                &times;

            </span>

        </div>



        <!-- نموذج التعديل -->

        <form

            id="editAssignmentForm"

            method="POST">

            @csrf



            <!-- المقرر -->

            <div class="form-group">

                <label>

                    المقرر

                </label>

                <select

                    name="course_id"

                    id="edit_course_id"

                    required>

                    @foreach($courses as $course)

                    <option value="{{ $course->course_id }}">

                        {{ $course->course_name }}

                    </option>

                    @endforeach

                </select>

            </div>



            <!-- القسم -->

            <div class="form-group">

                <label>

                    القسم

                </label>

                <select

                    name="department_id"

                    id="edit_department_id"

                    required>

                    @foreach($departments as $department)

                    <option value="{{ $department->id }}">

                        {{ $department->department_name }}

                    </option>

                    @endforeach

                </select>

            </div>



            <!-- الموظف -->

            <div class="form-group">

                <label>

                    عضو هيئة التدريس

                </label>

                <select

                    name="employee_id"

                    id="edit_employee_id"

                    required>

                    @foreach($employees as $employee)

                    <option value="{{ $employee->employee_id }}">

                        {{ $employee->full_name }}

                    </option>

                    @endforeach

                </select>

            </div>


<div class="form-group">

    <label>
        السنة الدراسية
    </label>

    <select
        id="edit_academic_year"
        name="academic_year"
        required>

        @php
            $currentYear = date('Y');

            for ($i = 0; $i <= 3; $i++) {

                $start = $currentYear + $i;
                $end   = $start + 1;

                echo "<option value='{$start}/{$end}'>{$start}/{$end}</option>";
            }
        @endphp

    </select>

</div>

            <!-- الفصل الدراسي -->

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



            <!-- زر الحفظ -->

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

<script src="{{ asset('js/course-assignment.js') }}"></script>

@endsection