<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Student;
use App\Models\RequestModel;
use App\Models\StopEnrollment;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Events\NewNotificationEvent;
use App\Models\Employee;
use App\Services\NotificationService;
use App\Services\RealtimeService;

class StopEnrollmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | عرض صفحة وقف القيد
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
            'dashboard-student.stop_enrollment',
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
            'semester'      => 'required',
            'stop_period'   => 'required',
            'reason'        => 'required|string',
            'request_date'  => 'required|date',
            'attachments.*' => 'nullable|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'
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
        
        if ($student->level == 'المستوى الأول') {

            return back()->with(
               'error',
               'لا يمكن تقديم طلب وقف القيد إلا بعد إكمال السنة الدراسية الأولى.'
            );
        }
       
        if ($student->academic_status == 'stopped') {

            return back()->with(
             'error',
             'الطالب موقوف القيد بالفعل.'
            );
        }
           $existingStop = StopEnrollment::whereHas(
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

         
          })->exists();
            if ($existingStop) {

                 return back()->with(
                 'error',
                 'لا يمكن تقديم طلب وقف قيد جديد لوجود طلب سابق قيد المراجعة أو معتمد.'
                 );
                
}

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | جلب خدمة وقف القيد
            |--------------------------------------------------------------------------
            */

            $service = Service::where(
                'service_name',
                'وقف القيد'
            )->first();

            if (!$service) {
                return back()->with(
                    'error',
                    'خدمة وقف القيد غير موجودة'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | حساب عدد مرات وقف القيد السابقة
            |--------------------------------------------------------------------------
            */

             $previousStops = StopEnrollment::whereHas(
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
                   )->count();

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
            | إنشاء سجل وقف القيد
            |--------------------------------------------------------------------------
            */

            StopEnrollment::create([

                'request_id' => $newRequest->request_id,

                'academic_year' => $request->academic_year,

                'semester' => $request->semester,

                'stop_period' => $request->stop_period,

                'reason' => $request->reason,

                'previous_stop_count' => $previousStops,

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

                        'file_name' => $file->getClientOriginalName(),

                        'file_path' => $path,

                        'file_type' => $file->getClientOriginalExtension(),

                        'file_size' => $file->getSize(),

                        'is_verified' => false

                    ]);
                }
            }
                
                    
                 // إشعار الطالب
NotificationService::send(

    Auth::id(),

    'تم إرسال الطلب',

    'تم إرسال طلبك بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.',

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

        'قام الطالب ' . $student->full_name . ' بإرسال طلب وقف قيد جديد.',

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
                                 
                               /*  Mail::to(
                                     $student->user->email
                                     )->send(

                                new NotificationMail(

                                                 'تم إرسال الطلب',

                                                 'تم إرسال طلب وقف القيد بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.'
 
                                                     )
            
                                            );*/
            DB::commit();

            return redirect()
                 ->route('my-requests')
                 ->with(
                 'success',
                 'تم إرسال طلب وقف القيد بنجاح'
            );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}