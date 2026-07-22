@extends('layouts.app')

@section('title', 'الخدمات الأكاديمية')

@section('content')

<!-- محتوى صفحة الخدمات -->
<div class="content-wrapper">
    <div class="page-header" style="text-align: center;">
        <h2>الخدمات الأكاديمية</h2>
        <p>اختر الخدمة التي ترغب في تقديم طلبها</p>
    </div>

    <div class="cardBox">
        @foreach($services as $service)

            @php
                // جلب اسم الراوت من الـ Accessor المعرف داخل موديل Service
                $route = $service->route_name;
            @endphp

            <a
                class="card {{ $service->status == 'inactive' ? 'disabled-card' : '' }}"

                @if($service->status == 'active' && $route)
                    href="{{ route($route) }}"
                @else
                    href="javascript:void(0)"
                @endif

                {{-- استدعاء التنبيه المخصص المتناسق مع التصميم في حال الضغط على خدمة غير مفعلة --}}
                @if($service->status == 'inactive')
                    onclick="showAlert('warning', 'الخدمة غير متاحة', 'عذراً، خدمة ({{ $service->service_name }}) غير متاحة للتقديم في الوقت الحالي.')"
                @endif
            >

                <div class="numbers">
                    <i class="{{ $service->icon }}"></i>
                </div>

                <div class="cardName">
                    {{ $service->service_name }}
                </div>

                <div class="card-desc">
                    {{ $service->description }}
                </div>

                @if($service->status == 'active')
                    <div class="card-badge success">
                        متاحة
                    </div>
                @else
                    <div class="card-badge danger">
                        غير متاحة
                    </div>
                @endif

            </a>

        @endforeach
    </div>
</div>

@endsection