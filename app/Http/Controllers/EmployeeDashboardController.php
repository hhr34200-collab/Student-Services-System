<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\RequestModel;
use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Models\RequestApproval;
use App\Services\NotificationService;
use App\Services\RealtimeService;

class EmployeeDashboardController extends Controller
{
   public function index()
{
  /*
|--------------------------------------------------------------------------
| الموظف الحالي
|--------------------------------------------------------------------------
|
| يتم جلب الموظف من العلاقة الموجودة داخل User Model.
|
*/

$employee = auth()->user()->employee;


    $requests = RequestModel::with([
        'student',
        'service'
    ])
   ->where(
    'current_employee_id',
    $employee->employee_id
)
    ->get();

    return view(
        'employees.dashboard',
        compact(
            'employee',
            'requests'
        )
    );
}
/*
|--------------------------------------------------------------------------
| عرض تفاصيل الطلب
|--------------------------------------------------------------------------
|
| تقوم هذه الدالة بفتح الاستمارة المناسبة حسب نوع الخدمة.
|
*/

public function show($id)
{
    /*
    |--------------------------------------------------------------------------
    | جلب الطلب مع جميع العلاقات
    |--------------------------------------------------------------------------
    */
   
    $request = RequestModel::with([

        'student',

        'student.department',

        'student.college',

        'service',

        'stopEnrollment',

        'reopenEnrollment',

        'appeal',

        'attachments',

        'approvals.employee.user'

    ])->findOrFail($id);
    

    /*
    |--------------------------------------------------------------------------
    | الموظف الحالي
    |--------------------------------------------------------------------------
    */

    $employee = $this->currentEmployee();
    /*
|--------------------------------------------------------------------------
| إشعار بدء مراجعة الطلب (مرة واحدة)
|--------------------------------------------------------------------------
*/
if (

    $request->review_started_at == null &&

    $request->status == 'submitted' &&

    $request->student &&

    $request->student->user

) {

    $request->update([

        'review_started_at' => now(),

        'status' => 'student_affairs_review'

    ]);

    NotificationService::send(

        $request->student->user->id,

        'طلبك قيد المراجعة',

        'تم استلام الطلب وبدأت مراجعته من قبل موظف شؤون الطلاب.',

        'review',

        $request->request_id,

        route(
            'my-requests.show',
            $request->request_id
        )

    );
        RealtimeService::refreshStudent(
    $request->student->user->id
);


}



    /*
    |--------------------------------------------------------------------------
    | صلاحيات كتابة الإفادة
    |--------------------------------------------------------------------------
    */

    $canWriteStudentAffairs =
    
        $employee->job_title == 'موظف شؤون الطلاب';

    $canWriteDepartmentHead =
        $employee->job_title == 'رئيس القسم';

    $canWriteDean =
        $employee->job_title == 'عميد الكلية';

    $canWriteArchive =
        $employee->job_title == 'رئيس قسم الأرشيف';

    /*
    |--------------------------------------------------------------------------
    | تحديد صفحة الاستمارة حسب الخدمة
    |--------------------------------------------------------------------------
    */

    switch ($request->service->service_name) {

    case 'وقف القيد':

        $view = 'requests.stop_enrollment';

        break;

    case 'إعادة القيد':

        $view = 'requests.reopen_enrollment';

        break;

    case 'التظلم':

        $view = 'requests.appeal';

        break;

    default:

        abort(404, 'الخدمة غير مدعومة.');
}

    

    /*
    |--------------------------------------------------------------------------
    | عرض الصفحة
    |--------------------------------------------------------------------------
    */

    return view(

        $view,

        compact(

            'request',

            'employee',

            'canWriteStudentAffairs',

            'canWriteDepartmentHead',

            'canWriteDean',

            'canWriteArchive'

        )

    )->with('printMode', false);
}
public function print($id)
{
    $request = RequestModel::with([

        'student',

        'student.department',

        'student.college',

        'service',

        'stopEnrollment',

        'reopenEnrollment',

        'appeal',

        'attachments',

        'approvals.employee.user'

    ])->findOrFail($id);

   if ($request->status != 'approved') {

    abort(403,'لا يمكن طباعة الطلب قبل اعتماده نهائياً.');

}

return view(
    'employees.print-request',
    compact('request')
);
}

public function downloadAttachment($id)
{
    $attachment = Attachment::findOrFail($id);

    $path = storage_path(
        'app/public/' . $attachment->file_path
    );

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
}
/*
|--------------------------------------------------------------------------
| اعتماد الطلب والانتقال للمرحلة التالية
|--------------------------------------------------------------------------
|
| تستخدم لجميع الخدمات.
| لا يتم الاعتماد إلا بعد حفظ الإفادة.
|
*/

/*
|--------------------------------------------------------------------------
| اعتماد الطلب والانتقال للمرحلة التالية
|--------------------------------------------------------------------------
|
| تستخدم لجميع الخدمات.
| لا يتم اعتماد الطلب إلا بعد حفظ الإفادة.
|
*/

public function approve($id)
{
    /*
    |--------------------------------------------------------------------------
    | جلب الطلب
    |--------------------------------------------------------------------------
    */
   

    $requestModel = $this->getRequest($id);

    /*
    |--------------------------------------------------------------------------
    | التحقق من الموظف الحالي
    |--------------------------------------------------------------------------
    */

    $employee = $this->validateEmployee($requestModel);

    /*
    |--------------------------------------------------------------------------
    | التأكد من حفظ الإفادة
    |--------------------------------------------------------------------------
    */

    if (!$this->validateApproval($requestModel, $employee)) {

        return back()->with(
            'error',
            'يجب حفظ الإفادة قبل اعتماد الطلب.'
        );

    }

    /*
    |--------------------------------------------------------------------------
    | الموظف التالي
    |--------------------------------------------------------------------------
    */

    $nextEmployee = $this->nextEmployee(
        $employee->job_title
    );

    /*
    |--------------------------------------------------------------------------
    | تحديد حالة الطلب
    |--------------------------------------------------------------------------
    */

    switch ($employee->job_title) {

        case 'موظف شؤون الطلاب':

            $status = 'student_affairs_review';

            break;

        case 'رئيس القسم':

            $status = 'department_head_review';

            break;

        case 'عميد الكلية':

            $status = 'archive_review';

            break;

        case 'رئيس قسم الأرشيف':

            $status = 'approved';

            break;

        default:

            $status = 'under_review';

    }

    /*
    |--------------------------------------------------------------------------
    | الاعتماد النهائي والأرشفة
    |--------------------------------------------------------------------------
    */

    if ($employee->job_title == 'رئيس قسم الأرشيف') {

        $requestModel->update([

            'status' => 'approved',

            'current_employee_id' => $nextEmployee?->employee_id,

            'approved_at' => now()

        ]);
        

        /*
        |--------------------------------------------------------------------------
        | إشعار الطالب
        |--------------------------------------------------------------------------
        */

        if ($requestModel->student && $requestModel->student->user) {

            NotificationService::send(

                $requestModel->student->user->id,

                'تم اعتماد الطلب',

                'تم اعتماد طلبك نهائياً وأرشفته.',

                'success',

                $requestModel->request_id,

                route(
                      'my-requests.show',
  
                    $requestModel->request_id
                )

            );

        }

        return back()->with(
            'success',
            'تم اعتماد الطلب نهائياً وأرشفته.'
        );

    }

    /*
    |--------------------------------------------------------------------------
    | تحويل الطلب للموظف التالي
    |--------------------------------------------------------------------------
    */

    $requestModel->update([

        'status' => $status,

        'current_employee_id' => $nextEmployee?->employee_id

    ]);
    /*
|--------------------------------------------------------------------------
| تحديث الواجهات
|--------------------------------------------------------------------------
*/

if ($requestModel->student && $requestModel->student->user) {

    RealtimeService::refreshStudent(
        $requestModel->student->user->id
    );

}

if ($nextEmployee && $nextEmployee->user) {

    RealtimeService::refreshEmployee(
        $nextEmployee->user->id
    );

}
    /*

|--------------------------------------------------------------------------
| إشعار الطالب بتقدم الطلب
|--------------------------------------------------------------------------
*/

if ($requestModel->student && $requestModel->student->user) {

    $message = '';

    switch ($employee->job_title) {

        case 'موظف شؤون الطلاب':

            $message =
            'تمت مراجعة طلبك من شؤون الطلاب وتحويله إلى رئيس القسم.';

            break;

        case 'رئيس القسم':

            $message =
            'تم اعتماد طلبك من رئيس القسم وتحويله إلى عميد الكلية.';

            break;

        case 'عميد الكلية':

            $message =
            'تم اعتماد طلبك من عميد الكلية وتحويله إلى قسم الأرشيف.';

            break;

    }

    NotificationService::send(

        $requestModel->student->user->id,

        'تحديث حالة الطلب',

        $message,

        'review',

        $requestModel->request_id,

        route(
            'my-requests.show',
            $requestModel->request_id
        )

    );

}

    /*
    |--------------------------------------------------------------------------
    | إشعار الموظف التالي
    |--------------------------------------------------------------------------
    */

    if ($nextEmployee && $nextEmployee->user) {

        NotificationService::send(

            $nextEmployee->user->id,

            'طلب جديد',

            'تم تحويل طلب جديد إليك للمراجعة.',
                  'info',

            $requestModel->request_id,

            route(
                'employee.request.show',
                $requestModel->request_id
            )

        );

    }

    return back()->with(
        'success',
        'تم اعتماد الطلب وتحويله للمرحلة التالية.'
    );
}
/*
|--------------------------------------------------------------------------
| الموظف الحالي
|--------------------------------------------------------------------------
|
| بعد تعديل قاعدة البيانات أصبح جدول users هو الذي يحمل
| employee_id، لذلك نجلب الموظف من العلاقة الموجودة داخل
| User Model بدلاً من البحث بواسطة user_id.
|
*/

private function currentEmployee()
{
    return auth()->user()->employee;
}





/*
|--------------------------------------------------------------------------
| إعادة الطلب
|--------------------------------------------------------------------------
|
| تحدد هذه الدالة تلقائياً الجهة التي سيعود إليها الطلب
| حسب الموظف الحالي.
|
*/

public function returnRequest(Request $request, $id)
{
    /*
    |--------------------------------------------------------------------------
    | التحقق من إدخال السبب
    |--------------------------------------------------------------------------
    */

    $request->validate([
        'reason' => 'required|string|max:1000'
    ]);

    /*
    |--------------------------------------------------------------------------
    | جلب الطلب
    |--------------------------------------------------------------------------
    */

    $requestModel = $this->getRequest($id);

    /*
    |--------------------------------------------------------------------------
    | التحقق من الموظف الحالي
    |--------------------------------------------------------------------------
    */

    $employee = $this->validateEmployee($requestModel);

    /*
    |--------------------------------------------------------------------------
    | تحديد الجهة التي سيعود إليها الطلب
    |--------------------------------------------------------------------------
    */

    switch ($employee->job_title) {

        /*
        |--------------------------------------------------------------------------
        | شؤون الطلاب ← الطالب
        |--------------------------------------------------------------------------
        */

        case 'موظف شؤون الطلاب':

           $requestModel->update([

    'status' => 'returned_to_student',

    'current_employee_id' => $employee->employee_id,

    'notes' => $request->reason

]);

            /*
            |--------------------------------------------------------------------------
            | إشعار الطالب
            |--------------------------------------------------------------------------
            */

            if ($requestModel->student && $requestModel->student->user) {

                NotificationService::send(

                    $requestModel->student->user->id,

                    'تمت إعادة الطلب',

                    'يرجى استكمال الطلب. السبب: ' . $request->reason,

                    'warning',

                    $requestModel->request_id,

                    route(
                      'employee.request.show',
                        $requestModel->request_id
                    )

                );

            }

            break;


        /*
        |--------------------------------------------------------------------------
        | رئيس القسم ← شؤون الطلاب
        |--------------------------------------------------------------------------
        */

        case 'رئيس القسم':

            $studentAffairs = Employee::where(
                'job_title',
                'موظف شؤون الطلاب'
            )->first();

            $requestModel->update([

                'status' => 'returned_to_student_affairs',

                'current_employee_id' => $studentAffairs?->employee_id,

                'notes' => $request->reason

            ]);

            /*
            |--------------------------------------------------------------------------
            | إشعار موظف شؤون الطلاب
            |--------------------------------------------------------------------------
            */

            if ($studentAffairs && $studentAffairs->user) {

                NotificationService::send(

                    $studentAffairs->user->id,

                    'تمت إعادة الطلب',

                    'أعاد رئيس القسم الطلب. السبب: ' . $request->reason,

                    'warning',

                    $requestModel->request_id,

                    route(
                        'employee.request.show',
                        $requestModel->request_id
                    )

                );

            }

            break;


        /*
        |--------------------------------------------------------------------------
        | العميد ← رئيس القسم
        |--------------------------------------------------------------------------
        */

        case 'عميد الكلية':

            $departmentHead = Employee::where(
                'job_title',
                'رئيس القسم'
            )->first();

            $requestModel->update([

                'status' => 'returned_to_department_head',

                'current_employee_id' => $departmentHead?->employee_id,

                'notes' => $request->reason

            ]);

            /*
            |--------------------------------------------------------------------------
            | إشعار رئيس القسم
            |--------------------------------------------------------------------------
            */

            if ($departmentHead && $departmentHead->user) {

                NotificationService::send(

                    $departmentHead->user->id,

                    'تمت إعادة الطلب',

                    'أعاد عميد الكلية الطلب. السبب: ' . $request->reason,

                    'warning',

                    $requestModel->request_id,

                    route(
                        'employee.request.show',
                        $requestModel->request_id
                    )

                );

            }

            break;


        /*
        |--------------------------------------------------------------------------
        | غير مسموح
        |--------------------------------------------------------------------------
        */

        default:

            return back()->with(

                'error',

                'لا يمكن إعادة الطلب من هذه المرحلة.'

            );

    }

    /*
    |--------------------------------------------------------------------------
    | رسالة النجاح
    |--------------------------------------------------------------------------
    */
/*
|--------------------------------------------------------------------------
| تحديث الواجهات
|--------------------------------------------------------------------------
*/

if ($requestModel->student && $requestModel->student->user) {

    RealtimeService::refreshStudent(
        $requestModel->student->user->id
    );

}

RealtimeService::refreshEmployee(
    $employee->user->id
);

/*
|--------------------------------------------------------------------------
| رسالة النجاح
|--------------------------------------------------------------------------
*/

return back()->with(

    'success',

    'تمت إعادة الطلب بنجاح.'

);
}
/*
|--------------------------------------------------------------------------
| جلب الطلب الحالي
|--------------------------------------------------------------------------
|
| تستخدم هذه الدالة في جميع العمليات حتى لا نكرر
| RequestModel::findOrFail() في كل دالة.
|
*/

private function getRequest($id)
{
    return RequestModel::findOrFail($id);
}


/*
|--------------------------------------------------------------------------
| التحقق من أن الطلب عند الموظف الحالي
|--------------------------------------------------------------------------
|
| تمنع أي موظف من تنفيذ عملية على طلب
| ليس موجوداً لديه.
|
*/

private function validateEmployee($requestModel)
{
    $employee = $this->currentEmployee();

    if ($requestModel->current_employee_id != $employee->employee_id) {

        abort(403,'هذا الطلب ليس عندك حالياً.');

    }

    return $employee;
}


/*
|--------------------------------------------------------------------------
| التحقق من حفظ الإفادة
|--------------------------------------------------------------------------
|
| لا يسمح بانتقال الطلب إلا بعد أن يقوم الموظف
| بحفظ إفادته.
|
*/

private function validateApproval($requestModel,$employee)
{
    return RequestApproval::where(

        'request_id',
        $requestModel->request_id

    )->where(

        'employee_id',
        $employee->employee_id

    )->exists();
}




/*
|--------------------------------------------------------------------------
| الموظف التالي في دورة العمل
|--------------------------------------------------------------------------
|
| تحدد هذه الدالة الموظف الذي سينتقل إليه الطلب
| حسب الموظف الحالي.
|
| جميع الخدمات ستستخدم نفس الدورة.
|
*/

private function nextEmployee($jobTitle)
{
    switch ($jobTitle) {

        // شؤون الطلاب → رئيس القسم
        case 'موظف شؤون الطلاب':

            return Employee::where(
                'job_title',
                'رئيس القسم'
            )->first();

        // رئيس القسم → عميد الكلية
        case 'رئيس القسم':

            return Employee::where(
                'job_title',
                'عميد الكلية'
            )->first();

        // العميد → رئيس قسم الأرشيف
        case 'عميد الكلية':

            return Employee::where(
                'job_title',
                'رئيس قسم الأرشيف'
            )->first();

        // الأرشيف → لا يوجد موظف بعده
        case 'رئيس قسم الأرشيف':

            return null;

        default:

            return null;
    }
}

public function saveApproval(Request $request, $id)
{
    /*
    |--------------------------------------------------------------------------
    | التحقق من البيانات
    |--------------------------------------------------------------------------
    */

    $request->validate([
        'approval_text' => 'required|string'
    ]);

    /*
    |--------------------------------------------------------------------------
    | الطلب الحالي
    |--------------------------------------------------------------------------
    */

    $requestModel = $this->getRequest($id);

    /*
    |--------------------------------------------------------------------------
    | الموظف الحالي
    |--------------------------------------------------------------------------
    */

    $employee = $this->validateEmployee($requestModel);

    /*
    |--------------------------------------------------------------------------
    | تحديد المرحلة حسب المسمى الوظيفي
    |--------------------------------------------------------------------------
    */

    switch ($employee->job_title) {

        case 'موظف شؤون الطلاب':
            $stage = 'student_affairs';
            break;

        case 'رئيس القسم':
            $stage = 'department_head';
            break;

        case 'عميد الكلية':
            $stage = 'dean';
            break;

        case 'رئيس قسم الأرشيف':
            $stage = 'archive';
            break;

        default:
            abort(403,'ليس لديك صلاحية.');
    }

    /*
    |--------------------------------------------------------------------------
    | التأكد من عدم وجود إفادة سابقة
    |--------------------------------------------------------------------------
    */

    $exists = RequestApproval::where(
        'request_id',
        $requestModel->request_id
    )->where(
        'stage',
        $stage
    )->exists();

    if($exists){

        return back()->with(
            'error',
            'تم حفظ الإفادة مسبقاً.'
        );

    }

    /*
    |--------------------------------------------------------------------------
    | حفظ الإفادة
    |--------------------------------------------------------------------------
    */

    RequestApproval::create([

        'request_id'      => $requestModel->request_id,

        'employee_id'     => $employee->employee_id,

        'stage'           => $stage,

        'approval_text'   => $request->approval_text,

        'approval_status' => 'saved',

        'is_locked'       => true,

        'approved_at'     => now()

    ]);

    return back()->with(
        'success',
        'تم حفظ الإفادة بنجاح.'
    );
}
public function reviewRequests()
{
    /*
    |--------------------------------------------------------------------------
    | الموظف الحالي
    |--------------------------------------------------------------------------
    */

    $employee = auth()->user()->employee;

    /*
    |--------------------------------------------------------------------------
    | الطلبات قيد المراجعة الخاصة بهذا الموظف
    |--------------------------------------------------------------------------
    */

    $requests = RequestModel::with([

        'student',

        'service',
        
        'currentEmployee'

    ])

    ->where(
        'current_employee_id',
        $employee->employee_id
    )

    ->whereIn(
        'status',
        [

            'student_affairs_review',

            'department_head_review',

            'archive_review'

        ]
    )

    ->latest()

    ->paginate(10);
    /*
    |--------------------------------------------------------------------------
    | عرض الصفحة
    |--------------------------------------------------------------------------
    */

    return view(
        'employees.review-requests',
        compact(
            'employee',
            'requests'
        )
    );
}
/*
|--------------------------------------------------------------------------
| الطلبات التي تحتاج استكمال
|--------------------------------------------------------------------------
|
| تعرض جميع الطلبات التي تمت إعادتها سواء للطالب
| أو لشؤون الطلاب أو لرئيس القسم.
|
*/

public function needComplete()
{
    /*
    |--------------------------------------------------------------------------
    | الموظف الحالي
    |--------------------------------------------------------------------------
    */

    $employee = auth()->user()->employee;

    /*
    |--------------------------------------------------------------------------
    | جلب الطلبات التي تحتاج استكمال
    |--------------------------------------------------------------------------
    */

    $requests = RequestModel::with([

        'student',

        'service'

    ])

    ->where(

        'current_employee_id',
        $employee->employee_id
    )

    ->whereIn(
        'status',
        [

            'returned_to_student',

            'returned_to_student_affairs',

            'returned_to_department_head'

        ]

    )

    ->latest()

    ->paginate(10);

    /*
    |--------------------------------------------------------------------------
    | عرض الصفحة
    |--------------------------------------------------------------------------
    */

    return view(

        'employees.need-complete',

        compact(

            'employee',

            'requests'

        )

    );

}
public function reject(Request $request, $id)
{
    /*
    |--------------------------------------------------------------------------
    | التحقق من السبب
    |--------------------------------------------------------------------------
    */

    $request->validate([

        'reason' => 'required|string|max:1000'

    ]);

    /*
    |--------------------------------------------------------------------------
    | الطلب الحالي
    |--------------------------------------------------------------------------
    */

    $requestModel = $this->getRequest($id);

    /*
    |--------------------------------------------------------------------------
    | التحقق من الموظف الحالي
    |--------------------------------------------------------------------------
    */

    $employee = $this->validateEmployee($requestModel);

    /*
    |--------------------------------------------------------------------------
    | تحديث حالة الطلب
    |--------------------------------------------------------------------------
    */

    $requestModel->update([

        'status' => 'rejected',

        'notes' => $request->reason,

        'current_employee_id' => null

    ]);

    /*
    |--------------------------------------------------------------------------
    | إشعار الطالب
    |--------------------------------------------------------------------------
    */

    if ($requestModel->student && $requestModel->student->user) {

        NotificationService::send(

            $requestModel->student->user->id,

            'تم رفض الطلب',

            'تم رفض طلبك. سبب الرفض: ' . $request->reason,

            'rejected',

            $requestModel->request_id,

            route(
                'my-requests.show',
                $requestModel->request_id
            )

        );

        RealtimeService::refreshStudent(
            $requestModel->student->user->id
        );

    }

    /*
    |--------------------------------------------------------------------------
    | تحديث واجهة الموظف
    |--------------------------------------------------------------------------
    */

    RealtimeService::refreshEmployee(
        $employee->user->id
    );

    return back()->with(

        'success',

        'تم رفض الطلب وإشعار الطالب.'

    );
}
public function archive()
{
    /*
    |--------------------------------------------------------------------------
    | الموظف الحالي
    |--------------------------------------------------------------------------
    */

    $employee = auth()->user()->employee;

    /*
    |--------------------------------------------------------------------------
    | جميع الطلبات المؤرشفة
    |--------------------------------------------------------------------------
    */

    $requests = RequestModel::with([

        'student',

        'service',

        'currentEmployee'

    ])

    ->where('status', 'approved')

    ->latest()

    ->paginate(10);

    /*
    |--------------------------------------------------------------------------
    | عرض الصفحة
    |--------------------------------------------------------------------------
    */

    return view(
        'employees.archive',
        compact(
            'employee',
            'requests'
        )
    );
}

public function profile()
{
    $user = auth()->user();

    $employee = $user->employee;

    return view(
        'employees.profile',
        compact(
            'user',
            'employee'
        )
    );
}
}