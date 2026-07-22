<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\User;
use App\Models\College;
use App\Models\Department;


class StudentController extends Controller
{
   // عرض الطلاب مع البحث
public function index()
{
    $students = Student::with([
        'college',
        'department'
    ])->get();

    $colleges = College::all();

    $departments = Department::all();

    return view(
        'students.index',
        compact(
            'students',
            'colleges',
            'departments'
        )
    );
}

 


    public function toggleStatus($id)
{
    $student = Student::where('student_id', $id)->firstOrFail();

    if ($student->academic_status == 'active') {

           $student->academic_status = 'stopped';

    } else {

          $student->academic_status = 'active';
   }


    $student->save();

    return redirect()
        ->back();
}

  public function store(Request $request)
{
    // التحقق من الحقول المطلوبة
    

      $request->validate([

    'full_name'     => 'required|string|max:255',

    'college_id'    => 'required|exists:colleges,id',

    'department_id' => 'required|exists:departments,id',
    
    'level'         => 'required|string|max:255',
]);

    // جلب آخر طالب مضاف

    $lastStudent = Student::latest()->first();

    // أول رقم إذا لم يوجد طلاب

    if(!$lastStudent)
    {
        $studentNumber = date('Y') . '0001';
    }
    else
    {
        // استخراج الرقم التسلسلي من آخر رقم جامعي

        $lastNumber = substr(
            $lastStudent->student_number,
            4
        );

        $nextNumber = $lastNumber + 1;

        $studentNumber =
            date('Y') .
            str_pad(
                $nextNumber,
                4,
                '0',
                STR_PAD_LEFT
            );
    }

    // حفظ الطالب

    Student::create([

    'student_number'   => $studentNumber,

    'full_name'        => $request->full_name,

    'college_id'       => $request->college_id,

    'department_id'    => $request->department_id,

    'level'            => $request->level,

    'academic_status'  => 'active'

]);


    return redirect('/students')
        ->with(
            'success',
            'تم إضافة الطالب بنجاح'
        );
}
public function destroy($id)
{
    $student = Student::where('student_id', $id)->firstOrFail();

    // حذف حساب المستخدم المرتبط بهذا الطالب إن وجد
    User::where('student_id', $student->student_id)->delete();

    // حذف الطالب
    $student->delete();

    return redirect()
        ->back()
        ->with(
            'success',
            'تم حذف الطالب بنجاح'
        );
}
public function update(Request $request, $id)
{
    $student = Student::where('student_id', $id)->firstOrFail();

    // تحديث بيانات الطالب

    $student->update([

       'full_name' => $request->full_name,

       'college_id' => $request->college_id,

       'department_id' => $request->department_id,

       'level' => $request->level,
    ]);

    // إذا كان لديه حساب

   $user = User::where('student_id', $student->student_id)->first();

   if ($user) {

    $user->update([

        'username' => $request->full_name
       
    ]);
    }

    return redirect()
        ->back()
        ->with(
            'success',
            'تم تعديل بيانات الطالب بنجاح'
        );
}
public function search(Request $request)
{
    $search = $request->search;

    $students = Student::with(['college', 'department'])

        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'full_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'student_number',
                    'like',
                    "%{$search}%"
                );

            });

        })

        ->get();

    return response()->json($students);
}


}


