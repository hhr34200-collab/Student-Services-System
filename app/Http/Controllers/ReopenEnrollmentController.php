<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Student;
use App\Models\RequestModel;
use App\Models\ReopenEnrollment;
use App\Models\Attachment;
use App\Models\Notification;
use App\Events\NewNotificationEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\StopEnrollment;
use Carbon\Carbon;
use App\Models\Employee;
use App\Services\NotificationService;
use App\Services\RealtimeService;

class ReopenEnrollmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | عرض صفحة إعادة القيد
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $user = Auth::user();

        $student = Student::with([
            'college',
            'department',
            'user'
        ])->find($user->student_id);

        if (!$student) {

            return back()->with(
                'error',
                'لم يتم العثور على بيانات الطالب'
            );
        }

        return view(
            'dashboard-student.reopen_enrollment',
            compact('student')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | حفظ الطلب
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'academic_year' => 'required',

            'request_date'  => 'required|date',

            'attachments.*' =>
            'nullable|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'

        ]);

        $user = Auth::user();

        $student = Student::find(
            $user->student_id
        );

        if (!$student) {

            return back()->with(
                'error',
                'لم يتم العثور على بيانات الطالب'
            );
        }
        /*
|--------------------------------------------------------------------------
| يجب أن يكون الطالب موقوف القيد
|--------------------------------------------------------------------------
*/

if ($student->academic_status != 'stopped') {

    return back()->with(
        'error',
        'لا يمكن تقديم طلب إعادة القيد لأن الطالب ليس موقوف القيد.'
    );
}
        /*
|--------------------------------------------------------------------------
| شروط إعادة القيد
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| التحقق من طلبات وقف القيد
|--------------------------------------------------------------------------
*/

// هل يوجد أي طلب وقف قيد؟
$hasStopRequest = StopEnrollment::whereHas(
    'request',
    function ($query) use ($student) {

        $query->where(
            'student_id',
            $student->student_id
        );

    }
)->exists();

// آخر طلب وقف قيد معتمد
$approvedStopRequest = StopEnrollment::whereHas(
    'request',
    function ($query) use ($student) {

        $query->where(
            'student_id',
            $student->student_id
        )
        ->where(
            'status',
            'approved'
        );

    }
)
->latest('request_date')
->first();

// يوجد طلب لكنه غير معتمد
if ($hasStopRequest && !$approvedStopRequest) {

    return back()->with(
        'error',
        'لا يمكن تقديم طلب إعادة القيد إلا بعد اعتماد طلب وقف القيد.'
    );
}

// إذا وجد طلب معتمد نطبق شرط السنتين
if ($approvedStopRequest) {

    if (!$approvedStopRequest->request->approved_at) {

        return back()->with(
            'error',
            'تاريخ اعتماد طلب وقف القيد غير موجود.'
        );
    }

    $stopDate = Carbon::parse(
        $approvedStopRequest->request->approved_at
    );

    if (
        $stopDate
            ->copy()
            ->addYears(2)
            ->lt(now())
    ) {

        return back()->with(
            'error',
            'لا يمكن تقديم طلب إعادة القيد لأن مدة الانقطاع تجاوزت سنتين.'
        );
    }
}
/*
|--------------------------------------------------------------------------
| منع تكرار طلب إعادة القيد
|--------------------------------------------------------------------------
*/

$existingReopen = ReopenEnrollment::whereHas(
    'request',
    function ($query) use ($student) {

        $query->where(
            'student_id',
            $student->student_id
        )
        ->whereIn(
            'status',
            [
                'submitted',
                'student_affairs_review',
                'department_head_review',
                'dean_review',
                'approved'
            ]
        );

    }
)->exists();

if ($existingReopen) {

    return back()->with(
        'error',
        'يوجد لديك طلب إعادة قيد سابق ولا يمكن تقديم طلب جديد.'
    );
}
        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | جلب الخدمة
            |--------------------------------------------------------------------------
            */

            $service = Service::where(
                'service_name',
                 'إعادة القيد'
            )->first();

            if (!$service) {

                return back()->with(
                    'error',
                    'خدمة إعادة القيد غير موجودة'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | إنشاء الطلب
            |--------------------------------------------------------------------------
            */
            $lastRequest = RequestModel::latest('request_id')->first();
            $nextNumber = $lastRequest
              ? (int) substr($lastRequest->request_number, -6) + 1
                : 1;
            $requestNumber = 'REQ-' . date('Y') . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);


             $studentAffairs = Employee::where(
            'job_title',
             'موظف شؤون الطلاب'
             )->first();
             $lastRequest = RequestModel::latest('request_id')->first();

            $newRequest = RequestModel::create([
                 'request_number' => $requestNumber,

                'student_id' => $student->student_id,

                'service_id' => $service->service_id,

                'status' => 'submitted',
                 'current_employee_id' => $studentAffairs->employee_id,


                'notes' => null

            ]);

            /*
            |--------------------------------------------------------------------------
            | إنشاء بيانات إعادة القيد
            |--------------------------------------------------------------------------
            */

            ReopenEnrollment::create([

                'request_id' => $newRequest->request_id,

                'academic_year' => $request->academic_year,

                'request_date' => $request->request_date

            ]);

            /*
            |--------------------------------------------------------------------------
            | حفظ المرفقات
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('attachments')) {

                foreach ($request->file('attachments') as $file) {

                    $path = $file->store(
                        'attachments',
                        'public'
                    );

                    Attachment::create([

                        'request_id' => $newRequest->request_id,

                        'file_name' =>
                        $file->getClientOriginalName(),

                        'file_path' => $path,

                        'file_type' =>
                        $file->getClientOriginalExtension(),

                        'file_size' =>
                        $file->getSize(),

                        'is_verified' => false

                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | إنشاء إشعار
            |--------------------------------------------------------------------------
            */

          // إشعار الطالب
NotificationService::send(

    Auth::id(),

    'تم إرسال الطلب',

    'تم إرسال طلب إعادة القيد بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.',

    'submitted',

    $newRequest->request_id,

    route(
        'my-requests.show',
        $newRequest->request_id
    )

);

// إشعار موظف شؤون الطلاب
if ($studentAffairs && $studentAffairs->user) {

    NotificationService::send(

        $studentAffairs->user->id,

        'طلب جديد',

        'قام الطالب ' . $student->full_name . ' بإرسال طلب إعادة قيد جديد.',

        'info',

        $newRequest->request_id,

        route(
            'employee.request.show',
            $newRequest->request_id
        )

    );

    RealtimeService::refreshEmployee(
        $studentAffairs->user->id
    );
}

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}