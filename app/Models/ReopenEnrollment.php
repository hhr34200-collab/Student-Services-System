<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReopenEnrollment extends Model
{
    protected $table = 'reopen_enrollments';

    protected $primaryKey = 'reopen_id';

    protected $fillable = [

        'request_id',

        'academic_year',

        'request_date'

    ];

    /*
    |--------------------------------------------------------------------------
    | الطلب المرتبط
    |--------------------------------------------------------------------------
    */

    public function request()
    {
        return $this->belongsTo(
            RequestModel::class,
            'request_id',
            'request_id'
        );
    }
}