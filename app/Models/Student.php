<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'student_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'student_number',
        'full_name',
        'college_id',
        'department_id',
        'academic_status',
        'level'
    ];

    /*
    |--------------------------------------------------------------------------
    | العلاقة مع المستخدم
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->hasOne(
            User::class,
            'student_id',
            'student_id'
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

    /*
    |--------------------------------------------------------------------------
    | طلبات الطالب
    |--------------------------------------------------------------------------
    */
    public function requests()
    {
        return $this->hasMany(
            RequestModel::class,
            'student_id',
            'student_id'
        );
    }
}

