@extends('layouts.form')

@section('title','استمارة وقف القيد')

@section('content')

<link rel="stylesheet" href="{{ asset('css/forms.css') }}">

<div class="official-form">

    @include('forms.partials.header')

    @include('forms.partials.student-info')
    @include('forms.partials.reopen-info')   

    @include('forms.partials.attachments')

    @include('forms.partials.approvals')

</div>

<div class="form-buttons">

    @include('forms.partials.actions')

</div>

@endsection