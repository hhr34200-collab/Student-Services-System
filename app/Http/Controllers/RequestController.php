<?php

namespace App\Http\Controllers;

use App\Models\RequestModel;
use App\Models\Employee;
use App\Models\Student;
use App\Models\Service;
use Illuminate\Http\Request;

class RequestController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | عرض الطلبات النشطة
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $requests = RequestModel::with([
            'student',
            'service',
            'currentEmployee.user'
        ])
        ->whereNotIn('status',[
            'approved',
            'rejected',
            'cancelled'
        ])
        ->latest()
        ->get();

        // إضافة بيانات تاريخ الإنشاء للفلتر
        $requests->each(function($request) {
            $request->created_at_formatted = $request->created_at->toISOString();
        });

        return view(
            'requests.index',
            compact('requests')
        );
    }
     public function moveNext($id)
    {
        $request = RequestModel::findOrFail($id);


        /*
        من جديد -> شؤون الطلاب
        */
        if ($request->status == 'submitted') {

            $employee = Employee::where(
                'job_title',
                'موظف شؤون الطلاب'
            )->first();

            $request->update([

                'status' =>
                'student_affairs_review',

                'current_employee_id' =>
                $employee->employee_id

            ]);
        }


        /*
        من شؤون الطلاب -> رئيس القسم
        */
        elseif ($request->status == 'student_affairs_review') {

            $employee = Employee::where(
                'job_title',
                'رئيس القسم'
            )->first();

            $request->update([

                'status' =>
                'department_head_review',

                'current_employee_id' =>
                $employee->employee_id

            ]);
        }


        /*
        من رئيس القسم -> العميد
        */
        elseif ($request->status == 'department_head_review') {

            $employee = Employee::where(
                'job_title',
               'عميد الكلية'
            )->first();

            $request->update([

                'status' =>
                'dean_review',

                'current_employee_id' =>
                $employee->employee_id

            ]);
        }


        /*
        اعتماد نهائي
        */
        elseif ($request->status == 'dean_review') {


            $request->update([

                'status' => 'approved'

            ]);
        }


        return back()
        ->with(
            'success',
            'تم تحديث حالة الطلب'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | جلب بيانات الطلب بصيغة JSON
    |--------------------------------------------------------------------------
    */

    public function showJson($id)
    {
        $request = RequestModel::with([
            'student',
            'service',
            'currentEmployee.user'
        ])->findOrFail($id);

        // خريطة الحالات
        $statusMap = [
            'submitted' => 'جديد',
            'student_affairs_review' => 'شؤون الطلاب',
            'department_head_review' => 'رئيس القسم',
            'dean_review' => 'العميد',
            'attachments_required' => 'استكمال مرفقات',
            'returned' => 'معاد للطالب',
            'on_hold' => 'معلق',
            'approved' => 'معتمد',
            'rejected' => 'مرفوض',
            'cancelled' => 'ملغي',
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'request_number' => $request->request_number,
                'student_name' => $request->student->full_name ?? '-',
                'service_name' => $request->service->service_name ?? '-',
                'current_employee' => $request->currentEmployee->full_name ?? 'غير محدد',
                'status_text' => $statusMap[$request->status] ?? $request->status,
                'status_key' => $request->status,
                'service_name_ar' => $request->service->service_name ?? '-',
                'current_employee_ar' => $request->currentEmployee->full_name ?? 'غير محدد',
            ]
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | أرشيف الطلبات
    |--------------------------------------------------------------------------
    */

    public function archive()
    {
        $requests = RequestModel::with([
            'student',
            'service'
        ])
        ->whereIn('status',[
            'approved',
            'rejected',
            'cancelled'
        ])
        ->latest()
        ->get();

        return view(
            'requests.archive',
            compact('requests')
        );
    }
}