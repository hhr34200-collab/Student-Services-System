<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_number' => 'required',
            'username'       => 'required|string|max:255|unique:users,username',
            'email'          => 'required|email|unique:users,email',
            'phone'          => 'required',
            'password'       => 'required|confirmed|min:8',
        ]);

        $student = Student::where(
            'student_number',
            $request->student_number
        )->first();

        if (!$student) {

            return back()
                ->withErrors([
                    'student_number' => 'الرقم الأكاديمي غير موجود'
                ])
                ->withInput();
        }

        $existingUser = User::where(
            'student_id',
            $student->student_id
        )->first();

        if ($existingUser) {

            return back()
                ->withErrors([
                    'student_number' => 'تم إنشاء حساب لهذا الطالب مسبقاً'
                ])
                ->withInput();
        }

        User::create([
            'username'    => $request->username,
            'student_id'  => $student->student_id,
            'employee_id' => null,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'password'    => Hash::make($request->password),
            'role_id'     => 3,
        ]);

        return redirect('/')
            ->with('success', 'تم إنشاء الحساب بنجاح');
    }

    public function getStudentData(Request $request)
    {
        $student = Student::with([
            'college',
            'department'
        ])
        ->where(
            'student_number',
            $request->student_number
        )
        ->first();

        if (!$student) {

            return response()->json([
                'success' => false
            ]);
        }

        return response()->json([
            'success' => true,

            'full_name'  => $student->full_name,
            'college'    => $student->college->college_name,
            'department' => $student->department->department_name,
            'level'      => $student->level
        ]);
    }
}

