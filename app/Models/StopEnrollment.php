<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StopEnrollment extends Model
{
    protected $table = 'stop_enrollments';

    protected $fillable = [

        'request_id',

        'academic_year',

        'semester',

        'stop_period',

        'reason',

        'previous_stop_count',

        'request_date'

    ];

    /*
    |--------------------------------------------------------------------------
    | الطلب
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