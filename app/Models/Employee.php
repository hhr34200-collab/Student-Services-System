<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'employee_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'employee_number',
        'full_name',
        'college_id',
        'department_id',
        'job_title',
        'phone',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | المستخدم المرتبط بالموظف
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->hasOne(
            User::class,
            'employee_id',
            'employee_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | الكلية
    |--------------------------------------------------------------------------
    */
    public function college()
    {
        return $this->belongsTo(
            College::class,
            'college_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | القسم
    |--------------------------------------------------------------------------
    */
    public function department()
    {
        return $this->belongsTo(
            Department::class,
            'department_id',
            'id'
        );
    }
    public function currentRequests()
{
    return $this->hasMany(
        RequestModel::class,
        'current_employee_id',
        'employee_id'
    );
}
}

