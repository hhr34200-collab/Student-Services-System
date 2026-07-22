<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    protected $table = 'requests';

    protected $primaryKey = 'request_id';

    protected $fillable = [
    'request_number',
    'student_id',
    'service_id',
    'current_employee_id',
    'status',
    'approved_at',
    'notes',
    'student_reply',
];

    /*
    |--------------------------------------------------------------------------
    | الطالب
    |--------------------------------------------------------------------------
    */

    public function student()
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
            'student_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | الخدمة
    |--------------------------------------------------------------------------
    */

    public function service()
    {
        return $this->belongsTo(
            Service::class,
            'service_id',
            'service_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | بيانات وقف القيد
    |--------------------------------------------------------------------------
    */

    public function stopEnrollment()
    {
        return $this->hasOne(
            StopEnrollment::class,
            'request_id',
            'request_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | المرفقات
    |--------------------------------------------------------------------------
    */

    public function attachments()
    {
        return $this->hasMany(
            Attachment::class,
            'request_id',
            'request_id'
        );
    }
    /*
|--------------------------------------------------------------------------
| بيانات إعادة القيد
|--------------------------------------------------------------------------
*/

public function reopenEnrollment()
{
    return $this->hasOne(
        ReopenEnrollment::class,
        'request_id',
        'request_id'
    );
}
/*
|--------------------------------------------------------------------------
| الموظف الحالي
|--------------------------------------------------------------------------
*/

public function currentEmployee()
{
   return $this->belongsTo(
    Employee::class,
    'current_employee_id',
    'employee_id'
);
}

/*
|--------------------------------------------------------------------------
| الإفادات
|--------------------------------------------------------------------------
*/

public function approvals()
{
    return $this->hasMany(
        RequestApproval::class,
        'request_id',
        'request_id'
    );
}
public function appeal()
{
    return $this->hasOne(
        Appeal::class,
        'request_id',
        'request_id'
    );
}
/*
|--------------------------------------------------------------------------
| الاسم العربي للحالة
|--------------------------------------------------------------------------
*/

public function getStatusNameAttribute()
{
    return match ($this->status) {

        'submitted' => 'تم الإرسال',

        'student_affairs_review' => 'قيد المراجعة (شؤون الطلاب)',

        'department_head_review' => 'قيد المراجعة (رئيس القسم)',

        'dean_review' => 'قيد المراجعة (العميد)',

        'approved' => 'تمت الموافقة',

        'rejected' => 'مرفوض',

        'returned_to_student' => 'مطلوب استكمال',

        default => $this->status,

    };
}
}
