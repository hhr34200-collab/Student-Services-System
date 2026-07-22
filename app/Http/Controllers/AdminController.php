<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Employee;
use App\Models\Service;
use App\Models\RequestModel;

class AdminController extends Controller
{
    /**
     * عرض لوحة مدير النظام
     */
  public function index()
{
    // عدد الطلاب
    $studentsCount = Student::count();

    // عدد الموظفين
    $employeesCount = Employee::count();

    // عدد الخدمات
    $servicesCount = Service::count();

    // عدد الطلبات
    $requestsCount = RequestModel::count();

    // الطلبات قيد المراجعة
    $reviewCount = RequestModel::whereIn('status', [

        'submitted',

        'student_affairs_review',

        'department_head_review',

    ])->count();

    // الطلبات الموافق عليها
    $approvedCount = RequestModel::where(
        'status',
        'approved'
    )->count();

    // الطلبات المرفوضة
    $rejectedCount = RequestModel::where(
        'status',
        'rejected'
    )->count();

    // الطلبات التي تحتاج استكمال
    $returnedCount = RequestModel::where(
        'status',
        'returned_to_student'
    )->count();


    //=============================
    // نسب الطلبات
    //=============================

    $reviewRate = $requestsCount > 0
        ? round(($reviewCount / $requestsCount) * 100)
        : 0;

    $approvedRate = $requestsCount > 0
        ? round(($approvedCount / $requestsCount) * 100)
        : 0;

    $rejectedRate = $requestsCount > 0
        ? round(($rejectedCount / $requestsCount) * 100)
        : 0;

    $returnedRate = $requestsCount > 0
        ? round(($returnedCount / $requestsCount) * 100)
        : 0;


    return view(
        'admin.dashboard',
        compact(

            'studentsCount',

            'employeesCount',

            'servicesCount',

            'requestsCount',

            'reviewCount',

            'approvedCount',

            'rejectedCount',

            'returnedCount',

            'reviewRate',

            'approvedRate',

            'rejectedRate',

            'returnedRate'

        )
    );
}
    public function report()
{
    return view('reports.report');
}
}