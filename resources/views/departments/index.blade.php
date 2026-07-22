@extends('layouts.admin')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/department.css') }}">

<!--
|--------------------------------------------------------------------------
| بطاقة عنوان الصفحة
|--------------------------------------------------------------------------
-->

<div class="header-card">

    <div class="page-header">

        <div>

            <h2>

                إدارة الأقسام

            </h2>

            <p>

                إضافة وتعديل وإدارة أقسام الجامعة.

            </p>

        </div>

        <div class="header-icon">

            <i class="fas fa-sitemap"></i>

        </div>

    </div>

</div>

<!--
|--------------------------------------------------------------------------
| بطاقات الإحصائيات
|--------------------------------------------------------------------------
-->

<div class="stats-grid">

    <!-- إجمالي الأقسام -->

    <div class="stat-card courses">

        <div class="stat-icon">

            <i class="fas fa-sitemap"></i>

        </div>

        <h3>

            إجمالي الأقسام

        </h3>

        <h2>

            {{ $departments->count() }}

        </h2>

    </div>

    <!-- الكليات -->

    <div class="stat-card departments">

        <div class="stat-icon">

            <i class="fas fa-building-columns"></i>

        </div>

        <h3>

            الكليات

        </h3>

        <h2>

            {{ $colleges->count() }}

        </h2>

    </div>

    <!-- الطلاب -->

    <div class="stat-card active">

        <div class="stat-icon">

            <i class="fas fa-user-graduate"></i>

        </div>

        <h3>

            الطلاب

        </h3>

        <h2>

            {{ $students->count() }}

        </h2>

    </div>

    <!-- الموظفون -->

    <div class="stat-card inactive">

        <div class="stat-icon">

            <i class="fas fa-user-tie"></i>

        </div>

        <h3>

            الموظفون

        </h3>

        <h2>

            {{ $employees->count() }}

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

            action="{{ route('departments.index') }}"

            class="search-form">

            <input

                type="text"

                name="search"

                placeholder="ابحث باسم القسم..."

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

            إضافة قسم

        </button>

    </div>

</div>
<!--
|--------------------------------------------------------------------------
| جدول الأقسام
|--------------------------------------------------------------------------
-->

<div class="table-box">

    <table>

        <thead>

            <tr>

                <th>

                    اسم القسم

                </th>

                <th>

                    الكلية

                </th>

                <th>

                    العمليات

                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($departments as $department)

            <tr>

                <!-- اسم القسم -->

                <td>

                    {{ $department->department_name }}

                </td>

                <!-- الكلية -->

                <td>

                    {{ $department->college->college_name }}

                </td>

                <!-- العمليات -->

                <td>

                    <!-- تعديل -->

                    <button

                        type="button"

                        class="btn-edit"

                        title="تعديل"

                        data-id="{{ $department->id }}"

                        data-name="{{ $department->department_name }}"

                        data-college="{{ $department->college_id }}">

                        <i class="fas fa-pen"></i>

                        <span>

                            تعديل

                        </span>

                    </button>

                    <!-- حذف -->

                    <form

                        action="{{ route('departments.delete',$department->id) }}"

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

                <td colspan="3">

                    لا توجد أقسام.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>
<!--
|--------------------------------------------------------------------------
| نافذة إضافة قسم
|--------------------------------------------------------------------------
-->

<div class="modal" id="addDepartmentModal">

    <div class="modal-content">

        <div class="modal-header">

            <h2>

                إضافة قسم جديد

            </h2>

            <span

                class="close"

                id="closeAddModal">

                &times;

            </span>

        </div>



        <form

            action="{{ route('departments.store') }}"

            method="POST">

            @csrf



            <!-- اسم القسم -->

            <div class="form-group">

                <label>

                    اسم القسم

                </label>

                <input

                    type="text"

                    name="department_name"

                    required>

            </div>



            <!-- الكلية -->

            <div class="form-group">

                <label>

                    الكلية

                </label>

                <select

                    name="college_id"

                    required>

                    <option value="">

                        اختر الكلية

                    </option>

                    @foreach($colleges as $college)

                    <option value="{{ $college->id }}">

                        {{ $college->college_name }}

                    </option>

                    @endforeach

                </select>

            </div>



            <div class="modal-footer">

                <button

                    type="submit"

                    class="btn-save">

                    حفظ القسم

                </button>

            </div>

        </form>

    </div>

</div>



<!--
|--------------------------------------------------------------------------
| نافذة تعديل قسم
|--------------------------------------------------------------------------
-->

<div class="modal" id="editDepartmentModal">

    <div class="modal-content">

        <div class="modal-header">

            <h2>

                تعديل بيانات القسم

            </h2>

            <span

                class="close"

                id="closeEditModal">

                &times;

            </span>

        </div>



        <form

            id="editDepartmentForm"

            method="POST">

            @csrf



            <!-- اسم القسم -->

            <div class="form-group">

                <label>

                    اسم القسم

                </label>

                <input

                    type="text"

                    id="edit_department_name"

                    name="department_name"

                    required>

            </div>



            <!-- الكلية -->

            <div class="form-group">

                <label>

                    الكلية

                </label>

                <select

                    id="edit_college_id"

                    name="college_id"

                    required>

                    @foreach($colleges as $college)

                    <option value="{{ $college->id }}">

                        {{ $college->college_name }}

                    </option>

                    @endforeach

                </select>

            </div>



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

<script src="{{ asset('js/department.js') }}"></script>

@endsection