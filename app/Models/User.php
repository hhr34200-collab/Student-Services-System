<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
protected $fillable = [

    // اسم المستخدم
    'username',

    // ربط الحساب بالطالب
    'student_id',

    // ربط الحساب بالموظف
    'employee_id',

    // البريد الإلكتروني
    'email',

    // رقم الهاتف (للإشعارات و SMS)
    'phone',

    // كلمة المرور
    'password',

    // الدور
    'role_id',
];
    protected $hidden = [
        'password',
        'remember_token',
    ];

   protected function casts(): array
{
    return [

        // تاريخ التحقق من البريد الإلكتروني
        'email_verified_at' => 'datetime',

        // تشفير كلمة المرور تلقائياً
        'password' => 'hashed',
    ];
}

    /*
    |--------------------------------------------------------------------------
    | العلاقات
    |--------------------------------------------------------------------------
    */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function student()
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
            'student_id'
        );
    }

    public function employee()
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id',
            'employee_id'
        );
    }

    /*
|--------------------------------------------------------------------------
| التحقق من الصلاحيات
|--------------------------------------------------------------------------
|
| تستخدم لمعرفة هل يمتلك المستخدم صلاحية معينة.
|
*/

public function hasPermission($permissionName)
{
    if (!$this->role) {
        return false;
    }

    return $this->role
        ->permissions()
        ->where(
            'permission_name',
            $permissionName
        )
        ->exists();
}
public function request()
{
    return $this->belongsTo(
        \App\Models\RequestModel::class,
        'request_id',
        'request_id'
    );
}
}