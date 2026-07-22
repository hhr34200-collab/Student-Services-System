<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<style>
  body{

    font-family: dejavusans;

    direction: rtl;

    color:#222;

    font-size:12px;

    margin:0;

    padding:0;

}

@page{
    size: A4 portrait;
    margin: 18mm;
}

body{

    font-family: 'Cairo';

    direction: rtl;

    color:#222;

    font-size:12px;

}

.logo{
    width:75px;
    display:block;
    margin:0 auto 10px;
}

.header{
    text-align:center;
    border-bottom:3px solid #1A3A5F;
    padding-bottom:15px;
    margin-bottom:25px;
}

.header h1{
    margin:5px 0;
    color:#1A3A5F;
    font-size:24px;
}

.header h2{
    margin:0;
    color:#C89A2B;
    font-size:18px;
}

.header p{
    margin-top:8px;
    color:#666;
    font-size:13px;
}

.info-table,
.stats-table{

    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;

}

.info-table td,
.stats-table td,
.stats-table th{

    border:1px solid #999;
    padding:10px;
    text-align:center;

}

.stats-table th{

    background:#1A3A5F;
    color:#fff;

}

.title{

    background:#1A3A5F;
    color:#fff;
    padding:10px;
    text-align:center;
    font-size:16px;
    font-weight:bold;
    margin:18px 0 8px;

}

.summary{

    border:1px solid #999;
    padding:15px;
    margin-top:15px;

}

.summary ul{

    margin:0;
    padding-right:20px;

}

.summary li{

    margin-bottom:8px;

}

.rate-table{

    width:100%;
    border-collapse:collapse;
    margin-top:20px;

}

.rate-table th{

    background:#1A3A5F;
    color:white;
    padding:10px;

}

.rate-table td{

    border:1px solid #ccc;
    padding:10px;
    text-align:center;

}

.signature{

    margin-top:45px;
    width:100%;

}

.signature table{

    width:100%;

}

.signature td{

    width:50%;
    text-align:center;

}

.footer{

    margin-top:40px;
    text-align:center;
    font-size:11px;
    color:#777;
    border-top:2px solid #1A3A5F;
    padding-top:10px;

}
table{

    width:100%;

    border-collapse:collapse;

}

tr{

    page-break-inside:avoid;

}

img{

    max-width:100%;

}

</style>
</head>

<body>

<div class="header">

<img
    src="{{ public_path('images/logo.jpg') }}"
    class="logo"
    alt="Logo">

    <h1>جامعة إقليم سبأ</h1>

    <h2>نظام الخدمات الطلابية</h2>

    <p>

        التقرير الإحصائي العام للنظام

        <br>

        تاريخ التقرير :

        {{ now()->format('Y-m-d') }}

    </p>

</div>

<table class="info-table">

<tr>

<td><strong>رقم التقرير</strong></td>

<td>

REP-{{ date('Y') }}-0001

</td>

<td><strong>وقت الإنشاء</strong></td>

<td>

{{ now()->format('H:i') }}

</td>

</tr>

<tr>

<td><strong>مدير النظام</strong></td>

<td>

Administrator

</td>

<td><strong>حالة التقرير</strong></td>

<td>

رسمي

</td>

</tr>

</table>

<div class="title">

الإحصائيات العامة

</div>

<table class="stats-table">

<tr>

<th>البيان</th>

<th>العدد</th>

</tr>

<tr>

<td>إجمالي الطلاب</td>

<td>{{ $studentsCount }}</td>

</tr>

<tr>

<td>إجمالي الموظفين</td>

<td>{{ $employeesCount }}</td>

</tr>

<tr>

<td>إجمالي الخدمات</td>

<td>{{ $servicesCount }}</td>

</tr>

<tr>

<td>إجمالي الطلبات</td>

<td>{{ $requestsCount }}</td>

</tr>

</table>

<div class="title">

إحصائيات الطلبات

</div>

<table class="stats-table">

<tr>

<th>الحالة</th>

<th>عدد الطلبات</th>

</tr>

<tr>

<td>قيد المراجعة</td>

<td>{{ $reviewCount }}</td>

</tr>

<tr>

<td>تمت الموافقة</td>

<td>{{ $approvedCount }}</td>

</tr>

<tr>

<td>تم رفضها</td>

<td>{{ $rejectedCount }}</td>

</tr>

<tr>

<td>تحتاج استكمال</td>

<td>{{ $returnedCount }}</td>

</tr>

</table>
<div class="title">
نسب الطلبات
</div>

<table class="rate-table">

<tr>

<th>نوع النسبة</th>

<th>القيمة</th>

</tr>

<tr>

<td>نسبة الموافقات</td>

<td>{{ $approvalRate }} %</td>

</tr>

<tr>

<td>نسبة الرفض</td>

<td>{{ $rejectionRate }} %</td>

</tr>

<tr>

<td>نسبة الطلبات المسترجعة</td>

<td>{{ $returnedRate }} %</td>

</tr>

</table>

<div class="title">

ملخص التقرير

</div>

<div class="summary">

<ul>

<li>

إجمالي الطلاب المسجلين بالنظام :

<strong>{{ $studentsCount }}</strong>

</li>

<li>

عدد الموظفين المستخدمين للنظام :

<strong>{{ $employeesCount }}</strong>

</li>

<li>

عدد الخدمات الإلكترونية :

<strong>{{ $servicesCount }}</strong>

</li>

<li>

إجمالي الطلبات المقدمة :

<strong>{{ $requestsCount }}</strong>

</li>

<li>

الطلبات التي تحتاج متابعة :

<strong>{{ $returnedCount }}</strong>

</li>

</ul>

</div>
<div class="title">

أكثر الخدمات استخداماً

</div>

<table class="stats-table">

<tr>

<th>الخدمة</th>

<th>عدد الطلبات</th>

</tr>

@foreach($topServices as $service)

<tr>

<td>

{{ $service->service->service_name ?? 'غير معروف' }}

</td>

<td>

{{ $service->total }}

</td>

</tr>

@endforeach

</table>

<div class="signature">

<table>

<tr>

<td>

................................

<br><br>

مدير النظام

</td>

<td>

................................

<br><br>

الختم الرسمي

</td>

</tr>

</table>

</div>
<hr>

<div class="footer">

تم إنشاء هذا التقرير إلكترونياً بواسطة

<strong>

نظام الخدمات الطلابية - جامعة إقليم سبأ

</strong>

<br>

{{ date('Y') }}

</div>
</body>

</html>