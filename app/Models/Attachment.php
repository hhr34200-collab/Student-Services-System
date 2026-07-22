<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';

    protected $primaryKey = 'attachment_id';

    protected $fillable = [

        'request_id',

        'file_name',

        'file_path',

        'file_type',

        'file_size',

        'is_verified'

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