@extends('layouts.app')

@section('title','الإشعارات')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/notifications.css') }}">
      

<div class="stop-container">

    <div class="page-header">

        <div class="header-content">

            <div class="header-icon">
                <i class="fas fa-bell"></i>
            </div>

            <div>
                <h1>الإشعارات</h1>
                <p>
                    متابعة حالة الطلبات والتنبيهات المهمة
                </p>
            </div>

        </div>

    </div>

    @if($notifications->count())

    <form method="POST"
          action="{{ route('notifications.deleteSelected') }}">

        @csrf

        <div class="notifications-top-bar">

    <h2 class="notifications-title">
        جميع الإشعارات
    </h2>

    <div class="settings-dropdown">

        <button type="button"
                id="settingsBtn"
                class="settings-btn">

            <i class="fas fa-cog"></i>

        </button>

        <div class="settings-menu"
             id="settingsMenu">

            <button type="button"
                    id="selectAllBtn">

                <i class="fas fa-check-square"></i>
                تحديد الكل

            </button>

           

            <button type="submit">

                <i class="fas fa-trash"></i>
                حذف المحدد

            </button>

        </div>

    </div>

</div>
            @foreach($notifications as $notification)

                    <div class="notification-card
                         {{ $notification->is_read ? 'read' : 'unread' }}
                         {{ $notification->type }}">
                     

                    <div class="notification-check">

                         <input type="checkbox"
                            name="notifications[]"
                            value="{{ $notification->id }}">

                    </div>

                 <div class="notification-content">

                   <h3>
                         {{ $notification->title }}
                   </h3>

                   <p>
                         {{ $notification->message }}
                   </p>

                    <span>
                         {{ $notification->created_at->diffForHumans() }}
                    </span>

                 </div>

        </div>

           @endforeach

        </div>

    </form>

    @else

        <div class="empty-box">

            <i class="fas fa-bell-slash"></i>

            <h3>

                لا توجد إشعارات حالياً

            </h3>

        </div>

    @endif




<script src="{{ asset('js/notifications.js') }}"></script>

@endsection