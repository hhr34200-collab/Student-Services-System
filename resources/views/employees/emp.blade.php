@extends('layouts.admin')

@section('title', 'إدارة حسابات الموظفين')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/emp.css') }}">
@endsection

@section('content')

    <!-- تمرير رسائل النظام لـ SweetAlert الخارجي -->
    <script>
        @if(session('success')) window.successMessage = "{{ session('success') }}"; @endif
        @if(session('error')) window.errorMessage = "{{ session('error') }}"; @endif
    </script>

    <div class="header">
        
        <h1><i class="fas fa-user-tie"></i> إدارة حسابات الموظفين النشطة</h1>
        <p>التحكم بحسابات موظفي النظام، وإضافة الصلاحيات وتتبع الحالات</p>
    </div>

    <div class="top-bar">
        <form method="GET" action="{{ route('employees.index') }}" id="mainSearchForm">
            <input class="search" type="text" name="search" id="mainSearchInput" value="{{ request('search') }}" placeholder="بحث فوري بالاسم أو الرقم الوظيفي...">
        </form>

        <div class="card">
            <strong>إجمالي الحسابات النشطة: {{ $employees->count() }}</strong>
        </div>
    </div>

    <div class="action-button-container">
        <button class="btn btn-add" onclick="openSelectionModal()">
            <i class="fas fa-user-plus"></i> إضافة موظف
        </button>
    </div>

    @if ($errors->any())
        <div class="error-container">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>اسم المستخدم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الرقم الوظيفي</th>
                    <th>القسم</th>
                    <th>الحالة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr class="student-row">
                        <td>{{ $employee->full_name }}</td>
                        <td>{{ $employee->user->username ?? '-' }}</td>
                        <td>{{ $employee->user->email ?? '-' }}</td>
                        <td>{{ $employee->employee_number }}</td>
                        <td>{{ $employee->department->department_name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('employees.toggleStatus', $employee->employee_id) }}">
                                @if($employee->status == 'active')
                                    <span class="status-badge active">🟢 مفعل</span>
                                @else
                                    <span class="status-badge inactive">🔴 موقوف</span>
                                @endif
                            </a>
                        </td>
                        <td>
                            <button class="action-icon edit-btn" onclick="openEditModal('{{ $employee->employee_id }}', '{{ $employee->full_name }}', '{{ $employee->user->email ?? '' }}', '{{ $employee->college_id }}', '{{ $employee->department_id }}', '{{ $employee->job_title }}', '{{ $employee->phone }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- استدعاء دالة الحذف الاحترافية الخاصة بك -->
                            <button class="action-icon delete-btn" onclick="return confirmDelete('{{ route('employees.delete', $employee->employee_id) }}', 'هل أنت متأكد من حذف هذا الموظف وحسابه نهائياً؟')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ========================================== -->
    <!-- نافذة الاختيار الرئيسية -->
    <!-- ========================================== -->
    <div class="modal" id="selectionModal">
        <div class="modal-content">
            <i class="fas fa-times modal-btn-close" onclick="closeSelectionModal()"></i>
            <h2 style="margin-bottom: 25px; text-align: center;">إضافة موظف</h2>
            
            <button class="btn-stacked btn-stacked-new" onclick="navigateFromSelection('new')">
                <i class="fas fa-user-plus"></i> موظف جديد 
            </button>
            
            <button class="btn-stacked btn-stacked-existing" onclick="navigateFromSelection('existing')">
                <i class="fas fa-user-check"></i> موظف موجود مسبقاً
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- نافذة 1: إضافة موظف جديد كلياً -->
    <!-- ========================================== -->
    <div class="modal" id="newEmpModal">
        <div class="modal-content">
            <i class="fas fa-arrow-right modal-btn-back" onclick="backToSelection('new')"></i>
            <i class="fas fa-times modal-btn-close" onclick="closeModal('new')"></i>
            
            <h2 style="text-align: center;">تسجيل موظف جديد </h2>
            
            <form method="POST" action="{{ route('employees.storeNew') }}">
                @csrf
                <div class="form-group"><input name="name" placeholder="اسم الموظف الكامل" required></div>
                <div class="form-group">
                    <select name="college_id" required>
                        <option value="">اختر الكلية</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}">{{ $college->college_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="department_id" required>
                        <option value="">اختر القسم</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
           <select name="job_title" required>
         <option value="">اختر المسمى الوظيفي</option>
         <option>رئيس القسم</option>
         <option>عميد الكلية</option>
         <option>نائب عميد شؤون الطلاب</option>
         <option>موظف شؤون الطلاب</option>
         <option>رئيس قسم شؤون الطلاب</option>
         <option>مسجل الكلية</option>
         <option>رئيس قسم الأرشيف</option>
         <option>المختص</option>
          </select>
           </div>
                <div class="form-group"><input name="phone" placeholder="رقم الهاتف" required></div>
                <hr style="border: 0.5px solid #eee; margin: 15px 0;">
                    <div class="form-group"><input name="username" placeholder="اسم المستخدم الجديد" required autocomplete="new-password"></div>
                <div class="form-group"><input type="email" name="email" placeholder="البريد الإلكتروني للخطابات" required></div>
                 <div class="form-group"><input type="password" name="password" placeholder="كلمة المرور" required autocomplete="new-password"></div>
                <div class="form-group"><input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" required></div>
                
                <div class="modal-buttons">
                    <button type="submit" class="btn-submit">حفظ وإنشاء الحساب</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- نافذة 2: البحث والربط لموظف موجود مسبقاً -->
    <!-- ========================================== -->
    <div class="modal" id="existingEmpModal">
        <div class="modal-content">
            <i class="fas fa-arrow-right modal-btn-back" onclick="backToSelection('existing')"></i>
            <i class="fas fa-times modal-btn-close" onclick="closeModal('existing')"></i>
            
            <h2 style="text-align: center; margin-bottom: 20px;">إنشاء حساب للموظف </h2>
            
            <!-- الجزء الأول: صندوق البحث (يختفي بالكامل عند العثور على الموظف) -->
            <div id="searchSection" class="form-group" style="position: relative;">
                <label>البحث بالاسم أو الرقم الوظيفي</label>
                <div class="search-group-wrapper">
                    <input type="text" id="empSearchQuery" placeholder="أدخل اسم الموظف أو الرقم الوظيفي...">
                    <button type="button" class="btn-search-icon" onclick="triggerExistingSearch()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="searchResultsDropdown" class="search-dropdown"></div>
            </div>
            
          
           <!-- الجزء الثاني: واجهة البيانات والحساب (تظهر فقط بعد اختيار الموظف) -->
<form method="POST" action="{{ route('employees.linkExisting') }}" id="linkExistingForm" style="display:none;" autocomplete="off">
    @csrf
    <input type="hidden" name="employee_id" id="selected_emp_id">
    
    <div style="background: #f8fafc; padding: 15px; border-radius: 12px; margin-bottom: 15px; border: 1px dashed #cbd5e1;">
        <div class="form-group" style="margin-bottom: 0;">
            <label style="color: #0F4C81;"><i class="fas fa-user"></i> الموظف المختار:</label>
            <input type="text" id="selected_emp_name" readonly style="background: transparent; border: none; font-weight: bold; font-size: 16px; color: #334155; padding: 5px 0;">
        </div>
    </div>

    <!-- إضافة الـ autocomplete لمنع المتصفح من وضع إيميل المدير -->
    <div class="form-group"><input name="username" placeholder="اسم المستخدم الجديد" required autocomplete="new-password"></div>
    <div class="form-group"><input type="email" name="email" placeholder="البريد الإلكتروني" required autocomplete="new-password"></div>
    <div class="form-group"><input type="password" name="password" placeholder="كلمة المرور" required autocomplete="new-password"></div>
    <div class="form-group"><input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" required autocomplete="new-password"></div>
    
    <div class="modal-buttons">
        <button type="submit" class="btn-submit" style="background-color: #3B82F6;">تفعيل وإنشاء الحساب</button>
    </div>
</form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- نافذة 3: تعديل البيانات -->
    <!-- ========================================== -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-times modal-btn-close" onclick="closeEditModal()"></i>
            <h2 style="text-align: center;">تعديل بيانات الموظف والحساب</h2>
            <form id="editForm" method="POST">
                @csrf
                <div class="form-group"><input type="text" name="name" id="edit_name" placeholder="اسم الموظف الكامل" required></div>
                <div class="form-group"><input type="email" name="email" id="edit_email" placeholder="البريد الإلكتروني" required></div>
                <div class="form-group">
                    <select name="college_id" id="edit_college_id" required>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}">{{ $college->college_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="department_id" id="edit_department_id" required>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="job_title" id="edit_job_title" required>
                        <option>رئيس القسم</option>
                        <option>عميد الكلية</option>
                        <option>موظف شؤون الطلاب</option>
                        <option>المختص</option>
                    </select>
                </div>
                <div class="form-group"><input type="text" name="phone" id="edit_phone" placeholder="رقم الهاتف" required></div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-submit">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/emp.js') }}"></script>
@endsection