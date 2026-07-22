<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppealItem extends Model
{
    protected $table = 'appeal_items';

    protected $primaryKey = 'item_id';

    protected $fillable = [

        'appeal_id',

        'course_id',

        'reason'

    ];

    /*
    |--------------------------------------------------------------------------
    | الطلب
    |--------------------------------------------------------------------------
    */

    public function appeal()
    {
        return $this->belongsTo(
            Appeal::class,
            'appeal_id',
            'appeal_id'
        );
    }

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
}