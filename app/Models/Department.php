<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'department_name',
        'college_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | الكلية التي ينتمي إليها القسم
    |--------------------------------------------------------------------------
    */
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    /*
    |--------------------------------------------------------------------------
    | الطلاب التابعون لهذا القسم
    |--------------------------------------------------------------------------
    */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /*
    |--------------------------------------------------------------------------
    | المقررات التابعة لهذا القسم
    |--------------------------------------------------------------------------
    |
    | استخدمنا belongsToMany لأن المقرر الواحد قد يكون
    | موجوداً في أكثر من قسم، والقسم يحتوي على عدة مقررات.
    | وتم ربطهما عن طريق جدول course_departments.
    |
    */
    public function courses()
    {
        return $this->belongsToMany(

            Course::class,

            'course_departments',

            'department_id',

            'course_id'

        );
    }
}