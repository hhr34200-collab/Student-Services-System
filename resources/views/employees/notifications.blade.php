@extends('layouts.employees')

@section('title','الإشعارات')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endsection

@section('content')
<div class="employee-table-page">

    {{-- الهيدر المطور: يجمع العنوان والبطاقة الإحصائية بمحاذاة أفقية مرنة --}}
    {{-- الهيدر الموزع على الأطراف --}}
    <div class="page-header">
        
        {{-- الجزء الأيمن: العنوان والوصف --}}
        <div class="header-main-info">
            <h2>
                <i class="fas fa-bell"></i>
                الإشعارات
            </h2>
            <p>جميع الإشعارات الخاصة بالموظف.</p>
        </div>

        {{-- الجزء الأيسر: بطاقة إجمالي الإشعارات --}}
        <div class="statistics-row">
            <div class="stat-card blue">
                <i class="fas fa-bell stat-icon"></i>
                <div class="stat-data">
                    <h3>{{ $notifications->count() }}</h3>
                    <span>إجمالي الإشعارات</span>
                </div>
            </div>
        </div>

    </div>
    {{-- أدوات الصفحة --}}
    <div class="notification-tools">
        {{-- تعليم الكل كمقروء --}}
        <form action="{{ route('notifications.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="tool-btn blue">
                <i class="fas fa-check-double"></i>
                تعليم الكل كمقروء
            </button>
        </form>

        {{-- الإعدادات --}}
        <div class="settings-dropdown">
            <button type="button" id="settingsBtn" class="settings-btn">
                <i class="fas fa-gear"></i>
            </button>
            <div id="settingsMenu" class="settings-menu">
                <button type="button" id="selectAllBtn">
                    <i class="fas fa-check-square"></i>
                    تحديد الكل
                </button>
            </div>
        </div>
    </div>

    {{-- قائمة الإشعارات --}}
    <div class="notifications-list" id="notificationsList">
        @forelse($notifications as $notification)
        <a href="{{ $notification->action_url ?? '#' }}" class="notification-link">
            <div class="notification-card {{ $notification->type }} {{ $notification->is_read ? 'read' : 'unread' }}">
                <div class="notification-content">
                    <h3>{{ $notification->title }}</h3>
                    <p>{{ $notification->message }}</p>
                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </a>
        @empty
        <div class="empty-table">
            <i class="fas fa-bell-slash fa-3x"></i>
            <br><br>
            لا توجد إشعارات حالياً.
        </div>
        @endforelse
    </div>

    {{-- الترقيم --}}
    <div class="pagination-wrapper">
        {{ $notifications->links() }}
    </div>

</div>
@endsection

@section('scripts')
<script src="{{ asset('js/notifications.js') }}"></script>
@endsection