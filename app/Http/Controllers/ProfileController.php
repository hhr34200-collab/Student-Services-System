<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\RequestModel;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $student = Student::with([
            'college',
            'department'
        ])->find($user->student_id);

        

        return view(
            'dashboard-student.profile',
            compact(
                'student',
                'user',
                
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | التحقق من كلمة المرور الحالية
    |--------------------------------------------------------------------------
    */

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required'
        ]);

        $user = Auth::user();

        if (
            !Hash::check(
                $request->current_password,
                $user->password
            )
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'كلمة المرور الحالية غير صحيحة'
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | حفظ التعديلات
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([

            'current_password' =>
                'required',

            'email' => [
                'required',
                'email',
                'unique:users,email,' . $user->id
            ],

            'phone' =>
                'required|max:20',

                'password' => [
                 'nullable',
                 'confirmed',
                 'min:8',
                 'regex:/[A-Za-z]/',
                  'regex:/[0-9]/'
]
        ], [

            'current_password.required' =>
                'يجب إدخال كلمة المرور الحالية',

            'email.required' =>
                'البريد الإلكتروني مطلوب',

            'email.email' =>
                'صيغة البريد الإلكتروني غير صحيحة',

            'email.unique' =>
                'البريد الإلكتروني مستخدم مسبقاً',

            'phone.required' =>
                'رقم الهاتف مطلوب',

            'password.confirmed' =>
                'كلمتا المرور غير متطابقتين',

            'password.min' =>
                'كلمة المرور يجب أن تكون 8 أحرف على الأقل',

            'password.regex' =>
'كلمة المرور يجب أن تحتوي على أحرف وأرقام'
        ]);

        /*
        |-------------------------------------
        | إعادة التحقق من كلمة المرور الحالية
        |-------------------------------------
        */

        if (
            !Hash::check(
                $request->current_password,
                $user->password
            )
        ) {

            return back()
                ->withErrors([
                    'current_password' =>
                        'كلمة المرور الحالية غير صحيحة'
                ])
                ->withInput();
        }

        $user->email =
            $request->email;

        $user->phone =
            $request->phone;

        if (
            $request->filled('password')
        ) {

            $user->password =
                Hash::make(
                    $request->password
                );
        }

        $user->save();

        return back()->with(
            'success',
            'تم تحديث البيانات بنجاح'
        );
    }
    /*
|--------------------------------------------------------------------------
| أرشيف المرفقات
|--------------------------------------------------------------------------
*/

public function attachments()
{
    $user = Auth::user();

    $student = Student::find($user->student_id);

    $attachments = Attachment::with([
        'request.service'
    ])
    ->whereHas('request', function ($query) use ($student) {

        $query->where(
            'student_id',
            $student->student_id
        );

    })
    ->latest()
    ->get();

    return view(
        'dashboard-student.attachments',
        compact('attachments')
    );
}
}
