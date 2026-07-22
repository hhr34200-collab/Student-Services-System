@extends('layouts.admin')

@section('title', 'إدارة الخدمات')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
@endsection

@section('content')

<div class="header">
    <h1>
        <i class="fas fa-cogs"></i>
        إدارة الخدمات
    </h1>
    <p>إدارة الخدمات الأكاديمية وإضافة وتعديل وحذف الخدمات</p>
</div>

@if(session('success'))
<div id="successMessage" class="success-message">
    {{ session('success') }}
</div>
@endif

<div class="top-bar">
    <div class="card">
        <strong>عدد الخدمات:</strong>
        {{ $services->count() }}
    </div>

    <form onsubmit="return false;">
        <input
            id="search"
            class="search"
            type="text"
            placeholder="بحث عن خدمة">
    </form>
</div>

<div class="actions">
    <button class="btn btn-add" onclick="openModal()">
        <i class="fas fa-plus"></i>
        إضافة خدمة
    </button>
</div>

<div class="table-box">
    <table>
        <thead>
            <tr>
                <th>اسم الخدمة</th>
                <th>الوصف</th>
                <th>الحالة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody id="servicesTable">
        @foreach($services as $service)
            <tr>
                <td>{{ $service->service_name }}</td>
                <td>{{ $service->description }}</td>
                <td>
                    <div class="status-wrapper">
                        <label class="switch">
                            <input
                                type="checkbox"
                                onchange="window.location='{{ route('services.status', $service->service_id) }}'"
                                {{ $service->status == 'active' ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                        <span class="status-text {{ $service->status == 'active' ? 'active' : 'inactive' }}">
                            {{ $service->status == 'active' ? 'مفعل' : 'موقفة' }}
                        </span>
                    </div>
                </td>
                <td>
                    <!-- زر التعديل -->
                    <button class="action-icon edit-btn" onclick="openEditModal('{{ $service->service_id }}', '{{ $service->service_name }}', '{{ $service->description }}')">
                        <i class="fas fa-edit"></i>
                    </button>

                    <!-- زر الحذف المصلح واستدعاء الـ SweetAlert بأمان -->
                    <button type="button" class="action-icon delete-btn" onclick="return confirmDelete('/services/{{ $service->service_id }}/delete', 'هل تريد حذف الخدمة؟')">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- نافذة إضافة خدمة -->
<div id="serviceModal" class="modal">
    <div class="modal-content">
        <h2>إضافة خدمة جديدة</h2>
        <form method="POST" action="{{ route('services.store') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="service_name" placeholder="اسم الخدمة" required>
            </div>
            <div class="form-group">
                <textarea name="description" placeholder="وصف الخدمة"></textarea>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn-submit">حفظ</button>
                <button type="button" class="btn-cancel" onclick="closeModal()">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<!-- نافذة تعديل خدمة -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h2>تعديل الخدمة</h2>
        <form id="editForm" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="service_name" id="edit_service_name" required>
            </div>
            <div class="form-group">
                <textarea name="description" id="edit_description"></textarea>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn-submit">حفظ التعديل</button>
                <button type="button" class="btn-cancel" onclick="closeEditModal()">إلغاء</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/services.js') }}"></script>
@endsection