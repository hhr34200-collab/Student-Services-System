<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\College;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    // عرض الموظفين الذين لديهم حسابات فقط
    public function index(Request $request)
    {
        $search = $request->search;

        // جلب الموظفين الذين يمتلكون حساب مستخدم فقط مع دعم البحث
        $employees = Employee::has('user')
            ->with('user', 'department', 'college')
            ->when($search, function($query) use ($search) {
                $query->where('employee_number', 'like', "%{$search}%")
                      ->orWhere('full_name', 'like', "%{$search}%");
            })
            ->get();

        $departments = Department::with('college')->get();
        $colleges = College::all();

        return view('employees.emp', compact('employees', 'departments', 'colleges'));
    }

   
public function searchExisting(Request $request)
{
    $search = $request->search;
    
    // 1. نبحث أولاً في كل الموظفين لمعرفة حالته الحقيقية
    $employeeCheck = Employee::where('employee_number', $search)
        ->orWhere('full_name', 'like', "%{$search}%")
        ->first();

    // 2. إذا كان موجوداً ولديه حساب مستخدم بالفعل، نرسل تنبيه فوري
    if ($employeeCheck && $employeeCheck->user) {
        return response()->json([
            'status' => 'has_account',
            'message' => 'هذا الموظف لديه حساب نشط بالفعل في النظام ومسجل مسبقاً.'
        ]);
    }
    
    // 3. إذا لم يكن لديه حساب، يظهر في نتائج البحث لإتمام عملية الربط
    $employees = Employee::doesntHave('user')
        ->where(function($q) use ($search) {
            $q->where('employee_number', $search)
              ->orWhere('full_name', 'like', "%{$search}%");
        })
        ->take(5)
        ->get();

    return response()->json($employees);
}

    // إضافة موظف جديد كلياً وإنشاء حسابه في خطوة واحدة
    public function storeNew(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'college_id' => 'required|exists:colleges,id',
            'department_id' => 'required|exists:departments,id',
            'job_title' => 'required',
            'phone' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        DB::transaction(function () use ($request) {
            // 1. توليد الرقم الوظيفي تلقائياً (آخر رقم + 1)
            $lastEmployee = Employee::orderBy('employee_id', 'desc')->first();
            $nextNumber = $lastEmployee ? (intval($lastEmployee->employee_number) + 1) : 1000;

            // 2. إنشاء الموظف
            $employee = Employee::create([
                'employee_number' => $nextNumber,
                'full_name' => $request->name,
                'college_id' => $request->college_id,
                'department_id' => $request->department_id,
                'job_title' => $request->job_title,
                'phone' => $request->phone,
                'status' => 'active'
            ]);

            // 3. إنشاء الحساب المرتبط به فوراً
            User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2, // دور الموظف
                'employee_id' => $employee->employee_id
            ]);
        });

        return redirect()->back()->with('success', 'تم تسجيل الموظف الجديد وإنشاء حسابه بنجاح.');
    }

    // ربط موظف سابق موجود مسبقاً بحساب جديد
    public function linkExisting(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        if($employee->user) {
            return back()->with('error', 'هذا الموظف يمتلك حساباً بالفعل.');
        }

        // إنشاء المستخدم للموظف السابق
        User::create([
            'username' => $request->username,
            'name' => $employee->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'employee_id' => $employee->employee_id
        ]);

        return redirect()->back()->with('success', 'تم تفعيل حساب الموظف السابق بنجاح انضمامه للنظام.');
    }

    // تعديل البيانات
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->update([
            'full_name'     => $request->name,
            'college_id'    => $request->college_id,
            'department_id' => $request->department_id,
            'job_title'     => $request->job_title,
            'phone'         => $request->phone
        ]);

        if($employee->user) {
            $employee->user->update([
                'name'  => $request->name,
                'email' => $request->email
            ]);
        }

        return redirect()->back()->with('success', 'تم تعديل بيانات الموظف وحسابه بنجاح.');
    }

    // حذف الحساب والموظف
    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        User::where('employee_id', $employee->employee_id)->delete();
        $employee->delete();

        return redirect()->back()->with('success', 'تم حذف الموظف وحسابه من النظام.');
    }

    // تغيير الحالة
    public function toggleStatus($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = ($employee->status == 'active') ? 'inactive' : 'active';
        $employee->save();

        return redirect()->back()->with('success', 'تم تغيير حالة الحساب بنجاح.');
    }
}