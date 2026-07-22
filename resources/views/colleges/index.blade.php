@extends('layouts.admin')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/college.css') }}">

<!--
|--------------------------------------------------------------------------
| بطاقة عنوان الصفحة
|--------------------------------------------------------------------------
-->

<div class="header-card">

    <div class="page-header">

        <div>

            <h2>

                إدارة الكليات

            </h2>

            <p>

                إضافة وتعديل وإدارة كليات الجامعة.

            </p>

        </div>

        <div class="header-icon">

            <i class="fas fa-building-columns"></i>

        </div>

    </div>

</div>

<!--
|--------------------------------------------------------------------------
| بطاقات الإحصائيات
|--------------------------------------------------------------------------
-->

<div class="stats-grid">

    <!-- إجمالي الكليات -->

    <div class="stat-card courses">

        <div class="stat-icon">

            <i class="fas fa-building-columns"></i>

        </div>

        <h3>

            إجمالي الكليات

        </h3>

        <h2>

            {{ $colleges->count() }}

        </h2>

    </div>



    <!-- الكليات النشطة -->

    

   



    <!-- الكليات الموقوفة -->

    



    <!-- عدد الأقسام -->

    <div class="stat-card departments">

        <div class="stat-icon">

            <i class="fas fa-sitemap"></i>

        </div>

        <h3>

            عدد الأقسام

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

            action="{{ route('colleges.index') }}"

            class="search-form">

            <input

                type="text"

                name="search"

                placeholder="ابحث باسم الكلية..."

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

            إضافة كلية

        </button>

    </div>

</div>

<!--
<!--
|--------------------------------------------------------------------------
| جدول الكليات
|--------------------------------------------------------------------------
-->

<div class="table-box">

    <table>

        <thead>

            <tr>

                <th>

                    اسم الكلية

                </th>

                <th>

                    عدد الأقسام

                </th>

                <th>

                    العمليات

                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($colleges as $college)

            <tr>

                <!-- اسم الكلية -->

                <td>

                    {{ $college->college_name }}

                </td>

                <!-- عدد الأقسام -->

                <td>

                    {{ $college->departments->count() }}

                </td>

                <!-- العمليات -->

                <td>

                    <!-- زر التعديل -->

                    <button

                        type="button"

                        class="btn-edit"

                        title="تعديل"

                        data-id="{{ $college->id }}"

                        data-name="{{ $college->college_name }}">

                        <i class="fas fa-pen"></i>

                        <span>

                            تعديل

                        </span>

                    </button>

                    <!-- زر الحذف -->

                    <form

                        action="{{ route('colleges.delete',$college->id) }}"

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

                    لا توجد كليات.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>



<!--
|--------------------------------------------------------------------------
| نافذة إضافة كلية
|--------------------------------------------------------------------------
-->

<div class="modal" id="addCollegeModal">

<div class="modal-content">

<div class="modal-header">

<h2>

إضافة كلية جديدة

</h2>

<span

class="close"

id="closeAddModal">

&times;

</span>

</div>



<form

action="{{ route('colleges.store') }}"

method="POST">

@csrf



<div class="form-group">

<label>

اسم الكلية

</label>

<input

type="text"

name="college_name"

required>

</div>







<div class="modal-footer">

<button

type="submit"

class="btn-save">

حفظ الكلية

</button>

</div>

</form>

</div>

</div>
<!--
|--------------------------------------------------------------------------
| نافذة تعديل الكلية
|--------------------------------------------------------------------------
-->

<div class="modal" id="editCollegeModal">

    <div class="modal-content">

        <!-- عنوان النافذة -->

        <div class="modal-header">

            <h2>

                تعديل بيانات الكلية

            </h2>

            <span

                class="close"

                id="closeEditModal">

                &times;

            </span>

        </div>



        <!-- نموذج التعديل -->

        <form

            id="editCollegeForm"

            method="POST">

            @csrf



            <!-- اسم الكلية -->

            <div class="form-group">

                <label>

                    اسم الكلية

                </label>

                <input

                    type="text"

                    name="college_name"

                    id="edit_college_name"

                    required>

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

<script src="{{ asset('js/college.js') }}"></script>

@endsection