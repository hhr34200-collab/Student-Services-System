@extends('layouts.app')

@section('title','الاشعارات')

@section('content')

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
</head>

<body>

<h2>{{ $title }}</h2>

<p>
    {{ $messageText }}
</p>

<hr>

<p>
نظام الخدمات الطلابية - جامعة إقليم سبأ
</p>

</body>
</html>
@endsection