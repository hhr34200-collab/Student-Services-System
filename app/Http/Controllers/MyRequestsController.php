<?php

namespace App\Http\Controllers;

use App\Models\RequestModel;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Attachment;
use App\Services\NotificationService;
use App\Models\Employee;
use Illuminate\Http\Request;

class MyRequestsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $student = Student::find(
        $user->student_id
    );


        if (!$student) {
            return redirect()
                ->route('login')
                ->with('error', 'يرجى تسجيل الدخول');
        }

        $requests = RequestModel::with([
            'service',
            'stopEnrollment',
            'student',
            'reopenEnrollment'

        ])
        ->where(
            'student_id',
            $student->student_id
        )
        ->latest()
        ->get();

        return view(
           'dashboard-student.my-requests',
            compact('requests')
        );
    }

    public function show($id)
    {
         $user = Auth::user();

        $student = Student::find(
        $user->student_id
    );
        if (!$student) {
            return redirect()
                ->route('login')
                ->with('error', 'يرجى تسجيل الدخول');
        }

        $requestData = RequestModel::with([
        

    'service',

    'stopEnrollment',

    'reopenEnrollment',

    'appeal.items.course',

    'attachments',

    'student.college',

    'student.department'



        ])
        ->where(
            'student_id',
            $student->student_id
        )
        ->findOrFail($id);
        $requestData->loadMissing([
          'stopEnrollment',
          'reopenEnrollment' ,
          'appeal.items.course'
        ]);

        return response()->json($requestData);
    }

  public function print($id)
{
    $user = Auth::user();

    $student = Student::find($user->student_id);

    if (!$student) {
        return redirect()
            ->route('login')
            ->with('error', 'يرجى تسجيل الدخول');
    }

    $request = RequestModel::with([
        'service',
        'stopEnrollment',
        'attachments',
        'student',
        'approvals.employee.user'
    ])
    ->where('student_id', $student->student_id)
    ->findOrFail($id);

    if ($request->status !== 'approved') {
        abort(403, 'الطلب لا يزال قيد المعالجة');
    }

    return view('employees.print-request', compact('request'));
}
   public function completeRequest(Request $request, $id)
{
    try {
    $user = Auth::user();

    $student = Student::find($user->student_id);

    if (!$student) {

        return response()->json([
            'success' => false,
            'message' => 'الطالب غير موجود'
        ],403);

    }

    /*
    |--------------------------------------------------------------------------
    | جلب الطلب
    |--------------------------------------------------------------------------
    */

    $requestModel = RequestModel::where(
        'student_id',
        $student->student_id
    )->findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | حفظ رد الطالب
    |--------------------------------------------------------------------------
    */

    $requestModel->student_reply = $request->student_reply;

    /*
    |--------------------------------------------------------------------------
    | إعادة الطلب لشؤون الطلاب
    |--------------------------------------------------------------------------
    */

    $employee = Employee::where(
        'job_title',
        'موظف شؤون الطلاب'
    )->first();

   $requestModel->status = 'student_affairs_review';

    $requestModel->current_employee_id =
        $employee?->employee_id;

    $requestModel->save();

    /*
    |--------------------------------------------------------------------------
    | حفظ الملفات الجديدة
    |--------------------------------------------------------------------------
    */

    if($request->hasFile('attachments')){

        foreach($request->file('attachments') as $file){

            $path = $file->store(
                'attachments',
                'public'
            );

            Attachment::create([

                'request_id' => $requestModel->request_id,

                'file_name' => $file->getClientOriginalName(),

                'file_path' => $path,

                'file_type' => $file->getClientMimeType(),

                'file_size' => $file->getSize(),

                'is_verified' => false

            ]);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | إشعار الموظف
    |--------------------------------------------------------------------------
    */

    if($employee && $employee->user){

        NotificationService::send(

            $employee->user->id,

            'تم استكمال الطلب',

            'قام الطالب باستكمال الطلب رقم '

            .$requestModel->request_number,

            'review',

            $requestModel->request_id,

            route(
                'employee.request.show',
                $requestModel->request_id
            )

        );

    }

    /*
    |--------------------------------------------------------------------------
    | إشعار الطالب
    |--------------------------------------------------------------------------
    */

    $studentUserId = $requestModel->student->user->id;

NotificationService::send(

    $studentUserId,

    'تم إرسال الاستكمال',

    'تم إرسال استكمال الطلب رقم '.$requestModel->request_number.' إلى شؤون الطلاب.',

    'success',

    $requestModel->request_id,

    route(
        'my-requests.show',
        $requestModel->request_id
    )

);
     return response()->json([
            'success' => true
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
        ], 500);

    }
}}