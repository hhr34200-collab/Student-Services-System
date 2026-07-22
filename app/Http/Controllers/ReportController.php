<?php

namespace App\Http\Controllers;


use App\Models\RequestModel;
use App\Models\Employee;
use App\Models\Student;
use App\Models\Service;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class ReportController extends Controller
{
   public function report()
{
    //====================================
    // الإحصائيات العامة
    //====================================

    $studentsCount = Student::count();

    $employeesCount = Employee::count();

    $servicesCount = Service::count();

    $requestsCount = RequestModel::count();


    //====================================
    // إحصائيات الطلبات
    //====================================

    $reviewCount = RequestModel::whereIn('status', [

        'submitted',

        'student_affairs_review',

        'department_head_review',

    ])->count();


    $approvedCount = RequestModel::where(
        'status',
        'approved'
    )->count();


    $rejectedCount = RequestModel::where(
        'status',
        'rejected'
    )->count();


    $returnedCount = RequestModel::where(
        'status',
        'returned_to_student'
    )->count();


    //====================================
    // مؤشرات الأداء
    //====================================

    $approvalRate = $requestsCount > 0
        ? round(($approvedCount / $requestsCount) * 100, 2)
        : 0;

    $rejectionRate = $requestsCount > 0
        ? round(($rejectedCount / $requestsCount) * 100, 2)
        : 0;

    $returnedRate = $requestsCount > 0
        ? round(($returnedCount / $requestsCount) * 100, 2)
        : 0;


    //====================================
    // أكثر الخدمات استخداماً
    //====================================

    $topServices = RequestModel::selectRaw(
            'service_id, COUNT(*) as total'
        )
        ->with('service')
        ->groupBy('service_id')
        ->orderByDesc('total')
        ->take(5)
        ->get();


    //====================================
    // إرسال البيانات للواجهة
    //====================================

    return view(
        'reports.report',
        compact(

            'studentsCount',

            'employeesCount',

            'servicesCount',

            'requestsCount',

            'reviewCount',

            'approvedCount',

            'rejectedCount',

            'returnedCount',

            'approvalRate',

            'rejectionRate',

            'returnedRate',

            'topServices'

        )
    );
}
  public function downloadPdf()
{
    //====================================
    // الإحصائيات العامة
    //====================================

    $studentsCount = Student::count();

    $employeesCount = Employee::count();

    $servicesCount = Service::count();

    $requestsCount = RequestModel::count();


    //====================================
    // إحصائيات الطلبات
    //====================================

    $reviewCount = RequestModel::whereIn('status', [

        'submitted',

        'student_affairs_review',

        'department_head_review',

    ])->count();


    $approvedCount = RequestModel::where(
        'status',
        'approved'
    )->count();


    $rejectedCount = RequestModel::where(
        'status',
        'rejected'
    )->count();


    $returnedCount = RequestModel::where(
        'status',
        'returned_to_student'
    )->count();


    //====================================
    // مؤشرات الأداء
    //====================================

    $approvalRate = $requestsCount > 0
        ? round(($approvedCount / $requestsCount) * 100, 2)
        : 0;


    $rejectionRate = $requestsCount > 0
        ? round(($rejectedCount / $requestsCount) * 100, 2)
        : 0;


    $returnedRate = $requestsCount > 0
        ? round(($returnedCount / $requestsCount) * 100, 2)
        : 0;


    //====================================
    // أكثر الخدمات استخداماً
    //====================================

    $topServices = RequestModel::selectRaw(
            'service_id, COUNT(*) as total'
        )
        ->with('service')
        ->groupBy('service_id')
        ->orderByDesc('total')
        ->take(5)
        ->get();


    //====================================
    // إنشاء صفحة التقرير
    //====================================

    $html = view(
        'reports.report-pdf',
        compact(

            'studentsCount',

            'employeesCount',

            'servicesCount',

            'requestsCount',

            'reviewCount',

            'approvedCount',

            'rejectedCount',

            'returnedCount',

            'approvalRate',

            'rejectionRate',

            'returnedRate',

            'topServices'

        )
    )->render();


    //====================================
    // إنشاء PDF
    //====================================

//====================================
// إنشاء PDF
//====================================

$mpdf = new Mpdf([

    'mode' => 'utf-8',

    'format' => 'A4',

    'orientation' => 'P',

    'default_font' => 'dejavusans',

    'margin_top' => 15,

    'margin_bottom' => 15,

    'margin_left' => 15,

    'margin_right' => 15,

]);

$mpdf->WriteHTML($html);

return response(
    $mpdf->Output(
        'System_Report.pdf',
        'S'
    )
)
->header(
    'Content-Type',
    'application/pdf'
)
->header(
    'Content-Disposition',
    'attachment; filename="System_Report.pdf"'
);
}

}