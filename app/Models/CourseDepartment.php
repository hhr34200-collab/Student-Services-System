<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseDepartment extends Model
{
    /*
    |--------------------------------------------------------------------------
    | الحقول المسموح بحفظها
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'course_id',

        'department_id'

    ];

    /*
    |--------------------------------------------------------------------------
    | المقرر
    |--------------------------------------------------------------------------
    */

    public function course()
    {
        return $this->belongsTo(

            Course::class,

            'course_id',

            'course_id'

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
}