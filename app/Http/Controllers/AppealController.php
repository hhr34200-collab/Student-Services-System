<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Student;
use App\Models\RequestModel;
use App\Models\Appeal;
use App\Models\AppealItem;
use App\Models\Attachment;
use App\Models\Notification;
use App\Models\Course;
use App\Events\NewNotificationEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CourseAssignment;
use App\Models\Employee;
class AppealController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | عرض صفحة التظلم
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
                'لم يتم العثور على بيانات الطالب.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | جلب مقررات الطالب
        |--------------------------------------------------------------------------
        */

       $courses = collect();
               
       return view(
    'dashboard-student.appeal',
    compact(
        'student',
        'courses'
    )
);
    }

    /*
    |--------------------------------------------------------------------------
    | حفظ طلب التظلم
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([

            'academic_year' => 'required',

            'semester' => 'required',

            'submission_date' => 'required|date',

            'course_id' => 'required|array|min:1',

            'course_id.*' => 'required|exists:courses,course_id',

            'reason' => 'required|array|min:1',

            'reason.*' =>  'required|string|max:1000',

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
        | يسمح فقط للطالب النشط
        |--------------------------------------------------------------------------
        */

        if ($student->academic_status != 'active') {

            return back()->with(
                'error',
                'لا يمكن تقديم طلب التظلم إلا للطالب المقيد.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | التحقق من المقررات
        |--------------------------------------------------------------------------
        */

        if (
            count($request->course_id)
            !=
            count(array_unique($request->course_id))
        ) {

            return back()->with(
                'error',
                'لا يمكن اختيار نفس المقرر أكثر من مرة.'
            );
        }

        foreach ($request->course_id as $courseId) {

            $course = Course::find($courseId);

            $assignment = CourseAssignment::where('course_id', $courseId)

    ->where('department_id', $student->department_id)

    ->where('academic_year', $request->academic_year)

    ->where('semester', $request->semester)

    ->first();

if (!$assignment) {

    return back()->with(
        'error',
        'هذا المقرر لا يتبع قسم الطالب.'
    );
}

if (

    $course->level != $student->level ||

    $course->semester != $request->semester

) {

    return back()->with(
        'error',
        'بيانات المقرر لا تطابق بيانات الطالب.'
    );

}
            /*
            |--------------------------------------------------------------------------
            | منع التظلم على نفس المقرر مرتين
            |--------------------------------------------------------------------------
            */

            $exists = AppealItem::where(
                'course_id',
                $courseId
            )

            ->whereHas(
                'appeal.request',
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

            if ($exists) {

                return back()->with(
                    'error',
                    'يوجد طلب تظلم سابق لهذا المقرر.'
                );
            }

        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | جلب خدمة التظلم
            |--------------------------------------------------------------------------
            */

            $service = Service::where(
                'service_name',
                'التظلم '
            )->first();

            if (!$service) {

                return back()->with(
                    'error',
                    'خدمة التظلم غير موجودة.'
                );
            }            /*
            |--------------------------------------------------------------------------
            | إنشاء رقم الطلب
            |--------------------------------------------------------------------------
            */

            $lastRequest = RequestModel::latest('request_id')->first();

            $nextNumber = $lastRequest
                ? (int) substr($lastRequest->request_number, -6) + 1
                : 1;

            $requestNumber = 'REQ-' . date('Y') . '-' .
                str_pad(
                    $nextNumber,
                    6,
                    '0',
                    STR_PAD_LEFT
                );

            /*
            |--------------------------------------------------------------------------
            | إنشاء الطلب
            |--------------------------------------------------------------------------
            */$studentAffairs = Employee::where(
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
            | إنشاء سجل التظلم
            |--------------------------------------------------------------------------
            */

            $appeal = Appeal::create([

                'request_id' => $newRequest->request_id,

                'academic_year' => $request->academic_year,

                'semester' => $request->semester,

                'submission_date' => $request->submission_date

            ]);

            /*
            |--------------------------------------------------------------------------
            | حفظ مقررات التظلم
            |--------------------------------------------------------------------------
            */

            foreach ($request->course_id as $index => $courseId) {
                $course = Course::find($courseId);

$assignment = CourseAssignment::where(
        'course_id',
        $courseId
    )

    ->where(
        'department_id',
        $student->department_id
    )

    ->where(
        'academic_year',
        $request->academic_year
    )

    ->where(
        'semester',
        $request->semester
    )

    ->first();
if (!$assignment) {

    throw new \Exception(
    'المقرر "' .
    $course->course_name .
    '" ليس له مدرس مكلف لهذا الفصل.'
);

}

                AppealItem::create([

                    'appeal_id' => $appeal->appeal_id,

                    'course_id' => $courseId,

                    'reason' => $request->reason[$index]

                ]);

            }

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

            /*
            |--------------------------------------------------------------------------
            | إنشاء إشعار للطالب
            |--------------------------------------------------------------------------
            */

            $notification = Notification::create([

                'user_id' => Auth::id(),

                'title' => 'تم إرسال طلب التظلم',

                'message' =>
                'تم إرسال طلب التظلم بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.',

                'type' => 'submitted',

                'is_read' => false

            ]);

            event(
                new NewNotificationEvent(
                    $notification
                )
            );

            /*
            |--------------------------------------------------------------------------
            | حفظ جميع العمليات
            |--------------------------------------------------------------------------
            */

            DB::commit();

            return redirect()
                ->route('my-requests')
                ->with(
                    'success',
                    'تم إرسال طلب التظلم بنجاح'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );

        }

    }
 public function getCourses(Request $request)
{
    $student = Student::find(Auth::user()->student_id);
    
    $courses = Course::with([
        'assignments' => function ($query) use ($request, $student) {
            $query->where('academic_year', $request->academic_year)
                  ->where('semester', $request->semester)
                  ->where('department_id', $student->department_id);
        },
        'assignments.employee'
    ])
    ->where('level', $student->level)
    ->where('semester', $request->semester)
    ->where('status', 'active')
    ->whereHas('assignments', function ($query) use ($request, $student) {
        $query->where('academic_year', $request->academic_year)
              ->where('semester', $request->semester)
              ->where('department_id', $student->department_id);
    })
    ->orderBy('course_name')
    ->get();

    // السطر الناقص المسبب للمشكلة: إرجاع البيانات كـ JSON للـ Front-end
    return response()->json($courses);
}}