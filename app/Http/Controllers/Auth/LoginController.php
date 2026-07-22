<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
   public function showLogin()
    {
        // إذا كان هناك مستخدم مسجل دخوله ودخل لصفحة تسجيل الدخول، يتم إنهاء جلسته فوراً
        if (Auth::check()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // البحث عن المستخدم باسم المستخدم أو البريد الإلكتروني
        $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username)
                    ->first();

        if (!$user) {
            return back()
                ->withInput()
                ->with('error', 'اسم المستخدم أو البريد الإلكتروني غير صحيح');
        }

        // التحقق من كلمة المرور
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withInput()
                ->with('error', 'كلمة المرور غير صحيحة');
        }

        // تسجيل دخول المستخدم
        Auth::login($user);

        // الحصول على المستخدم بعد تسجيل الدخول
        $user = Auth::user();

        $student = null;
        $employee = null;

        // تصحيح الشروط هنا: فصلنا شرط الطالب عن شرط الموظف
        if ($user->role_id == 3) {
            $student = $user->student;
        } elseif ($user->role_id == 2) {
            $employee = $user->employee;
        }

        // تخزين بيانات الجلسة
        session([
            'user_id' => $user->id,
            'username' => $user->username,
            'student_id' => $student?->student_id,
            'student_name' => $student?->full_name,
            'role_id' => $user->role_id,
            'employee_id' => $employee?->employee_id,
        ]);

        // التوجيه حسب نوع المستخدم
        switch ($user->role_id) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('employee.dashboard');
            case 3:
                return redirect()->route('home');
            default:
                Auth::logout();
                return redirect()
                    ->route('login')
                    ->with('error', 'لا توجد صلاحية للدخول.');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}