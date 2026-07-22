@extends('layouts.form')

@section('title','طباعة الطلب')

@section('content')

<link rel="stylesheet" href="{{ asset('css/print.css') }}">

<div class="print-page">

    {{-- الترويسة --}}
    @include('forms.partials.header')

    {{-- بيانات الطالب --}}
    @include('forms.partials.student-info')

    {{-- بيانات الطلب --}}
   

    <div class="official-divider"></div>

    {{-- خاص بالجهات المختصة --}}
    <div class="print-main-title">

        خاص بالجهات المختصة

    </div>

    {{-- إفادة شؤون الطلاب --}}
    @include('forms.print.student-affairs')

    {{-- رأي عمادة الكلية (يجمع رئيس القسم والعميد) --}}
    @include('forms.print.department-head')



    {{-- اعتماد الأرشيف --}}
    @include('forms.print.archive')

</div>

{{--=========================================================
                أزرار التحكم
==========================================================--}}

<div class="print-actions">

    <button
        type="button"
        class="btn-print-page"
        onclick="window.print()">

        <i class="fas fa-print"></i>

        طباعة

    </button>

 <button
    type="button"
    class="btn-back-page"
    onclick="window.close()">

    <i class="fas fa-arrow-right"></i>

    رجوع

</button>
</div>

@endsection