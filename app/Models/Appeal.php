<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    protected $table = 'appeals';

    protected $primaryKey = 'appeal_id';

    protected $fillable = [

        'request_id',

        'academic_year',

        'semester',

        'submission_date'

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

    /*
    |--------------------------------------------------------------------------
    | مقررات التظلم
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany(
            AppealItem::class,
            'appeal_id',
            'appeal_id'
        );
    }
}